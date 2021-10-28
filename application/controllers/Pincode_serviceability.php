<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pincode_serviceability extends Auth_Controller
{
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pincode_serviceability_model');
		$this->userId = $this->session->userdata('userId');
		$this->userType = $this->session->userdata('userType');
		ini_set('memory_limit', '-1');

		//Do your magic here
	}
	public function loadview($viewname)
	{
		$this->load->view('admin/template/header');
		$this->load->view('admin/template/sidebar');
		$this->load->view('admin/pincode/' . $viewname, $this->data);
		$this->load->view('admin/template/footer');
	}

	/**
	 * pincode_serviceability
	 *
	 * @return  load pincode_serviceability '1'!== '1'
	 */
	public function index()
	{
		if ($this->input->post('submit') == "Get Pincode") {
			$this->data['your_pincode'] = $this->input->post('your_pincode');
			$this->data['check_pincode'] = $this->input->post('check_pincode');
			$where = "pincode IN (" . $this->data['your_pincode'] . "," . $this->data['check_pincode'] . ")";
			$pincode_master = $this->Common_model->getSingle_data('count(*) as count', 'pincode_master', $where);
			if (!empty($pincode_master)) {
				$this->data['pincode_details'] = $this->Common_model->getSingle_data('pincode, city,state', 'pincode_master', array('pincode' => $this->data['check_pincode']));
				$logistic_details = $this->Pincode_serviceability_model->get_pincode_details($this->data['your_pincode'], $this->data['check_pincode'], $this->userId, $this->userType);
				$arr = $pin_code = array();
				if (!empty($logistic_details)) {
					$pin_code['is_cod'] = $pin_code['is_prepaid'] = $pin_code['is_pickup'] = $pin_code['is_reverse_pickup'] = '0';
					foreach ($logistic_details as $logistic) {
						if ($logistic['pincode'] ==  $this->data['check_pincode'] && $logistic['pincode'] ==  $this->data['your_pincode']) {
							$pin_code['is_cod'] = $logistic['is_cod'];
							$pin_code['is_prepaid'] = $logistic['is_prepaid'];
							$pin_code['is_pickup'] = $logistic['is_pickup'];
							$pin_code['is_reverse_pickup'] = $logistic['is_reverse_pickup'];
						} elseif ($logistic['pincode'] ==  $this->data['check_pincode']) {
							$pin_code['is_reverse_pickup'] = $logistic['is_reverse_pickup'];
							$pin_code['is_cod'] = $logistic['is_cod'];
							$pin_code['is_prepaid'] = $logistic['is_prepaid'];
						} elseif ($logistic['pincode'] ==  $this->data['your_pincode']) {
							$pin_code['is_pickup'] = $logistic['is_pickup'];
						}
						$pin_code['api_name'] = $logistic['api_name'];
						$pin_code['logistic_name'] = $logistic['logistic_name'];
						$arr[$logistic['logistic_name']] = $pin_code;
					}
					$this->data['logistic_details'] = $arr;
				} else {
					$this->session->set_flashdata('error', "No Data Found");
				}
			} else {
				$this->session->set_flashdata('error', "Pincode Not Available");
			}
		}
		$this->loadview('pincode_serviceability', $this->data);
	}
}

/* End of file Pincode_serviceability.php */
