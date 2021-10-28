<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Front_login extends CI_Controller
{
	public $data = [];
	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->model('Forgot_password_model', 'Forgot_pwd');
		$this->load->helper('url'); //Loading url helper
		// $this->userAccount = $this->session->userdata('userAccount');
	}
	/**
	 * Login Page
	 * @return Layout
	 */
	public function index()
	{

		if (!$this->session->userdata('userId')) {
			if ($this->input->post()) {
				$validation = [
					['field' => 'user_email', 'label' => 'Email', 'rules' => 'trim|required|valid_email'],
					['field' => 'user_password', 'label' => 'Password', 'rules' => 'trim|required|min_length[8]|max_length[16]'],
				];
				$this->form_validation->set_rules($validation);
				if ($this->form_validation->run() == false) {
					redirect('login');
				} else {
					$email = @$this->input->post('user_email');
					$password = @$this->input->post('user_password');
					$customerDetail = $this->Common_model->getSingle_data('id, email, name, is_active, status,wallet_balance,is_pre_awb_allow', 'sender_master', array('email' => $email, 'password' => $password));

					if (!empty($customerDetail)) {
						if ($customerDetail['is_active'] == '1') {
							if ($customerDetail['status'] != '2') {
								$this->session->set_userdata('userId', @$customerDetail['id']);
								$this->session->set_userdata('userType', '4');
								$this->session->set_userdata('userEmail', @$customerDetail['email']);
								$this->session->set_userdata('userName', @$customerDetail['name']);
								$this->session->set_userdata('wallet_balance', @$customerDetail['wallet_balance']);
								$this->session->set_userdata('is_preawb_allow', @$customerDetail['is_pre_awb_allow']);
								$this->session->set_flashdata('message', 'Login success !!');
								$customerKycDetail = $this->Common_model->getSingle_data('id', 'kyc_verification_master', array('sender_id' => @$customerDetail['id']));
								if (empty($customerKycDetail)) {
									$this->session->set_userdata('userAllow', 'kyc');
									redirect('kyc-verification');
								} else {
									if ($customerDetail['status'] == '1') {
										$customerPickupDetail = $this->Common_model->getSingle_data('id', 'sender_address_master', array('sender_id' => @$customerDetail['id']));
										if (empty($customerPickupDetail)) {
											$this->session->set_userdata('userAllow', 'pickup');
										} else {
											$this->session->set_userdata('userAllow', '');
										}
										redirect('dashboard-new');
									} else {
										$this->session->set_userdata('userAllow', 'kycPending');
										redirect('approve-pending');
									}
								}
							} else {
								$this->session->set_flashdata('error', 'Your KYC rejected by Administrator.Please contact administrator');
								redirect('');
							}
						} else {
							$this->session->set_flashdata('error', 'Your account is currently Inactive.Please contact administrator');
							redirect('');
						}
					} else {
						$userDetail = $this->Common_model->getSingle_data('id, user_email, user_type, name, is_active,wallet_balance,is_pre_awb_allow', 'user_master', array('user_email' => $email, 'user_password' => ($password)));

						// dd($userDetail);

						if (!empty($userDetail)) {
							if ($userDetail['is_active'] == '1') {
								$this->session->set_userdata('userId', @$userDetail['id']);
								$this->session->set_userdata('userType', @$userDetail['user_type']);
								$this->session->set_userdata('userEmail', @$userDetail['user_email']);
								$this->session->set_userdata('userName', @$userDetail['name']);
								$this->session->set_userdata('is_preawb_allow', @$userDetail['is_pre_awb_allow']);
								$this->session->set_userdata('userAllow', '');
								$this->session->set_userdata('wallet_balance', @$userDetail['wallet_balance']);
								$this->session->set_flashdata('message', 'Login success !!');
								redirect('dashboard-new');
							} else {
								$this->session->set_flashdata('error', 'Your account is currently Inactive.Please contact administrator');
								redirect('');
							}
						} else {
							$this->session->set_flashdata('error', 'Invalid Email or Password');
							redirect('login');
						}
					}
				}
			} else {
				redirect('login/user');
			}
		} else {
			redirect('dashboard-new');
		}
	}

	/**
	 * Registration page for Customer
	 * @return Layout
	 */
	public function sign_up()
	{
		// dd($this->input->post());
		if (!$this->session->userdata('userId')) {
			if ($this->input->post()) {
				$validation = [
					['field' => 'first_name', 'label' => 'First Name', 'rules' => 'required'],
					// ['field' => 'last_name', 'label' => 'Last Name', 'rules' => 'required'],
					['field' => 'user_email', 'label' => 'Email Address', 'rules' => 'trim|required|valid_email|is_unique[sender_master.email]|is_unique[user_master.user_email]'],
					['field' => 'user_phone', 'label' => 'Mobile No', 'rules' => 'trim|required'],
					['field' => 'user_password', 'label' => 'Password', 'rules' => 'required|min_length[8]|max_length[16]'],
					['field' => 'user_confirm_password', 'label' => 'Confirm Password', 'rules' => 'required|min_length[4]|max_length[16]|matches[user_password]'],
					['field' => 'user_agreement', 'label' => 'Agreement', 'rules' => 'required'],
					['field' => 'user_website', 'label' => 'Website', 'rules' => 'trim|valid_url'],
				];
				$this->form_validation->set_rules($validation);
				if ($this->form_validation->run() == false) {
					// dd($this->form_validation->error_array());
					$this->data['errors'] = $this->form_validation->error_array();
					load_front_view('signup', $this->data);
				} else {
					// dd($this->form_validation->error_array());
					$name = @$this->input->post('first_name') . " " . @$this->input->post('last_name');
					if ($this->input->post('user_agreement')) {
						$details['is_active'] = '1';
					} else {
						$details['is_active'] = '0';
					}
					$details = [
						'email' => @$this->input->post('user_email'),
						'password' => @$this->input->post('user_password'),
						'name' => @$name,
						'mobile_no' => @$this->input->post('user_phone'),
						'website' => @$this->input->post('user_website'),
						'is_active' => '1',
						'status' => '0',
						'created_date' => date('Y-m-d H:i:s'),
						'updated_date' => date('Y-m-d H:i:s'),
					];
					$emp_id = $this->Common_model->insert($details, 'sender_master');

					if ($emp_id != "") {
						$this->session->set_flashdata('message', 'Registration success !!');
						redirect('');
					} else {
						$this->session->set_flashdata('error', 'Something Went Wrong');
						redirect('sign-up');
					}
				}
			} else {
				load_front_view('login');
			}
		} else {
			redirect('dashboard-new');
		}
	}

	public function logout()
	{
		session_destroy();
		redirect('');
	}

	// password reset
	public function sent_mail()
	{
		$string = urlseg(2);
		$string_exist = $this->Forgot_pwd->check_valid_string($string);
		// lq();
		$this->data['email'] = $string_exist;
		$this->data['type'] = $string_exist;
		if (!empty($string_exist)) {
			$string_delete = $this->Forgot_pwd->check_for_delete($string);
			$created_at = $string_delete->updated_at;
			// date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)
			$now = date('Y-m-d H:i:s');
			$mint_diff = abs(strtotime($now) - strtotime($created_at));
			$diff = round($mint_diff / 60);
			if ($diff <= 30) {
				load_user_view('reset_forgot_password', 'reset_forgot_password', $this->data);
			} else {
				$this->Common_model->delete('user_email', array('string' => $string));
				$this->session->set_flashdata('error', 'Token expired');
				redirect('forgot-password');
			}
		} else {
			$this->session->set_flashdata('error', 'Invalid token');
			redirect('forgot-password');
		}
	}

	public function update_pwd()
	{
		if ($this->input->post()) {
			$validation = [
				['field' => 'password', 'label' => 'password', 'rules' => 'required'],
				['field' => 'confirm_password', 'label' => 'confirm_password', 'rules' => 'required'],
			];
			$this->form_validation->set_rules($validation);
			if ($this->form_validation->run() == false) {
				$this->data['errors'] = $this->form_validation->error_array();
				load_user_view('reset_forgot_password', 'reset_forgot_password', $this->data);
			} else {
				$type = $this->input->post('type');
				$email = $this->input->post('email');
				if ($type == '0') {
					$senderdata = array(
						"password" => $this->input->post('password'),
					);
					$result = $this->Common_model->update($senderdata, 'sender_master', array('email' => $email));
					if ($result) {
						$this->session->set_flashdata('message', "Password successfully changed");
						redirect('');
					}
				} else {
					$userdata = array(
						"password" => $this->input->post('password'),
					);

					$result = $this->Common_model->update($userdata, 'user_master', array('user_email' => $email));
					if ($result) {
						$this->session->set_flashdata('message', "Password successfully changed");
						redirect('');
					}
				}
			}
		} else {
			$this->session->set_flashdata('message', "Something went wrong..!!");
			redirect('');
		}
	}
}
