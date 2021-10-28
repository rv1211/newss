<?php

defined('BASEPATH') or exit('No direct script access allowed');
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
class Xpress_awb extends Auth_Controller
{

	public $data = array();

	public function __construct()
	{
		parent::__construct();
		$this->customer_id = $this->session->userdata('userId');
		$this->load->model('Common_model');
	}


	public function index()
	{


		$this->data['logisticDetail'] = $this->Common_model->getall_data('api_name, logistic_name', 'logistic_master', array('is_zship' => '1', 'is_active' => '1', 'api_name' => 'Xpressbees_Direct'));

		if ($this->input->post()) {
			$validation = [
				['field' => 'order_type', 'label' => 'Order Type', 'rules' => 'trim|required'],
			];
			$this->form_validation->set_rules($validation);

			if ($this->form_validation->run() == FALSE) {
				$this->data['errors'] = $this->form_validation->error_array();
				load_admin_view('xpressbess_awb', 'add_xpress_awb', $this->data);
			} else {
				$logistic = $this->input->post('logistic');
				$order_type = $this->input->post('order_type');
				$is_express = $this->input->post('is_air');
				$responce = $this->genrate_awb($order_type, $is_express);
				// dd($responce);
				if ($responce['curl_response']['success_response']['BatchID']) {
					$batchID = $responce['curl_response']['success_response']['BatchID'];
					$responce1 = $this->get_awb($batchID, $order_type, $is_express);
					if (!empty($responce1['success'])) {
						$this->session->set_flashdata('message', 'Awb Number Genetated Successfully');
					} else {
						$this->session->set_flashdata('error', 'Something Went Wrong');
					}
				} else {
					$this->session->set_flashdata('error', $responce['error']);
				}
				redirect('genrate-awb-xpress');
			}
		} else {
			load_admin_view('xpressbess_awb', 'add_xpress_awb', $this->data);
		}
	}


	public function index_air()
	{
		$this->data['logisticDetail'] = $this->Common_model->getall_data('api_name, logistic_name', 'logistic_master', array('is_zship' => '1', 'is_active' => '1', 'api_name' => 'Xpressbeesair_Direct'));
		load_admin_view('xpressbess_awb', 'add_xpressair_awb', $this->data);
	}


	public function genrate_awb($order_type, $is_express)
	{
		file_put_contents(APPPATH . 'logs\xpress_awb\_' . date("d-m-Y") . '_xpress_awb.txt', "\n----------------------------------START ADD Xpress awb FOR REQUEST -------------------------------------\n", FILE_APPEND);
		$url = $this->config->item('XPRESSBEES_AWB_REQUEST');


		if ($is_express == "1") {
			$xbkey = $this->config->item('XPRESSBEES_AIR_ORDER_KEY');
		} else {
			$xbkey = $this->config->item('XPRESSBEES_ORDER_KEY');
		}

		$body = '{
			    "BusinessUnit" : "ECOM",
			    "ServiceType" : "FORWARD",
			    "DeliveryType" : "' . $order_type . '",
			}';

		// dd($body);
		$curl_response = CUSTOM::curl_request('application/json', "", $url, $body, "POST", "", $xbkey);

		// dd($curl_response);
		$awb_log['curl_response'] = $curl_response;
		if (!empty($curl_response)) {
			if (!empty($curl_response['success_response'])) {
				if ($curl_response['success_response']['ReturnCode'] == '100') {
					if (!empty($curl_response['success_response']['BatchID'])) {
						$awb_log['success']['batchID'] = $curl_response['success_response']['BatchID'];
					}
				} else {
					$awb_log['error'] = $curl_response['success_response']['ReturnMessage'];
				}
			} else {
				$awb_log['error'] = $curl_response['success_response']['ReturnMessage'];
			}
		} else {
			$awb_log['error'] = 'Something Went Wrong!!!';
		}
		file_put_contents(APPPATH . 'logs\xpress_awb\_' . date("d-m-Y") . '_xpress_awb.txt', print_r($awb_log, true) . "\n------------------- Get AWB REQUEST End ---------------\n", FILE_APPEND);
		return $awb_log;
	}

	public function get_awb($batchID, $order_type, $is_express)
	{

		file_put_contents(APPPATH . 'logs\xpress_awb\_' . date("d-m-Y") . '_xpress_awb_.txt', "\n----------------------------------START ADD Xpress awb FOR RESPONCE -------------------------------------\n", FILE_APPEND);
		$url = $this->config->item('XPRESSBEES_AWB_RESPONCE');


		$body = '{
			    "BusinessUnit" : "ECOM",
			    "ServiceType" : "FORWARD",
			    "BatchID" : "' . $batchID . '",
			}';

		if ($is_express == "1") {
			$xbkey = $this->config->item('XPRESSBEES_AIR_ORDER_KEY');
		} else {
			$xbkey = $this->config->item('XPRESSBEES_ORDER_KEY');
		}

		$curl_response = CUSTOM::curl_request('application/json', "", $url, $body, "POST", "", $xbkey);

		$awb_log['curl_response'] = $curl_response;
		if (!empty($curl_response)) {
			if (!empty($curl_response['success_response'])) {
				if ($curl_response['success_response']['ReturnCode'] == '100') {
					if (!empty($curl_response['success_response']['AWBNoSeries'])) {
						$awb_log['success']['batchID'] = $curl_response['success_response']['BatchID'];
						$awb_array = $curl_response['success_response']['AWBNoSeries'];

						// $awb_array = ['5246546544', '56341654654654', '14653465465', '14656546544', '3514454654'];
						$insdata = [];
						if ($order_type == "COD") {
							$type = 1;
						} else if ($order_type == 'PREPAID') {
							$type = 2;
						} else {
							$type = 3;
						}
						foreach ($awb_array as $key => $value) {
							$insdata[] = [
								"awb_number" => $value,
								"is_used" => '1',
								"type" => $type,
								"for_what" => '2'
							];
						}

						// dd($insdata);
						if ($is_express == "1") {
							$result = $this->db->insert_batch('xpressbeesair_direct_airwaybill', $insdata);
						} else {
							$result = $this->db->insert_batch('xpressbees_direct_airwaybill', $insdata);
						}
						$awb_log['insert_result'] = $result;
						if (!empty($result)) {
							$awb_log['success'] = "AWB Generated Successfully";
						} else {
							$awb_log['error'] = "AWB Generate Failed!!";
						}
					}
				} else {
					$awb_log['error'] = $curl_response['success_response']['ReturnMessage'];
				}
			} else {
				$awb_log['error'] = $curl_response['success_response']['ReturnMessage'];
			}
		} else {
			$awb_log['error'] = 'Something Went Wrong !!!';
		}
		file_put_contents(APPPATH . 'logs\xpress_awb\_' . date("d-m-Y") . '_xpress_awb.txt', print_r($awb_log, true) . "\n------------------- Get AWB RESPONCE End ---------------\n", FILE_APPEND);
		return $awb_log;
	}

	public function get_total_awb()
	{
		$order_type = $this->input->post('order_type');
		$is_express = $this->input->post('is_express');

		switch ($order_type) {
			case 'COD':
				$type = '1';
				break;

			case 'PREPAID':
				$type = '2';
				break;

			default:
				$type = '3';
				break;
		}

		$sql =
			$this->db->select('*');
		if ($is_express == '1') {
			$this->db->from('xpressbeesair_direct_airwaybill');
		} else {
			$this->db->from('xpressbees_direct_airwaybill');
		}
		$this->db->where('type', $type);
		$count = $this->db->count_all_results();

		echo json_encode(['count' => $count]);
		exit;
	}
}

/* End of file Controllername.php */
