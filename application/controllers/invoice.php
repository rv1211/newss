<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Invoice extends Auth_Controller
{
    public $data = array();
    public function __construct()
    {
        parent::__construct();
        $this->userId = $this->session->userdata('userId');
        $this->userType = $this->session->userdata('userType');
        $this->load->model('Invoice_model');
    }

    public function index()
    {

        $this->load->library('pdf');
        $firstday = Date("Y-m-d", strtotime("first day of previous month"));
        $lastday = Date("Y-m-d", strtotime("last day of previous month"));
        $invoice_date = Date("Y-m-d", strtotime("first day of this month"));


        $data = $this->Invoice_model->get_order_data($lastday, $firstday, '1', $this->userId, $this->userType);

        $data['invoice_date'] = $invoice_date;

        //reverse GST Calculation
        $total_amount = $data['Total'];

        // echo "<pre> Total Amount ";
        // print_r($total_amount);
        // echo "</pre>";

        $gst_percentage  = 18;
        //Original Cost = GST Inclusive Price * 100/(100 + GST Rate Percentage)
        $nontaxamount = $total_amount * 100 / (100 + $gst_percentage);


        // echo "<br><br><pre> NON Amount ";
        // print_r($nontaxamount);
        // echo "</pre>";

        $totataxamount  = $total_amount - $nontaxamount;

        $sgst = $totataxamount / 2;
        $cgst = $totataxamount / 2;

        $data['sgst'] = $sgst;
        $data['cgst'] = $cgst;
        $data['nontaxamount'] = $nontaxamount;


        $html = $this->load->view('admin/invoice/invoice', $data, true);
        // $this->load->view('admin/invoice/invoice', $data);
        // dd($html);

        $this->pdf->createPDF($html, 'mypdf', false, 'A4', 'portrait');
    }
}

/* End of file Controllername.php */
