<?php

use Razorpay\Api\Api;

defined('BASEPATH') or exit('No direct script access allowed');

class Wallet extends Auth_Controller
{

	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Common_model');
		$this->customer_id = $this->session->userdata('userId');
		$this->name = $this->session->userdata('name');
		$this->email = $this->session->userdata('email');
		// $this->userAccount = $this->session->userdata('userAccount');
	}


	public function loadview(string $viewname, $data = "")
	{

		$this->load->view('admin/template/header');
		$this->load->view('admin/template/sidebar');
		$this->load->view('admin/wallet/' . $viewname, $data);
		$this->load->view('admin/template/footer');
	} //common view function created by rutvik 

	/**
	 * wallet Transaction
	 * @return Layout
	 */
	public function index()
	{
		if ($this->input->post()) {
			$validation = [
				['field' => 'wallet_amount', 'label' => 'Wallet Amount', 'rules' => 'trim|required|numeric'],
			];

			$this->form_validation->set_rules($validation);

			if ($this->form_validation->run() == FALSE) {
				$this->data['errors'] = $this->form_validation->error_array();
				$this->loadview('wallet_transaction', $this->data);
			}
		} else {

			if ($this->session->userdata('userType') == 4) {
				$this->data['wallet_balance'] = $this->Common_model->getWhere(array('id' => $this->customer_id), 'wallet_balance', 'sender_master');
			} else {
				$this->data['wallet_balance'] = $this->Common_model->getWhere(array('id' => $this->customer_id), 'wallet_balance', 'user_master');
			}

			$this->loadview('wallet_transaction', $this->data);
		}
	}

	/**
	 * logisctic list datatable
	 *
	 * @return  datatable  load all logistic in database
	 */
	public function loadwallat_transaction()
	{

		$userid = $this->session->userdata('userId');


		$columns = array();
		$table = 'wallet_transaction';
		$primaryKey = 'id';
		$where = "sender_id = $userid";

		$columns[0] = array('db' => 'created_date', 'dt' => 0, 'field' => 'created_date');
		$columns[1] = array('db' => 'debit', 'dt' => 1, 'field' => 'debit');
		$columns[2] = array('db' => 'credit', 'dt' => 2, 'field' => 'credit');
		$columns[3] = array('db' => 'runningbalance', 'dt' => 3, 'field' => 'runningbalance');
		$columns[4] = array('db' => 'remarks', 'dt' => 4, 'field' => 'remarks');

		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns, '', $where)
		);
	}

	/**
	 * @return status return the status of wallet balance inseted or not
	 */
	public function insert_wallet_recharge()
	{

		if ($this->session->userdata('userType') == 4) {
			$result_customer_wallet_credit = $this->Common_model->getRowArray(array('id' => $this->customer_id), 'wallet_balance', 'sender_master');
		} else {
			$result_customer_wallet_credit = $this->Common_model->getRowArray(array('id' => $this->customer_id), 'wallet_balance', 'user_master');
		}

		// $log_array_value['select_query_for_get_wallet_balance_of_customer'] = $this->db->last_query();
		// $log_array_value['available_wallet_balance'] = $result_customer_wallet_credit['wallet_credit'];
		// $log_array_value['post_data'] = $_POST;

		$insert_data = array(
			'sender_id' => $this->customer_id,
			'credit' => $this->input->post('totalAmount'),
			'remarks' => "Payment Made from RZP " . $this->input->post('razorpay_payment_id'),
			'runningbalance' => $this->input->post('totalAmount') + $result_customer_wallet_credit[0]['wallet_balance'],
			'created_by' => $this->customer_id,
			'created_date' => date("Y-m-d H:i:s"),
		);

		$message = '';
		$total_rate = ($this->input->post('totalAmount') * 100);

		include $this->config->item('FILE_PATH') . "application/views/payment-razorpay/Razorpay.php";
		$api = new Api($this->config->item('RAZORPAY_KEY'), $this->config->item('RAZORPAY_TOKEN'));
		$payment_fetch = $api->payment->fetch($this->input->post('razorpay_payment_id'));
		$log_array_value['razorpay_payment_fetch_for_wallet'] = $payment_fetch;
		try {
			$payment = $payment_fetch->capture(array('amount' => $total_rate, 'currency' => 'INR'));
			// $log_array_value['razorpay_payment_response_for_wallet'] = $payment;
			if (!empty($payment) && $payment->id != "" && $payment->error_reason == "") {
				$wallet_insert_result = $this->Common_model->insert($insert_data, 'wallet_transaction');
				// $log_array_value['insert_query_for_wallet_transaction'] = $this->db->last_query();
				$total_wallet_balance['wallet_balance'] = $result_customer_wallet_credit[0]['wallet_balance'] + $this->input->post('totalAmount');

				if ($this->session->userdata('userType') == 4) {
					$wallet_update_result = $this->Common_model->update($total_wallet_balance, 'sender_master', array('id' => $this->customer_id));
				} else {
					$wallet_update_result = $this->Common_model->update($total_wallet_balance, 'user_master', array('id' => $this->customer_id));
				}
				// $log_array_value['update_query_for_wallet_credit_in_customer_master'] = $this->db->last_query();

				$this->session->set_userdata('wallet_balance', $total_wallet_balance['wallet_balance']);
				$message = 'success';
			} else {
				$log_array_value['razorpay_payment_capture_error_for_wallet'] = @$payment->error_reason;
				$message = "Something intrupt with your payment it will reward soon";
			}
		} catch (Exception $e) {
			$message = $e;
			$log_array_value['razorpay_payment_response_error_for_wallet'] = $e;
		}
		$arr = array('message' => $message, 'status' => true);
		// CUSTOM::put_log_in_file($this->customer_id, 'wallet-transaction-data', $log_array_value, 1, 1);

		echo json_encode($arr);
		exit();
	}
}