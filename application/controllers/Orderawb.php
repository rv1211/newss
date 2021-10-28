<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Orderawb extends Auth_Controller
{

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('Create_singleorder_awb');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->load->helper('get_shiping_price_helper');
		$this->customer_id = $this->session->userdata('userId');
		$this->load->model('Bulk_order_model', 'Bulk_model');
	}

	public function index($data = "")
	{
		$this->data['logistic_type'] = $this->Create_singleorder_awb->get_logistic($this->session->userdata('userId'));
		$this->data['pickup_address'] = $this->Create_singleorder_awb->get_pickup_address($this->session->userdata('userId'));
		load_admin_view('order', 'create_single_order_awbno', $this->data);
	}

	//craete single order for pre airwaybill number
	public function insert_single_order_awb()
	{
		// dd($_POST);
		$userId = $this->session->userdata('userId');
		if ($this->input->post()) {
			$validation = [
				['field' => 'pickup_address', 'label' => 'Pickup Address', 'rules' => 'required'],
				['field' => 'shipment_type', 'label' => 'Shipment type', 'rules' => 'required'],
				['field' => 'logistic', 'label' => 'Logistic Type', 'rules' => 'required'],
				['field' => 'awbno', 'label' => 'Airwaybill Number', 'rules' => 'required'],
				['field' => 'shippingcharge', 'label' => 'Shipping Charge', 'rules' => 'required'],
				['field' => 'pincode', 'label' => 'Pincode', 'rules' => 'required'],
				['field' => 'state', 'label' => 'Status', 'rules' => 'required'],
				['field' => 'city', 'label' => 'City', 'rules' => 'required'],
				['field' => 'customer_name', 'label' => 'Customer Name', 'rules' => 'required'],
				['field' => 'customer_mobile', 'label' => 'Customer Mobile', 'rules' => 'required'],
				['field' => 'customer_address1', 'label' => 'Customer Address 1', 'rules' => 'required'],
				['field' => 'length', 'label' => 'Lenght', 'rules' => 'required'],
				['field' => 'width', 'label' => 'Customer Address 1', 'rules' => 'required'],
				['field' => 'height', 'label' => 'height', 'rules' => 'required'],
				['field' => 'physical_width', 'label' => 'Physical width', 'rules' => 'required'],
				['field' => 'product_value', 'label' => 'Product value', 'rules' => 'required'],
				['field' => 'product_name', 'label' => 'Product Name', 'rules' => 'required'],
				['field' => 'product_qty', 'label' => 'Product quantity', 'rules' => 'required'],
				['field' => 'order_type', 'label' => 'Order type', 'rules' => 'required'],


			];
			if ($this->input->post('seller_info') == "on") {
				$validation[] = ['field' => 'reseller_name', 'label' => 'Resaller Name', 'rules' => 'required'];
			}
			if ($this->input->post('order_type') == '1') {
				$validation[] = ['field' => 'collectable_amount', 'label' => 'Collectable Amount', 'rules' => 'required'];
			}

			$this->form_validation->set_rules($validation);
			// dd($this->form_validation->error_array());
			if ($this->form_validation->run() == FALSE) {
				$this->data['errors'] = $this->form_validation->error_array();
				$this->index($this->data);
			} else {
				file_put_contents(APPPATH . 'logs/create_order/' . date("d-m-Y") . '_create_order.txt', "\n-------------- Start Create Order --------------\n", FILE_APPEND);
				$awbno = $this->input->post('awbno');
				$logistic_name = $this->input->post('logistic');
				$logistic_api_name = $this->Common_model->getSingle_data('api_name, logistic_name', 'logistic_master', array('id' => $this->input->post('logistic_id')));
				$logisticTableName = str_replace(' ', '_', strtolower(trim($logistic_api_name['logistic_name'])));
				if ($logistic_api_name['api_name'] == "Delhivery_Surface") {
					$logistic = "Delhivery_Surface";
				} else if ($logistic_api_name['api_name'] == 'Xpressbees_Surface') {
					$logistic = "Xpressbees_Surface";
				} else if ($logistic_api_name['api_name'] == 'Ekart_Surface') {
					$logistic = 'Ekart_Surface';
				}
				$shipingcharge = $this->input->post('totalshipping');
				// dd($shipingcharge);
				//Product detail -order_product_detail
				$insert_pro_detail['length'] = $this->input->post('length');
				$insert_pro_detail['width'] = $this->input->post('width');
				$insert_pro_detail['height'] = $this->input->post('height');
				$insert_pro_detail['volumetric_weight'] = $this->input->post('volumetric_weight');
				$insert_pro_detail['physical_weight'] = $this->input->post('physical_width');
				$insert_pro_detail['product_value'] = $this->input->post('product_value');
				$insert_pro_detail['product_name'] = $this->input->post('product_name');
				$insert_pro_detail['product_quantity'] = $this->input->post('product_qty');
				$insert_pro_detail['cod_amount'] = $this->input->post('collectable_amount');
				$insert_pro_detail['product_quantity'] = $this->input->post('quantity');
				$insert_pro_detail['cod_charge'] = $this->input->post('codcharge');
				$insert_product_detail = $this->Common_model->insert($insert_pro_detail, 'order_product_detail');
				$product_id = $insert_product_detail;

				//receiver address tbl
				$insert_receiver_address['sender_id'] = $userId;
				$insert_receiver_address['name'] = $this->input->post('customer_name');
				$insert_receiver_address['email'] = $this->input->post('customer_email');
				$insert_receiver_address['mobile_no'] = $this->input->post('customer_mobile');
				$insert_receiver_address['address_1'] = $this->input->post('customer_address1');
				$insert_receiver_address['address_2'] = $this->input->post('customer_address2');
				$insert_receiver_address['state'] = $this->input->post('state');
				$insert_receiver_address['city'] = $this->input->post('city');
				$insert_receiver_address['pincode'] = $this->input->post('pincode');
				$insert_receiver_detail = $this->Common_model->insert($insert_receiver_address, 'receiver_address');
				$deliver_address_id = $insert_receiver_detail;

				if ($product_id && $deliver_address_id != "") {
					//tmp order tbl
					$insert_tmp_single_order['sender_id'] = $userId;
					$insert_tmp_single_order['pickup_address_id'] = $this->input->post('pickup_address');
					$insert_tmp_single_order['order_product_detail_id'] = $product_id;
					$insert_tmp_single_order['logistic_id'] = $this->input->post('logistic_id');
					$insert_tmp_single_order['deliver_address_id'] = $deliver_address_id;
					// $insert_tmp_single_order['order_no'] = $this->input->post('order_number');
					$insert_tmp_single_order['customer_order_no'] = $this->input->post('order_number');
					if ($this->input->post('order_type') == '1') {
						$insert_tmp_single_order['order_type'] = '1';
					}
					if ($this->input->post('order_type') == '0') {
						$insert_tmp_single_order['order_type'] = '0';
					}
					//$insert_tmp_single_order['gst_amount'] = ;
					$insert_tmp_single_order['total_shipping_amount'] = $shipingcharge;
					$insert_tmp_single_order['awb_number'] = $this->input->post('awbno');
					if ($this->input->post('reseller_name') != "") {
						$insert_tmp_single_order['is_seller_info'] = '1';
						$insert_tmp_single_order['packing_slip_warehouse_name'] = $this->input->post('reseller_name');
					}
					//$insert_tmp_single_order['is_return_address_same_as_pickup'] = $this->input->post('is_return_address_same_as_pickup');
					$insert_tmp_single_order['sgst_amount'] = $this->input->post('sgst');
					$insert_tmp_single_order['cgst_amount'] = $this->input->post('cgst');
					$insert_tmp_single_order['igst_amount'] = $this->input->post('igst');
					$insert_tmp_single_order['created_date'] = date('Y-m-d H:i:s');
					$insert_tmp_single_order['created_by'] = $userId;
					$insert_tmp_single_order['is_pre_awb'] = '1';
					$createOrder_log['create_order_body'] = $insert_tmp_single_order;
					$insert_tmp_order = $this->Common_model->insert($insert_tmp_single_order, 'temp_forward_order_master');
					$createOrder_log['insert_temp_order_id'] = $insert_tmp_order;
					file_put_contents(APPPATH . 'logs/create_order/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_log, true), FILE_APPEND);

					if ($insert_tmp_order) {
						$update_data['order_no'] = 'PDL' . $userId . '-' . $insert_tmp_order . 'S';
						$updateRsult = $this->Common_model->update($update_data, 'temp_forward_order_master', array('id' => $insert_tmp_order));

						if ($logistic_api_name['api_name'] == "Delhivery_Surface" || $logistic_api_name['api_name'] == 'Xpressbees_Surface' || $logistic_api_name['api_name'] == 'Ekart_Surface') {
							$add_id = $this->input->post('pickup_address');
							$pickup_address_fetch_row_info = $this->Common_model->getSingle_data('*', 'sender_address_master', array('id' => $add_id));
							if ($pickup_address_fetch_row_info['zship_sender_id'] == "") {
								$email = (!empty($this->input->post('customer_email'))) ? $this->input->post('customer_email') :  "sample@gmail.com";
								$pickup_address_fetch_row_info['email'] = $email;
								$zship_sender_id = $this->create_address_in_api($pickup_address_fetch_row_info);
							} else {
								$zship_sender_id = $pickup_address_fetch_row_info['zship_sender_id'];
							}
							$this->load->helper('zship_new');
							//create order in zship
							$response = create_order_zship($insert_tmp_order);
							$createOrder_response_log['order_response'] = $response;
							file_put_contents(APPPATH . 'logs/create_order/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
						} else if ($logistic_api_name['api_name'] == 'Xpressbees_Direct') {
							$repeat = 0;
							$response = xpressbees_direct::xpressbees_order($insert_tmp_order, 0);
							$createOrder_response_log['order_response'] = $response;
							if ($response['status'] == 0 && $response['message'] == 'AWB Already Exists' && $repeat == 0) {
								$response = xpressbees_direct::xpressbees_order($insert_tmp_order, 1);
								$createOrder_response_log['order_response_repeat'] = $response;
								$repeat++;
							}
							file_put_contents(APPPATH . 'logs/create_order/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
						} else if ($logistic_api_name['api_name'] == 'Ecart_air') {
							$response = API::ecart_order($insert_tmp_order, 0);
							$createOrder_response_log['order_response'] = $response;
							file_put_contents(APPPATH . 'logs/create_order/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
						}
						if ($response['status'] == 0) {
							$this->session->set_flashdata('error', $response['message']);
						} else {
							if ($logistic_api_name['api_name'] == "Delhivery_Surface" || $logistic_api_name['api_name'] == 'Xpressbees_Surface' || $logistic_api_name['api_name'] == 'Ekart_Surface') {
								$this->session->set_flashdata('message', "Your request Has been accepted and Order in process.");
							} else {
								$this->session->set_flashdata('message', "Order Created Successfully.");
							}
						}
						redirect('create-single-order-awbno');
					} else {
						$this->session->set_flashdata('error', "Something went wrong");
						redirect('create-single-order-awbno');
					}
				}
				file_put_contents(APPPATH . 'logs/create_order/' . date("d-m-Y") . '__create_order', "\n--------- End Create Order -----\n", FILE_APPEND);
			}
		}
	}

	//get city ,state from pincode
	public function get_pincode()
	{
		$pincode = $this->input->post('pincode_data');
		$pincode_data = str_replace("<br>", "", $this->Common_model->getSingle_data('city,state', 'pincode_master', array('pincode' => $pincode)));
		if (!empty($pincode_data)) {
			echo (json_encode($pincode_data));
			exit;
		} else {
			$error = ["error" => "error"];
			echo (json_encode($error));
			exit;
		}
	}

	//get logistic type on awb number
	public function get_duplicate_awbno()
	{
		$userId = $this->session->userdata('userId');
		$awb_no = $this->input->post('awb_no');
		$ordertype = $this->input->post('ordertype');
		if (!empty($awb_no)) {
			$awbNumber = $this->Create_singleorder_awb->check_awb($awb_no, $ordertype, $userId);

			if (!empty($awbNumber)) {
				echo json_encode($awbNumber);
				exit;
			} else {
				echo "error";
				exit;
			}
		}
	}

	//check order number
	public function check_oreder_number()
	{
		$order_number = $this->input->post('ordernumber');
		$order_result = $this->Common_model->getall_data('order_no,id', 'forward_order_master', array('order_no' => $order_number));

		if (empty($order_result)) {
			$order_result1 = $this->Common_model->getall_data('order_no,id', 'temp_forward_order_master', array('order_no' => $order_number));
			if (empty($order_result1)) {
				echo "sucess";
				exit;
			} else {
				echo "error";
				exit;
			}
		} else {
			echo "error";
			exit;
		}
	}

	// pre awb bulk order start (EXCEL) by milan
	public function bulk_order_awb($data = "")
	{
		$userId = $this->session->userdata('userId');
		$this->data['all_pickup_address'] = $this->Common_model->getResultArray(array('sender_id' => $userId), '*', 'sender_address_master');
		$this->data['user_logistics'] = $this->Create_singleorder_awb->user_by_get_logistic($userId);
		load_admin_view('order', 'pre_awb_bulk_order', $this->data);
	}

	// pre bulk order excel
	public function create_pre_airway_bill()
	{
		// dd($_POS);
		if ($this->input->post()) {
			$validation = [
				['field' => 'pickup_address', 'label' => 'Pickup Address', 'rules' => 'required'],
			];

			$this->form_validation->set_rules($validation);
			if ($this->form_validation->run() == false) {
				$this->data['errors'] = $this->form_validation->error_array();
				$this->bulk_order_awb($this->data);
			} else {

				$paths = FCPATH . "./assets/pre_airway_bulk_order/";
				$config['upload_path'] = './assets/pre_airway_bulk_order/';
				$config['allowed_types'] = 'xlsx|xls|csv';
				$config['remove_spaces'] = true;
				$config['overwrite'] = true;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				$this->upload->initialize($config);
				if (!$this->upload->do_upload('pre_bulk_import_file')) {
					$this->session->set_flashdata('error', $this->upload->display_errors());
					redirect('pre-bulk-order-awb');
				} else {
					$data = array('upload_data' => $this->upload->data());
					if (!empty($data['upload_data']['file_name'])) {
						$import_xls_file = $data['upload_data']['file_name'];
					} else {
						$import_xls_file = 0;
					}
				}
				$inputFileName = $paths . $import_xls_file;

				$inputFileName = $paths . $import_xls_file;
				try {
					$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
					$objReader = PHPExcel_IOFactory::createReader($inputFileType);
					$objPHPExcel = $objReader->load($inputFileName);
				} catch (Exception $e) {
					die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
						. '": ' . $e->getMessage());
				}

				$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

				$all_field = ['Pincode', 'CustomerName', 'CustomerMobile', 'CustomerAddresss', 'Ship_length_incm', 'Ship_widht_incm', 'Ship_height_incm', 'PhysicalWeight_inkg', 'ProductValue', 'ProductName', 'Productsku', 'OrderNumber', 'OrderType', 'CODAmount', 'Quantity', 'Awb_Number'];

				$array1 = $allDataInSheet['1'];
				$array2 = $all_field;
				$match_array = array_diff($array2, $array1);

				$result = "";
				if ($match_array) {
					implode(",", $match_array);
					$this->session->set_flashdata('error', implode(", ", $match_array) . ' feild Missing in excel...');
					redirect('pre-bulk-order-awb');
				} else {
					$arrayCount = count($allDataInSheet);
					$flag = true;
					$i = 0;
					$pickup_address_id = $this->input->post('pickup_address');
					$total = count($allDataInSheet);

					foreach ($allDataInSheet as $key => $value) {

						if ($key == 1) {
							continue;
						} else {
							if ($value['A'] == "" && $value['B'] == "" && $value['C'] == "" && $value['D'] == "" && $value['E'] == "" && $value['F'] == "" && $value['G'] == "" && $value['H'] == "" && $value['I'] == "" && $value['J'] == "" && $value['K'] == "" && $value['L'] == "" && $value['M'] == "" && $value['N'] == "" && $value['O'] == "" && $value['P'] == "") {
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
								$ins_data[$val] = '';
								$error = $allDataInSheet[1][$val] . ' Is Empty';
							}
							if ($value[$val] == "" || $value[$val] == null) {
								$count++;
							}
						}

						if ($count != '17') {
							$inserdata['sender_id'] = $this->customer_id;
							$inserdata['pincode'] = $value['A'];
							$inserdata['name'] = $value['B'];
							$inserdata['mobile_no'] = $value['C'];
							$inserdata['address_1'] = $value['D'];

							// check cod/prepaid
							if (strtolower(trim($value['M'])) == "cod") {
								$inserdata3['order_type'] = '1';
								$ordertype = '1';
								$awb_types_in = 1;
							} else if (strtolower(trim($value['M'])) == "prepaid") {
								$inserdata3['order_type'] = '0';
								$ordertype = '2';
								$awb_types_in = 0;
							}
							// end
							// get logistic id from name
							// $logistic_name = $value['Q'];
							$awb_no = $value['P'];
							$order_type = $value['M'];

							$user_Id = $this->session->userdata('userId');
							$get_logistic = $this->Create_singleorder_awb->check_awb($awb_no, $ordertype, $user_Id);
							// echo $awb_no;
							// lq();
							// dd($get_logistic);


							$inserdata3['logistic_id'] = $get_logistic['id'];
							// end
							$inserdata3['awb_number'] = $awb_no;

							// get shipping charge price helper start 
							//session id
							$userId = $this->session->userdata('userId');
							// get logistic id
							$logistic_id = $get_logistic['id'];
							//pickup pincode address
							$pickup_id = $this->input->post('pickup_address');
							$get_pickup_pincode = $this->Bulk_model->get_id_from_pincode($pickup_id);
							$pickup_pincode =  $get_pickup_pincode->pincode;
							//delived pincode address
							$deliverd_pincode = $value['A'];
							$shipment_type = '0';
							$order_type_id = $awb_types_in;
							$volumetric_weight = ($value['E'] * $value['F'] * $value['G'] / 5000);
							$physical_weight = $value['H'];
							$collectable_amount = ($value['I'] * $value['O']);
							$get_total_amount =  get_shiping_price($userId, $logistic_id, $pickup_pincode, $deliverd_pincode, $shipment_type, $order_type_id, $volumetric_weight, $physical_weight, $collectable_amount, 1, 18);
							// dd($get_total_amount);
							if (empty($get_logistic)) {
								$error = 'Invalid Airwaybill';
								goto end;
							}

							if ($get_total_amount['status'] == true) {
								if ($logistic_id == "" || $logistic_id == NULL) {
									$logistic_id = $get_total_amount['data'][0]['logistic_id'];
								}
								$inserdata3['total_shipping_amount'] = $get_total_amount['data'][0]['subtotal'];
								$inserdata3['sgst_amount'] = $get_total_amount['data'][0]['tax']['SGST'];
								$inserdata3['cgst_amount'] = $get_total_amount['data'][0]['tax']['CGST'];
								$inserdata3['igst_amount'] = $get_total_amount['data'][0]['tax']['IGST'];
								$inserdata1['cod_charge'] = $get_total_amount['data'][0]['cod_ammount'];
							} else {
								$error = $get_total_amount['message'];
								goto end;
							}
							// get shipping charge price helper end 

							// valid for pincode of pickup
							$pickup_id = $this->input->post('pickup_address');
							$get_pickup_pincode = $this->Bulk_model->get_id_from_pincode($pickup_id);
							$pickup_add_pincode =  $get_pickup_pincode->pincode;
							// end validation

							// Pincode rec. validation
							$pincodes = $value['A'];
							$check_pincode_numeric = $this->Create_singleorder_awb->numeric($pincodes);
							$check_pincode = $this->Create_singleorder_awb->exact_length($pincodes, 6);
							if ($check_pincode_numeric != true) {
								$error = 'Pincode is not numeric';
								goto end;
							}
							if ($check_pincode != true) {
								$error = 'Pincode is not valid length or syntax';
								goto end;
							}

							//check phone
							$phone = $value['C'];
							$check_phone_numeric = $this->Create_singleorder_awb->numeric($phone);
							if ($check_phone_numeric != true) {
								$error = 'Contact Number is not numeric';
								goto end;
							}
							$call = strlen($phone);
							if (9 < $call && $call < 16) {
							} else {
								$error = 'Customer contact number is not valid';
								goto end;
							}
							// end

							$ship_length_incm = $value['E'];
							$check_shipment_alpha = $this->Create_singleorder_awb->numeric($ship_length_incm);
							if ($check_shipment_alpha != true) {
								$error = 'ship length is not alpha_numeric';
								goto end;
							}

							$weight = $value['F'];
							$check_volumetric_alpha = $this->Create_singleorder_awb->numeric($weight);
							if ($check_volumetric_alpha != true) {
								$error = 'Physical weight in kg volumetric is not alpha_numeric';
								goto end;
							}

							$ship_height_incm = $value['G'];
							$check_ship_height_alpha = $this->Create_singleorder_awb->numeric($ship_height_incm);
							if ($check_ship_height_alpha != true) {
								$error = 'ship height is not alpha_numeric';
								goto end;
							}

							$physicalweight = $value['H'];
							$check_physical_weight_alpha = $this->Create_singleorder_awb->numeric($physicalweight);
							if ($check_physical_weight_alpha != true) {
								$error = 'Phyweight in kg is not alpha_numeric';
								goto end;
							}

							$productvalue = $value['I'];
							$check_product_alpha = $this->Create_singleorder_awb->numeric($productvalue);
							if ($check_product_alpha != true) {
								$error = 'Product is not alpha_numeric';
								goto end;
							}

							$cod_amounts = $value['N'];
							$check_amount_alpha = $this->Create_singleorder_awb->numeric($cod_amounts);
							if ($check_amount_alpha != true) {
								$error = 'Product Amount is not alpha_numeric';
								goto end;
							}

							$type_check = $value['M'];
							$check_type_numeric = $this->Create_singleorder_awb->alpha_numeric($type_check);
							if ($check_type_numeric != true) {
								$error = 'Order type is not alpha_numeric';
								goto end;
							}

							if ((strtolower(trim($value['M']))) == "cod" || (strtolower(trim($value['M']))) == "prepaid") {
							} else {
								$error = 'order_type is not valid';
								goto end;
							}

							$awb_number = $value['P'];
							// $name_of_logistic = $value['Q'];
							// $logistic_name_final = strtolower(str_replace(' ', '_', trim($name_of_logistic)));
							// if ($logistic_name_final != '') {       
							// $logistic_name = $value['Q'];
							$awb_no = $value['P'];
							$order_type = $value['M'];
							// $user_Id = $this->session->userdata('userId');
							$get_logistic = $this->Create_singleorder_awb->check_awb($awb_no, $ordertype, $user_Id);
							// dd($get_logistic);
							// $get_logistic = $this->Create_singleorder_awb->check_awb($logistic_name);
							$inserdata3['logistic_id'] = $get_logistic['id'];
							$logistic_id = $get_logistic['id'];
							$check_assign_logsitic = $this->Create_singleorder_awb->check_logistic_id_by_user($logistic_id, $userId);
							if (empty($check_assign_logsitic) && $check_assign_logsitic == "") {
								$error = 'Logistic is not assign';
								goto end;
							}
							// }
							// else{
							//     $error = 'Logistic name is empty';
							//     goto end;
							// }

							if ($awb_number != '') {

								$awb_no = $value['P'];
								$order_type = $value['M'];
								$user_Id = $this->session->userdata('userId');
								$get_logistic = $this->Create_singleorder_awb->check_awb($awb_no, $ordertype, $user_Id);
								// dd($get_logistic);
								$inserdata3['logistic_id'] = $get_logistic['id'];
								$logistic_id = $get_logistic['id'];
								// $logistic = $this->input->post('logistic');

								$logist_number_is_used = $this->Create_singleorder_awb->check_logistic_exist($logistic_id, $awb_number);
								if (!empty($logist_number_is_used['awb_number']) && $logist_number_is_used['awb_number'] != "") {
									$awb = $logist_number_is_used['awb_number'];
									$awb_check_for_temp = $this->Create_singleorder_awb->check_in_temp_awb($awb, $logistic_id);
									if (!empty($awb_check_for_temp)) {
									}
								} else {
									$error = 'AWB number is not avilable in this logistic';
									goto end;
								}
							} else {
								$error = 'AWB number is blank';
								goto end;
							}


							$awb_status = $this->Create_singleorder_awb->get_awb($awb_number, $logistic_id, $ordertype);
							// lq();
							if (empty($awb_status) && $awb_status == "") {
								$error = 'Awb Number is not valid';
								goto end;
							}
							end:


							$receiver_address_id = $this->Common_model->insert($inserdata, "receiver_address");
							$inserdata1['length'] = $value['E'];
							$inserdata1['width'] = $value['F'];
							$inserdata1['height'] = $value['G'];
							$inserdata1['volumetric_weight'] = $volumetric_weight;
							$inserdata1['physical_weight'] = $value['H'];
							$inserdata1['product_value'] = $value['I'];
							$inserdata1['product_name'] = $value['J'];
							$inserdata1['product_sku'] = $value['K'];
							$inserdata1['cod_amount'] = $value['N'];
							$inserdata1['product_quantity'] = $value['O'];

							$order_product_detail_id = $this->Common_model->insert($inserdata1, "order_product_detail");
							$inserdata3['sender_id'] = $this->customer_id;
							$inserdata3['pickup_address_id'] = $pickup_address_id;
							$inserdata3['order_product_detail_id'] = $order_product_detail_id;
							$inserdata3['deliver_address_id'] = $receiver_address_id;
							$inserdata3['customer_order_no'] = $value['L'];
							$inserdata3['logistic_id'] = $logistic_id;



							if ($error != '') {
								$inserdata3['is_process'] = '1';
								$inserdata3['error_message'] = $error;
							} else {
								$inserdata3['is_process'] = '0';
							}

							$inserdata3['is_pre_awb'] = '1';

							$result = $this->Create_singleorder_awb->insert($inserdata3, "temp_order_master");
							if ($result) {
								$update_data['order_no'] = 'SSL' . $this->customer_id . '-' . $result . 'B';
								$updateRsult = $this->Common_model->update($update_data, 'temp_order_master', array('id' => $result));
							}
							if ($error != '') {
								unset($error);
							}
						}
						$i++;
					}
					if ($result) {
						$this->session->set_flashdata('message', 'Your Pre Bulk order created Successfully.');
						redirect('pre-bulk-order-awb');
					} else {
						$this->session->set_flashdata('error', 'Please check  Your Excel');
						redirect('pre-bulk-order-awb');
					}
				}
			}
		} else {
			$this->session->set_flashdata('error', 'something went wrong');
			redirect('pre-bulk-order-awb');
		}
	}
	// pre awb bulk order end (EXCEL)

	//get shipping price
	public function get_shipping_charge()
	{
		$sender_id = $this->session->userdata('userId');
		$logistic_id = $this->input->post('logistic');
		$shipment_type = $this->input->post('shipment_type');
		$order_type_id = $this->input->post('order_type');
		$volumetric_weight = $this->input->post('volumetric_weight');
		$physical_weight = $this->input->post('physical_width');
		$collectable_amount = $this->input->post('collectable_amount');
		$to_pin = $this->input->post('deliverd_pincode');
		$pickup_id = $this->input->post('pickup_id');

		$sender_info = $this->Common_model->getSingle_data('id,sender_id,state,pincode', 'sender_address_master', array('id' => $pickup_id));

		$total_shipping_price = get_shiping_price($sender_id, $logistic_id, $sender_info['pincode'], $to_pin, $shipment_type, $order_type_id, $volumetric_weight, $physical_weight, $collectable_amount, 0, 18);
		if ($total_shipping_price['status'] == true) {
			$shipping_amount_array = $total_shipping_price['data'][0];
			$total_order_amount = $total_shipping_price['data'][0]['total'];
			if ($total_order_amount) {
				$checkWallet = API::check_wallet($sender_id, $total_order_amount);
				if ($checkWallet == '1') {
					$array = ['shipping_amount_array' => $shipping_amount_array, 'shippingcharge' => $total_order_amount, 'message' => "success", 'error' => ""];
					echo json_encode($array);
					exit;
				} else {
					$array = ['shipping_amount_array' => "", 'shippingcharge' => 0, 'message' => "", 'error' => "You have not sufficient wallet balance,Recharge your wallet"];
					echo json_encode($array);
					exit;
				}
			} else {
				$array = ['shipping_amount_array' => "", 'shippingcharge' => 0, 'message' => "", 'error' => "Something Went Wrong"];
				echo json_encode($array);
				exit;
			}
		} else {
			$array4 = ['shipping_amount_array' => "", 'shippingcharge' => "", 'message' => "", 'error' => $total_shipping_price['message']];
			echo json_encode($array4);
			exit;
		}
	}

	// Insert Pickup Address In ZSHIP
	public function create_address_in_api($pickup_address_fetch_row_info)
	{
		$token_detail = $this->Common_model->getSingle_data('*', 'zship_token_master', '');
		$address = $pickup_address_fetch_row_info['address_line_1'];
		if ($pickup_address_fetch_row_info['address_line_2'] != "") {
			$address .= ", " . $pickup_address_fetch_row_info['address_line_2'];
		}
		$address .= ", " . $pickup_address_fetch_row_info['city'] . ", " . $pickup_address_fetch_row_info['state'];

		$request_body = 'name=' . urlencode($pickup_address_fetch_row_info['warehouse_name']) . '&company=' . urlencode($pickup_address_fetch_row_info['contact_person_name']) . '&email=' . urlencode($pickup_address_fetch_row_info['email']) . '&address=' . urlencode($address) . '&phone=' . urlencode($pickup_address_fetch_row_info['contact_no']) . '&pincode=' . urlencode($pickup_address_fetch_row_info['pincode']) . '';
		$response['api-request-body'] = $request_body;

		$curl_response = CUSTOM::curl_request('application/x-www-form-urlencoded', $token_detail['token'], $this->config->item('ZSHIP_API_SAVE_SENDER_URL'), $request_body, "POST");

		$response['curl_response'] = $curl_response;
		if (@$curl_response['error_response'] != "") {
			$response['error_response'] = $curl_response['error_response'];
		} else {
			if ($curl_response['success_response']['status'] == 200) {
				if ($curl_response['success_response']['message']['sender_id'] != "") {
					$response['success_response'] = "create in api order suceessfuly.";
					$data['zship_sender_id'] = $curl_response['success_response']['message']['sender_id'];
					$this->Common_model->update($data, 'sender_address_master', array('id' => $pickup_address_fetch_row_info['id']));
				} else {
					$response['error_response'] = $curl_response['success_response']['message'];
				}
			} elseif ($curl_response['success_response']['status'] == 401) {
				$response['error_response'] = $curl_response['success_response']['message'];
			} elseif ($curl_response['success_response']['status'] == 400) {
				if (is_array($response['success_response']['message'])) {
					$response['error_response'] = "Invalid Request.";
				} else {
					$response['error_response'] = $curl_response['success_response']['message'];
				}
			}
		}
		return $response;
	}

	public function bulk_order_awb_data()
	{
		$columns = array();
		$table = 'temp_order_master';
		$primaryKey = 'id';
		if ($this->session->userdata('userType') == '1') {
			$where = "tom.is_flag='0' AND tom.is_pre_awb='1'";
		} else {
			$where = "tom.is_flag='0' AND tom.is_pre_awb='1' AND tom.sender_id='" . $this->session->userdata('userId') . "'";
		}
		// $where = "tom.is_flag='0' AND tom.is_pre_awb='1'";

		$joinquery = "FROM {$table} AS tom JOIN receiver_address as ra on tom.deliver_address_id = ra.id LEFT JOIN logistic_master as lm on tom.logistic_id = lm.id";

		$columns[0] = array('db' => 'tom.id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {

			if ($row[7] == '0') {

				return '<input type="checkbox" class="getChecked" id="check_single" name="check_single" value="' . $d . '">';
			}
			if ($row[7] == '1') {
				return '<input type="checkbox"  disabled class="getChecked" id="check_single" name="check_single" value="">';
			}
		});
		$columns[1] = array('db' => 'tom.customer_order_no', 'dt' => 1, 'field' => 'customer_order_no');

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

				$action = "<a href='" . base_url('delete-pre-bulk-order/' . $d) . "'>
        <button type='button' id='delete_btn_bulk' class='btn-raised btn-sm btn btn-danger btn-floating waves-effect waves-classic waves-effect waves-light'><i class='icon md-delete' aria-hidden='true'></i></button></a>";
			} else {

				$action = "<a href='" . base_url('delete-pre-bulk-order/' . $d) . "'>
        <button type='button' id='delete_btn_bulk' class='btn-raised btn-sm btn btn-danger btn-floating waves-effect waves-classic waves-effect waves-light'>
        <i class='icon md-delete' aria-hidden='true'></i></button></a>";
			}

			return $action;
		});


		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns, $joinquery, $where)
		);
	}

	public function delete_bulk_order($id)
	{
		$result = $this->Common_model->delete('temp_order_master', array('id' => $id));
		if ($result) {
			$this->session->set_flashdata('error', "Pre Bulk order Deleted Successfully");
			redirect(base_url('pre-bulk-order-awb'));
		}
	}
}
/* End of file Controllername.php */
