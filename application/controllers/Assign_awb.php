<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Assign_awb extends Auth_Controller
{
    public $data = array();

    public function __construct()
    {

        parent::__construct();
        $this->load->model('Assign_awb_customer_model');

        //Do your magic here
    }

    public function loadview(string  $viewname, $data = "")
    {

        $this->load->view('admin/template/header');
        $this->load->view('admin/template/sidebar');

        $this->load->view('admin/assign_awb/' . $viewname, $data);
        $this->load->view('admin/template/footer');
    }

    public function index()
    {
        $this->data['sender_list'] = $this->Assign_awb_customer_model->get_customers();
        $this->loadview("assign_awb_customer", $this->data);
    }

    public function get_sender_id()
    {
        $sender_id = $this->input->post('sender_id');
        $get_assign_logistic = $this->Assign_awb_customer_model->get_logistic($sender_id);
        $output = "";
        foreach ($get_assign_logistic as $single_logistic) {
            $output .= "<option value=" . $single_logistic['id'] . ">" . $single_logistic['logistic_name'] . "</option>";
        }
        echo $output;
    }

    public function get_awb_table()
    {
        if ($this->input->post('logistic_type') != "") {
            $sender_id = $this->input->post('sender_id');
            $logistic_type = $this->input->post('logistic_type');

            $logistic_name = $this->Assign_awb_customer_model->get_logistic_name($logistic_type);
            if ($logistic_name['api_name']) {
                $table = str_replace(' ', '_', strtolower($logistic_name['api_name']));
                $this->data['get_awb'] = $this->Assign_awb_customer_model->get_airwaybill($table);
            }
            $this->data['api_name'] = $logistic_type;

            echo $this->load->view('admin/assign_awb/assign_awb_table', $this->data, true);
        } else {
            echo "error";
        }
        // $this->data['get_awb'] = array();

    }

    public function get_awb_data($logistic_type)
    {

        $columns = array();
        $logistic_name = $this->Assign_awb_customer_model->get_logistic_name($logistic_type);
        $table = str_replace(' ', '_', strtolower($logistic_name['api_name'])) . '_airwaybill';
        if ($table == 'udaan_direct_airwaybill') {
            $where = "is_used='1' AND for_what='2'  ";
        } else {

            $where = "is_used='1' AND for_what='2' AND type='2' ";
        }
        $primaryKey = 'id';
        $joinQuery = '';
        $columns[0] = array('db' => 'id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {
            return '<input class="select-item awb" type="checkbox" id="checked_item"
                                value="' . $d . '" name="checkbox_item" style="margin-left:135px">';
        });
        $columns[1] = array('db' => 'awb_number', 'dt' => 1, 'field' => 'awb_number');

        echo json_encode(
            SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where)
        );
    }

    public function export_data()
    {
        $id_array = $this->input->post('check_array');
        $logistic_id = $this->input->post('logistic');
        $sender_id = $this->input->post('sender_id');

        $sender_email = $this->Common_model->getSingle_data('id,email', 'sender_master', array('id' => $sender_id));
        $logistic_name = $this->Common_model->getSingle_data('id,logistic_name,api_name', 'logistic_master', array('id' => $logistic_id));
        $data = $this->Assign_awb_customer_model->get_excel_data($id_array, $logistic_id);

        $path = base_url('assets/export_customer_awb');
        $files = glob($path . 'xlsx');
        if (isset($files)) {
            foreach ($files as $findfiles) {
                unlink($findfiles);
            }
        }
        $searchVal = array('AirwayBill Number', 'Logistic', 'Customer Email');

        $fileName = 'CuatomerAirwaybill_' . time() . '.xlsx';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $stylearray = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '000000'),
                'size' => 14,
            ),
        );
        $j = 'A';
        $col = 0;
        foreach ($searchVal as $key) {
            $objPHPExcel->getActiveSheet()->getStyle($j . '1')->applyFromArray($stylearray);
            $objPHPExcel->getActiveSheet()->SetCellValue($j . '1', $key);
            $objPHPExcel->getActiveSheet()
                ->getStyle($j . '1')
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            //->getStartColor();
            // ->setARGB('0C3F5E');                        
            $j++;
        }
        $rowCount = 2;
        if (!empty($data)) {
            // dd($data);
            $update_awb = $this->Assign_awb_customer_model->updateawb($id_array, $logistic_name);

            foreach (@$data as $element) {
                $data = [
                    'awb_number' => $element['awb_number'],
                    'logistic_id' => $logistic_id,
                    'sender_id' => $sender_id,
                    'is_used' => '1',

                ];
                $insert_data = $this->Common_model->insert($data, 'assign_airwaybill');

                array_push($element, $logistic_name['logistic_name'], $sender_email['email']);
                $index = 'A';
                foreach ($element as $value) {
                    $objPHPExcel->getActiveSheet()->SetCellValue($index . $rowCount, $value . ' ');
                    if ($index == 'A') {
                        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
                        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
                    } else {
                        $objPHPExcel->getActiveSheet()->getColumnDimension($index)->setWidth(20);
                    }
                    $index++;
                }
                $rowCount++;
            }
        }
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header("Content-Type: application/vnd.ms-excel");
        $objWriter->save('assets/export_customer_awb/' . @$fileName);
        $finalpath = base_url() . 'assets/export_customer_awb/' . @$fileName;
        echo base64_encode($finalpath);
        exit;
    }
}
