<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Auth_Controller
{
	public $data;

	public function __construct()
	{
		parent::__construct();
		redirect('dashboard-new');
		// $this->load->model('Dashboard_model');
		// $this->userId = $this->session->userdata('userId');
		// $this->userType = $this->session->userdata('userType');
		// if ($this->session->userdata('userType') == '4' && $this->session->userdata('userAllow') != "") {
		// 	if ($this->session->userdata('userAllow') == "kyc") {
		// 		redirect('kyc-verification');
		// 	}
		// 	if ($this->session->userdata('userAllow') == "kycPending") {
		// 		redirect('approve-pending');
		// 	}
		// 	if ($this->session->userdata('userAllow') == "pickup") {
		// 		redirect('pickup-address');
		// 	}
	}


	public function index()
	{
		if ($this->userType == '4') {
			$this->data = $this->Common_model->getSingle_data('name', 'sender_master', array('id' => $this->userId));
		} else {
			$this->data = $this->Common_model->getSingle_data('name', 'user_master', array('id' => $this->userId));
		}
		$this->data['logistics_list'] = $this->Dashboard_model->get_all_logistics($this->userId, $this->userType);

		$this->load->view('admin/template/header');
		$this->load->view('admin/template/sidebar');
		$this->load->view('admin/dashboard/dashboard', $this->data);
		$this->load->view('admin/template/footer');
	}

	public function new_dashboard()
	{
		if ($this->userType == '4') {
			$this->data = $this->Common_model->getSingle_data('name', 'sender_master', array('id' => $this->userId));
		} else {
			$this->data = $this->Common_model->getSingle_data('name', 'user_master', array('id' => $this->userId));
		}
		$this->data['logistics_list'] = $this->Dashboard_model->get_all_logistics($this->userId, $this->userType);

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

		$get_c_date = $this->Dashboard_model->get_daily_shipment_count(1, $today, $fromday, $this->userType, $this->userId, $logistic);

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
		$get_u_date = $this->Dashboard_model->get_daily_shipment_count($status, $today, $fromday, $this->userType, $this->userId, $logistic);
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
		$this->data['sender_data']  = "";
		echo $this->load->view('admin/dashboard/daily_shipment_table', $this->data, true);
	}

	public function ofd_count()
	{
		$today = $this->input->post('end');
		$fromday = $this->input->post('start');

		$data['total_ofd'] = $this->Dashboard_model->get_today_order_count($today, $fromday, 5, $this->userId, $this->userType); //5//total_ofd
		$data['total_delivered'] = $this->Dashboard_model->get_today_order_count($today, $fromday, 6, $this->userId, $this->userType); //6//total_delivered
		$rto_manifest = $this->Dashboard_model->get_today_order_count($today, $fromday, 9, $this->userId, $this->userType);
		$rto_processing = $this->Dashboard_model->get_today_order_count($today, $fromday, 10, $this->userId, $this->userType);
		$rto_intransit = $this->Dashboard_model->get_today_order_count($today, $fromday, 11, $this->userId, $this->userType);
		$rto_dispatched = $this->Dashboard_model->get_today_order_count($today, $fromday, 12, $this->userId, $this->userType);
		$returned = $this->Dashboard_model->get_today_order_count($today, $fromday, 13, $this->userId, $this->userType);
		$rto = $this->Dashboard_model->get_today_order_count($today, $fromday, 14, $this->userId, $this->userType);
		$data['total_rto'] = ($rto_manifest + $rto_processing + $rto_intransit + $rto_dispatched + $returned + $rto);
		$data['total_undelivered'] = $this->Dashboard_model->get_today_order_count($today, $fromday, 18, $this->userId, $this->userType); //18//total_undelivered
		echo json_encode($data);
	}
	public function carrier_performance_count()
	{
		$today = $this->input->post('end');
		$fromday = $this->input->post('start');

		$all_total_data = $logistic = array();

		$all_total_count = $this->Dashboard_model->get_carrier_performance_count('', $today, $fromday, $this->userType, $this->userId);

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
		$carrier_performance_data = $this->Dashboard_model->get_carrier_performance_count($status, $today, $fromday, $this->userType, $this->userId);

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
		$this->data['total_count'] = $this->Dashboard_model->get_today_order_count($today, $fromday, '', $this->userId, $this->userType); //total count
		$this->data['delivered_count'] = $this->Dashboard_model->get_today_order_count($today, $fromday, 6, $this->userId, $this->userType); //delivered 
		$this->data['intransit_count'] = $this->Dashboard_model->get_today_order_count($today, $fromday, 3, $this->userId, $this->userType); //in transist
		$this->data['ofd_count'] = $this->Dashboard_model->get_today_order_count($today, $fromday, 5, $this->userId, $this->userType); //Dispatched//Out for Delivery //OFD

		//RTO in transist
		$rto_manifested = $this->Dashboard_model->get_today_order_count($today, $fromday, 9, $this->userId, $this->userType);
		$rto_processing = $this->Dashboard_model->get_today_order_count($today, $fromday, 10, $this->userId, $this->userType);
		$rto_intransit = $this->Dashboard_model->get_today_order_count($today, $fromday, 11, $this->userId, $this->userType);
		$rto_dispatched = $this->Dashboard_model->get_today_order_count($today, $fromday, 12, $this->userId, $this->userType);
		//RTO delivered
		$rto_returned = $this->Dashboard_model->get_today_order_count($today, $fromday, 13, $this->userId, $this->userType);
		$rto = $this->Dashboard_model->get_today_order_count($today, $fromday, 14, $this->userId, $this->userType);

		$this->data['rto_count'] = (@$rto_manifested + @$rto_processing + @$rto_intransit +  @$rto_dispatched + @$rto_returned + @$rto);

		echo $this->load->view('admin/dashboard/carrier_performance_table', $this->data, true);
	}

	public function today_orders_count()
	{
		$today = $this->input->post('end');
		$fromday = $this->input->post('start');

		$data['all_created_order_count'] = $this->Dashboard_model->get_today_order_count('', '', 1, $this->userId, $this->userType); //1//all created order
		$data['created_order_count_result'] = $this->Dashboard_model->get_today_order_count($today, $fromday, 1, $this->userId, $this->userType); //1//created order
		$data['intransit_count_result'] = $this->Dashboard_model->get_today_order_count($today, $fromday, 3, $this->userId, $this->userType); //in transist
		$data['ofd_count_result'] = $this->Dashboard_model->get_today_order_count($today, $fromday, 5, $this->userId, $this->userType); //Dispatched//Out for Delivery //OFD
		$data['ndr_count_result'] = $this->Dashboard_model->get_today_order_count($today, $fromday, 18, $this->userId, $this->userType); //NDR
		$data['delivered_count_result'] = $this->Dashboard_model->get_today_order_count($today, $fromday, 6, $this->userId, $this->userType); //delivered

		//RTO in transist
		$rto_manifested = $this->Dashboard_model->get_today_order_count($today, $fromday, 9, $this->userId, $this->userType);
		$rto_processing = $this->Dashboard_model->get_today_order_count($today, $fromday, 10, $this->userId, $this->userType);
		$rto_intransit = $this->Dashboard_model->get_today_order_count($today, $fromday, 11, $this->userId, $this->userType);
		$rto_dispatched = $this->Dashboard_model->get_today_order_count($today, $fromday, 12, $this->userId, $this->userType);
		$data['rto_intransit_count_result'] = (@$rto_manifested + @$rto_processing + @$rto_intransit +  @$rto_dispatched);

		//RTO delivered
		$rto_returned = $this->Dashboard_model->get_today_order_count($today, $fromday, 13, $this->userId, $this->userType);
		$rto = $this->Dashboard_model->get_today_order_count($today, $fromday, 14, $this->userId, $this->userType);
		$data['rto_delivered_count_result'] = (@$rto_returned + @$rto);
		$data['all_order_count_result'] = ($data['created_order_count_result'] + $data['intransit_count_result'] +  $data['ofd_count_result'] + $data['ndr_count_result'] +  $data['delivered_count_result'] + $data['rto_intransit_count_result'] + $data['rto_delivered_count_result']);  //all order
		echo json_encode($data);
	}

	public function cod_remittance_count()
	{
		$today = $this->input->post('end');
		$fromday = $this->input->post('start');

		$get_remitted_amount = $this->Dashboard_model->get_cod_remittanace_count('2', $today, $fromday, $this->userId, $this->userType);
		$data['remitted_amount'] = $get_remitted_amount['cod_amount'] == null ? '0' : $get_remitted_amount['cod_amount'];

		$get_unremitted_amount = $this->Dashboard_model->get_cod_remittanace_count('3', $today, $fromday, $this->userId, $this->userType);
		$data['unremitted_amount'] = $get_unremitted_amount['cod_amount'] == null ? '0' : $get_unremitted_amount['cod_amount'];

		$get_shipping_amount = $this->Dashboard_model->get_cod_remittanace_count('1', $today, $fromday, $this->userId, $this->userType);
		$data['avg_shipping_amnt'] = $get_shipping_amount[0]['shipping_amount'] == null ? '0.00' : $get_shipping_amount[0]['shipping_amount'];

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
		// lq();
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
}


//8511443237
