<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Customercredit_controller extends Auth_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->userId = $this->session->userdata('userId');
		$this->userType = $this->session->userdata('userType');
	}


	public $data;

	public function loadview(string $viewname)
	{

		$this->load->view('admin/template/header');
		$this->load->view('admin/template/sidebar');
		$this->load->view('admin/customercredit/' . $viewname, $this->data);
		$this->load->view('admin/template/footer');
	} //common view function created by rutvik 


	public function index()
	{
		$this->data['customer_list'] = $this->Common_model->getResultArray(array('status' => '1', 'is_active' => '1'), 'id,name,email,allow_credit,allow_credit_limit', 'sender_master');
		$this->loadview('customer_allow_credit');
	}

	public function customer_update_allow_credit()
	{
		if ($this->input->post('allow_credit') == 1) {
			$data['allow_credit'] = $this->input->post('allow_credit');
			$data['allow_credit_limit'] = $this->input->post('allow_credit_limit');
		} else {
			$data['allow_credit'] = "0";
			$data['allow_credit_limit'] = NULL;
		}
		$result = $this->Common_model->update($data, 'sender_master', array('id' => $this->input->post('customer_id')));
		if ($result) {
			echo "success";
		} else {
			echo "error";
		}
	}

	public function user_wallet_balance()
	{

		// if (@$this->userType == '1') {

		if ($this->userType == '1') {
			$this->data['user_list'] = $this->Common_model->getResult(array('status' => '1', 'is_active' => '1'), '*', 'sender_master');
		} else {
			$this->load->model('Wallet_balance_model');
			$this->data['user_list'] = $this->Wallet_balance_model->get_users($this->userType, $this->userId);
			// $this->data['user_list'] = $this->Common_model->getResult(array('status' => '1', 'is_active' => '1'), '*', 'sender_master');
		}
		// $data['all_transaction'] = $this->admin_model->get_all_wallet_transaction_by_id($this->userId);
		$this->loadview('user-wallet-balance', $this->data);
		// } else {
		// redirect('dashboard');
		// }

	}

	public function update_wallet_transaction_for_user()
	{


		$user_data = $this->Common_model->getRow(array('id' => $this->input->post('user_id')), 'id,wallet_balance,allow_credit', 'sender_master');
		// dd($user_data);
		$data['sender_id'] = $this->input->post('user_id');
		$data['remarks'] = $this->input->post('wallet_remarks');
		if (!empty($this->input->post('razorpay_pay_id'))) {
			$data['remarks'] .= " / (Pay ID: " . $this->input->post('razorpay_pay_id') . ")";
		}
		switch ($this->input->post('wallet_action')) {

			case 0:
				if ($this->input->post('wallet_amount') <= $user_data->wallet_balance) {

					$data['debit'] = $this->input->post('wallet_amount');
					$data1['wallet_balance'] = $data['runningbalance'] = $user_data->wallet_balance - $this->input->post('wallet_amount');
					break;
				} else {
					if ($user_data->allow_credit == 1) {
						$data['debit'] = $this->input->post('wallet_amount');
						$data1['wallet_balance'] = $data['runningbalance'] = $user_data->wallet_balance - $this->input->post('wallet_amount');
						break;
					} else {
						$this->session->set_flashdata('error', 'Unable to Debit becuse user credit not allowed !!');
						redirect('user-wallet-balance');
					}
				}

			case 1:
				$data['credit'] = $this->input->post('wallet_amount');
				$data1['wallet_balance'] = $data['runningbalance'] = $user_data->wallet_balance + $this->input->post('wallet_amount');
				break;
		}

		$result = $this->Common_model->insert($data, 'wallet_transaction');

		$userupdateresult = $this->Common_model->update($data1, 'sender_master', array('id' => $this->input->post('user_id')));

		if ($userupdateresult) {
			$this->session->set_flashdata('message', 'Insert wallet transaction Successfully');
			redirect('user-wallet-balance');
		} else {
			$this->session->set_flashdata('error', 'Something wents to wrong');
			redirect('user-wallet-balance');
		}
	}

	public function used_credit_list()
	{
		$this->data['customer_list'] = $this->Common_model->getResultArray(array('allow_credit' => '1', 'status' => '1', 'is_active' => '1'), 'id,name,email', 'sender_master');
		if ($this->input->post('submit') == "get_list") {
			// dd($_POST);
			$this->data['customer_id'] = $this->input->post('customer_id');
			$this->data['from_date'] = $this->input->post('from_date');
			$this->data['to_date'] = $this->input->post('to_date');
		}
		load_admin_view('customercredit', 'customer_used_credit', $this->data);
	}

	public function customer_used_credit_table()
	{
		$columns = array();
		$table = 'wallet_transaction';
		$primaryKey = 'id';
		$joinQuery = ' FROM ' . $table . ' wt INNER JOIN sender_master as sm ON sm.id= wt.sender_id';

		$where = "sm.status = '1' AND sm.allow_credit='1' AND wt.sender_id='" . $this->input->post('customer_id') . "' AND  DATE_FORMAT(wt.created_date,'%Y-%m-%d') between '" . $this->input->post('from_date') . "' AND '" . $this->input->post('to_date') . "' ";

		$columns[0] = array('db' => 'sm.name', 'dt' => 0, 'field' => 'name');
		$columns[1] = array('db' => 'sm.email', 'dt' => 1, 'field' => 'email');
		$columns[2] = array('db' => 'SUM(wt.debit) as debit', 'dt' => 2, 'field' => 'debit');
		$columns[3] = array('db' => 'sm.allow_credit_limit', 'dt' => 3, 'field' => 'allow_credit_limit');

		echo json_encode(
			SSP::simple($_POST, $table, $primaryKey, $columns, $joinQuery, $where)
		);
	}

	public function get_customer_credit()
	{
		$columns = array();
		$table = 'sender_master';
		$primaryKey = 'id';
		$where = "status = '1' AND allow_credit='1'";
		$columns[0] = array('db' => 'name', 'dt' => 0, 'field' => 'name');
		$columns[1] = array('db' => 'email', 'dt' => 1, 'field' => 'email');
		$columns[2] = array('db' => 'allow_credit_limit', 'dt' => 2, 'field' => 'allow_credit_limit');
		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns, null, $where)
		);
	}
}
    
    /* End of file Customercredit_controller.php */
