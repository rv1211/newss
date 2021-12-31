<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Webhook extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Order_model');
		$this->load->model('Common_model');
		$this->load->model('Create_singleorder_awb');
	}
	public function index()
	{
		$log_data1 = array();
		$post_data = file_get_contents('php://input');
		$log_data['post_response'] = $post_data;
		$log_data['post_data'] = json_decode($post_data, true);

		file_put_contents(APPPATH . 'logs/create_order_zship_api/' . date("d-m-Y") . '_webhook_responce.txt', "------- Start Log ------\n" . print_r($log_data, true) . "\n\n\n\n", FILE_APPEND);
		$data = json_decode($post_data, true);
		if ($data['status'] == 200) {
			$count = count($data['message']['data']);
			foreach ($data['message']['data'] as $single) {
				if (substr($single['order_id'], -1) == 'B') {
					$temp_order_table = 'temp_order_master';
				} else {
					$temp_order_table = 'temp_forward_order_master';
				}
				$order_no = $single['order_id'];
				$tempOrderData = $this->Common_model->getSingle_data('id', $temp_order_table, array('order_no' => $order_no));
				$log_data1['get_temp_id'] = $this->db->last_query();
				$tempOrderId = $tempOrderData['id'];
				$log_data1['get_temp_result'] = $tempOrderId;
				if (@$single['status'] == 1 || $single['status'] == '1') {
					// Success Response
					$log_data1['Status'] = "success From Webhook.";
					$orderResponse = wallet_direct::debit_wallet($tempOrderId, $temp_order_table, trim($single['tracking_id']), $order_no, '', '1');
					$log_data1['orderResponse'] = $orderResponse;
					$success = 'Your Order Shipped Successfully ';
				} else {
					$error_msg = $single['info'];
					$log_data1['Status'] = $error_msg;
					$orderResponse = wallet_direct::debit_wallet($tempOrderId, $temp_order_table, trim($single['tracking_id']), $order_no, $error_msg, '1');
					$log_data1['orderResponse'] = $orderResponse;
					$error = "Your Order Failed to Shipped due to error." . @$error_msg;
				}
			}
		}
		file_put_contents(APPPATH . 'logs/create_order_zship_api/' . date("d-m-Y") . '_webhook_responce.txt', "\n" . print_r($log_data1, true) . "------- END Log ------\n\n\n\n\n", FILE_APPEND);
	}
}
/* End of file Webhook.php */
