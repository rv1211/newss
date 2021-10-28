<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Codremittance extends Auth_Controller
{

	public $data;

	public function __construct()
	{
		parent::__construct();
		// dd($_SESSION);
		$this->customer_id = $this->session->userdata('userId');
		$this->name = $this->session->userdata('name');
		$this->email = $this->session->userdata('email');
		$this->type = $this->session->userdata('userType');
		$this->wallet_credit = $this->session->userdata('wallet_credit');
		$this->allow_credit = $this->session->userdata('allow_credit');
		$this->load->model('Codremittance_model');
		$this->load->model('Common_model');
	}

	public function cod_available_list()
	{
		$this->data['services'] = $this->Common_model->getAllData('logistic_master');
		if ($this->input->post('submit')) {
			$this->data['select_service'] = $this->input->post('service_id');
		}
		load_admin_view('codremittance', 'cod_remittance_list', $this->data);
	}

	public function cod_available_ajax_get_list()
	{
		$columns = array();
		$table = 'forward_order_master';
		$primaryKey = 'id';
		$where_condition = "";

		$columns[0] = array('db' => 'ot.id', 'dt' => 0, 'formatter' => function ($d, $row) {
			return '<input type="checkbox" class="check_single_cod_available_order" name="check_order_id[' . $row[0] . ']" value="' . $row[0] . '">';
		}, 'field' => 'id');
		$columns[1] = array('db' => 'ot.order_no', 'dt' => 1, 'field' => 'order_no');
		// $columns[2] = array('db' => 'ot.order_number', 'dt' => 2, 'field' => 'order_number');
		$columns[3] = array('db' => 'ot.awb_number', 'dt' => 3, 'field' => 'awb_number');
		$columns[4] = array('db' => 'opd.cod_amount', 'dt' => 4, 'field' => 'cod_amount');

		$columns[5] = array('db' => 'ot.updated_date', 'dt' => 5, 'formatter' => function ($d, $row) {
			return date("d-m-Y", strtotime($d));
		}, 'field' => 'updated_date');
		$columns[6] = array('db' => 'ot.created_date', 'dt' => 6, 'formatter' => function ($d, $row) {
			return date("d-m-Y H:i:s", strtotime($d));
		}, 'field' => 'created_date');
		$columns[7] = array('db' => 'sm.name', 'dt' => 7, 'field' => 'name');

		$join_query = "FROM {$table} AS ot
		LEFT JOIN sender_master AS sm ON sm.id=ot.sender_id
		LEFT JOIN order_product_detail AS opd ON opd.id=ot.order_product_detail_id";

		$where = " ot.order_status = 'delivered' AND ot.is_cod_remittance=0 AND ot.service_id='" . $this->input->post('service') . "'";
		$joinQuery = $join_query;
		echo json_encode(
			SSP::simple($_POST, $table, $primaryKey, $columns, $joinQuery, $where)
		);
	}

	public function update_cod_available_order_list()
	{
		$order_data = array(
			'is_cod_remittance' => "1",
			'is_cod_available_date' => date("Y-m-d H:i:s"),
		);
		$result_order_data = $this->Common_model->update_in(explode(",", $this->input->post('order_id')), $order_data, "order_master", "order_id");
		if ($result_order_data) {
			echo "success";
		} else {
			echo "error";
		}
	}

	public function cod_remittance_list()
	{
		$this->data['customer_list'] = $this->Common_model->getResultArray(array('status' => '1', 'is_active' => '1'), 'id,name,email', 'sender_master');
		if ($this->input->post('submit') == "Get List") {
			$this->data['customer_id'] = $this->input->post('customer_id');
			$this->data['from_date'] = $this->input->post('from_date');
			$this->data['to_date'] = $this->input->post('to_date');
		}
		load_admin_view('codremittance', 'cod_remittance_list', $this->data);
	}

	public function cod_remittance_ajax_get_list()
	{
		$columns = array();
		$table = 'forward_order_master';
		$primaryKey = 'id';

		$columns[0] = array('db' => 'ot.id', 'dt' => 0, 'formatter' => function ($d, $row) {
			return '<input type="checkbox" class="check_single_cod_remittance_order" name="check_order_id[' . $row[0] . ']" value="' . $row[0] . '" data-codamount="' . $row[3] . '">';
		}, 'field' => 'id');
		$columns[1] = array('db' => 'ot.order_no', 'dt' => 1, 'field' => 'order_no');
		// $columns[2] = array('db' => 'ot.order_number', 'dt' => 2, 'field' => 'order_number');
		$columns[2] = array('db' => 'ot.awb_number', 'dt' => 2, 'field' => 'awb_number');
		$columns[3] = array('db' => 'opd.cod_amount', 'dt' => 3, 'field' => 'cod_amount');

		$columns[4] = array('db' => 'oad.delivery_date', 'dt' => 4, 'formatter' => function ($d, $row) {
			return date("d-m-Y", strtotime($d));
		}, 'field' => 'delivery_date');
		$columns[5] = array('db' => 'ot.created_date', 'dt' => 5, 'formatter' => function ($d, $row) {
			return date("d-m-Y H:i:s", strtotime($d));
		}, 'field' => 'created_date');
		$columns[6] = array('db' => 'sm.name', 'dt' => 6, 'field' => 'name');

		$join_query = "FROM {$table} AS ot
		INNER JOIN sender_master AS sm ON sm.id=ot.sender_id
		INNER JOIN order_product_detail AS opd ON opd.id=ot.order_product_detail_id
		INNER JOIN order_airwaybill_detail as oad ON ot.id = oad.order_id";

		$where = "ot.is_delete = '0' AND oad.order_status_id='6' AND ot.is_cod_remittance ='0' AND ot.order_type='1' AND ot.sender_id='" . $this->input->post('customer_id') . "' AND (oad.delivery_date BETWEEN '" . date("Y-m-d 00:00:00", strtotime($this->input->post('from_date'))) . "' AND '" . date("Y-m-d 23:59:59", strtotime($this->input->post('to_date'))) . "')";

		$joinQuery = $join_query;
		echo json_encode(
			SSP::simple($_POST, $table, $primaryKey, $columns, $joinQuery, $where)
		);
	}

	public function add_cod_remittance()
	{
		$cod_remittance_data = array(
			"sender_id" => $this->input->post('customer_id'),
			"from_date" => date("Y-m-d", strtotime($this->input->post('from_date'))),
			"to_date" => date("Y-m-d", strtotime($this->input->post('to_date'))),
			"cod_remittance_note" => $this->input->post('cod_remittance_note'),
			"cod_remittance_amount" => $this->input->post('cod_remittance_amount'),
			"created_date" => date("Y-m-d H:i:s"),
		);
		$result = $this->Common_model->insert($cod_remittance_data, "cod_remittance_detail");
		if ($result) {
			$cod_remittance_detail_id = $this->db->insert_id();
			$order_data = array(
				"cod_remittance_detail_id" => $cod_remittance_detail_id,
				"is_cod_remittance" => '1',
				"is_cod_remittance_close_datetime" => date("Y-m-d H:i:s"),
			);
			$this->Common_model->update_in(explode(",", $this->input->post('order_id')), $order_data, 'forward_order_master', 'id');
			$msg = "success";
		} else {
			$msg = "error";
		}
		echo json_encode(array("msg" => $msg, "cod_remittance_detail_id" => @$cod_remittance_detail_id));
	}

	public function export_cod_remmitance_data()
	{
		try {
			$Dpath = FCPATH . 'Document_Upload\export_cod_remmitance_data\*';
			$files = glob($Dpath . 'xlsx');
			if (isset($files)) {
				foreach ($files as $findfile) {
					unlink($findfile);
				}
			}
			$searchVal = array('Airwaybill Number', 'Deliver Date', 'COD Amount');
			$fileName = 'export_cod_remittance_' . date("d-m-Y-H-i-s") . '.xlsx';
			// load excel library
			$objPHPExcel = new PHPExcel();
			// set Header
			$styleArray = array(
				'font' => array(
					'bold' => true,
					'color' => array('rgb' => '000000'),
					'size' => 12,
				),
			);
			$objPHPExcel->setActiveSheetIndex(0);
			$cod_remittance_data = $this->Codremittance_model->get_cod_remittance_data($this->input->post('cod_remittance_detail_id'));

			$j1 = 'A';
			foreach ($searchVal as $key1) {
				$objPHPExcel->getActiveSheet()->getStyle($j1 . '1')->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->SetCellValue($j1 . '1', $key1);
				$objPHPExcel->getActiveSheet()
					->getStyle($j1 . '1')
					->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()
					->setARGB('B6C5CE');
				$j1++;
			}
			$rowCount1 = 2;
			if (!empty($cod_remittance_data)) {
				$count = count($cod_remittance_data);

				foreach (@$cod_remittance_data as $element1) {
					$index = 'A';
					foreach ($element1 as $value) {
						$objPHPExcel->getActiveSheet()->SetCellValue($index . $rowCount1, $value);
						$objPHPExcel->getActiveSheet()->getColumnDimension($index)->setWidth(20);
						$index++;
					}
					$rowCount1++;
				}
			}
			$objPHPExcel->getActiveSheet()->setTitle('NDR Comment Report');
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			header("Content-Type: application/vnd.ms-excel");

			// header("Content-Type: application/vnd.ms-excel");
			$objWriter->save('Document_Upload/export_cod_remmitance_data/' . @$fileName);
			$finalpath = base_url() . 'Document_Upload/export_cod_remmitance_data/' . @$fileName;
			$file = FCPATH . '/Document_Upload/export_cod_remmitance_data/' . @$fileName;

			CUSTOM::download($file, @$fileName, 'text/plain');
		} catch (Exception $e) {
			echo $e;
		}
	}

	public function all_cod_remittance_list()
	{
		load_admin_view('codremittance', 'all_cod_remittance_list', $this->data);
		// $this->load->view('admin/codremittance/all_cod_remittance_list');
	}

	public function all_cod_remittance_ajax_get_list()
	{
		$columns = array();
		$table = 'cod_remittance_detail';
		$primaryKey = 'cod_remittance_detail_id';
		$where_condition = "";

		$columns[0] = array('db' => 'crd.created_date', 'dt' => 0, 'formatter' => function ($d, $row) {
			return date("d-m-Y", strtotime($d));
		}, 'field' => 'created_date');
		$columns[1] = array('db' => 'crd.cod_remittance_amount', 'dt' => 1, 'field' => 'cod_remittance_amount');
		$columns[2] = array('db' => 'crd.cod_remittance_note', 'dt' => 2, 'field' => 'cod_remittance_note');
		$columns[3] = array('db' => 'cod_remittance_detail_id', 'dt' => 3, 'formatter' => function ($d, $row) {
			$actions = '<div>
							<button class="btn btn-sm btn-primary cod_remittance_order_detail_info_button" value="' . $row[3] . '"> View Detail</button>
                        </div>';
			return $actions;
		}, 'field' => 'cod_remittance_detail_id');

		if ($this->type == 1) {
			$columns[4] = array('db' => 'cm.name', 'dt' => 4, 'field' => 'name');
		} else {
			$where_condition = "crd.sender_id=" . $this->customer_id;
		}
		$join_query = "FROM {$table} AS crd LEFT JOIN sender_master AS cm ON cm.id=crd.sender_id";

		$where = $where_condition;
		$joinQuery = $join_query;
		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where)
		);
	}

	public function cod_remittance_order_detail_info()
	{
		$this->data['cod_order_list'] = $this->Codremittance_model->get_cod_remittance_order_data($this->input->post('cod_remittance_detail_id'));
		echo $this->load->view('admin/codremittance/cod_remittance_order_detail_info', $this->data, true);
	}


	public function view_remittance()
	{
		load_admin_view('codremittance', 'view_remittance');
	}

	// start netxt cod remmitance all data
		public function next_cod_remittance_all_list()
	{
		$this->data['customer_list'] = $this->Codremittance_model->get_next_cod_remittanace_all_data();
		
		load_admin_view('codremittance', 'next_cod_remmitance_all_data', $this->data);
	}
	public function delete_cod_remittance_list()
	{		
		$sender_ids =$this->input->post('checkbox_cod_delete');
		$result = $this->Codremittance_model->delete_in_cod($sender_ids);
		
		if ($result) {
			$this->session->set_flashdata('message', "Reset Successfully");
		}else{
			$this->session->set_flashdata('error',"Something Went Wrong");
		}
		redirect('next-cod-remittance-all-data','refresh');
	}
	// end next cod remmitance for delete data
	
	// start next cod remmitance amount
	public function next_cod_remittance_list()
	{
		if ($this->input->post('submit') == "Get List") {
			$this->data['from_date'] = $this->input->post('from_date');
			$this->data['to_date'] = $this->input->post('to_date');
			$this->data['customer_list'] = $this->Codremittance_model->get_next_cod_remittanace_data($this->data['from_date'],$this->data['to_date'],$this->customer_id,$this->type);
		}
		load_admin_view('codremittance', 'next_cod_remittance', $this->data);
	}
	public function insert_cod_remittance_list()
	{
		
		foreach($this->input->post('checkbox_cod_remmitance') as $value){
			
			$this->data['sender_id'] = $value;
			$this->data['order_count'] = $this->input->post('checkbox_cod_remmitance_order_count')[$value];
			$this ->data['cod_remittance_amount'] = $this->input->post('checkbox_cod_remmitance_cod_amount')[$value];
			
			$get_customer_data = $this->Common_model->getSingle_data('sender_id','next_cod_remittance_list',array('sender_id' => $this->data['sender_id']));
			
			if(!empty($get_customer_data)){
				$result = $this->Common_model->update($this->data,'next_cod_remittance_list',array('sender_id' => $this->data['sender_id']));
			}else{
				$result = $this->Common_model->insert($this->data,'next_cod_remittance_list');
			}
		}
		if ($result) {
			$this->session->set_flashdata('message', "Cod Amount Inserted Successfully");
		}else{
			$this->session->set_flashdata('error',"Something Went Wrong");
		}
		redirect('next-cod-remittance-list','refresh');
	}
	// end next cod remmitance amount
}