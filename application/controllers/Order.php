<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends Auth_Controller
{
	public $data;


	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->load->model('Create_singleorder_awb');
		$this->load->helper('get_shiping_price_helper');
	}

	public function Create_single_order(string $viewname)
	{
		$data['all_pickup_address'] = $this->Common_model->getall_data('*', 'sender_address_master');
		$this->load->view('admin/template/header');
		$this->load->view('admin/template/sidebar');
		$this->load->view('admin/order/' . $viewname, $this->data);
		$this->load->view('admin/template/footer');
	}

	/**
	 * add logistic view load
	 *
	 * @return  view  load add logistic form
	 */
	public function index()
	{
		// dd($_POST);
		$this->db->cache_delete_all();
		$this->data['pickup_address'] = $this->Create_singleorder_awb->get_pickup_address($this->session->userdata('userId'));
		if ($this->input->post()) {
			$validation = [
				['field' => 'pickup_address', 'label' => 'Pickup Address', 'rules' => 'required'],
				['field' => 'shipment_type', 'label' => 'Shipment type', 'rules' => 'required'],
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
				['field' => 'order_type', 'label' => 'Order type', 'rules' => 'required'],

			];
			if ($this->input->post('seller_info')) {
				$validation[] = ['field' => 'reseller_name', 'label' => 'Resaller Name', 'rules' => 'required'];
			}
			if ($this->input->post('order_type') == 1) {
				$validation[] = ['field' => 'collectable_amount', 'label' => 'Collectable Amount', 'rules' => 'required'];
			}

			$this->form_validation->set_rules($validation);
			if ($this->form_validation->run() == FALSE) {
				$this->data['errors'] = $this->form_validation->error_array();
				$this->Create_single_order("Create_single_order", $this->data);
			} else {
				file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_order.txt', "\n-------------- Start Create Order --------------\n", FILE_APPEND);
				$logistic_id = $this->input->post('logistic_id');
				$logistic_name = $this->Common_model->getSingle_data('api_name, logistic_name', 'logistic_master', array('id' => $logistic_id));
				$logisticTableName = str_replace(' ', '_', strtolower(trim($logistic_name['logistic_name'])));
				if ($logistic_name['api_name'] == "Delhivery_Surface") {
					$logistic = "Delhivery_Surface";
				} else if ($logistic_name['api_name'] == 'Xpressbees_Surface') {
					$logistic = "Xpressbees_Surface";
				} else if ($logistic_name['api_name'] == 'Ekart_Surface') {
					$logistic = 'Ekart_Surface';
				}

				$userId = $this->session->userdata('userId');
				$insert_pro_detail['length'] = $this->input->post('length');
				$insert_pro_detail['width'] = $this->input->post('width');
				$insert_pro_detail['height'] = $this->input->post('height');
				$insert_pro_detail['volumetric_weight'] = $this->input->post('volumetric_weight');
				$insert_pro_detail['physical_weight'] = $this->input->post('physical_width');
				$insert_pro_detail['product_value'] = $this->input->post('product_value');
				$insert_pro_detail['product_name'] = $this->input->post('product_name');
				$insert_pro_detail['product_quantity'] = $this->input->post('product_qty');
				$insert_pro_detail['product_sku'] = $this->input->post('sku');
				$insert_pro_detail['cod_amount'] = $this->input->post('collectable_amount');
				$insert_pro_detail['cod_charge'] = $this->input->post('cod_charge');
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

					$insert_tmp_single_order['deliver_address_id'] = $deliver_address_id;
					// $insert_tmp_single_order['order_no'] = $this->input->post('order_number');
					$insert_tmp_single_order['customer_order_no'] = $this->input->post('order_number');
					if ($this->input->post('order_type') == '1') {
						$insert_tmp_single_order['order_type'] = '1';
					}
					if ($this->input->post('order_type') == '0') {
						$insert_tmp_single_order['order_type'] = '0';
					}
					$insert_tmp_single_order['total_shipping_amount'] = $this->input->post('base_ship');
					$insert_tmp_single_order['zone'] = @$this->input->post('zone');
					$insert_tmp_single_order['awb_number'] = "";
					$insert_tmp_single_order['logistic_id'] = $this->input->post('logistic_id');

					if ($this->input->post('reseller_name') != "") {
						$insert_tmp_single_order['is_seller_info'] = '1';
						$insert_tmp_single_order['packing_slip_warehouse_name'] = $this->input->post('reseller_name');
					}
					$insert_tmp_single_order['sgst_amount'] = $this->input->post('sgst');
					$insert_tmp_single_order['cgst_amount'] = $this->input->post('cgst');
					$insert_tmp_single_order['igst_amount'] = $this->input->post('igst');

					$insert_tmp_single_order['is_return_address_same_as_pickup'] = $this->input->post('is_return_address_same_as_pickup');

					$insert_tmp_single_order['created_date'] = date('Y-m-d H:i:s');
					$insert_tmp_single_order['created_by'] = $userId;
					$insert_order_log['order_request_body'] = $insert_tmp_single_order;
					file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_order.txt', print_r($insert_order_log, true), FILE_APPEND);

					$insert_tmp_order = $this->Common_model->insert($insert_tmp_single_order, 'temp_forward_order_master');

					$total_charge = $this->input->post('total');

					if ($insert_tmp_order) {
						$update_data['order_no'] = 'SSL' . $userId . '-' . $insert_tmp_order . '-' . rand(001, 999) . 'S';
						$updateRsult = $this->Common_model->update($update_data, 'temp_forward_order_master', array('id' => $insert_tmp_order));
						$response['message'] = 'Something Went Wrong';

						if ($logistic_name['api_name'] == "Delhivery_Surface" || $logistic_name['api_name'] == 'Xpressbees_Surface' || $logistic_name['api_name'] == 'Ekart_Surface') {
							$zship_sender_id = "";
							$add_id = $this->input->post('pickup_address');
							$pickup_address_fetch_row_info = $this->Common_model->getSingle_data('*', 'sender_address_master', array('id' => $add_id));
							if ($pickup_address_fetch_row_info['zship_sender_id'] == "") {

								$email = (!empty($this->input->post('customer_email'))) ? $this->input->post('customer_email') :  "sample@gmail.com";
								$pickup_address_fetch_row_info['email'] = $email;
								$zship_sender_id = $this->create_address_in_api($pickup_address_fetch_row_info);
							} else {
								$zship_sender_id = $pickup_address_fetch_row_info['zship_sender_id'];
							}
							if ($zship_sender_id != '') {
								$this->load->helper('zship_new');
								$response = create_order_zship($insert_tmp_order);
								$createOrder_response_log['order_response'] = $response;
								file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
							} else {
								$this->session->set_flashdata('error', 'Address not created in API');
								redirect('create-single-order');
							}
						} else if ($logistic_name['api_name'] == 'Xpressbees_Direct') {
							$repeat = 0;
							$response = xpressbees_direct::xpressbees_order($insert_tmp_order, 0);
							$createOrder_response_log['order_response'] = $response;
							if ($response['status'] == 0 && $response['message'] == 'AWB Already Exists' && $repeat == 0) {
								$response = xpressbees_direct::xpressbees_order($insert_tmp_order, 1);
								$createOrder_response_log['order_response_repeat'] = $response;
								$repeat++;
							}
							file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
						} else if ($logistic_name['api_name'] == 'Xpressbeesair_Direct') {
							$repeat = 0;
							$this->load->helper('xpressbeesair_direct');
							$response = xpressbeesair_direct::xpressbeesair_order($insert_tmp_order, 0);
							$createOrder_response_log['order_response'] = $response;
							if ($response['status'] == 0 && $response['message'] == 'AWB Already Exists' && $repeat == 0) {
								$response = xpressbeesair_direct::xpressbeesair_order($insert_tmp_order, 1);
								$createOrder_response_log['order_response_repeat'] = $response;
								$repeat++;
							}
							file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
						} else if ($logistic_name['api_name'] == 'Ekart_Direct') {
							// $this->load->helper('ecart_direct');
							$response = ekart_direct::ekart_order($insert_tmp_order, 0);
							$createOrder_response_log['order_response'] = $response;
							file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
						} else if ($logistic_name['api_name'] == 'Ecom_Direct') {

							$response = ecom_direct::ecom_order($insert_tmp_order, 0);
							$createOrder_response_log['order_response'] = $response;
							file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
							// dd($response);
						} else if ($logistic_name['api_name'] == 'Udaan_Direct') {
							$this->load->helper('udaan_direct');
							$response = Udaan_Direct::create_order($insert_tmp_order, 0);
							$createOrder_response_log['order_response'] = $response;
							file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
						} else if ($logistic_name['api_name'] == 'Shadowfax_Direct') {
							$this->load->helper('shadowfax_direct');
							$response = shadowfax_direct::create_order($insert_tmp_order, 0);
							$createOrder_response_log['order_response'] = $response;
							file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
						} else if ($logistic_name['api_name'] == 'Delhivery_Direct') {
							$this->load->helper('delhiver_direct');
							$response = delhiver_direct::create_order($insert_tmp_order, 0);
							$createOrder_response_log['order_response'] = $response;
							file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
						} else if ($logistic_name['api_name'] == 'Deliverysexpress_Direct') {
							$this->load->helper('delhiver_direct');
							$response = delhiver_direct::create_order($insert_tmp_order, 0, 1);
							$createOrder_response_log['order_response'] = $response;
							file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
						}
						if ($response['status'] == 0) {
							$this->session->set_flashdata('error', $response['message']);
						} else {
							if ($logistic_name['api_name'] == "Delhivery_Surface" || $logistic_name['api_name'] == 'Xpressbees_Surface' || $logistic_name['api_name'] == 'Ekart_Surface') {
								$this->session->set_flashdata('message', "Your request Has been accepted and Order in process.");
							} else {
								$this->session->set_flashdata('message', "Order Created Successfully.");
							}
						}
						redirect('create-single-order');
					}
				} else {
					$this->session->set_flashdata('error', "Something went wrong");
					redirect('create-single-order');
				}
			}
		} else {
			$this->Create_single_order("Create_single_order", $this->data);
		}
		file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_order.txt', "\n--------- End Create Order -----\n", FILE_APPEND);
	}
	/* Get shipping charge */
	public function shipping_charge()
	{

		$sender_id = $this->session->userdata('userId');
		//$logistic_id = $this->input->post('logistic');
		$shipment_type = $this->input->post('shipment_type');
		$order_type_id = $this->input->post('order_type');
		$volumetric_weight = $this->input->post('volumetric_weight');
		$physical_weight = $this->input->post('physical_width');
		$collectable_amount = $this->input->post('collectable_amount');
		$to_pin = $this->input->post('deliverd_pincode');
		$pickup_id = $this->input->post('pickup_id');
		$logistic_ids = NUll;
		$sender_info = $this->Common_model->getSingle_data('id,sender_id,pincode', 'sender_address_master', array('id' => $pickup_id));

		// $shipment_type = 2;
		$total_shipping_price = get_shiping_price($sender_id, $logistic_ids, $sender_info['pincode'], $to_pin, $shipment_type, $order_type_id, $volumetric_weight, $physical_weight, $collectable_amount, 0, 18);
		//DD($total_shipping_price);

		if ($total_shipping_price['status'] == true) {
			$this->data['shippingprice'] = $total_shipping_price['data'];
			$shipDiv = $this->load->view("admin/order/shipping_table", $this->data, TRUE);
			$array4 = ['message' => $shipDiv, 'error' => ''];
			echo json_encode($array4);
			exit;
		} else {
			$array4 = ['message' => '', 'error' => $total_shipping_price['message']];
			echo json_encode($array4);
			exit;
		}
	}

	/* check wallet balance*/
	public function check_wallet()
	{

		$this->load->model('Order_model');
		$sender_id = $this->session->userdata('userId');
		$check_bulk_order = $this->Order_model->check_bulk_order($sender_id);

		if ($check_bulk_order > 0) {
			$array = ['shipping_amount_array' => "0", 'shippingcharge' => 00, 'message' => "", 'error' => "you have already $check_bulk_order bulk order(s) in pending,Please wait untill it's done..."];
			echo json_encode($array);
			exit;
		}

		$sgst = $this->input->post('sgst');
		$igst = $this->input->post('igst');
		$cgst = $this->input->post('cgst');
		$total = intval($this->input->post('total'));

		if ($igst == '0') {
			$totalshipping = (floatval($sgst) + floatval($cgst) + floatval($total));
		} else {
			$totalshipping = (floatval($igst) + floatval($total));
		}

		$userId = $this->session->userdata('userId');
		$bulk_order = $this->Common_model->getSingle_data('id', 'temp_order_master', array('sender_id' => $userId));

		if ($totalshipping) {
			$checkWallet = API::check_wallet($sender_id, $totalshipping);
			if ($checkWallet == '1') {
				$array = ['shipping_amount_array' => '0', 'shippingcharge' => $totalshipping, 'message' => "success", 'error' => ""];
				echo json_encode($array);
				exit;
			} else {
				$array = ['shipping_amount_array' => "0", 'shippingcharge' => $totalshipping, 'message' => "", 'error' => "You have not sufficient wallet balance,Recharge your wallet"];
				echo json_encode($array);
				exit;
			}
		} else {
			$array5 = ['shipping_amount_array' => "", 'shippingcharge' => $totalshipping, 'message' => "", 'error' => "Something Went Wrong"];
			echo json_encode($array5);
			exit;
		}
	}

	//packing slip
	public function single_packing_slip($order_id)
	{
		$order_id = /*openssl_decrypt(*/ $order_id/*, ENCRYPT_DECRYPT_CTR, ENCRYPT_DECRYPT_KEY, ENCRYPT_DECRYPT_OPTION, ENCRYPT_DECRYPT_IV)*/;
		$order_info = $this->Order_model->get_multiple_order_list_for_slip($order_id);

		foreach ($order_info as $single_order_info) {
			$data['order_info'] = $single_order_info;
			if ($single_order_info['airwaybill_barcode'] != "") {
				$data['order_info']['airwaybill_barcode1'] = 'Upload/order_barcode/' . $single_order_info['airwaybill_barcode'];
			} else {
				$data['order_info']['airwaybill_barcode1'] = $this->createWaybillBarcodeImage($single_order_info['order_id'], $single_order_info['airwaybill_number']);
			}
		}
		$html = $this->load->view('admin/order/single_packing_slip', $data, true);
		$this->pdf->createPDF($html, 'mypdf', false, 'A4', 'portrait');
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

		// dd($token_detail);


		$curl_response = CUSTOM::curl_request('application/x-www-form-urlencoded', $token_detail['token'], $this->config->item('ZSHIP_API_SAVE_SENDER_URL'), $request_body, "POST");
		// dd($curl_response);

		$response['curl_response'] = $curl_response;
		if (@$curl_response['error_response'] != "") {

			$response['error_response'] = $curl_response['error_response'];
		} else {
			if ($curl_response['success_response'] != "") {
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
			} else {
				$response['error_response'] = "Address not created in API";
			}
		}

		file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_zship_pickup_address.txt', "\n--------- Start Create Order -----\n" . $response . "\n--------- End Create Order -----\n", FILE_APPEND);

		return $response;
	}

	//rate calulator mehthod
	/* Get shipping charge */
	public function shipping_charge_rate()
	{

		$sender_id = $this->session->userdata('userId');
		//$logistic_id = $this->input->post('logistic');
		$shipment_type = $this->input->post('shipment_type');
		$order_type_id = $this->input->post('order_type');
		$volumetric_weight = $this->input->post('volumetric_weight');
		$physical_weight = $this->input->post('physical_width');
		$collectable_amount = $this->input->post('collectable_amount');
		$to_pin = $this->input->post('deliverd_pincode');
		$sender_info['pincode'] = $this->input->post('pickup_id');
		$logistic_ids = NUll;

		// $shipment_type = 2;
		$total_shipping_price = get_shiping_price($sender_id, $logistic_ids, $sender_info['pincode'], $to_pin, $shipment_type, $order_type_id, $volumetric_weight, $physical_weight, $collectable_amount, 0, 18);
		//DD($total_shipping_price);

		if ($total_shipping_price['status'] == true) {
			$this->data['shippingprice'] = $total_shipping_price['data'];
			$shipDiv = $this->load->view("admin/order/shipping_table", $this->data, TRUE);
			$array4 = ['message' => $shipDiv, 'error' => ''];
			echo json_encode($array4);
			exit;
		} else {
			$array4 = ['message' => '', 'error' => $total_shipping_price['message']];
			echo json_encode($array4);
			exit;
		}
	}
}
