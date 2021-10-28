<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Delete_order extends Auth_Controller
{
    public $data = array();
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Delete_order_model');
        ini_set('memory_limit', '-1');

        //Do your magic here
    }
    public function loadview($viewname)
    {
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/order/' . $viewname, $this->data);
        $this->load->view('admin/template/footer');
    }

    /**
     * Delete datatable
     *
     * @return  datatable  load Delete table in database
     */
    public function index()
    {
        $this->data['order_details'] = $this->Delete_order_model->get_order_details();
        $this->loadview('delete_orders');
    }
    /**
     * Delete orders 
     *
     * @return  Delete order Number
     */
    public function delete_check_order()
    {
        $forward_array = $this->input->post('forward_array');
        $error_array = $this->input->post('error_array');

        if (!empty($forward_array)) {
            $result = $this->Delete_order_model->delete_checked_forward($forward_array);
        }

        if (!empty($error_array)) {
            $result = $this->Delete_order_model->delete_checked_error($error_array);
        }
        if ($result) {
            $response = 'success';
        } else {
            $response = 'error';
        }
        echo json_encode($response);
    }
    /**
     * Export Delete orders 
     *
     * @return  Export
     */
    public function export_data()
    {
        $id_array = $this->input->post('check_array');

        $data = $this->Delete_order_model->get_excel_data($id_array);
        $path = base_url('assets/export_delete_orders');
        $files = glob($path . 'xlsx');
        if (isset($files)) {
            foreach ($files as $findfiles) {
                unlink($findfiles);
            }
        }
        $searchVal = array('Order Number', 'Airwaybill Number', 'API Name', 'Customer Name', 'Customer Email', 'Customer Number', 'Order Type', 'Processing Date', 'Payment status', 'User');

        $fileName = 'DeleteOrders_' . time() . '.xlsx';
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
        foreach ($searchVal as $key) {
            $objPHPExcel->getActiveSheet()->getStyle($j . '1')->applyFromArray($stylearray);
            $objPHPExcel->getActiveSheet()->SetCellValue($j . '1', $key);
            $objPHPExcel->getActiveSheet()
                ->getStyle($j . '1')
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $j++;
        }
        $rowCount = 2;
        if (!empty($data)) {
            foreach (@$data as $element1) {
                $index = 'A';
                foreach ($element1 as $value) {
                    $objPHPExcel->getActiveSheet()->SetCellValue($index . $rowCount, $value . ' ');
                    $objPHPExcel->getActiveSheet()->getColumnDimension($index)->setWidth(20);
                    $index++;
                }
                $rowCount++;
            }
        }
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header("Content-Type: application/vnd.ms-excel");
        $objWriter->save('assets/export_delete_orders/' . @$fileName);
        $finalpath = base_url() . 'assets/export_delete_orders/' . @$fileName;
        echo base64_encode($finalpath);
        exit;
    }

    public function refund_order($id)
    {
        // dd($id);
        $data = ['is_refund' => '1'];
        $this->Common_model->update($data, 'forward_order_master', array('id' => $id));
        $this->load->helper('wallet');
        wallet::refund_wallet($id);
        $this->session->set_flashdata('message', "Order Refunded Successfully.");
        redirect('delete-order');
    }

    public function refund_all_orders()
    {
        $this->db->select('id');
        $this->db->from('forward_order_master');
        $this->db->where('is_delete', '1');
        $this->db->where('is_refund', '0');
        $query = $this->db->get();
        $ids = array_column($query->result_array(), 'id');

        foreach ($ids as $id) {
            $data = ['is_refund' => '1'];
            $this->Common_model->update($data, 'forward_order_master', array('id' => $id));
            $this->load->helper('wallet');
            wallet::refund_wallet($id);
        }
        $this->session->set_flashdata('message', "Order Refunded Successfully.");
        redirect('delete-order');
    }
}

/* End of file Delete_order.php */