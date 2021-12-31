<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Reorder extends Auth_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->model('Reorder_model');
	}


	/**
	 * Function take information from old order and genrate new order
	 *
	 * @param int $id
	 * @return void
	 */
	public function index($id)
	{

		file_put_contents(APPPATH . 'logs/create_reorder_simple/' . date("d-m-Y") . '_create_order.txt', "\n-------------- Start Create Order --------------\n", FILE_APPEND);
		$error_order = $this->Reorder_model->get_error_data($id); // get the error order data

		$logdata['error_order'] = $error_order;
		$error_order['order_no'] = $error_order['order_no'] . "-RE"; // genrate  new order number to remove same id error
		$logdata['new_order_no'] = $error_order['order_no'];

		$responce = $this->Reorder_model->delete_and_insert($error_order);


		$logdata['insert_responce'] = $responce;
		$logdata['executed_query'] = $this->db->last_query();

		file_put_contents(APPPATH . 'logs/create_reorder_simple/' . date("d-m-Y") . '_create_order.txt', print_r($logdata, true), FILE_APPEND);

		//check order is moved successfully from error table to temp table
		if ($responce['status'] == 1 && !empty($responce['temp_id'])) {
			$insert_tmp_order = $responce['temp_id'];
			$logistic_name = $this->Common_model->getSingle_data('api_name, logistic_name', 'logistic_master', array('id' => $error_order['logistic_id']));
			if ($logistic_name['api_name'] == "Delhivery_Surface" || $logistic_name['api_name'] == 'Xpressbees_Surface' || $logistic_name['api_name'] == 'Ekart_Surface') {
				$zship_sender_id = "";
				$add_id = $error_order['pickup_address_id'];
				$pickup_address_fetch_row_info = $this->Common_model->getSingle_data('*', 'sender_address_master', array('id' => $add_id));
				if ($pickup_address_fetch_row_info['zship_sender_id'] == "") {

					$email = (!empty($this->input->post('customer_email'))) ? $this->input->post('customer_email') :  "sample@gmail.com";
					$pickup_address_fetch_row_info['email'] = $email;
					$zship_sender_id = $this->order->create_address_in_api($pickup_address_fetch_row_info);
				} else {
					$zship_sender_id = $pickup_address_fetch_row_info['zship_sender_id'];
				}
				if ($zship_sender_id != '') {
					// $this->load->helper('zship_new');
					// // $response = create_order_zship($insert_tmp_order);
					// $createOrder_response_log['order_response'] = $response;
					// file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
				} else {
					$this->session->set_flashdata('error', 'Address not created in API');
					redirect('create-single-order');
				}
			} else if ($logistic_name['api_name'] == 'Xpressbees_Direct') {
				$repeat = 0;
				$response = xpressbees_direct::xpressbees_order($insert_tmp_order, 0);
				$createOrder_response_log['order_response'] = $response;
				if ($response['status'] == 0 && $response['message'] == 'AWB Already Exists' && $repeat == 0) {
					$response = xpressbees_direct::xpressbees_order($insert_tmp_order, 1);
					$createOrder_response_log['order_response_repeat'] = $response;
					$repeat++;
				}
				file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
			} else if ($logistic_name['api_name'] == 'Xpressbeesair_Direct') {
				$repeat = 0;
				$this->load->helper('xpressbeesair_direct');
				$response = xpressbeesair_direct::xpressbeesair_order($insert_tmp_order, 0);
				$createOrder_response_log['order_response'] = $response;
				if ($response['status'] == 0 && $response['message'] == 'AWB Already Exists' && $repeat == 0) {
					$response = xpressbeesair_direct::xpressbeesair_order($insert_tmp_order, 1);
					$createOrder_response_log['order_response_repeat'] = $response;
					$repeat++;
				}
				file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
			} else if ($logistic_name['api_name'] == 'Ekart_Direct') {
				// $this->load->helper('ecart_direct');
				$response = ekart_direct::ekart_order($insert_tmp_order, 0);
				$createOrder_response_log['order_response'] = $response;
				file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
			} else if ($logistic_name['api_name'] == 'Ecom_Direct') {

				$response = ecom_direct::ecom_order($insert_tmp_order, 0);
				$createOrder_response_log['order_response'] = $response;
				file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
				// dd($response);
			} else if ($logistic_name['api_name'] == 'Udaan_Direct') {
				$this->load->helper('udaan_direct');
				$response = Udaan_Direct::create_order($insert_tmp_order, 0);
				$createOrder_response_log['order_response'] = $response;
				file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
			} else if ($logistic_name['api_name'] == 'Shadowfax_Direct') {
				$this->load->helper('shadowfax_direct');
				$response = shadowfax_direct::create_order($insert_tmp_order, 0);
				$createOrder_response_log['order_response'] = $response;
				file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
			} else if ($logistic_name['api_name'] == 'Delhivery_Direct') {
				$this->load->helper('delhiver_direct');
				$response = delhiver_direct::create_order($insert_tmp_order, 0);
				$createOrder_response_log['order_response'] = $response;
				file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
			} else if ($logistic_name['api_name'] == 'Deliverysexpress_Direct') {
				$this->load->helper('delhiver_direct');
				$response = delhiver_direct::create_order($insert_tmp_order, 0, 1);
				$createOrder_response_log['order_response'] = $response;
				file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
			} else if (strpos($logistic_name['api_name'], 'ssl') !== false) {
				$this->load->helper('shiprocket_direct');
				$response = shiprocket_direct::create_order($insert_tmp_order, 0);
				$createOrder_response_log['order_response'] = $response;
				file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
			}



			if ($response['status'] == 0) {
				$this->session->set_flashdata('error', $response['message']);
			} else {
				if ($logistic_name['api_name'] == "Delhivery_Surface" || $logistic_name['api_name'] == 'Xpressbees_Surface' || $logistic_name['api_name'] == 'Ekart_Surface') {
					$this->session->set_flashdata('message', "Your request Has been accepted and Order in process.");
				} else {
					$this->session->set_flashdata('message', "Order Created Successfully.");
				}
			}
		} else {
			$this->session->set_flashdata('error', "Order Not Reset For Reorder");
		}
		file_put_contents(APPPATH . 'logs/create_reorder_simple/' . date("d-m-Y") . '_create_order.txt', "\n--------- End Create Order -----\n", FILE_APPEND);
		redirect('error-order-list');
	}
}

/* End of file Reorder.php */
