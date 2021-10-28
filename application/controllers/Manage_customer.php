<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_customer extends Auth_Controller
{
	public $data = [];

	public function __construct()
	{
		parent::__construct();
		$this->customer_id = $this->session->userdata('userId');
		$this->load->model('Common_model');
		$this->load->model('Manage_customer_model', 'Manage_customer');
	}

	//manage customer view
	public function manage_customer_index()
	{
		$this->data['all_pending_customer'] = $this->Manage_customer->get_all_pending_customer();
		load_admin_view('manage_customer', 'kyc_pending_customer', $this->data);
	}

	public function test()
	{
		$this->load->view('mailview');
	}
	public function kyc_pending_customer_list()
	{
		$action = '';
		$columns = array();
		$table = 'kyc_verification_master';
		$primaryKey = 'id';
		$where = "sm.status = '0'";
		$groupBy = "kym.sender_id";
		$joinquery = "FROM {$table} AS kym JOIN sender_master as sm on kym.sender_id = sm.id LEFT OUTER JOIN billing_address as ba on kym.billing_address_id = ba.id";
		$columns[0] = array('db' => 'kym.id', 'dt' => 0, 'field' => 'id');
		$columns[1] = array('db' => 'sm.name', 'dt' => 1, 'field' => 'name');
		$columns[2] = array('db' => 'sm.email', 'dt' => 2, 'field' => 'email');
		$columns[3] = array('db' => 'sm.website', 'dt' => 3, 'field' => 'website');
		$columns[4] = array('db' => 'sm.mobile_no', 'dt' => 4, 'field' => 'mobile_no');
		$columns[5] = array('db' => 'ba.address_1', 'dt' => 5, 'field' => 'address_1', 'formatter' => function ($d, $row) {
			return $d . " " . $row[6];
		});
		$columns[6] = array('db' => 'ba.address_2', 'dt' => 6, 'field' => 'address_2');
		$columns[7] = array('db' => 'ba.city', 'dt' => 7, 'field' => 'city');
		$columns[8] = array('db' => 'ba.pincode', 'dt' => 8, 'field' => 'pincode');
		$columns[9] = array('db' => 'kym.created_date', 'dt' => 9, 'field' => 'created_date');
		$columns[10] = array('db' => 'sm.status', 'dt' => 10, 'field' => 'status', 'formatter' => function ($d, $row) {
			switch ($d) {
				case '0':
					return "Pending";
					break;
				case '2':
					return "Rejected";
					break;
				default:
					return "Approved";
					break;
			}
		});
		$columns[11] = array('db' => 'sm.is_active', 'dt' => 11, 'field' => 'is_active', 'formatter' => function ($d, $row) {
			switch ($d) {
				case '0':
					return "Inactive";
					break;
				default:
					return "Active";
					break;
			}
		});
		$columns[12] = array('db' => 'sm.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
			switch ($row[11]) {
				case 0:
					$action = "<a href='" . base_url('manage-customer/change_status/' . $row[12]) . "'>
					<button type='button' class='btn btn-primary btn-sm ladda-button waves-effect waves-classic'>
					 Activate</button></a>";
					break;
				default:
					$action = "<a href='" . base_url('manage-customer/change_status/' . $row[12]) . "'>
                <button type='button' class='btn btn-danger btn-sm ladda-button waves-effect waves-classic'>
                Deactivate</button></a>";
					break;
			}
			return $action;
		});

		$columns[13] = array('db' => 'kym.sender_id', 'dt' => 13, 'field' => 'id', 'formatter' => function ($d, $row) {
			return '<a type="button" href="' . base_url('view-customer/' . $d) . '" data-id="3" data-name="testingggg1" class="btn-raised btn-sm btn btn-success btn-floating waves-effect waves-classic waves-effect waves-light waves-effect waves-classic">
            <i class="icon md-eye" aria-hidden="true"></i></a>';
		});


		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns, $joinquery, $where, '', $groupBy)
		);
	}

	public function change_status()
	{
		$id = $this->uri->segment(3);
		$customerDetail = $this->Common_model->getSingle_data('id,is_active,status', 'sender_master', array('id' => $id));
		if ($customerDetail['is_active'] == '1') {
			$update_status = [
				'is_active' => '0',
			];
		} else {
			$update_status = [
				'is_active' => '1',
			];
		}
		$status_data = $this->Common_model->update($update_status, 'sender_master', array('id' => $id));
		if ($status_data) {
			$this->session->set_flashdata('message', "Customer Status Change Successfully");
			redirect('approve-customer', 'refresh');
		} else {
			$this->session->set_flashdata('error', "Something Went Wrong");
			redirect('approve-customer', 'refresh');
		}
	}

	public function deleteimage()
	{
		$success = $error = "";
		try {
			$img_id = $this->input->post('imgid');
			$img_name = $this->Common_model->getWhere(array('id' => $img_id), 'image', 'kyc_document_master');
			$deleted_img = $this->Common_model->delete('kyc_document_master', array('id' => $img_id));
			unlink('uploads/kyc_verfication_document/other_document' . $img_name);
			$success =  "Image Deleted Successfully";
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
		echo json_encode(array('success' => $success, 'error' => $error));
	}

	/**
	 * Approved Customer
	 */
	public function manage_approved_customer()
	{
		load_admin_view('manage_customer', 'kyc_approved_customer', '');
	}

	/**
	 * Approved Customer SSP Table
	 * @return Result
	 */
	public function approved_customer_list()
	{
		$action = '';
		$columns = array();
		$table = 'kyc_verification_master';
		$primaryKey = 'id';
		$where = "sm.status = '1'";
		$groupBy = "kym.sender_id";
		$joinquery = "FROM {$table} AS kym JOIN sender_master as sm on kym.sender_id = sm.id LEFT OUTER JOIN billing_address as ba on kym.billing_address_id = ba.id";

		$columns[0] = array('db' => 'kym.id', 'dt' => 0, 'field' => 'id');
		$columns[1] = array('db' => 'sm.name', 'dt' => 1, 'field' => 'name');
		$columns[2] = array('db' => 'sm.email', 'dt' => 2, 'field' => 'email');
		$columns[3] = array('db' => 'sm.website', 'dt' => 3, 'field' => 'website');
		$columns[4] = array('db' => 'sm.mobile_no', 'dt' => 4, 'field' => 'mobile_no');
		$columns[5] = array('db' => 'ba.address_1', 'dt' => 5, 'field' => 'address_1', 'formatter' => function ($d, $row) {
			return $d . " " . $row[6];
		});
		$columns[6] = array('db' => 'ba.address_2', 'dt' => 6, 'field' => 'address_2');
		$columns[7] = array('db' => 'ba.city', 'dt' => 7, 'field' => 'city');
		$columns[8] = array('db' => 'ba.pincode', 'dt' => 8, 'field' => 'pincode');
		$columns[9] = array('db' => 'kym.created_date', 'dt' => 9, 'field' => 'created_date');
		$columns[10] = array('db' => 'sm.status', 'dt' => 10, 'field' => 'status', 'formatter' => function ($d, $row) {
			switch ($d) {
				case '0':
					return "Pending";
					break;
				case '2':
					return "Rejected";
					break;
				default:
					return "Approved";
					break;
			}
		});
		$columns[11] = array('db' => 'sm.is_active', 'dt' => 11, 'field' => 'is_active', 'formatter' => function ($d, $row) {
			switch ($d) {
				case '0':
					return "Inactive";
					break;
				default:
					return "Active";
					break;
			}
		});
		$columns[12] = array('db' => 'sm.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
			switch ($row[11]) {
				case 0:
					$action = "<a href='" . base_url('manage-customer/change_status/' . $row[12]) . "'>
					<button type='button' class='btn btn-primary btn-sm ladda-button waves-effect waves-classic'>
					 Activate</button></a>";
					break;
				default:
					$action = "<a href='" . base_url('manage-customer/change_status/' . $row[12]) . "'>
                <button type='button' class='btn btn-danger btn-sm ladda-button waves-effect waves-classic'>
                Deactivate</button></a>";
					break;
			}
			return $action;
		});

		$columns[13] = array('db' => 'kym.sender_id', 'dt' => 13, 'field' => 'id', 'formatter' => function ($d, $row) {
			return '<a type="button" href="' . base_url('view-customer/' . $d) . '" data-id="3" data-name="testingggg1" class="btn-raised btn-sm btn btn-success btn-floating waves-effect waves-classic waves-effect waves-light waves-effect waves-classic">
            <i class="icon md-eye" aria-hidden="true"></i></a>';
		});


		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns, $joinquery, $where, '', $groupBy)
		);
	}

	/**
	 * Rejected Customer
	 */
	public function manage_rejected_customer()
	{
		load_admin_view('manage_customer', 'kyc_rejected_customer', '');
	}

	/**
	 * Rejected Customer SSP Table
	 * @return Result
	 */
	public function approved_rejected_list()
	{
		$action = '';
		$columns = array();
		$table = 'kyc_verification_master';
		$primaryKey = 'id';
		$where = "sm.status = '2'";
		$groupBy = "kym.sender_id";
		$joinquery = "FROM {$table} AS kym JOIN sender_master as sm on kym.sender_id = sm.id LEFT OUTER JOIN billing_address as ba on kym.billing_address_id = ba.id";

		$columns[0] = array('db' => 'kym.id', 'dt' => 0, 'field' => 'id');
		$columns[1] = array('db' => 'sm.name', 'dt' => 1, 'field' => 'name');
		$columns[2] = array('db' => 'sm.email', 'dt' => 2, 'field' => 'email');
		$columns[3] = array('db' => 'sm.website', 'dt' => 3, 'field' => 'website');
		$columns[4] = array('db' => 'sm.mobile_no', 'dt' => 4, 'field' => 'mobile_no');
		$columns[5] = array('db' => 'ba.address_1', 'dt' => 5, 'field' => 'address_1', 'formatter' => function ($d, $row) {
			return $d . " " . $row[6];
		});
		$columns[6] = array('db' => 'ba.address_2', 'dt' => 6, 'field' => 'address_2');
		$columns[7] = array('db' => 'ba.city', 'dt' => 7, 'field' => 'city');
		$columns[8] = array('db' => 'ba.pincode', 'dt' => 8, 'field' => 'pincode');
		$columns[9] = array('db' => 'kym.created_date', 'dt' => 9, 'field' => 'created_date');
		$columns[10] = array('db' => 'sm.status', 'dt' => 10, 'field' => 'status', 'formatter' => function ($d, $row) {
			switch ($d) {
				case '0':
					return "Pending";
					break;
				case '2':
					return "Rejected";
					break;
				default:
					return "Approved";
					break;
			}
		});
		$columns[11] = array('db' => 'sm.is_active', 'dt' => 11, 'field' => 'is_active', 'formatter' => function ($d, $row) {
			switch ($d) {
				case '0':
					return "Inactive";
					break;
				default:
					return "Active";
					break;
			}
		});
		$columns[12] = array('db' => 'sm.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
			$action = "<a href='" . base_url('manage-customer/change_status/' . $row[12]) . "'>
				<button type='button' class='btn btn-primary btn-sm ladda-button waves-effect waves-classic'>
				Approve</button></a>";

			return $action;
		});


		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns, $joinquery, $where, '', $groupBy)
		);
	}

	public function lable()
	{
		$this->load->model('Assign_awb_customer_model');
		$this->data['sender_list'] = $this->Assign_awb_customer_model->get_customers();
		load_admin_view('order', 'assign_lable', $this->data);
	}

	public function label_assign()
	{
		$validation = [
			['field' => 'sender_name', 'label' => 'Customer', 'rules' => 'required'],
			['field' => 'lable_id[]', 'label' => 'Label', 'rules' => 'required'],
		];
		$this->form_validation->set_rules($validation);
		if ($this->form_validation->run() == false) {
			$this->data['errors'] = $this->form_validation->error_array();
			// dd($this->data);
			$this->lable();
		} else {

			$sender_id = $this->input->post('sender_name');
			if ($sender_id) {
				$this->db->where('sender_id', $sender_id);
				$this->db->delete('assign_label_user');
			}
			$lables = $this->input->post('lable_id');



			foreach ($lables as $key => $value) {
				$data = [
					'sender_id' => $sender_id,
					'label_type' => $value,
				];
				$result  = $this->db->insert('assign_label_user', $data);
			}

			$this->session->set_flashdata('message', 'Label Assigned Successfully');
			redirect('assign-lable');
		}
	}

	public function check_assigned_label()
	{
		$sender_id = $this->input->post('id');
		$this->db->select('label_type');
		$this->db->from('assign_label_user');
		$this->db->where('sender_id', $sender_id);
		$query = $this->db->get();
		$data = $query->result_array();
		// dd($data);
		echo json_encode($data);
	}

	public function change_reject_status()
	{
		$id = $this->uri->segment(3);
		$customerDetail = $this->Common_model->getSingle_data('id,is_active,status', 'sender_master', array('id' => $id));

		if ($customerDetail['is_active'] == '0') {
			$customer_status = '1';
		} else {
			$customer_status = '0';
		}

		$update_status = [
			'is_active' => $customer_status,

		];
		$logistic_status_data = $this->Common_model->update($update_status, 'sender_master', array('id' => $id));
		if ($logistic_status_data) {
			$this->session->set_flashdata('message', "Customer Status Update Successfully");
			if ($customerDetail['status'] == '0') {
				redirect('kyc-pending-customer', 'refresh');
			} else if ($customerDetail['status'] == '1') {
				redirect('approve-customer', 'refresh');
			} else {
				redirect('rejected-customer', 'refresh');
			}
		}
	}
	public function view_pending_customer($id)
	{
		$this->data['document_list'] = $this->Common_model->getResultArray(array('is_active' => '1'), '*', 'document_master');
		$this->data['source_user_data'] = $this->Common_model->getResultArray(array('is_active' => '1', 'user_type' => '2'), '*', 'user_master');
		$this->data['all_active_logistic'] = $this->Common_model->getResultArray(array('is_active' => '1'), '*', 'logistic_master');
		$this->data['edit_pending_customer'] = $this->Manage_customer->get_particular_pending_customer($id);
		$kyc_doc_list = $this->Manage_customer->get_particular_pending_customer_doc($this->data['edit_pending_customer']['id']);

		// dd($this->data);

		$docType = $docList = array();
		foreach ($kyc_doc_list as $docVal) {
			$docList[$docVal['doc_type']][] = $docVal;
			if (!in_array($docVal['doc_type'], $docType)) {
				$docType[] = $docVal['doc_type'];
			}
		}
		$this->data['kyc_doc_list'] = $docList;
		$this->data['kyc_doc_type'] = $docType;

		$customer_logistics = $this->Manage_customer->get_customer_allow_logistics($id);
		foreach ($customer_logistics as $customer_logistics_1) {
			$this->data['customer_logistics'][] = $customer_logistics_1['logistic_id'];
		}

		if ($this->input->post()) {

			$validation = [
				['field' => 'source_id', 'label' => 'Source', 'rules' => 'trim|required'],
				['field' => 'logistic_id[]', 'label' => 'Logistic', 'rules' => 'required'],
				['field' => 'profile_type', ' ' => 'Profilt Tyoe', 'rules' => 'required'],
				['field' => 'profile_type', 'label' => 'Profilt Tyoe', 'rules' => 'required'],
				// ['field' => 'pan_no', 'label' => 'Pancard No', 'rules' => 'required|regex_match[/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}$/]'],
				['field' => 'pincode', 'label' => 'Pincode', 'rules' => 'required'],
				['field' => 'city', 'label' => 'City', 'rules' => 'required'],
				['field' => 'state', 'label' => 'state', 'rules' => 'required'],
				['field' => 'address_1', 'label' => 'address', 'rules' => 'required'],
				['field' => 'doc1_id', 'label' => 'Document', 'rules' => 'required'],
				['field' => 'cancelled_cheque_image', 'lable' => 'Cancelled Cheque Image', 'rule' => 'required'],
			];


			switch ($this->input->post('profile_type')) {
				case 1:
					// $validation[] = ['field' => 'gst_no', 'label' => 'GST No', 'rules' => 'required|exact_length[15]|regex_match[/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/]'];
					$validation[] = ['field' => 'company_type', 'label' => 'Company Type', 'rules' => 'required'];
					$validation[] =	['field' => 'company_name', 'lable' => 'Company Name', 'rules' => 'required'];
					break;
				case 0:
					// $validation[] = ['field' => 'gst_no', 'label' => 'GST No', 'rules' => 'exact_length[15]|regex_match[/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/]'];
					break;
			}
			if ($this->input->post('reject')) {
				$validation[] =	['field' => 'rejection_reason', 'lable' => 'Rejection Reson', 'rules' => 'required'];
			}

			$this->form_validation->set_rules($validation);

			if ($this->form_validation->run() == FALSE) {
				// $this->create_pickup_address();
				$this->data['errors'] = $this->form_validation->error_array();
				load_admin_view('manage_customer', 'pending_customer_edit', $this->data);
			} else {
				// dd($_POST);
				$flag = 1;
				$update_in_kyc = [
					'created_by'    => $this->input->post('source_id'),
					'profile_type' => $this->input->post('profile_type'),
					'company_type' => $this->input->post('company_type'),
					'company_name' => $this->input->post('company_name'),
					'pan_no' 	   => @$this->input->post('pan_no'),
					'gst_no'       => @$this->input->post('gst_no'),
				];
				$sender_id = $this->input->post('sender_id');
				$result = $this->Common_model->update($update_in_kyc, 'kyc_verification_master', array('sender_id' => $sender_id));
				$update_bill_add = [
					'address_1'     => $this->input->post('address_1'),
					'address_2' 	=> $this->input->post('address_2'),
					'pincode' 		=> $this->input->post('pincode'),
					'state' 	=> $this->input->post('state'),
					'city' 	=> $this->input->post('city'),
				];
				$result1 = $this->Common_model->update($update_bill_add, 'billing_address', array('sender_id' => $sender_id));

				$kyc_id = $this->input->post('kyc_id');
				$doc_1_path =  "uploads/kyc_verification_document/doc1_image/";
				if (!empty($_FILES['doc1_1_img']['name'])) {
					if (!empty($_FILES['doc1_1_img']['name'][0])) {
						unlink($doc_1_path . $this->input->post('doc1_img_names')[0]);
						$_FILES['file']['name'] = $_FILES['doc1_1_img']['name'][0];
						$_FILES['file']['type'] = $_FILES['doc1_1_img']['type'][0];
						$_FILES['file']['tmp_name'] = $_FILES['doc1_1_img']['tmp_name'][0];
						$_FILES['file']['error'] = $_FILES['doc1_1_img']['error'][0];
						$_FILES['file']['size'] = $_FILES['doc1_1_img']['size'][0];
						$config['upload_path'] = './uploads/kyc_verification_document/doc1_image/';
						$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
						$config['max_size'] = 7096;

						$this->upload->initialize($config);
						if (!$this->upload->do_upload('file')) {
							$flag = 0;
							$error = $this->upload->display_errors();
							if (strpos($error, "The file you are attempting to upload is larger than the permitted size")) {
								$this->session->set_flashdata('error', "File size larger than 7MB.");
							} else {
								$this->session->set_flashdata('error', $error);
							}

							load_admin_view('manage_customer', 'pending_customer_edit', $this->data);
						} else {
							$post_image = $this->upload->data();
							$doc1_1_img = $post_image['file_name'];
						}
						$this->Common_model->update(array('image' => $doc1_1_img), 'kyc_document_master', array('id' => $this->input->post('doc1_img_id')[0]));
					}

					if (!empty($_FILES['doc1_1_img']['name'][1])) {
						if (!empty($_FILES['doc1_1_img']['name'][1])) {
							unlink($doc_1_path . $this->input->post('doc1_img_names')[1]);
							$_FILES['file']['name'] = $_FILES['doc1_1_img']['name'][1];
							$_FILES['file']['type'] = $_FILES['doc1_1_img']['type'][1];
							$_FILES['file']['tmp_name'] = $_FILES['doc1_1_img']['tmp_name'][1];
							$_FILES['file']['error'] = $_FILES['doc1_1_img']['error'][1];
							$_FILES['file']['size'] = $_FILES['doc1_1_img']['size'][1];
							$config['upload_path'] = './uploads/kyc_verification_document/doc1_image/';
							$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
							$config['max_size'] = 7096;

							$this->upload->initialize($config);
							if (!$this->upload->do_upload('file')) {
								$flag = 0;
								$error = $this->upload->display_errors();
								if (strpos($error, "The file you are attempting to upload is larger than the permitted size")) {
									$this->session->set_flashdata('error', "File size larger than 7MB.");
								} else {
									$this->session->set_flashdata('error', $error);
								}
								load_admin_view('manage_customer', 'pending_customer_edit', $this->data);
							} else {
								$post_image = $this->upload->data();
								$doc1_2_img = $post_image['file_name'];
							}
							$this->Common_model->update(array('image' => $doc1_2_img), 'kyc_document_master', array('id' => $this->input->post('doc1_img_id')[1]));
						}
					}
				}

				$doc_2_path =  "uploads/kyc_verification_document/doc2_image/";
				if (!empty($_FILES['doc2_1_img']['name'])) {
					if (!empty($_FILES['doc2_1_img']['name'][0])) {
						unlink($doc_2_path . $this->input->post('doc2_img_names')[0]);
						$_FILES['file']['name'] = $_FILES['doc2_1_img']['name'][0];
						$_FILES['file']['type'] = $_FILES['doc2_1_img']['type'][0];
						$_FILES['file']['tmp_name'] = $_FILES['doc2_1_img']['tmp_name'][0];
						$_FILES['file']['error'] = $_FILES['doc2_1_img']['error'][0];
						$_FILES['file']['size'] = $_FILES['doc2_1_img']['size'][0];
						$config['upload_path'] = './uploads/kyc_verification_document/doc2_image/';
						$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
						$config['max_size'] = 7096;

						$this->upload->initialize($config);
						if (!$this->upload->do_upload('file')) {
							$flag = 0;
							$error = $this->upload->display_errors();
							if (strpos($error, "The file you are attempting to upload is larger than the permitted size")) {
								$this->session->set_flashdata('error', "File size larger than 7MB.");
							} else {
								$this->session->set_flashdata('error', $error);
							}
							load_admin_view('manage_customer', 'pending_customer_edit', $this->data);
						} else {
							$post_image = $this->upload->data();
							$doc2_1_img = $post_image['file_name'];
						}
						$this->Common_model->update(array('image' => $doc2_1_img), 'kyc_document_master', array('id' => $this->input->post('doc2_img_id')[0]));
					}
					if (!empty($_FILES['doc2_1_img']['name'][1])) {
						if ($_FILES['doc2_1_img']['name'][1] != '') {
							unlink($doc_2_path . $this->input->post('doc2_img_names')[1]);
							$_FILES['file']['name'] = $_FILES['doc2_1_img']['name'][1];
							$_FILES['file']['type'] = $_FILES['doc2_1_img']['type'][1];
							$_FILES['file']['tmp_name'] = $_FILES['doc2_1_img']['tmp_name'][1];
							$_FILES['file']['error'] = $_FILES['doc2_1_img']['error'][1];
							$_FILES['file']['size'] = $_FILES['doc2_1_img']['size'][1];
							$config['upload_path'] = './uploads/kyc_verification_document/doc2_image/';
							$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
							$config['max_size'] = 7096;

							$this->upload->initialize($config);
							if (!$this->upload->do_upload('file')) {
								$flag = 0;
								$error = $this->upload->display_errors();
								if (strpos($error, "The file you are attempting to upload is larger than the permitted size")) {
									$this->session->set_flashdata('error', "File size larger than 7MB.");
								} else {
									$this->session->set_flashdata('error', $error);
								}
								load_admin_view('manage_customer', 'pending_customer_edit', $this->data);
							} else {
								$post_image = $this->upload->data();
								$doc2_2_img = $post_image['file_name'];
							}
							$this->Common_model->update(array('image' => $doc2_2_img), 'kyc_document_master', array('id' => $this->input->post('doc2_img_id')[1]));
						}
					}
				}

				$cancelled_path =  "uploads/kyc_verification_document/cancelled_cheque_image/";
				if (!empty($_FILES['cancelled_cheque_image']['name'])) {
					if ($_FILES['cancelled_cheque_image']['name'] != '') {
						unlink($cancelled_path . $this->input->post('cc_img_name'));
						$config['upload_path'] = './uploads/kyc_verification_document/cancelled_cheque_image/';
						$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
						$config['max_size'] = 7096;
						$cancelled_cheque_image_name = strtotime('now');
						$config['file_name'] = $cancelled_cheque_image_name;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('cancelled_cheque_image')) {
							$flag = 0;
							$error = $this->upload->display_errors();
							if (strpos($error, "The file you are attempting to upload is larger than the permitted size")) {
								$this->session->set_flashdata('error', "File size larger than 7MB.");
							} else {
								$this->session->set_flashdata('error', $error);
							}
							load_admin_view('manage_customer', 'pending_customer_edit', $this->data);
						} else {
							$post_image = $this->upload->data();
							$cancelled_cheque_image = $post_image['file_name'];
						}
						//update on img name
						$this->Common_model->update(array('image' => $cancelled_cheque_image), 'kyc_document_master', array('id' => $this->input->post('cc_img_id')));
					}
				}

				$pickup_path =  "uploads/kyc_verification_document/pickup_image/";
				if (!empty($_FILES['pick_up_img']['name'])) {
					if ($_FILES['pick_up_img']['name'] != '') {
						unlink($pickup_path . $this->input->post('pickup_img_name'));
						$config['upload_path'] = './uploads/kyc_verification_document/pickup_image/';
						$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
						$config['max_size'] = 7096;
						$pickup_image_name = strtotime('now');
						$config['file_name'] = $pickup_image_name;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('pick_up_img')) {
							$flag = 0;
							$error = $this->upload->display_errors();
							if (strpos($error, "The file you are attempting to upload is larger than the permitted size")) {
								$this->session->set_flashdata('error', "File size larger than 7MB.");
							} else {
								$this->session->set_flashdata('error', $error);
							}
							load_admin_view('manage_customer', 'pending_customer_edit', $this->data);
						} else {
							$post_image = $this->upload->data();
							$pickup_img_name = $post_image['file_name'];
						}
						//update on img name
						$this->Common_model->update(array('image' => $pickup_img_name), 'kyc_document_master', array('id' => $this->input->post('pickup_img_id')));
					}
				}

				if (!empty($_FILES['other_document']['name'])) {
					for ($i = 0; $i < count($_FILES['other_document']['name']); $i++) {
						if ($_FILES['other_document']['name'][$i] != '') {
							$_FILES['file']['name'] = $_FILES['other_document']['name'][$i];
							$_FILES['file']['type'] = $_FILES['other_document']['type'][$i];
							$_FILES['file']['tmp_name'] = $_FILES['other_document']['tmp_name'][$i];
							$_FILES['file']['error'] = $_FILES['other_document']['error'][$i];
							$_FILES['file']['size'] = $_FILES['other_document']['size'][$i];
							$config['upload_path'] = './uploads/kyc_verification_document/other_document/';
							$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
							$config['max_size'] = 7096;

							$this->upload->initialize($config);
							if (!$this->upload->do_upload('file')) {
								$flag = 0;
								$error = $this->upload->display_errors();
								if (strpos($error, "The file you are attempting to upload is larger than the permitted size")) {
									$this->session->set_flashdata('error', "File size larger than 7MB.");
								} else {
									$this->session->set_flashdata('error', $error);
								}
								load_admin_view('manage_customer', 'pending_customer_edit', $this->data);
							} else {
								$post_image = $this->upload->data();
								$other_document = $post_image['file_name'];
							}
							$other_doc = array(
								"kyc_id" => $kyc_id,
								"doc_id" => 8,
								"image" => $other_document,
							);
							$cancel_check_insert = $this->Common_model->insert($other_doc, "kyc_document_master");
						}
					}
				}

				$logistic_id = $this->input->post('logistic_id');

				$get_logistics = $this->Manage_customer->already_inserted_logistics($sender_id);

				$exist_logistic_id = array();

				foreach ($get_logistics as $single_logistic) {
					$exist_logistic_id[] = $single_logistic['logistic_id'];
					if (!in_array($single_logistic['logistic_id'], $this->input->post('logistic_id'))) {
						$this->Common_model->delete('assign_logistic_sender', array('logistic_id' => $single_logistic['logistic_id'], 'sender_id' => $sender_id));
					}
				}

				foreach ($this->input->post('logistic_id') as $single_post_logistic_id) {
					$data_check = $this->Manage_customer->check_inserted($sender_id, $single_post_logistic_id);
					if (empty($data_check)) {
						$res = array('sender_id' => $sender_id, 'logistic_id' => $single_post_logistic_id);
						$resultt =	$this->db->insert('assign_logistic_sender', $res);
					}
				}

				if ($flag == 1) {
					if ($this->input->post('reject') == "Reject") {
						$reject = [
							'status'      	=> '2',
							'updated_by	'   => $this->session->userdata('userId'),
							'updated_date'    => date('Y-m-d H:i:s'),

						];
						$reject_status = $this->Common_model->update($reject, 'sender_master', array('id' => $sender_id));
						if ($reject_status) {
							$sender_id = $this->input->post('sender_id');
							$sender_email = $this->Common_model->getSingle_data('id,email,password', 'sender_master', array('id' => $sender_id));
							$password = $sender_email['password'];
							$to = $sender_email['email'];
							$subject = "Kyc Request Reject";
							$messageBody = "<h4>Thank You to Visit Pack and Drop Logistic!</h4>
							<h4>Due to some issue we are unable to approve your sign in application

							</h4>
							<h4>To open your Shipsecure Logistic homepage, please follow this link:</h4>
							<h4>Go to Pack and Drop Logistic now!</h4>
							<h4>Link doesn't work? Copy the following link to your browser address bar:https://shipsecurelogistics.com/</h4>
							<h4>Your registered email address: $to
							<br>Your password : $password</h4>
							<h3>Any Support Required Any point of Time Below mention is Details </h3><table class='table table-bordered'>
							  <tr>
								<td>1</td>
								<td>CRM 1st level</td>
								<td>Support@shipsecurelogistics.com</td>
								<td>+91 </td>
							  </tr>
							</table>
							<h4>Thanks & Regards,</h4>
							<img  src='<?=base_url();?>assets/custom/img/logo.png' width='100' height='100'><br>
								<h4>Shipsecure Logistics</h4>
									<h4>www.shipsecurelogistics.com
								</h4>";

							$this->load->helper('mailhelper');
							$mail = simpleMail($to, $subject, $messageBody);
							$mailLog['toMail'] = $to;
							$mailLog['MailBody'] = $messageBody;
							$mailLog['ApproveMailResponse'] = $mail;
							file_put_contents(APPPATH . 'logs/mailLog/' . date("d-m-Y") . '_maillog.txt', "\n\n---------- KYC Approve -------------\n" . print_r($mailLog, true), FILE_APPEND);
							$this->session->set_flashdata('message', "Kyc Reject Successfully");
						}
						$this->session->set_flashdata('message', "Kyc Reject Successfully");
					}
					if ($this->input->post('approved') == "Approved") {

						$Approve = [
							'status'      	=> '1',
							'updated_by	'   => $this->session->userdata('userId'),
							'updated_date'    => date('Y-m-d H:i:s'),
						];
						$result_sender = $this->Common_model->update($Approve, 'sender_master', array('id' => $sender_id));
						//send approve mail to customer
						if ($result_sender) {
							$sender_id = $this->input->post('sender_id');
							$sender_email = $this->Common_model->getSingle_data('id,email,password', 'sender_master', array('id' => $sender_id));
							$password = $sender_email['password'];
							$to = $sender_email['email'];
							$subject = "Kyc Request Approved";
							$messageBody = "<h4>Welcome to Shipsecure Logistic homepage, please follow this link:</h4>
							<h4>Go to Pack and Drop Logistic now!</h4>
							<h4>Link doesn't work? Copy the following link to your browser address bar:https://shipsecurelogistics.com/</h4>
							<h4>Your registered email address: $to
							<br>Your password : $password </h4>
							<h3>Any Support Required Any point of Time Below mention is Details </h3>
							<table class='table table-bordered'>
							  <tr>
								<td>1</td>
								<td>CRM 1st level</td>
								<td>shipsecurelogistics1@gmail.com</td>
								<td>+91 9099822295</td>
							  </tr>
							</table>
							<h4>Thanks & Regards,</h4>
							<img  src='<?=base_url();?>assets/custom/img/logo.png' width='100' height='100'><br>
								<h4>Ship Secure Logistics</h4>
								<h4>www.shipsecurelogistics.com
								</h4>";

							$this->load->helper('mailhelper');
							$mail = simpleMail($to, $subject, $messageBody);
							$mailLog['toMail'] = $to;
							$mailLog['MailBody'] = $messageBody;
							$mailLog['ApproveMailResponse'] = $mail;
							file_put_contents(APPPATH . 'logs/mailLog/' . date("d-m-Y") . '_maillog.txt', "\n\n---------- KYC Approve-------------\n" . print_r($mailLog, true), FILE_APPEND);
							$this->session->set_flashdata('message', "Kyc Approve Successfully");
						}
					}
					redirect('kyc-pending-customer');
				} else {
					load_admin_view('manage_customer', 'pending_customer_edit', $this->data);
				}
			}
		} else {
			load_admin_view('manage_customer', 'pending_customer_edit', $this->data);
		}
	}

	public function view_customer_list()
	{
		load_admin_view('manage_customer', 'customer_list', '');
	}

	public function view_customer_table()
	{
		$columns = array();
		$table = 'sender_master';
		$primaryKey = 'id';

		$joinquery = "FROM " . $table . " AS sm JOIN kyc_verification_master AS km ON sm.id = km.sender_id  JOIN user_master AS um ON km.created_by = um.id ";
		$where = "sm.status = '1' ";
		if ($this->session->userdata('userType') == '2') {
			$where .= " AND km.created_by = '" . $this->session->userdata('userId') . "'";
		}

		$columns[0] = array('db' => 'sm.name', 'dt' => 0, 'field' => 'name');
		$columns[1] = array('db' => 'email', 'dt' => 1, 'field' => 'email');
		$columns[2] = array('db' => 'password', 'dt' => 2, 'field' => 'password');
		$columns[3] = array('db' => 'mobile_no', 'dt' => 3, 'field' => 'mobile_no');
		// $columns[4] = array('db' => 'SUM(wt.credit) as credit', 'dt' => 4, 'field' => 'credit');
		$columns[4] = array('db' => 'sm.wallet_balance', 'dt' => 4, 'field' => 'wallet_balance');
		$columns[5] = array('db' => 'sm.allow_credit_limit', 'dt' => 5, 'field' => 'allow_credit_limit');
		$columns[6] = array('db' => 'um.name AS uname', 'dt' => 6, 'field' => 'uname');


		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns, $joinquery, $where)
		);
	}

	public function pre_awb_dashboard_list()
	{
		load_admin_view('manage_customer', 'pre_awb_dashboard');
	}

	public function pre_awb_dashboard_data()
	{
		$columns = array();
		$table = 'sender_master';
		$primaryKey = 'id';
		$where = "status = '1'";

		$columns[0] = array('db' => 'name', 'dt' => 0, 'field' => 'name');
		$columns[1] = array('db' => 'email', 'dt' => 1, 'field' => 'email');
		$columns[2] = array('db' => 'is_pre_awb_allow', 'dt' => 2, 'field' => 'status', 'formatter' => function ($d, $row) {
			switch ($d) {
				case '0':
					return "Not Allowed";
					break;
				case '1':
					return "Allowed";
					break;
			}
		});
		$columns[3] = array('db' => 'id', 'dt' => 3, 'field' => 'id', 'formatter' => function ($d, $row) {
			if ($row[2] == 0) {
				$action = "<a href='" . base_url('manage-customer-dashboard/change_status/' . $row[3]) . "'>
                <button type='button' class='btn btn-primary btn-sm ladda-button waves-effect waves-classic' style='width:84px;'>
                 Allow</button></a>";
			} else {
				$action = "<a href='" . base_url('manage-customer-dashboard/change_status/' . $row[3]) . "'>
                <button type='button' class='btn btn-danger btn-sm ladda-button waves-effect waves-classic'>
                Not Allow</button></a>";
			}

			return $action;
		});
		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns, "", $where, '')
		);
	}

	public function chage_status($id)
	{
		$user_status = $this->Common_model->getSingle_data('id,is_pre_awb_allow', 'sender_master', array('id' => $id));
		if ($user_status['is_pre_awb_allow'] == '0') {
			$user_status = '1';
		} else {
			$user_status = '0';
		}
		$this->db->where('id', $id);
		$this->db->update('sender_master', ['is_pre_awb_allow' =>  $user_status]);
		$status = $this->db->affected_rows();
		if ($status) {
			$this->session->set_flashdata('message', "User Status Update Successfully");
			redirect('customer-pre-awb', 'refresh');
		}
	}
}
