<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Create_bulk_order extends Auth_Controller
{
	public $data;
	/**
	 * construct
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Bulk_order_model', 'Bulk_model');
		$this->customer_id = $this->session->userdata('userId');
		$this->load->model('Common_model');
		$this->load->model('Create_singleorder_awb');
		$this->load->library('Excel');
		$this->load->helper('get_shiping_price_helper');
		// print_r($this->session->userdata());
		// exit();

	}

	public function index()
	{
		$userId = $this->session->userdata('userId');
		$this->data['all_pickup_address'] = $this->Common_model->getResultArray(array('sender_id' => $userId), '*', 'sender_address_master');
		load_admin_view('bulk_order', 'bulk_oder_index', $this->data);
	}

	public function excel_import_bulk_order()
	{
		ini_set('max_execution_time', 0);
		set_time_limit(0);

		if ($this->input->post()) {
			$validation = [
				['field' => 'pickup_address', 'label' => 'Pickup Address', 'rules' => 'required'],
			];

			$this->form_validation->set_rules($validation);
			if ($this->form_validation->run() == false) {
				$this->data['errors'] = $this->form_validation->error_array();
				$this->index($this->data);
			} else {

				$paths = FCPATH . "./assets/import_bulk_order/uploaded/";
				$config['upload_path'] = './assets/import_bulk_order/uploaded/';
				$config['allowed_types'] = 'xlsx|xls|csv';
				$config['remove_spaces'] = true;
				$config['overwrite'] = true;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if (!$this->upload->do_upload('import_file')) {
					$error = array('error' => 'error');
					echo json_encode($error);
					exit;
					$error = array('error' => $this->upload->display_errors());
				} else {
					$data = array('upload_data' => $this->upload->data());
				}

				if (!empty($data['upload_data']['file_name'])) {
					$import_xls_file = $data['upload_data']['file_name'];
				} else {
					$import_xls_file = 0;
				}
				$inputFileName = $paths . $import_xls_file;
				try {
					$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
					$objReader = PHPExcel_IOFactory::createReader($inputFileType);
					$objPHPExcel = $objReader->load($inputFileName);
					// $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
				} catch (Exception $e) {
					die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
						. '": ' . $e->getMessage());
				}

				$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

				$all_field = ['Pincode', 'CustomerName', 'CustomerMobile', 'CustomerAddresss', 'Ship_length_incm', 'Ship_width_incm', 'Ship_height_incm', 'PhysicalWeight_inkg', 'ProductValue', 'ProductName', 'OrderNumber', 'OrderType', 'CODAmount', 'Quantity'];

				$array1 = $allDataInSheet['1'];
				$array2 = $all_field;
				$match_array = array_diff($array2, $array1);

				$result = "";
				if ($match_array) {
					implode(",", $match_array);
					$this->session->set_flashdata('error', implode(", ", $match_array) . ' Filed Missing in excel...');
					redirect('bulk-order');
				} else {
					$arrayCount = count($allDataInSheet);
					$flag = true;
					$i = 0;
					$pickup_address_id = $this->input->post('pickup_address');
					$total = count($allDataInSheet);

					$test = array();

					$requre_keys = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'L', 'M', 'N', 'O');
					// dd($allDataInSheet);
					foreach ($allDataInSheet as $key => $value) {

						if ($key == 1) {
							continue;
						} else {
							if ($value['A'] == "" && $value['B'] == "" && $value['C'] == "" && $value['D'] == "" && $value['E'] == "" && $value['F'] == "" && $value['G'] == "" && $value['H'] == "" && $value['I'] == "" && $value['J'] == "" && $value['L'] == "" && $value['M'] == "" && $value['N'] == "" && $value['O'] == "") {
								break;
							}
						}
						$fild_key = array_keys($value);
						$count = 0;
						$error = '';
						foreach ($fild_key as $key2 => $val) {

							if ($value[$val] != "" || $value[$val] != null) {
								$ins_data[$val] = $value[$val];
							} else {
								if ($val != "k" && $allDataInSheet[1][$val] != '') {
									$ins_data[$val] = '';
									$error = $allDataInSheet[1][$val] . ' Is Empty';
								}
							}
							if ($value[$val] == "" || $value[$val] == null) {
								$count++;
							}
						}

						if ($count != '15') {
							$inserdata['sender_id'] = $this->customer_id;
							$inserdata['pincode'] = $value['A'];
							$inserdata['name'] = $value['B'];
							$inserdata['mobile_no'] = $value['C'];
							$inserdata['address_1'] = $value['D'];
							if (strtolower(trim($value['M'])) == "cod") {
								$inserdata3['order_type'] = '1';
								$awb_type = 'is_cod';
								$awb_types_in = 1;
							} else if (strtolower(trim($value['M'])) == "prepaid") {
								$inserdata3['order_type'] = '0';
								$awb_type = 'is_prepaid';
								$awb_types_in = 0;
							}

							// function of get price // get_shiping_price
							$userId = $this->session->userdata('userId');
							$pickup_id = $this->input->post('pickup_address');
							$get_pickup_pincode = $this->Bulk_model->get_id_from_pincode($pickup_id);
							$pickup_pincode = $get_pickup_pincode->pincode;
							$deliverd_pincode = $value['A'];
							$shipment_type = 1;
							$order_type_id = $awb_types_in;
							$volumetric_weight = ($value['E'] * $value['F'] * $value['G'] / 5000);
							$physical_weight = $value['H'];
							$collectable_amount = ($value['I'] * $value['O']);
							// $this->benchmark->mark('1');
							$get_total_amount = get_shiping_price($userId, null, $pickup_pincode, $deliverd_pincode, $shipment_type, $order_type_id, $volumetric_weight, $physical_weight, $collectable_amount, 1, 18);
							// $this->benchmark->mark('2');
							// echo "Full Function 1 TO 2 : ", $this->benchmark->elapsed_time('1', '2');
							// exit;
							//    dd($get_total_amount);
							if ($get_total_amount['status'] == true) {
								$inserdata3['logistic_id'] = $get_total_amount['data'][0]['logistic_id'];
								$inserdata3['total_shipping_amount'] = $get_total_amount['data'][0]['subtotal'];
								$inserdata3['sgst_amount'] = $get_total_amount['data'][0]['tax']['SGST'];
								$inserdata3['cgst_amount'] = $get_total_amount['data'][0]['tax']['CGST'];
								$inserdata3['igst_amount'] = $get_total_amount['data'][0]['tax']['IGST'];
								$inserdata3['zone'] = @$get_total_amount['data'][0]['zone'];
								$inserdata1['cod_charge'] = $get_total_amount['data'][0]['cod_ammount'];
							} else {
								$error = $get_total_amount['message'];
								goto end;
							}
							// end fun       

							// valid for pincode of pickup
							$pickup_id = $this->input->post('pickup_address');
							$get_pickup_pincode = $this->Bulk_model->get_id_from_pincode($pickup_id);
							$pickup_add_pincode = $get_pickup_pincode->pincode;

							// valid for rec pinocode
							$pincodes = $value['A'];
							$check_pincode_numeric = $this->Create_singleorder_awb->numeric($pincodes);
							$check_pincode = $this->Create_singleorder_awb->exact_length($pincodes, 6);

							if ($check_pincode_numeric != true) {
								$error .= ' Pincode is not numeric';
								goto end;
							}
							if ($check_pincode != true) {
								$error .= ' Pincode is not valid length or syntax';
								goto end;
							}

							$phone = $value['C'];
							$check_phone_numeric = $this->Create_singleorder_awb->numeric($phone);
							if ($check_phone_numeric != true) {
								$error .= ' Contact Number is not numeric';
								goto end;
							}
							$call = strlen($phone);
							if (9 < $call && $call < 16) {
							} else {
								$error .= ' Customer contact number is not valid';
								goto end;
							}
							$ship_length_incm = $value['E'];


							$check_shipment_alpha = $this->Create_singleorder_awb->numeric($ship_length_incm);
							// dd($check_shipment_alpha);
							if ($check_shipment_alpha != true) {
								$error .= ' ship length is not numeric';

								goto end;
							}
							$volumetric_weight = $value['F'];
							$check_volumetric_alpha = $this->Create_singleorder_awb->numeric($volumetric_weight);
							if ($check_volumetric_alpha != true) {
								$error .= ' Physical weight in kg volumetric is not numeric';
								goto end;
							}
							$ship_height_incm = $value['G'];
							$check_ship_height_alpha = $this->Create_singleorder_awb->numeric($ship_height_incm);
							if ($check_ship_height_alpha != true) {
								$error .= ' ship height is not numeric';
								goto end;
							}
							$physicalweight = $value['H'];
							$check_physical_weight_alpha = $this->Create_singleorder_awb->numeric($physicalweight);
							if ($check_physical_weight_alpha != true) {
								$error .= ' Phyweight in kg is not numeric';
								goto end;
							}

							$productvalue = $value['I'];

							$check_product_alpha = $this->Create_singleorder_awb->numeric($productvalue);

							if ($check_product_alpha != true) {
								$error .= ' Product is not numeric';
								goto end;
							}

							$cod_amounts = $value['N'];

							$check_amount_alpha = $this->Create_singleorder_awb->numeric($cod_amounts);

							if ($check_amount_alpha != true) {
								$error .= ' Product Amount is not numeric';
								goto end;
							}

							$type_check = $value['M'];

							// $check_type_numeric = $this->Create_singleorder_awb->alpha_numeric($type_check);

							// if ($check_type_numeric != true) {
							//     $error .= ' Order type is not numeric';
							//     goto end;
							// }

							if ((strtolower(trim($value['M'])) == "cod") || (strtolower(trim($value['M'])) == "prepaid")) {
							} else {
								$error .= ' order_type is not valid';
								goto end;
							}
							end:
							// echo "insert";exit;
							$receiver_address_id = $this->Common_model->insert($inserdata, "receiver_address");

							$test[$key]['receiver_data'] = $inserdata;

							$inserdata1['length'] = $value['E'];
							$inserdata1['width'] = $value['F'];
							$inserdata1['height'] = $value['G'];
							$inserdata1['physical_weight'] = $value['H'];
							$inserdata1['product_value'] = $value['I'];
							$inserdata1['product_name'] = $value['J'];
							$inserdata1['product_sku'] = $value['K'];
							$inserdata1['cod_amount'] = $value['N'];
							$inserdata1['product_quantity'] = $value['O'];
							// dd($inserdata1);
							$order_product_detail_id = $this->Common_model->insert($inserdata1, "order_product_detail");

							$test[$key]['order_product_detail'] = $inserdata1;

							$inserdata3['sender_id'] = $this->customer_id;
							$inserdata3['pickup_address_id'] = $pickup_address_id;
							$inserdata3['order_product_detail_id'] = $order_product_detail_id;
							$inserdata3['deliver_address_id'] = $receiver_address_id;
							$inserdata3['customer_order_no'] = $value['L'];

							if ($error != '') {
								$inserdata3['is_process'] = '1';
								$inserdata3['error_message'] = $error;
							} else {
								$inserdata3['is_process'] = '0';
							}



							$result = $this->Create_singleorder_awb->insert($inserdata3, "temp_order_master");
							if ($result) {
								$update_data['order_no'] = 'SSL' . $this->customer_id . '-' . $result . '-' . rand(001, 999) . 'B';
								$updateRsult = $this->Common_model->update($update_data, 'temp_order_master', array('id' => $result));
							}
							if ($error != '') {
								unset($error);
							}
							unset($inserdata3);
						}
						$i++;
					}

					if ($result) {
						$this->session->set_flashdata('message', 'Your Bulk order created Successfully.');
						redirect('bulk-order');
					} else {
						$this->session->set_flashdata('error', 'Please check  Your Excel');
						redirect('bulk-order');
					}
				}
			}
		} else {
			$this->session->set_flashdata('error', 'something went wrong');
			redirect('bulk-order');
		}
	}

	public function bulk_order_data()
	{
		$userId = $this->session->userdata('userId');
		$columns = array();
		$table = 'temp_order_master';
		$primaryKey = 'id';
		$where = "is_flag='0' AND is_pre_awb='0' AND tom.sender_id='" . $userId . "'";
		$joinquery = "FROM {$table} AS tom  JOIN receiver_address as ra on tom.deliver_address_id = ra.id LEFT JOIN logistic_master as lm on tom.logistic_id = lm.id";

		$columns[0] = array('db' => 'tom.id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {

			if ($row[7] == '0') {
				return '<input type="checkbox" class="getChecked" id="check_single" name="check_single" value="' . $d . '">';
			}
			if ($row[7] == '1') {
				return '<input type="checkbox"  disabled class="" id="check_single" name="check_single" value="">';
			}
		});
		$columns[1] = array('db' => 'tom.order_no', 'dt' => 1, 'field' => 'order_no');

		$columns[2] = array('db' => 'lm.logistic_name', 'dt' => 2, 'field' => 'logistic_name');
		$columns[3] = array('db' => 'tom.created_date', 'dt' => 3, 'field' => 'created_date');
		$columns[4] = array('db' => 'ra.name', 'dt' => 4, 'field' => 'name');
		$columns[5] = array('db' => 'tom.order_type', 'dt' => 5, 'field' => 'order_type', 'formatter' => function ($d, $row) {
			return ($d == "0") ? "PrePaid" : "Cod";
		});
		$columns[6] = array('db' => 'tom.error_message', 'dt' => 6, 'field' => 'error_message');
		$columns[7] = array('db' => 'tom.is_process', 'dt' => 7, 'field' => 'is_process');
		$columns[8] = array('db' => 'tom.id', 'dt' => 8, 'field' => 'id', 'formatter' => function ($d, $row) {

			$action = '';

			if ($row[7] == '1') {

				$action = "<a href='" . base_url('delete-simple-bulk-order/' . $d) . "'>
            <button type='button' id='delete_btn_bulk' class='btn-raised btn-sm btn btn-danger btn-floating waves-effect waves-classic waves-effect waves-light'><i class='icon md-delete' aria-hidden='true'></i></button></a><a href='" . base_url('#' . $d) . "'></a>";
			} else {

				$action = "<a href='" . base_url('delete-simple-bulk-order/' . $d) . "'>
            <button type='button' id='delete_btn_bulk' class='btn-raised btn-sm btn btn-danger btn-floating waves-effect waves-classic waves-effect waves-light'>
            <i class='icon md-delete' aria-hidden='true'></i></button></a>";
			}
			// <button type='button' id='edit_btn' class='btn-raised btn-sm btn btn-dark btn-floating waves-effect waves-classic waves-effect waves-light'><i class='icon md-edit' aria-hidden='true'></i></button>
			return $action;
		});

		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns, $joinquery, $where)
		);
	}


	public function delete_simple_bulk_order($id)
	{
		$result = $this->Common_model->delete('temp_order_master', array('id' => $id));
		if ($result) {
			$this->session->set_flashdata('error', "Bulk order Deleted Successfully");
			redirect(base_url('bulk-order'));
		}
	}
	public function simple_bulk_order_create()
	{
		$this->load->model('Order_model');
		$order_ids = $this->input->post('values');
		$totalshipping  = $this->Bulk_model->get_order_cost($order_ids);
		$totalshipping  = $totalshipping->total_shipping_amount;
		$sender_id =  $this->session->userdata('userId');

		$check_bulk_order = $this->Order_model->check_bulk_order($sender_id);
		$check_priority = $this->Order_model->check_priority($sender_id);


		$flag = 0;

		if ($check_bulk_order > 0) {
			echo json_encode(array('status' => '2', 'count' => $check_bulk_order));
			return;
		} else if (empty($check_priority)) {
			echo json_encode(array('status' => '3'));
		} else {
			if ($totalshipping) {
				$checkWallet = API::check_wallet($sender_id, $totalshipping);
				if ($checkWallet == '1') {
					$flag = 1;
				} else {
					$flag = 0;
				}
			}
			if ($flag == 1) {
				foreach ($order_ids as $key => $value) {
					$data = ['is_flag' => '1'];
					$this->db->where('id', $value);
					$data = $this->db->update('temp_order_master', $data);
				}
				echo json_encode(array('status' => '1'));
			} else {
				echo json_encode(array('status' => '0'));
			}
		}
	}

	public function delete_multiple_bulk_order()
	{
		// dd($_POST);
		$order_id = $this->input->post('order_id');
		if ($this->input->post('order_id')) {
			$result = $this->Bulk_model->delete_bulk_order($order_id);
			echo $result;
			exit;
		}
	}

	public function delete_all_error_order()
	{
		$status =  $this->Bulk_model->delete_bulk_error_order($this->customer_id);
		// dd($status);
		if ($status > 0) {
			echo json_encode(['status' => "1", 'msg' => 'Order Deleted Successfully']);
		} else {
			echo json_encode(['status' => "0", 'msg' => 'Something Went Wrong']);
		}
	}
}
