<?php

use phpDocumentor\Reflection\Types\String_;

defined('BASEPATH') or exit('No direct script access allowed');

class Weight_missmatch extends Auth_Controller
{

	public $data;


	public function __construct()
	{
		parent::__construct();
		$this->load->model('Weight_missmatch_model');
		$this->load->helper('get_shiping_price');
	}



	public function index($data = "")
	{
		load_admin_view('weight_missmatch', 'missmatch', $this->data);
	}


	public function import_weight_exel()
	{

		$paths = FCPATH . "./assets/weightmissmatch_import/";
		$config['upload_path'] = './assets/weightmissmatch_import/';
		$config['allowed_types'] = 'xlsx|xls';
		$config['overwrite'] = TRUE;

		$this->upload->initialize($config);
		if (!$this->upload->do_upload('weight_excel')) {
			$this->session->set_flashdata('error', $this->upload->display_errors());
			redirect('weight-missmatch');
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
			redirect('weight-missmatch');
		}

		/*Fetch excel data to array*/
		$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

		/*Validate upload fomate values*/
		if (!empty($allDataInSheet)) {

			$final_array = array(); //array with database values
			$missmatch_array =  array(); //array with miss match data

			$arr_common_format = array("Awbno", "Actualweight");
			// dd($arr_common_format);
			/*Check pincode import excel file format*/
			if (!empty(array_diff($arr_common_format, $allDataInSheet[1]))) {
				$this->session->set_flashdata('error', 'Data format incorrect!');
				redirect('weight-missmatch');
			}

			//retriving order data from database
			foreach ($allDataInSheet as $key => $singlerecord) {
				if ($key == 1) {
					continue;
				}
				$get_all_data = $this->Weight_missmatch_model->get_order_data($singlerecord['A']);
				// lq();
				$shipment_type = "";
				if (!empty($get_all_data)) {
					$get_all_data[0]['actual_weight'] = $singlerecord['B'];
				}
				// dd($get_all_data);
				foreach ($get_all_data as $key => $val) {
					//shipmentype == order_status_id , 6 == deliverd == 0 , 13,14 == rto == 1
					switch ($val['order_status_id']) {
						case 6:
							$shipment_type = "0";
							break;
						case 13:
						case 14:
							$shipment_type = "1";
							break;
						default:
							$shipment_type = "1";
							break;
					}
					$total_shipping_price = get_shiping_price($val['sender_id'], $val['logistic_id'], $val['pickup_pincode'], $val['receiver_pincode'], $shipment_type,  $val['order_type'], $val['actual_weight'], $val['actual_weight'], $val['cod_amount'], 0, 18);
					$final_array[] = (array_merge($val, $total_shipping_price['data'][0]));
				}
			}
			// exit();

			// dd($get_all_data[0]['logistic_id']);

			// if (empty($$get_all_data[0]['logistic_id'])) {
			// 	$this->session->set_flashdata('error', 'Uploaded file Has Logistic Error');
			// 	redirect('weight-missmatch');
			// }

			//Histroy Entry	
			$id = $this->Weight_missmatch_model->insert_history_index($this->session->userdata('userId'), $get_all_data[0]['logistic_id']);

			//insert in database
			$data = array();
			foreach ($final_array as $record) {
				$data[] = [
					'missmatch_id' => $id,
					'sender_id' => $record['sender_id'],
					'order_id' => $record['id'],
					'awb_number' => $record['awb_number'],
					'order_date' => $record['created_date'],
					'debited_amount' => $record['total_shipping_amount'],
					'logistic_id' => $record['logistic_id'],
					'actual_weight' => $record['actual_weight'],
					'actual_amount' => $record['subtotal']
				];
			}

			$this->Weight_missmatch_model->insert_missmatch_record($data);
			$this->session->set_flashdata('message', 'File Uploaded Successfully');
			redirect('weight-missmatch-list');
		} else {
			$this->session->set_flashdata('error', 'Uploaded file is blank');
			redirect('weight-missmatch');
		}
	}


	public function weightmissmatch()
	{

		$this->data['mismatch_history'] = $this->Weight_missmatch_model->get_history($this->session->userdata('userId'), $this->session->userdata('userType'));
		// dd($this->data);
		load_admin_view('weight_missmatch', 'mismatch_table', $this->data);
	}

	public function get_missmatch_data()
	{
		$id = $this->input->post('id');
		$this->data['final_array'] = $this->Weight_missmatch_model->get_missmatch_data($id, $this->session->userdata('userType'));
		echo $this->load->view('admin/weight_missmatch/missmatch_list', $this->data, true);
	}
}

/* End of file Weight_missmatch.php */
