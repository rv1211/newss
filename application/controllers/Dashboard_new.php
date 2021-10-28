<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_new extends Auth_Controller
{
    public $data;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model');
        $this->load->model('Dashboard_new_model');
        $this->userId = $this->session->userdata('userId');
        $this->userType = $this->session->userdata('userType');
        if ($this->session->userdata('userType') == '4' && $this->session->userdata('userAllow') != "") {
            if ($this->session->userdata('userAllow') == "kyc") {
                redirect('kyc-verification');
            }
            if ($this->session->userdata('userAllow') == "kycPending") {
                redirect('approve-pending');
            }
            if ($this->session->userdata('userAllow') == "pickup") {
                redirect('pickup-address');
            }
        }
    }

    public function index()
    {

        if ($this->userType == '4') {
            $this->data = $this->Common_model->getSingle_data('name', 'sender_master', array('id' => $this->userId));
        } else {
            $this->data = $this->Common_model->getSingle_data('name', 'user_master', array('id' => $this->userId));
        }
        $this->data['logistics_list'] = $this->Dashboard_new_model->get_all_logistics($this->userId, $this->userType);

        $today = date("Y-m-d", strtotime("last day of this month"));
        $fromday = date("Y-m-d", strtotime("first day of this month"));
        // echo $today."<br>".$fromday;exit;
        //$today = $fromday = date('Y-m-d');
        $this->data['all_created_order_count'] = $this->data['created_order_count_result'] = $this->data['intransit_count_result'] = $this->data['ofd_count_result'] = $this->data['ndr_count_result'] = $this->data['delivered_count_result'] = $this->data['rto_intransit_count_result'] = $this->data['rto_delivered_count_result'] = $this->data['all_order_count_result'] = '0';
        $all_created_order_count = $this->Dashboard_new_model->get_today_order_count('', '',  array('1'), $this->userId, $this->userType);
        $this->data['all_created_order_count'] = $all_created_order_count[0]['totalCount'];
        $created_order_count = $this->Dashboard_new_model->get_today_order_count($today, $fromday, array('1'), $this->userId, $this->userType);
        if (!empty($created_order_count)) {
            $this->data['all_order_count_result'] = $this->data['created_order_count_result'] = $created_order_count[0]['totalCount'];
        }
        $status = array('3', '5', '6', '9', '10', '11', '12', '13', '14', '18');
        $get_all_count = $this->Dashboard_new_model->get_today_order_count($today, $fromday, $status, $this->userId, $this->userType);
        if (!empty($get_all_count)) {
            foreach ($get_all_count as $count) {
                switch ($count['order_status_id']) {
                    case '3':
                        $this->data['intransit_count_result'] = $count['totalCount'];
                        $this->data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '5':
                        $this->data['ofd_count_result'] = $count['totalCount'];
                        $this->data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '6':
                        $this->data['delivered_count_result'] = $count['totalCount'];
                        $this->data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '9':
                        $this->data['rto_intransit_count_result'] += $count['totalCount'];
                        $this->data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '10':
                        $this->data['rto_intransit_count_result'] += $count['totalCount'];
                        $this->data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '11':
                        $this->data['rto_intransit_count_result'] += $count['totalCount'];
                        $this->data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '12':
                        $this->data['rto_intransit_count_result'] += $count['totalCount'];
                        $this->data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '13':
                        $this->data['rto_delivered_count_result'] += $count['totalCount'];
                        $this->data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '14':
                        $this->data['rto_delivered_count_result'] += $count['totalCount'];
                        $this->data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '18':
                        $this->data['ndr_count_result'] = $count['totalCount'];
                        $this->data['all_order_count_result'] += $count['totalCount'];
                        break;

                    default:
                        $de = '1';
                        break;
                }
            }
        }
        // COD remmitance
        $get_remitted_amount = $this->Dashboard_new_model->get_cod_remittanace_count('2', $today, $fromday, $this->userId, $this->userType);
        $this->data['remitted_amount'] = $get_remitted_amount['cod_amount'] == null ? '0' : number_format($get_remitted_amount['cod_amount'], 2, '.', ',');
        if ($this->userType == 4) {
            $get_next_remmitance_amount = $this->Common_model->getSingle_data('cod_remittance_amount', 'next_cod_remittance_list', array('sender_id' => $this->userId));
            $this->data['next_remmitance'] = $get_next_remmitance_amount['cod_remittance_amount'] == null ? 'Coming Soon' : '₹ ' . number_format($get_next_remmitance_amount['cod_remittance_amount'], 2, '.', ',');
        } else {
            $this->data['next_remmitance'] = 'Coming Soon';
        }

        $get_unremitted_amount = $this->Dashboard_new_model->get_cod_remittanace_count('3', $today, $fromday, $this->userId, $this->userType);
        $this->data['unremitted_amount'] = $get_unremitted_amount['cod_amount'] == null ? '0' : number_format($get_unremitted_amount['cod_amount'], 2, '.', ',');

        $get_shipping_amount = $this->Dashboard_new_model->get_cod_remittanace_count('1', $today, $fromday, $this->userId, $this->userType);
        $this->data['avg_shipping_amnt'] = $get_shipping_amount[0]['shipping_amount'] == null ? '0.00' : number_format($get_shipping_amount[0]['shipping_amount'], 2, '.', ',');

        load_admin_view('dashboard', 'dashboard_new', $this->data);
    }

    public function daily_shipments_count()
    {
        $from = $this->input->post('from');
        if ($from == '0') {
            $today = $this->input->post('end');
            $fromday = $this->input->post('start');
            $logistic = $this->input->post('logistic');
        } else {
            $date = $this->input->post('date');
            $date_pieces = explode("-", $date);
            $today = date('Y-m-d', strtotime($date_pieces[1]));
            $fromday = date('Y-m-d', strtotime($date_pieces[0]));
        }
        $logistic = $this->input->post('logistic');

        $get_all_update_data = $date  = array();

        $get_c_date = $this->Dashboard_new_model->get_daily_shipment_count(1, $today, $fromday, $this->userType, $this->userId, $logistic);

        if (!empty($get_c_date)) {
            foreach ($get_c_date as $val) {
                if (!in_array($val['createdate'], $date)) {
                    $date[] = $val['createdate'];
                    $get_all_update_data[$val['createdate']]['1'] = $get_all_update_data[$val['createdate']]['2'] = $get_all_update_data[$val['createdate']]['3'] = $get_all_update_data[$val['createdate']]['5'] = $get_all_update_data[$val['createdate']]['6'] = $get_all_update_data[$val['createdate']]['9'] = $get_all_update_data[$val['createdate']]['10'] = $get_all_update_data[$val['createdate']]['11'] = $get_all_update_data[$val['createdate']]['12'] = $get_all_update_data[$val['createdate']]['13'] = $get_all_update_data[$val['createdate']]['14'] = $get_all_update_data[$val['createdate']]['18'] = '0';
                }
                $get_all_update_data[$val['createdate']]['date'] = $val['createdate'];
                $get_all_update_data[$val['createdate']]['1'] = $val['status_count'];
            }
        }
        $status = array('2', '3', '5', '6', '9', '10', '11', '12', '13', '14', '18');
        $get_u_date = $this->Dashboard_new_model->get_daily_shipment_count($status, $today, $fromday, $this->userType, $this->userId, $logistic);
        if (!empty($get_u_date)) {
            foreach ($get_u_date as $val) {
                if (!in_array($val['updatedate'], $date)) {
                    $date[] = $val['updatedate'];
                    $get_all_update_data[$val['updatedate']]['1'] = $get_all_update_data[$val['updatedate']]['2'] = $get_all_update_data[$val['updatedate']]['3'] = $get_all_update_data[$val['updatedate']]['5'] = $get_all_update_data[$val['updatedate']]['6'] = $get_all_update_data[$val['updatedate']]['9'] = $get_all_update_data[$val['updatedate']]['10'] = $get_all_update_data[$val['updatedate']]['11'] = $get_all_update_data[$val['updatedate']]['12'] = $get_all_update_data[$val['updatedate']]['13'] = $get_all_update_data[$val['updatedate']]['14'] = $get_all_update_data[$val['updatedate']]['18'] = '0';
                }
                $get_all_update_data[$val['updatedate']]['date'] = $val['updatedate'];
                switch ($val['status_id']) {
                    case '2':
                        $get_all_update_data[$val['updatedate']]['2'] = $val['status_count'];
                        break;
                    case '3':
                        $get_all_update_data[$val['updatedate']]['3'] = $val['status_count'];
                        break;
                    case '5':
                        $get_all_update_data[$val['updatedate']]['5'] = $val['status_count'];
                        break;
                    case '6':
                        $get_all_update_data[$val['updatedate']]['6'] = $val['status_count'];
                        break;
                    case '9':
                        $get_all_update_data[$val['updatedate']]['9'] = $val['status_count'];
                        break;
                    case '10':
                        $get_all_update_data[$val['updatedate']]['10'] = $val['status_count'];
                        break;
                    case '11':
                        $get_all_update_data[$val['updatedate']]['11'] = $val['status_count'];
                        break;
                    case '12':
                        $get_all_update_data[$val['updatedate']]['12'] = $val['status_count'];
                        break;
                    case '13':
                        $get_all_update_data[$val['updatedate']]['13'] = $val['status_count'];
                        break;
                    case '14':
                        $get_all_update_data[$val['updatedate']]['14'] = $val['status_count'];
                        break;
                    case '18':
                        $get_all_update_data[$val['updatedate']]['18'] = $val['status_count'];
                        break;

                    default:
                        break;
                }
            }
        }
        $this->data['orderCountData'] = $get_all_update_data;
        echo $this->load->view('admin/dashboard/daily_shipment_table', $this->data, true);
    }

    public function ofd_count()
    {
        $today = $this->input->post('end');
        $fromday = $this->input->post('start');

        $this->data['total_ofd'] = $this->data['total_delivered'] = $this->data['total_rto'] = $this->data['total_undelivered'] = '0';
        $status = array('5', '6', '9', '10', '11', '12', '13', '14', '18');
        $get_all_count = $this->Dashboard_new_model->get_today_order_count($today, $fromday, $status, $this->userId, $this->userType);
        if (!empty($get_all_count)) {
            foreach ($get_all_count as $count) {
                switch ($count['order_status_id']) {
                    case '5':
                        $this->data['total_ofd'] = $count['totalCount'];
                        break;

                    case '6':
                        $this->data['total_delivered'] = $count['totalCount'];
                        break;

                    case '9':
                        $this->data['total_rto'] += $count['totalCount'];
                        break;

                    case '10':
                        $this->data['total_rto'] += $count['totalCount'];
                        break;

                    case '11':
                        $this->data['total_rto'] += $count['totalCount'];
                        break;

                    case '12':
                        $this->data['total_rto'] += $count['totalCount'];
                        break;

                    case '13':
                        $this->data['total_rto'] += $count['totalCount'];
                        break;

                    case '14':
                        $this->data['total_rto'] += $count['totalCount'];
                        break;

                    case '18':
                        $this->data['total_undelivered'] = $count['totalCount'];
                        break;

                    default:
                        $de = '1';
                        break;
                }
            }
        }
        echo json_encode($this->data);
    }

    public function carrier_performance_count()
    {

        $today = $this->input->post('end');
        $fromday = $this->input->post('start');

        $all_total_data = $logistic = array();

        $all_total_count = $this->Dashboard_new_model->get_carrier_performance_count('', $today, $fromday, $this->userType, $this->userId);

        if (!empty($all_total_count)) {
            foreach ($all_total_count as $val) {
                if (!in_array($val['logistic_name'], $logistic)) {
                    $logistic[] = $val['logistic_name'];
                    $all_total_data[$val['logistic_name']]['total'] = $all_total_data[$val['logistic_name']]['3'] = $all_total_data[$val['logistic_name']]['5'] = $all_total_data[$val['logistic_name']]['6'] = $all_total_data[$val['logistic_name']]['9'] = $all_total_data[$val['logistic_name']]['10'] = $all_total_data[$val['logistic_name']]['11'] = $all_total_data[$val['logistic_name']]['12'] = $all_total_data[$val['logistic_name']]['13'] = $all_total_data[$val['logistic_name']]['14']  = '0';
                }
                $all_total_data[$val['logistic_name']]['logistic'] = $val['logistic_name'];
                $all_total_data[$val['logistic_name']]['total'] = $val['status_count'];
            }
        }

        $status = array('3', '5', '6', '9', '10', '11', '12', '13', '14');
        $carrier_performance_data = $this->Dashboard_new_model->get_carrier_performance_count($status, $today, $fromday, $this->userType, $this->userId);
        if (!empty($carrier_performance_data)) {
            foreach ($carrier_performance_data as $val) {
                if (!in_array($val['logistic_name'], $logistic)) {
                    $logistic[] = $val['logistic_name'];
                    $all_total_data[$val['logistic_name']]['total'] = $all_total_data[$val['logistic_name']]['3'] = $all_total_data[$val['logistic_name']]['5'] = $all_total_data[$val['logistic_name']]['6'] = $all_total_data[$val['logistic_name']]['9'] = $all_total_data[$val['logistic_name']]['10'] = $all_total_data[$val['logistic_name']]['11'] = $all_total_data[$val['logistic_name']]['12'] = $all_total_data[$val['logistic_name']]['13'] = $all_total_data[$val['logistic_name']]['14'] = '0';
                }
                $all_total_data[$val['logistic_name']]['logistic'] = $val['logistic_name'];
                switch ($val['status_id']) {
                    case '3':
                        $all_total_data[$val['logistic_name']]['3'] = $val['status_count'];
                        break;
                    case '5':
                        $all_total_data[$val['logistic_name']]['5'] = $val['status_count'];
                        break;
                    case '6':
                        $all_total_data[$val['logistic_name']]['6'] = $val['status_count'];
                        break;
                    case '9':
                        $all_total_data[$val['logistic_name']]['9'] = $val['status_count'];
                        break;
                    case '10':
                        $all_total_data[$val['logistic_name']]['10'] = $val['status_count'];
                        break;
                    case '11':
                        $all_total_data[$val['logistic_name']]['11'] = $val['status_count'];
                        break;
                    case '12':
                        $all_total_data[$val['logistic_name']]['12'] = $val['status_count'];
                        break;
                    case '13':
                        $all_total_data[$val['logistic_name']]['13'] = $val['status_count'];
                        break;
                    case '14':
                        $all_total_data[$val['logistic_name']]['14'] = $val['status_count'];
                        break;

                    default:
                        break;
                }
            }
        }
        $this->data['carrier_performance_data'] = $all_total_data;
        $this->data['total_count'] = $this->Dashboard_new_model->get_today_order_count($today, $fromday, '', $this->userId, $this->userType); //total count
        $delivered_count = $this->Dashboard_new_model->get_today_order_count($today, $fromday, 6, $this->userId, $this->userType); //delivered 
        $intransit_count = $this->Dashboard_new_model->get_today_order_count($today, $fromday, 3, $this->userId, $this->userType); //in transist
        $ofd_count = $this->Dashboard_new_model->get_today_order_count($today, $fromday, 5, $this->userId, $this->userType); //Dispatched//Out for Delivery //OFD

        //RTO in transist
        $rto_manifested = $this->Dashboard_new_model->get_today_order_count($today, $fromday, 9, $this->userId, $this->userType);
        $rto_processing = $this->Dashboard_new_model->get_today_order_count($today, $fromday, 10, $this->userId, $this->userType);
        $rto_intransit = $this->Dashboard_new_model->get_today_order_count($today, $fromday, 11, $this->userId, $this->userType);
        $rto_dispatched = $this->Dashboard_new_model->get_today_order_count($today, $fromday, 12, $this->userId, $this->userType);
        //RTO delivered
        $rto_returned = $this->Dashboard_new_model->get_today_order_count($today, $fromday, 13, $this->userId, $this->userType);
        $rto = $this->Dashboard_new_model->get_today_order_count($today, $fromday, 14, $this->userId, $this->userType);


        $rto_count = (@$rto_manifested[0]['totalCount'] + @$rto_processing[0]['totalCount'] + @$rto_intransit[0]['totalCount'] +  @$rto_dispatched[0]['totalCount'] + @$rto_returned[0]['totalCount'] + @$rto[0]['totalCount']);

        // dd($rto_count);
        $this->data['delivered_count'] = $delivered_count[0]['totalCount'];
        $this->data['intransit_count'] = $intransit_count[0]['totalCount'];
        $this->data['ofd_count'] = $ofd_count[0]['totalCount'];
        $this->data['rto_count'] = $rto_count;

        // load_admin_view('dashboard', 'dashboard_new', $this->data);
        echo $this->load->view('admin/dashboard/carrier_performance_table', $this->data, true);
    }

    public function today_orders_count()
    {
        $today = $this->input->post('end');
        $fromday = $this->input->post('start');

        $data['created_order_count_result'] = $data['intransit_count_result'] = $data['ofd_count_result'] = $data['ndr_count_result'] = $data['delivered_count_result'] = $data['rto_intransit_count_result'] = $data['rto_delivered_count_result'] = $data['all_order_count_result'] = '0';
        $created_order_count = $this->Dashboard_new_model->get_today_order_count($today, $fromday, array('1'), $this->userId, $this->userType); //1//created order
        if (!empty($created_order_count)) {
            $data['all_order_count_result'] = $data['created_order_count_result'] = $created_order_count[0]['totalCount'];
        }
        $status = array('3', '5', '6', '9', '10', '11', '12', '13', '14', '18');
        $get_all_count = $this->Dashboard_new_model->get_today_order_count($today, $fromday, $status, $this->userId, $this->userType);
        if (!empty($get_all_count)) {
            foreach ($get_all_count as $count) {
                switch ($count['order_status_id']) {
                    case '3':
                        $data['intransit_count_result'] = $count['totalCount'];
                        $data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '5':
                        $data['ofd_count_result'] = $count['totalCount'];
                        $data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '6':
                        $data['delivered_count_result'] = $count['totalCount'];
                        $data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '9':
                        $data['rto_intransit_count_result'] += $count['totalCount'];
                        $data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '10':
                        $data['rto_intransit_count_result'] += $count['totalCount'];
                        $data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '11':
                        $data['rto_intransit_count_result'] += $count['totalCount'];
                        $data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '12':
                        $data['rto_intransit_count_result'] += $count['totalCount'];
                        $data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '13':
                        $data['rto_delivered_count_result'] += $count['totalCount'];
                        $data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '14':
                        $data['rto_delivered_count_result'] += $count['totalCount'];
                        $data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '18':
                        $data['ndr_count_result'] = $count['totalCount'];
                        $data['all_order_count_result'] += $count['totalCount'];
                        break;

                    default:
                        $de = '1';
                        break;
                }
            }
        }
        echo json_encode($data);
    }

    public function logout()
    {
        session_destroy();
        redirect('');
    }


    public function chart_counts()
    {
        //today
        $fromday = date('Y-m-d ');
        $today = date('Y-m-d ');

        $data['today']['created_order_count_result'] = $this->Dashboard_model->get_chart_count($today, $fromday, 1,  $this->userType, $this->userId);
        $data['today']['intransit_count_result'] = $this->Dashboard_model->get_chart_count($today, $fromday, 3,  $this->userType, $this->userId);
        $data['today']['ofd_count_result'] = $this->Dashboard_model->get_chart_count($today, $fromday, 5,  $this->userType, $this->userId);
        $data['today']['ndr_count_result'] = $this->Dashboard_model->get_chart_count($today, $fromday, 18,  $this->userType, $this->userId);
        $data['today']['delivered_count_result'] = $this->Dashboard_model->get_chart_count($today, $fromday, 6,  $this->userType, $this->userId);
        $data['today']['rto_intransit_count_result'] =  $this->Dashboard_model->get_chart_count($today, $fromday, array('9', '10', '11', '12'),  $this->userType, $this->userId);
        $data['today']['rto_delivered_count_result'] = $this->Dashboard_model->get_chart_count($today, $fromday, array('13', '14'),  $this->userType, $this->userId);
        $data['today']['all_order_count_result'] = ($data['today']['created_order_count_result'] + $data['today']['intransit_count_result'] +  $data['today']['ofd_count_result'] + $data['today']['ndr_count_result'] +  $data['today']['delivered_count_result'] + $data['today']['rto_intransit_count_result'] + $data['today']['rto_delivered_count_result']);

        // all
        $fromday = date('Y-m-d 00-00-0000', mktime(11, 14, 54, 01, 01, 2021));

        $data['all']['created_order_count_result'] = $this->Dashboard_model->get_chart_count($today, $fromday, 1,  $this->userType, $this->userId);
        $data['all']['intransit_count_result'] = $this->Dashboard_model->get_chart_count($today, $fromday, 3,  $this->userType, $this->userId);
        $data['all']['ofd_count_result'] = $this->Dashboard_model->get_chart_count($today, $fromday, 5,  $this->userType, $this->userId);
        $data['all']['ndr_count_result'] = $this->Dashboard_model->get_chart_count($today, $fromday, 18,  $this->userType, $this->userId);
        $data['all']['delivered_count_result'] = $this->Dashboard_model->get_chart_count($today, $fromday, 6,  $this->userType, $this->userId);
        $data['all']['rto_intransit_count_result'] =  $this->Dashboard_model->get_chart_count($today, $fromday, array('9', '10', '11', '12'),  $this->userType, $this->userId);

        $data['all']['rto_delivered_count_result'] = $this->Dashboard_model->get_chart_count($today, $fromday, array('13', '14'),  $this->userType, $this->userId);
        $data['all']['all_order_count_result'] = ($data['all']['created_order_count_result'] + $data['all']['intransit_count_result'] +  $data['all']['ofd_count_result'] + $data['all']['ndr_count_result'] +  $data['all']['delivered_count_result'] + $data['all']['rto_intransit_count_result'] + $data['all']['rto_delivered_count_result']);

        echo  json_encode($data);
    }

    public function cod_remittance_count()
    {
        $today = $this->input->post('end');
        $fromday = $this->input->post('start');

        $get_remitted_amount = $this->Dashboard_new_model->get_cod_remittanace_count('2', $today, $fromday, $this->userId, $this->userType);
        $data['remitted_amount'] = $get_remitted_amount['cod_amount'] == null ? '0' : number_format($get_remitted_amount['cod_amount'], 2, '.', ',');

        $get_unremitted_amount = $this->Dashboard_new_model->get_cod_remittanace_count('3', $today, $fromday, $this->userId, $this->userType);
        $data['unremitted_amount'] = $get_unremitted_amount['cod_amount'] == null ? '0' : number_format($get_unremitted_amount['cod_amount'], 2, '.', ',');

        $get_shipping_amount = $this->Dashboard_new_model->get_cod_remittanace_count('1', $today, $fromday, $this->userId, $this->userType);
        $data['avg_shipping_amnt'] = $get_shipping_amount[0]['shipping_amount'] == null ? '0.00' : number_format($get_shipping_amount[0]['shipping_amount'], 2, '.', ',');

        echo json_encode($data);
    }
    public function all_order_chart()
    {
        $data = $this->Dashboard_model->get_year_chart_count($this->userType, $this->userId);
        // dd($data);
        $final = array_column($data, 'orders', 'month_name');
        $orders['January'] = (!empty($final['January']) ? $final['January'] : '0');
        $orders['February'] = (!empty($final['February']) ? $final['February'] : '0');
        $orders['March'] = (!empty($final['March']) ? $final['March'] : '0');
        $orders['April'] = (!empty($final['April']) ? $final['April'] : '0');
        $orders['May'] = (!empty($final['May']) ? $final['May'] : '0');
        $orders['June'] = (!empty($final['June']) ? $final['June'] : '0');
        $orders['July'] = (!empty($final['July']) ? $final['July'] : '0');
        $orders['August'] = (!empty($final['August']) ? $final['August'] : '0');
        $orders['September'] = (!empty($final['September']) ? $final['September'] : '0');
        $orders['October'] = (!empty($final['October']) ? $final['October'] : '0');
        $orders['November'] = (!empty($final['November']) ? $final['November'] : '0');
        $orders['December'] = (!empty($final['December']) ? $final['December'] : '0');
        // dd($orders);
        echo json_encode($orders);
    }

    public function cod_chart()
    {
        $data = $this->Dashboard_new_model->get_cod_year_chart_count($this->userType, $this->userId);

        $final = array_column($data, 'cod_amount', 'month_name');
        // dd($final);
        $orders['January'] = (!empty($final['January']) ? $final['January'] : '0');
        $orders['February'] = (!empty($final['February']) ? $final['February'] : '0');
        $orders['March'] = (!empty($final['March']) ? $final['March'] : '0');
        $orders['April'] = (!empty($final['April']) ? $final['April'] : '0');
        $orders['May'] = (!empty($final['May']) ? $final['May'] : '0');
        $orders['June'] = (!empty($final['June']) ? $final['June'] : '0');
        $orders['July'] = (!empty($final['July']) ? $final['July'] : '0');
        $orders['August'] = (!empty($final['August']) ? $final['August'] : '0');
        $orders['September'] = (!empty($final['September']) ? $final['September'] : '0');
        $orders['October'] = (!empty($final['October']) ? $final['October'] : '0');
        $orders['November'] = (!empty($final['November']) ? $final['November'] : '0');
        $orders['December'] = (!empty($final['December']) ? $final['December'] : '0');
        // dd($orders);
        echo json_encode($orders);
    }



    // prea awb dashboard data
    public function preawb_today_orders_count()
    {
        $today = $this->input->post('end');
        $fromday = $this->input->post('start');

        $data['created_order_count_result'] = $data['intransit_count_result'] = $data['ofd_count_result'] = $data['ndr_count_result'] = $data['delivered_count_result'] = $data['rto_intransit_count_result'] = $data['rto_delivered_count_result'] = $data['all_order_count_result'] = '0';
        $created_order_count = $this->Dashboard_new_model->get_today_order_count_preawb($today, $fromday, array('1'), $this->userId, $this->userType); //1//created order
        if (!empty($created_order_count)) {
            $data['all_order_count_result'] = $data['created_order_count_result'] = $created_order_count[0]['totalCount'];
        }
        $status = array('3', '5', '6', '9', '10', '11', '12', '13', '14', '18');
        $get_all_count = $this->Dashboard_new_model->get_today_order_count_preawb($today, $fromday, $status, $this->userId, $this->userType);
        if (!empty($get_all_count)) {
            foreach ($get_all_count as $count) {
                switch ($count['order_status_id']) {
                    case '3':
                        $data['intransit_count_result'] = $count['totalCount'];
                        $data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '5':
                        $data['ofd_count_result'] = $count['totalCount'];
                        $data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '6':
                        $data['delivered_count_result'] = $count['totalCount'];
                        $data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '9':
                        $data['rto_intransit_count_result'] += $count['totalCount'];
                        $data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '10':
                        $data['rto_intransit_count_result'] += $count['totalCount'];
                        $data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '11':
                        $data['rto_intransit_count_result'] += $count['totalCount'];
                        $data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '12':
                        $data['rto_intransit_count_result'] += $count['totalCount'];
                        $data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '13':
                        $data['rto_delivered_count_result'] += $count['totalCount'];
                        $data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '14':
                        $data['rto_delivered_count_result'] += $count['totalCount'];
                        $data['all_order_count_result'] += $count['totalCount'];
                        break;

                    case '18':
                        $data['ndr_count_result'] = $count['totalCount'];
                        $data['all_order_count_result'] += $count['totalCount'];
                        break;

                    default:
                        $de = '1';
                        break;
                }
            }
        }
        echo json_encode($data);
    }
}


//8511443237