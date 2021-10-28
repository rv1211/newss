<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Codremittance_new extends Auth_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('common_model');
        $this->load->model('Codremittance_model');
        $this->userId = $this->session->userdata('userId');
        $this->userType = $this->session->userdata('userType');
    }

    public function index()
    {
        $this->total_amount();
        load_admin_view('codremittance', 'cod_remittance', $this->data);
    }
    public function cod_shipping_charges()
    {
        $this->total_amount();
        load_admin_view('codremittance', 'cod_shipping_charges', $this->data);
    }
    public function cod_wallet_transactions()
    {
        $this->total_amount();
        load_admin_view('codremittance', 'cod_wallet_transactions', $this->data);
    }
    public function cod_bill_summary()
    {
        $this->total_amount();
        load_admin_view('codremittance', 'cod_bill_summary', $this->data);
    }
    function total_amount()
    {
        $get_remitted_amount = $this->Codremittance_model->get_cod_remittanace_count('2', $this->userId, $this->userType);
        $remitted_amount = $get_remitted_amount['cod_amount'] == null ? '0' : $get_remitted_amount['cod_amount'];

        $get_unremitted_amount = $this->Codremittance_model->get_cod_remittanace_count('3', $this->userId, $this->userType);
        $unremitted_amount = $get_unremitted_amount['cod_amount'] == null ? '0' : $get_unremitted_amount['cod_amount'];

        if ($this->userType == 4) {
            $get_next_remmitance_amount = $this->Common_model->getSingle_data('SUM(cod_remittance_amount) AS cod_remittance_amount', 'next_cod_remittance_list', array('sender_id' => $this->userId));
        } else {
            $get_next_remmitance_amount = $this->Common_model->getSingle_data('SUM(cod_remittance_amount) AS cod_remittance_amount', 'next_cod_remittance_list');
        }

        $next_remmitance = $get_next_remmitance_amount['cod_remittance_amount'] == null ? '0' : $get_next_remmitance_amount['cod_remittance_amount'];
        if ($this->userType == 4) {
            $where = "wallet_balance < '0.00' AND id='" . $this->userId . "'";
            $get_wallet_transaction = $this->Common_model->getSingle_data('SUM(wallet_balance) AS wallet_balance', 'sender_master', $where);
        } else {
            $where = "wallet_balance < '0.00'";
            $get_wallet_transaction = $this->Common_model->getSingle_data('SUM(wallet_balance) AS wallet_balance', 'sender_master', $where);
        }

        $wallet_balance = $get_wallet_transaction['wallet_balance'] == null ? '0' : $get_wallet_transaction['wallet_balance'];

        $this->data['total_cod_generated'] = number_format(($remitted_amount + $unremitted_amount), 2, '.', ',');
        $this->data['total_bill_adjusted'] = number_format((($remitted_amount + $unremitted_amount) - $remitted_amount - abs($wallet_balance)), 2, '.', ',');
        $this->data['total_refund_adjusted'] = "coming soon";
        $this->data['total_advance_hold'] = "coming soon";
        $this->data['total_cod_remmitted'] = number_format($remitted_amount, 2, '.', ',');
        $this->data['wallet_transfered'] = number_format($wallet_balance, 2, '.', ',');
        $this->data['unremmited_cod'] = number_format($unremitted_amount, 2, '.', ',');
        $this->data['next_remmitance'] = number_format($next_remmitance, 2, '.', ',');
    }
    public function cod_remittance_table()
    {
        $columns = array();
        $table = 'cod_remittance_detail';
        $primaryKey = 'cod_remittance_detail_id';
        $where_condition = "";

        $columns[0] = array('db' => 'crd.created_date', 'dt' => 0, 'formatter' => function ($d, $row) {
            return date("d-m-Y", strtotime($d));
        }, 'field' => 'created_date');
        $columns[1] = array('db' => 'crd.cod_remittance_amount', 'dt' => 1, 'field' => 'cod_remittance_amount');
        $columns[2] = array('db' => 'crd.cod_remittance_note', 'dt' => 2, 'field' => 'cod_remittance_note');
        $columns[3] = array('db' => 'cod_remittance_detail_id', 'dt' => 3, 'formatter' => function ($d, $row) {
            $actions = '<div>
        					<button class="btn btn-sm btn-primary cod_remittance_order_detail_info_button" value="' . $row[3] . '"> View Detail</button>
                        </div>';
            return $actions;
        }, 'field' => 'cod_remittance_detail_id');

        $columns[4] = array('db' => 'cm.name', 'dt' => 4, 'field' => 'name');

        if ($this->userType != 1) {
            $where_condition = "crd.sender_id=" . $this->userId;
        }
        $join_query = "FROM {$table} AS crd LEFT JOIN sender_master AS cm ON cm.id=crd.sender_id";

        $where = $where_condition;
        $joinQuery = $join_query;
        echo json_encode(
            SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where)
        );
    }
    public function export_data()
    {
        $crf_id = $this->input->post('check_array');

        $data = $this->Codremittance_model->get_excel_data($crf_id);

        $path = base_url('assets/export_pickup_address');
        $files = glob($path . 'xlsx');
        if (isset($files)) {
            foreach ($files as $findfiles) {
                unlink($findfiles);
            }
        }
        $searchVal = array('AWB No', 'Order No', 'Customer', 'Logistics', 'Price', 'Delivered Date');

        $fileName = 'remitance_' . time() . '.xlsx';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $stylearray = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => 'FFFFFF'),
                'size' => 12,
            ),
        );
        $j = 'A';
        foreach ($searchVal as $key) {
            $objPHPExcel->getActiveSheet()->getStyle($j . '1')->applyFromArray($stylearray);
            $objPHPExcel->getActiveSheet()->SetCellValue($j . '1', $key);
            $objPHPExcel->getActiveSheet()
                ->getStyle($j . '1')
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('000000');
            $j++;
        }
        $rowCount = 2;
        if (!empty($data)) {
            foreach (@$data as $element1) {
                $index = 'A';
                foreach ($element1 as $value) {
                    $objPHPExcel->getActiveSheet()->SetCellValue($index . $rowCount, $value);
                    $objPHPExcel->getActiveSheet()->getColumnDimension($index)->setWidth(20);
                    $index++;
                }
                $rowCount++;
            }
        }
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header("Content-Type: application/vnd.ms-excel");
        $objWriter->save('assets/export_codremittance/' . @$fileName);
        $finalpath = base_url() . 'assets/export_codremittance/' . @$fileName;
        echo base64_encode($finalpath);
        exit;
    }
    public function cod_shipping_charge_table()
    {
        $columns = array();
        $table = 'cod_remittance';
        $primaryKey = 'id';
        $where = "";

        $columns[0] = array('db' => 'crf_id', 'dt' => 0, 'field' => 'crf_id');
        $columns[1] = array('db' => 'cod_create_date', 'dt' => 1, 'field' => 'cod_create_date');
        $columns[2] = array('db' => 'cod_available', 'dt' => 2, 'field' => 'cod_available');
        $columns[3] = array('db' => 'remittance_amount', 'dt' => 3, 'field' => 'remittance_amount');
        $columns[4] = array('db' => 'paid_amount', 'dt' => 4, 'field' => 'paid_amount');
        $columns[5] = array('db' => 'id', 'dt' => 5, 'field' => 'id', 'formatter' => function ($d, $row) {
            return '<i class="fas fa-rupee-sign"></i> 0.00';
        });
        $columns[6] = array('db' => 'id', 'dt' => 6, 'field' => 'id', 'formatter' => function ($d, $row) {
            return '<i class="fas fa-rupee-sign"></i> 0.00';
        });
        $columns[7] = array('db' => 'id', 'dt' => 7, 'field' => 'id', 'formatter' => function ($d, $row) {
            return '<i class="fas fa-rupee-sign"></i> 0.00';
        });
        $columns[8] = array('db' => 'remain_amount', 'dt' => 8, 'field' => 'remain_amount');
        $columns[9] = array('db' => 'remarks', 'dt' => 9, 'field' => 'remarks');

        echo json_encode(
            SSP::simple($_GET, $table, $primaryKey, $columns, '', $where)
        );
    }
    public function cod_wallet_transactions_table()
    {
        $columns = array();
        $table = 'wallet_transaction';
        $primaryKey = 'id';

        $joinQuery = 'FROM ' . $table . ' as wt JOIN sender_master as sm ON sm.id = wt.sender_id';
        $where = "sm.status = '1' ";

        $columns[0] = array('db' => 'wt.updated_date', 'dt' => 0, 'field' => 'updated_date');
        $columns[1] = array('db' => 'wt.id', 'dt' => 1, 'field' => 'id');
        $columns[2] = array('db' => 'wt.debit as debit', 'dt' => 2, 'field' => 'debit');
        $columns[3] = array('db' => 'wt.credit as credit', 'dt' => 3, 'field' => 'credit');
        $columns[4] = array('db' => 'sm.wallet_balance', 'dt' => 4, 'field' => 'wallet_balance');
        $columns[5] = array('db' => 'wt.remarks', 'dt' => 5, 'field' => 'remarks');
        if ($this->userType == 4) {
            $where = "wt.sender_id = '" . $this->userId . "'";
        }

        echo json_encode(
            SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where, '')
        );
    }
    public function cod_bill_summary_table()
    {
        $columns = array();
        $table = 'cod_remittance';
        $primaryKey = 'id';
        $where = "";

        $columns[0] = array('db' => 'crf.id', 'dt' => 0, 'field' => 'crf.id');
        $columns[1] = array('db' => 'cod_create_date', 'dt' => 1, 'field' => 'cod_create_date');
        $columns[2] = array('db' => 'cod_available', 'dt' => 2, 'field' => 'cod_available');
        $columns[3] = array('db' => 'remittance_amount', 'dt' => 3, 'field' => 'remittance_amount');
        $columns[4] = array('db' => 'paid_amount', 'dt' => 4, 'field' => 'paid_amount');
        $columns[5] = array('db' => 'id', 'dt' => 5, 'field' => 'id', 'formatter' => function ($d, $row) {
            return '<i class="fas fa-rupee-sign"></i> 0.00';
        });
        $columns[6] = array('db' => 'id', 'dt' => 6, 'field' => 'id', 'formatter' => function ($d, $row) {
            return '<i class="fas fa-rupee-sign"></i> 0.00';
        });
        $columns[7] = array('db' => 'id', 'dt' => 7, 'field' => 'id', 'formatter' => function ($d, $row) {
            return '<i class="fas fa-rupee-sign"></i> 0.00';
        });
        $columns[8] = array('db' => 'remain_amount', 'dt' => 8, 'field' => 'remain_amount');
        $columns[9] = array('db' => 'remarks', 'dt' => 9, 'field' => 'remarks');
        $columns[10] = array('db' => 'remittance_status', 'dt' => 10, 'field' => 'remittance_status');
        $columns[11] = array('db' => 'id', 'dt' => 11, 'field' => 'id', 'formatter' => function ($d, $row) {
            return 'Download';
        });
        $columns[12] = array('db' => 'id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
            return '<i class="fas fa-rupee-sign"></i> 0.00';
        });

        echo json_encode(
            SSP::simple($_GET, $table, $primaryKey, $columns, '', $where)
        );
    }
}
