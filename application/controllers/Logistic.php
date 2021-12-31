<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Logistic extends CI_Controller
{
	public $data;


	public function __construct()
	{
		parent::__construct();
		$this->load->model('Logistic_priority_model');
		$this->load->model('Logistic_import_model');
		//Do your magic here
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	}

	/**
	 * loadview coommon fucntion for load a view
	 *
	 * @param   string  $viewname  name of view that need to load
	 * @param   array  $data      Data that passes to view
	 *
	 * @return  view        load a view 
	 */
	public function loadview(string $viewname)
	{

		$this->load->view('admin/template/header');
		$this->load->view('admin/template/sidebar');
		$this->load->view('admin/price/' . $viewname, $this->data);
		$this->load->view('admin/template/footer');
	}

	/**
	 * add logistic view load
	 *
	 * @return  view  load add logistic form
	 */
	public function index()
	{
		$this->loadview("addlogistic");
	}

	/**
	 * add logistic to database
	 *
	 * @return  view  return to add logicstic form after login
	 */
	public function addlogistic()
	{

		$id = $this->input->post('logistic_id');
		if ($id) {
			$validation = [
				['field' => 'logisticname', 'label' => 'Logisticname', 'rules' => 'trim|required|is_unique[logistic_master.logistic_name]'],
				['field' => 'api_name', 'label' => 'API Name', 'rules' => 'trim|required'],
				['field' => 'codprice', 'label' => 'Codprice', 'rules' => 'required|greater_than[0]'],
				['field' => 'codpercentage', 'label' => 'Codpercentage', 'rules' => 'required|greater_than[0]'],
			];
		} else {
			$validation = [
				['field' => 'logisticname', 'label' => 'Logisticname', 'rules' => 'trim|required|is_unique[logistic_master.logistic_name]'],
				// ['field' => 'api_name', 'label' => 'API Name', 'rules' => 'trim|required|is_unique[logistic_master.api_name]'],
				['field' => 'api_name', 'label' => 'API Name', 'rules' => 'trim|required'],
				['field' => 'codprice', 'label' => 'Codprice', 'rules' => 'required|greater_than[0]'],
				['field' => 'codpercentage', 'label' => 'Codpercentage', 'rules' => 'required|greater_than[0]'],
			];
		}
		$this->form_validation->set_rules($validation);

		if ($this->form_validation->run() == FALSE) {
			$this->data['errors'] = $this->form_validation->error_array();
			$this->index();
		} else {

			if (isset($_POST['iszship'])) {
				$logisticarr['is_zship'] = '0';
			} else {
				$logisticarr['is_zship'] = '1';
			}

			$logisticarr['logistic_name'] = $this->input->post('logisticname');
			$logisticarr['api_name'] = $this->input->post('api_name');
			$logisticarr['cod_price'] = $this->input->post('codprice');
			$logisticarr['cod_percentage'] = $this->input->post('codpercentage');
			if ($id != '0') {

				$result = $this->Common_model->update($logisticarr, 'logistic_master', array('id' => $id));

				if ($result) {
					$this->session->set_flashdata('message', "Logistic Updated Successfully");
				} else {
					$this->session->set_flashdata('error', "Something went wrong");
				}
				redirect('manage-logistic', 'refresh');
			} else {
				$result1 = $this->Common_model->insert($logisticarr, 'logistic_master');
				if ($result1) {
					$this->session->set_flashdata('message', "Logistic Inserted Successfully");
				} else {
					$this->session->set_flashdata('error', "Something went wrong");
				}
				redirect('manage-logistic', 'refresh');
			}
		}
	}

	/**
	 * logisctic list datatable
	 *
	 * @return  datatable  load all logistic in database
	 */
	public function loadlogistics()
	{
		$columns = array();
		$table = 'logistic_master';
		$primaryKey = 'id';


		$columns[0] = array('db' => 'logistic_name', 'dt' => 0, 'field' => 'logistic_name');
		$columns[1] = array('db' => 'api_name', 'dt' => 1, 'field' => 'api_name');
		$columns[2] = array('db' => 'cod_price', 'dt' => 2, 'field' => 'cod_price');
		$columns[3] = array('db' => 'cod_percentage', 'dt' => 3, 'field' => 'cod_percentage');
		$columns[4] = array('db' => 'is_active', 'dt' => 4, 'field' => 'is_active', 'formatter' => function ($d, $row) {
			if ($row[4] == 0) {
				return "Inactive";
			} elseif ($row[4] == 1) {
				return "Active";
			}
		});
		$columns[5] = array('db' => 'is_zship', 'dt' => 5, 'field' => 'is_zship', 'formatter' => function ($d, $row) {
			if ($row[5] == '0') {
				return "Yes";
			} elseif ($row[5] == '1') {
				return "No";
			}
		});
		$columns[6] = array('db' => 'id', 'dt' => 6, 'field' => 'id', 'formatter' => function ($d, $row) {

			$action = "<button type='button' data-id='" . $row[6] . "' data-name='" . $row[0] . "' data-api='" . $row[1] . "'  data-cod='" . $row[2] . "' data-cod_pr='" . $row[3] . "' data-zship='" . $row[5] . "' class='logistic_edit btn btn-primary btn-sm ladda-button waves-effect waves-classic'>
            <i class='icon md-edit' aria-hidden='true'></i></button>";
			if ($row[4] == '0') {
				$action .= "<a href='" . base_url('manage-logistic/change_status/' . $d) . "'>
                <button type='button' class='btn btn-primary btn-sm ladda-button waves-effect waves-classic'>
                 Activate</button></a><a href='" . base_url('logistic/delete_logistic/' . $d) . "' style='margin-left:3px;'><button type='button' id='delete_btn' class='btn-raised btn-sm btn btn-danger btn-floating waves-effect waves-classic waves-effect waves-light'>
                 <i class='icon md-delete' aria-hidden='true' ></i></button></a> ";
			} else {
				$action .= "<a href='" . base_url('manage-logistic/change_status/' . $d) . "'>
                <button type='button' class='btn btn-danger btn-sm ladda-button waves-effect waves-classic'>
                Deactivate</button></a><a href='" . base_url('logistic/delete_logistic/' . $d) . "' style='margin-left:3px;'><button type='button' id='delete_btn' class='btn-raised btn-sm btn btn-danger btn-floating waves-effect waves-classic waves-effect waves-light'>
                <i class='icon md-delete' aria-hidden='true' ></i></button></a> ";
			}
			return $action;
		});
		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns)
		);
	}



	public function change_status()
	{
		$id = $this->uri->segment(3);
		$logistic_status = $this->Common_model->getSingle_data('id,is_active', 'logistic_master', array('id' => $id));

		if ($logistic_status['is_active'] == '0') {
			$logistic_status = '1';
		} else {
			$logistic_status = '0';
		}

		$update_status = [
			'is_active' => $logistic_status,

		];
		$logistic_status_data = $this->Common_model->update($update_status, 'logistic_master', array('id' => $id));
		if ($logistic_status_data) {
			$this->session->set_flashdata('message', "Logistic Status Update Successfully");
			redirect('manage-logistic', 'refresh');
		}
	}

	/**
	 * load add rule form
	 *
	 * @return  view  redirect to add rule
	 */
	public function rules()
	{
		$this->loadview('addrule');
	}

	/**
	 * add rule 
	 *
	 * @return view
	 */
	public function addrule()
	{
		$id = $this->input->post('rule_id');

		if ($id) {
			$validation =  [
				['field' => 'rulename', 'label' => 'Rule Name', 'rules' => 'required'],
				['field' => 'from_kg', 'label' => 'From', 'rules' => 'required|numeric'],
				['field' => 'to_kg', 'label' => 'To', 'rules' => 'required|numeric|differs[from_kg]']
			];
		} else {
			$validation =  [
				['field' => 'rulename', 'label' => 'Rule Name', 'rules' => 'required|is_unique[rule_master.name]'],
				['field' => 'from_kg', 'label' => 'From', 'rules' => 'required|numeric'],
				['field' => 'to_kg', 'label' => 'To', 'rules' => 'required|numeric|differs[from_kg]']
			];
		}

		$this->form_validation->set_rules($validation);

		if ($this->form_validation->run() == FALSE) {
			$this->data['errors'] = $this->form_validation->error_array();
			$this->rules($this->data);
		} else {
			$rulearr = [
				'name' => $this->input->post('rulename'),
				'from_kg' => $this->input->post('from_kg'),
				'to_kg' => $this->input->post('to_kg')
			];
			if ($id) {
				$result = $this->Common_model->update($rulearr, 'rule_master', array('id' => $id));
				if ($result) {
					$this->session->set_flashdata('message', "Rule Updated Successfully");
				} else {
					$this->session->set_flashdata('error', "Something went wrong");
				}
			} else {
				$result1 = $this->Common_model->insert($rulearr, 'rule_master');
				if ($result1) {
					$this->session->set_flashdata('message', "Rule Inserted Successfully");
				} else {
					$this->session->set_flashdata('error', "Something went wrong");
				}
			}
			redirect('manage-logistic/add-rule');
		}
	}


	public function rulelist()
	{
		$columns = array();
		$table = 'rule_master';
		$primaryKey = 'id';

		$columns[0] = array('db' => 'name', 'dt' => 0, 'field' => 'name');
		$columns[1] = array('db' => 'from_kg', 'dt' => 1, 'field' => 'from');
		$columns[2] = array('db' => 'to_kg', 'dt' => 2, 'field' => 'to');

		$columns[3] = array('db' => 'is_active', 'dt' => 3, 'field' => 'is_active', 'formatter' => function ($d, $row) {
			if ($row[3] == 0) {
				return "Deactive";
			} elseif ($row[3] == 1) {
				return "Active";
			}
		});
		$columns[4] = array('db' => 'id', 'dt' => 4, 'field' => 'id', 'formatter' => function ($d, $row) {

			$action = "<button type='button' data-id='" . $row[4] . "' data-name='" . $row[0] . "' data-from='" . $row[1] . "' data-to='" . $row[2] . "' class='rule_edit btn btn-primary btn-sm ladda-button waves-effect waves-classic'>
            <i class='icon md-edit' aria-hidden='true'></i></button>";
			if ($row[3] == 0) {
				$action .= "<a href='" . base_url('manage-rule/change_status/' . $row[4]) . "'>
                <button type='button' class='btn btn-primary btn-sm ladda-button waves-effect waves-classic'>
                 Activate</button></a>";
			} else {
				$action .= "<a href='" . base_url('manage-rule/change_status/' . $row[4]) . "'>
                <button type='button' class='btn btn-danger btn-sm ladda-button waves-effect waves-classic'>
                Deactive</button></a>";
			}
			return $action;
		});



		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns)
		);
		// lq();
	}

	public function change_rule_status()
	{
		$id = $this->uri->segment(3);
		$Rule_status = $this->Common_model->getSingle_data('id,is_active', 'rule_master', array('id' => $id));

		if ($Rule_status['is_active'] == '0') {
			$Rule_status = '1';
		} else {
			$Rule_status = '0';
		}

		$update_status = [
			'is_active' => $Rule_status,

		];
		$Rule_status_data = $this->Common_model->update($update_status, 'rule_master', array('id' => $id));
		if ($Rule_status_data) {
			$this->session->set_flashdata('message', "Rule Status Update Successfully");
			redirect('manage-logistic/add-rule', 'refresh');
		}
	}

	public function delete_logistic()
	{
		$id = $this->uri->segment(3);
		// dd($id);
		$check_order = $this->Logistic_priority_model->check_order($id);
		// dd($check_order);
		if ($check_order) {
			$this->session->set_flashdata('error', "Order already exist with this logistic ,So you can't delete logistic ");
			redirect('manage-logistic', 'refresh');
		} else {
			$delete_logistic = $this->Common_model->delete('logistic_master', array('id' => $id));
			if ($delete_logistic) {
				$this->session->set_flashdata('message', "Logistic Delete Successfully");
				redirect('manage-logistic', 'refresh');
			} else {
				$this->session->set_flashdata('error', "Logistic Not Delete !! Try again");
				redirect('manage-logistic', 'refresh');
			}
		}
	}

	public function view_customer_list()
	{
		$this->load->view('admin/template/header');
		$this->load->view('admin/template/sidebar');
		$this->load->view('admin/manage_customer/customer_list');
		$this->load->view('admin/template/footer');
		// load_admin_view('manage_customer', 'customer_list', $this->data);
	}

	public function view_customer_table()
	{
		$columns = array();
		$table = 'sender_master';
		$primaryKey = 'id';

		$columns[0] = array('db' => 'name', 'dt' => 0, 'field' => 'name');
		$columns[1] = array('db' => 'email', 'dt' => 1, 'field' => 'email');
		$columns[2] = array('db' => 'password', 'dt' => 2, 'field' => 'password');
		$columns[3] = array('db' => 'mobile_no', 'dt' => 3, 'field' => 'mobile_no');

		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns)
		);
	}

	/**
	 * Import Logistic List
	 */
	public function import_logistic()
	{
		if (!empty($_FILES['logistic_excel'])) {
			$paths = FCPATH . "./assets/logistic_import/";

			$config['upload_path'] = './assets/logistic_import/';
			$config['allowed_types'] = 'xlsx|xls';
			$config['overwrite'] = TRUE;

			$this->upload->initialize($config);
			if (!$this->upload->do_upload('logistic_excel')) {
				$this->session->set_flashdata('error', $this->upload->display_errors());
				redirect('import-logistic');
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
				redirect('import-logistic');
			}

			/*Fetch excel data to array*/
			$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
			/*Validate upload fomate values*/
			if (!empty($allDataInSheet)) {
				$arr_common_format = array("courier_id", "courier name");

				/*Check pincode import excel file format*/
				if (!empty(array_diff($arr_common_format, $allDataInSheet[1]))) {
					$this->session->set_flashdata('error', 'Data format incorrect!');
					redirect('import-logistic');
				}

				$import_result = $this->Logistic_import_model->manage_logistic_entries($allDataInSheet);
				/*result message display and redirect*/
				$this->session->set_flashdata($import_result['response'], $import_result['message']);
				redirect('import-logistic');
				// dD($allDataInSheet);
			} else {
				$this->session->set_flashdata('error', 'Uploaded file is blank');
				redirect('import-logistic');
			}
		} else {
			$this->loadview('logistic_import');
		}
	}
}

/* End of file Logistic.php */
