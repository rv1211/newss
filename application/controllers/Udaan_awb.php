<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Udaan_awb extends Auth_Controller
{
    public $data = array();


    public function index()
    {
        $total_unused_awb = $this->Common_model->getResultArray(array('is_used' => '1'), 'id', 'udaan_direct_airwaybill');
        $this->data['total_unused_awb'] = count($total_unused_awb);
        load_admin_view('udaan', 'awb_generate', $this->data);
    }

    public function generate_new_udaan_awb()
    {
        file_put_contents(APPPATH . 'logs/udaan_awb/' . date("d-m-Y") . '_udaan_awb.txt', "\n------------------- Get AWB Statr ---------------\n", FILE_APPEND);
        $this->load->helper('Udaan_Direct');
        $response = Udaan_Direct::generate_awb();
        if ($response['success']) {
            $this->session->set_flashdata('message', $response['success']);
            redirect('udaan-generate-awb');
        }else{
            $this->session->set_flashdata('error', $response['error']);
            redirect('udaan-generate-awb');
        }
        redirect('udaan-generate-awb');
    }
}
