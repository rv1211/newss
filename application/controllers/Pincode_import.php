<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pincode_import extends Auth_Controller
{
	public $data = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->model('pincode_import_model');
		//Do your magic here
	}

	/**
	 * loadview coommon fucntion for load a view
	 *
	 * @param   string  $viewname  name of view that need to load
	 * @param   array  $data      Data that passes to view
	 *
	 * @return  view        load a view 
	 */
	public function loadview($viewname, $data = "")
	{
		$this->load->view('admin/template/header');
		$this->load->view('admin/template/sidebar');
		$this->load->view('admin/pincode_import/' . $viewname);
		$this->load->view('admin/template/footer');
	}

	/**
	 * add user view load
	 *
	 * @return  view  load add logistic form
	 */
	public function index($data = "")
	{
		if ($this->input->post()) {
			$validation = [
				['field' => 'logistic', 'label' => 'Logistic Type', 'rules' => 'required'],
				['field' => 'option', 'label' => 'Option', 'rules' => 'required'],
				// ['field' => 'pincode_excel', 'label' => 'Excel File', 'rules' => 'required'],
			];
			$this->form_validation->set_rules($validation);
			if ($this->form_validation->run() == FALSE) {
				$this->data['errors'] = $this->form_validation->error_array();
				$this->index($this->data);
			} else {
				$logistic_id = $this->input->post('logistic');
				$option = $this->input->post('option');
				//insert excel data
				$paths = FCPATH . "./assets/pincode_import/";

				$config['upload_path'] = './assets/pincode_import/';
				$config['allowed_types'] = 'xlsx|xls';
				$config['overwrite'] = TRUE;

				$this->upload->initialize($config);
				if (!$this->upload->do_upload('pincode_excel')) {
					$this->session->set_flashdata('error', $this->upload->display_errors());
					redirect('import-pincode');
				} else {
					$data = array('upload_data' => $this->upload->data());
					if (!empty($data['upload_data']['file_name'])) {
						$import_xls_file = $data['upload_data']['file_name'];
					} else {
						$import_xls_file = 0;
					}
				}
				$inputFileName = $paths . $import_xls_file;
				try {
					$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
					$objReader     = PHPExcel_IOFactory::createReader($inputFileType);
					$objPHPExcel   = $objReader->load($inputFileName);
				} catch (Exception $e) {
					$this->session->set_flashdata('error', 'Error loading file: ' . $e->getMessage());
					redirect('import-pincode');
				}
				/*Fetch excel data to array*/
				$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
				/*Validate upload fomate values*/
				if (!empty($allDataInSheet)) {
					$arr_common_format = array("Pincode", "City", "State", "COD(Y/N)", "Prepaid(Y/N)", "Pickup(Y/N)", "ReversePickup(Y/N)");
					$xpressbees_format = array_merge($arr_common_format, array("AreaCode", "HubZoneName"));
					$shadowfax_format = array_merge($arr_common_format, array("ZoneMapping"));

					// if($logistic_id=="1"){
					//     /*Check pincode import excel file format for Shadowfax*/
					//     if(!empty(array_diff($shadowfax_format,$allDataInSheet[1]))){
					//         $this->session->set_flashdata('error','Data format incorrect for Shadowfax pincode import');
					//         redirect('import-pincode');	
					//     }

					// }else if($logistic_id=="2" || $logistic_id=="3"){
					//     /*Check pincode import excel file format for Xpressbees Lite and Xpressbees Express*/
					//     if(!empty(array_diff($xpressbees_format,$allDataInSheet[1]))){
					//         $this->session->set_flashdata('error','Data format incorrect for Xpressbees pincode import');
					//         redirect('import-pincode');	
					//     }
					// }else{
					/*Check pincode import excel file format*/
					if (!empty(array_diff($arr_common_format, $allDataInSheet[1]))) {
						$this->session->set_flashdata('error', 'Data format incorrect!');
						redirect('import-pincode');
					}
					// }
					// dd($allDataInSheet);
					$import_result = $this->pincode_import_model->manage_pincode_entries($allDataInSheet, $option, $logistic_id);
					/*result message display and redirect*/
					$this->session->set_flashdata($import_result['response'], $import_result['message']);
					redirect('import-pincode');
				} else {
					$this->session->set_flashdata('error', 'Uploaded file is blank');
				}
			}
		} else {
			$this->data['logistic_name'] = $this->Common_model->getall_data('*', 'logistic_master', array('is_active' => '1'));
			$this->loadview('pincode_import_form', $this->data);
		}
	}

	public function genrate_pincode()
	{
		if ($this->input->post('submit') == "Generate Pincode") {
			file_put_contents(APPPATH . 'logs/ecom_pincode/' . date("d-m-Y") . '_ecom_pincode_log.txt', "\n", FILE_APPEND);
			$log_data = array();
			$request_body = 'username=' . urlencode($this->config->item('ECOM_API_USER')) . '&password=' . urlencode($this->config->item('ECOM_API_PASS'));

			$curl_response = CUSTOM::curl_request('application/json', '', $this->config->item('ECOM_API_PINCODE'), $request_body, "POST", '');
			$log_data['pincode_response'] = $curl_response;
			file_put_contents(APPPATH . 'logs/ecom_pincode/' . date("d-m-Y") . '_ecom_pincode_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);

			$import_result = $this->pincode_import_model->insert_ecom_pincode($curl_response);
			if ($import_result) {
				$this->session->set_flashdata('message', 'Pincode Generated Successfully');
				redirect('generate-pincode-ecom');
			} else {
				$this->session->set_flashdata('error', 'Something went wrong!! Try again');
				redirect('generate-pincode-ecom');
			}
		} else {
			$this->loadview('import_ecom_pincode', $this->data);
		}
	}
}
