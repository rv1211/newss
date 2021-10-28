<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Custom_webhook_or_api extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->helper('get_shiping_price_helper');
		$this->load->model('common_model');
		$this->load->model('Create_singleorder_awb');
	}

	public function custom_api_add_pickup_address()
	{
		file_put_contents(APPPATH . 'logs/custom_api_log/' . date("d-m-Y") . '_create_pickup_address.txt', "\n-------------- Start Create Pickup Address --------------\n", FILE_APPEND);
		$post = @file_get_contents("php://input");
		$log_data1['post_data'] = $post;
		file_put_contents(APPPATH . 'logs/custom_api_log/' . date("d-m-Y") . '_create_pickup_address.txt', print_r($log_data1, true), FILE_APPEND);
		if (isset($post) && $post != '') {
			$log_data['post_data'] = $post;
			$post = json_decode($post, true);
			$log_data['post_data_json_decode'] = $post;
			if ($post['UID'] != "") {
				if ($post['UKEY'] != "") {
					$sender_info_data = $this->Common_model->getSingleRowArray(array("api_is_web_access" => '1', "api_user_id" => $post['UID'], "api_key" => $post['UKEY']), "id", "sender_master");
					if ($sender_info_data) {
						if (base64_decode($post['warehouse_name']) != "") {
							$pickup_result_data = $this->Common_model->getRowArray(array("warehouse_name" => base64_decode($post['warehouse_name'])), 'id', 'sender_address_master');
							if (empty($pickup_result_data)) {
								$pickup_address_create = $this->pickup_address_insert_in_database($sender_info_data, $post);
								if (@$pickup_address_create['success'] != "") {
									$arr[] = array('success' => 1, 'message' => @$pickup_address_create['success'], 'pickup_id' => base64_encode(@$pickup_address_create['pickup_id']));
								} else {
									$arr[] = array('success' => 0, 'message' => @$pickup_address_create['error']);
								}
							} else {
								$arr[] = array('success' => 0, 'message' => "Warehouse Name Already Exists");
							}
						} else {
							$arr[] = array('success' => 0, 'message' => "Warehouse Name Not Provided");
						}
					} else {
						$arr[] = array('success' => 0, 'message' => "UKEY Not Provided.");
					}
				} else {
					$arr[] = array('success' => 0, 'message' => "UID Not Provided.");
				}
			} else {
				$arr[] = array('success' => 0, 'message' => "Invalid Credintial OR WebAccess not Allowed");
			}
		} else {
			$arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
		}
		file_put_contents(APPPATH . 'logs/custom_api_log/' . date("d-m-Y") . '_create_pickup_address.txt', print_r($log_data, true), FILE_APPEND);
		file_put_contents(APPPATH . 'logs/custom_api_log/' . date("d-m-Y") . '_create_pickup_address.txt', "\n-------------- Start Create Pickup Address --------------\n", FILE_APPEND);
		header('Content-type: application/json');
		echo json_encode($arr);
	}

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

	function pickup_address_insert_in_database($sender_info_data, $post)
	{
		$pickupaddressdata = array(
			"sender_id" => $sender_info_data['id'],
			"warehouse_name" => CUSTOM::remove_special_characters_and_extra_space(base64_decode($post['warehouse_name'])),
			"contact_person_name" => CUSTOM::remove_special_characters_and_extra_space(base64_decode($post['contact_info']['contact_person'])),
			"contact_email" => CUSTOM::remove_special_characters_and_extra_space(base64_decode($post['contact_info']['email'])),
			"website" => CUSTOM::remove_special_characters_and_extra_space(base64_decode($post['contact_info']['website'])),
			"contact_no" => CUSTOM::remove_special_characters_and_extra_space(base64_decode($post['contact_info']['contact_no'])),
			"address_line_1" => CUSTOM::remove_special_characters_and_extra_space(base64_decode($post['address_info']['address_1'])),
			"address_line_2" => CUSTOM::remove_special_characters_and_extra_space(base64_decode($post['address_info']['address_2'])),
			"city" => CUSTOM::remove_special_characters_and_extra_space(base64_decode($post['address_info']['city'])),
			"state" => CUSTOM::remove_special_characters_and_extra_space(base64_decode($post['address_info']['state'])),
			"pincode" => CUSTOM::remove_special_characters_and_extra_space(base64_decode($post['address_info']['pincode'])),
		);
		$result = $this->Common_model->insert($pickupaddressdata, "sender_address_master");
		if ($result) {
			$pickup_address_id = $this->db->insert_id();
			$data['custom_api_sender_pickup_address_id'] = md5($pickup_address_id . "" . $sender_info_data['id'] . "pickup_address_id");
			$result1 = $this->Common_model->update($data, 'sender_address_master', array('id' => $pickup_address_id));
			if ($result1) {
				$res['success'] = 'Pickup Address add Successfully.';
				$res['pickup_id'] = $pickup_address_id;
			} else {
				$this->Common_model->delete('sender_address_master', ['id' => $pickup_address_id,]);
				$res['error'] = "Something wents to wrong";
			}
		} else {
			$res['error'] = "Invalid data";
		}
		file_put_contents(APPPATH . 'logs/custom_api_log/' . date("d-m-Y") . '_create_pickup_address.txt', "\n-------------------------------------------------\n" . print_r($res, true), FILE_APPEND);
		return $res;
	}

	public function custom_api_create_order()
	{
		file_put_contents(APPPATH . 'logs/custom_api_log/' . date("d-m-Y") . '_create_order.txt', "\n-------------- Start Create Order --------------\n", FILE_APPEND);
		$post = @file_get_contents("php://input");
		$log_data1['post_data'] = $post;
		file_put_contents(APPPATH . 'logs/custom_api_log/' . date("d-m-Y") . '_create_order.txt', print_r($log_data1, true), FILE_APPEND);
		if (isset($post) && $post != '') {
			$log_data['post_data'] = $post;
			$post = json_decode($post, true);
			$log_data['post_data_json_decode'] = $post;
			if ($post['UID'] != "") {
				if ($post['UKEY'] != "") {
					$sender_info_data = $this->Common_model->getSingleRowArray(array("api_is_web_access" => '1', "api_user_id" => $post['UID'], "api_key" => $post['UKEY']), "id,api_pickup_address_id", "sender_master");

					// dd($post);

					if ($sender_info_data) {
						if ($post['order_info']['pickup_warehouse_name'] != "") {
							$sender_address_info_data = $this->Common_model->getSingleRowArray(array("warehouse_name" => base64_decode($post['order_info']['pickup_warehouse_name'])), "pincode", "sender_address_master");
							// lq();
							// dd($sender_address_info_data);

							$log_data['sender_address_info'] = $sender_address_info_data;

							$order_type1 = base64_decode($post['order_info']['order_type']);
							switch (strtolower(trim($order_type1))) {
								case 'cod':
									$order_type = 1;
									$cod_amount = base64_decode($post['order_info']['cod_amount']);
									break;
								case 'prepaid':
									$order_type = $cod_amount = 0;
									break;

								default:
									$order_type = $cod_amount = "";
									break;
							}

							$receiver_address_data = array(
								'sender_id' => $sender_info_data['id'],
								'name' => base64_decode($post['customer_info']['name']),
								'email' => base64_decode($post['customer_info']['email']),
								'mobile_no' => str_replace(" ", "", base64_decode($post['customer_info']['mobile_no'])),
								'address_1' => base64_decode($post['customer_info']['address_1']),
								'address_2' => base64_decode($post['customer_info']['address_2']),
								'city' => base64_decode($post['customer_info']['city']),
								'state' => base64_decode($post['customer_info']['state']),
								'pincode' => base64_decode($post['customer_info']['pincode']),
							);

							// dd($receiver_address_data);

							$log_data['receiver_address_data'] = $receiver_address_data;
							$receiver_address_id = $this->Common_model->insert($receiver_address_data, 'receiver_address');

							$order_product_detail_data = array(
								'physical_weight' => base64_decode($post['product_info']['physical_weight']),
								'height' => base64_decode($post['shipment_info']['height']),
								'width' => base64_decode($post['shipment_info']['width']),
								'length' => base64_decode($post['shipment_info']['length']),
								'volumetric_weight' => ((base64_decode($post['shipment_info']['height']) + base64_decode($post['shipment_info']['width']) + base64_decode($post['shipment_info']['length'])) / 4500),
								'product_name' => base64_decode($post['product_info']['product_name']),
								'product_quantity' => base64_decode($post['product_info']['product_quantity']),
								'product_value' => base64_decode($post['product_info']['product_value']),
								'cod_amount' => $cod_amount,
							);

							// dd($order_product_detail_data);

							$log_data['order_product_detail_data'] = $order_product_detail_data;
							$order_product_detail_id = $this->Common_model->insert($order_product_detail_data, 'order_product_detail');

							$sender_pickup_address_info_data = $this->Common_model->getSingleRowArray(array("id" => base64_decode($post['pickup_id'])), "id", "sender_address_master");
							// lq();
							// dd($sender_pickup_address_info_data);
							$tmp_single_order_data = array(
								'customer_order_no' => base64_decode($post['order_info']['order_number']),
								'sender_id' => $sender_info_data['id'],
								'pickup_address_id' => $sender_pickup_address_info_data['id'],
								'order_product_detail_id' => $order_product_detail_id,
								'deliver_address_id' => $receiver_address_id,
								'order_type' => $order_type,
							);



							$shipping_order_data = get_shiping_price($sender_info_data['id'], null, $sender_address_info_data['pincode'], base64_decode($post['customer_info']['pincode']), '0', $order_type, $order_product_detail_data['volumetric_weight'], $order_product_detail_data['physical_weight'], ($order_product_detail_data['product_quantity'] * $order_product_detail_data['product_value']), 1);

							if ($shipping_order_data['status'] == 1) {
								$tmp_single_order_data['logistic_id'] = $shipping_order_data['data'][0]['logistic_id'];
								$tmp_single_order_data['total_shipping_amount'] = $shipping_order_data['data'][0]['total'];
								//$tmp_single_order_data['is_web'] = '1';
								$update_order_product_detail_data['cod_charge'] = $shipping_order_data['data'][0]['cod_ammount'];
								$insert_tmp_order = $this->Common_model->insert($tmp_single_order_data, 'temp_forward_order_master');

								$log_data['shipping_order_data'] = $shipping_order_data;
								$log_data['temp_singe_order_data'] = $tmp_single_order_data;

								if ($insert_tmp_order) {
									$update_data['order_no'] = 'SSL' . $sender_info_data['id'] . '-' . $insert_tmp_order . 'S';

									$this->Common_model->update($update_data, 'temp_forward_order_master', array('id' => $insert_tmp_order));
									$log_data['update_order_no'] = $this->db->last_query();
									$this->Common_model->update($update_order_product_detail_data, 'order_product_detail', array('id' => $order_product_detail_id));

									$log_data['update_order_detail'] = $this->db->last_query();

									$logistic_name = $this->Common_model->getSingle_data('*', 'logistic_master', array('id' => $tmp_single_order_data['logistic_id']));

									$log_data['logistic_data'] = $logistic_name;

									if ($logistic_name['api_name'] == "Delhivery_Surface" || $logistic_name['api_name'] == 'Xpressbees_Surface' || $logistic_name['api_name'] == 'Ekart_Surface') {
										$zship_sender_id = "";

										$pickup_address_fetch_row_info = $this->Common_model->getSingle_data('*', 'sender_address_master', array('id' => $sender_info_data['api_pickup_address_id']));
										$log_data['zship_pickup_address'] = $pickup_address_fetch_row_info;

										if ($pickup_address_fetch_row_info['zship_sender_id'] == "") {
											$email = (!empty($this->input->post('customer_email'))) ? $this->input->post('customer_email') : "sample@gmail.com";
											$pickup_address_fetch_row_info['email'] = $email;
											$zship_sender_id = $this->create_address_in_api($pickup_address_fetch_row_info);
										} else {
											$zship_sender_id = $pickup_address_fetch_row_info['zship_sender_id'];
										}
										if ($zship_sender_id != '') {
											$this->load->helper('zship_new');
											$response = create_order_zship($insert_tmp_order);
											sleep(2);
											$data = $this->db->select('awb_number')->from('forward_order_master')->where('order_no', $response['order_id'])->get()->row_array();
											$response['AWBNo']  =  $data['awb_number'];
										} else {
											$arr[] = array('success' => 1, 'message' => "Address not created in API ");
										}
									} else if ($logistic_name['api_name'] == 'Xpressbees_Direct') {
										$repeat = 0;
										$response = xpressbees_direct::xpressbees_order($insert_tmp_order, 0);
										if ($response['status'] == 0 && $response['message'] == 'AWB Already Exists' && $repeat == 0) {
											$response = xpressbees_direct::xpressbees_order($insert_tmp_order, 1);
											$createOrder_response_log['order_response_repeat'] = $response;
											$repeat++;
										}
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
									} else if ($logistic_name['api_name'] == 'Ekart_Direct') {
										$response = ekart_direct::ekart_order($insert_tmp_order, 0);
									} else if ($logistic_name['api_name'] == 'Ecom_Direct') {
										$response = ecom_direct::ecom_order($insert_tmp_order, 0);
									} else if ($logistic_name['api_name'] == 'Udaan_Direct') {
										$this->load->helper('udaan_direct');
										$response = Udaan_Direct::create_order($insert_tmp_order, 0);
									} else if ($logistic_name['api_name'] == 'Shadowfax_Direct') {
										$this->load->helper('shadowfax_direct');
										$response = shadowfax_direct::create_order($insert_tmp_order, 0);
									} else if ($logistic_name['api_name'] == 'Delhivery_Direct') {
										$this->load->helper('delhiver_direct');
										$response = delhiver_direct::create_order($insert_tmp_order, 0);
										$createOrder_response_log['order_response'] = $response;
									} else if ($logistic_name['api_name'] == 'Deliverysexpress_Direct') {
										$this->load->helper('delhiver_direct');
										$response = delhiver_direct::create_order($insert_tmp_order, 0, 1);
										$createOrder_response_log['order_response'] = $response;
									}

									$createOrder_response_log['order_response'] = $response;
									file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
									if ($response['status'] == 0) {
										$arr[] = $response;
									} else {
										if ($logistic_name['api_name'] == "Delhivery_Surface" || $logistic_name['api_name'] == 'Xpressbees_Surface' || $logistic_name['api_name'] == 'Ekart_Surface') {
											$arr[] = array('success' => 1, 'AWBNo' => base64_encode($response['AWBNo']), 'message' => "Your request has been accepted and order is in process");
										} else {
											$arr[] = array('success' => 1, 'AWBNo' => base64_encode($response['AWBNo']), 'message' => "Order Create successfully");
										}
									}
								} else {
									$this->move_order($tmp_single_order_data, "Error From Data Insertation");
									$log_data['move_order_query'] = $this->db->last_query();
									$arr[] = array('success' => 0, 'message' => "Error From Data Insertation");
								}
							} else {
								$this->move_order($tmp_single_order_data, $shipping_order_data['message']);
								$log_data['move_order_query'] = $this->db->last_query();
								$arr[] = array('success' => 0, 'message' => $shipping_order_data['message']);
							}
						} else {
							$arr[] = array('success' => 0, 'message' => "pickup_id Not Provided.");
						}
					} else {
						$arr[] = array('success' => 0, 'message' => "Invalid Credintial OR WebAccess not Allowed.");
					}
				} else {
					$arr[] = array('success' => 0, 'message' => "UKEY Not Provided.");
				}
			} else {
				$arr[] = array('success' => 0, 'message' => "UID Not Provided.");
			}
		} else {
			$arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
		}

		$log_data['result'] = $arr;

		file_put_contents(APPPATH . 'logs/custom_api_log/' . date("d-m-Y") . '_create_order.txt', print_r($log_data, true), FILE_APPEND);
		// header('Content-type: application/json');
		// echo json_encode($arr);
		dd($arr);
	}

	public function custom_pre_airwaybill_create_order_api()
	{
		file_put_contents(APPPATH . 'logs/custom_api_log/' . date("d-m-Y") . '_create_pre_airwaybill_order.txt', "\n-------------- Start Create Order --------------\n", FILE_APPEND);
		$post = @file_get_contents("php://input");
		$log_data1['post_data'] = $post;
		file_put_contents(APPPATH . 'logs/custom_api_log/' . date("d-m-Y") . '_create_pre_airwaybill_order.txt', print_r($log_data1, true), FILE_APPEND);
		if (isset($post) && $post != '') {
			$log_data['post_data'] = $post;
			$post = json_decode($post, true);
			$log_data['post_data_json_decode'] = $post;
			if ($post['UID'] != "") {
				if ($post['UKEY'] != "") {
					$sender_info_data = $this->Common_model->getSingleRowArray(array("api_is_web_access" => '1', "api_user_id" => $_GET['UID'], "api_key" => $_GET['UKEY']), "id", "sender_master");
					if ($sender_info_data) {
						if ($post['pickup_id'] != "") {
							if ($post['airwaybill_number'] != "") {
								$get_logistic_info = $this->Create_singleorder_awb->check_awb($post['airwaybill_number'], $ordertype, $sender_info_data['id']);
								$log_data['get_logistic_info'] = $get_logistic_info;
								if (!empty($get_logistic_info)) {
									$sender_address_info_data = $this->Common_model->getSingleRowArray(array("id" => $sender_info_data['api_pickup_address_id']), "pincode", "sender_address_master");

									$log_data['sender_address_info'] = $sender_address_info_data;

									$order_type1 = base64_decode($post['order_info']['order_type']);
									switch (strtolower(trim($order_type1))) {
										case 'cod':
											$order_type = 1;
											$cod_amount = base64_decode($post['order_info']['cod_amount']);
											break;
										case 'prepaid':
											$order_type = $cod_amount = 0;
											break;

										default:
											$order_type = $cod_amount = "";
											break;
									}

									$receiver_address_data = array(
										'sender_id' => $sender_info_data['id'],
										'name' => base64_decode($post['customer_info']['name']),
										'email' => base64_decode($post['customer_info']['email']),
										'mobile_no' => str_replace(" ", "", base64_decode($post['customer_info']['mobile_no'])),
										'address_1' => base64_decode($post['customer_info']['address_1']),
										'address_2' => base64_decode($post['customer_info']['address_2']),
										'city' => base64_decode($post['customer_info']['city']),
										'state' => base64_decode($post['customer_info']['state']),
										'pincode' => base64_decode($post['customer_info']['pincode']),
									);
									$log_data['receiver_address_data'] = $receiver_address_data;
									$receiver_address_id = $this->Common_model->insert($receiver_address_data, 'receiver_address');
									$order_product_detail_data = array(
										'physical_weight' => base64_decode($post['product_info']['physical_weight']),
										'height' => base64_decode($post['shipment_info']['height']),
										'width' => base64_decode($post['shipment_info']['width']),
										'length' => base64_decode($post['shipment_info']['length']),
										'volumetric_weight' => ((base64_decode($post['shipment_info']['height']) + base64_decode($post['shipment_info']['width']) + base64_decode($post['shipment_info']['length'])) / 4500),
										'product_name' => base64_decode($post['product_info']['product_name']),
										'product_quantity' => base64_decode($post['product_info']['product_quantity']),
										'product_value' => base64_decode($post['product_info']['product_value']),
										'cod_amount' => $cod_amount,
									);
									$log_data['order_product_detail_data'] = $order_product_detail_data;
									$order_product_detail_id = $this->Common_model->insert($order_product_detail_data, 'order_product_detail');
									$sender_pickup_address_info_data = $this->Common_model->getSingleRowArray(array("custom_api_sender_pickup_address_id" => $post['pickup_id']), "id", "sender_address_master");
									$tmp_single_order_data = array(
										'customer_order_no' => base64_decode($post['order_info']['order_number']),
										'sender_id' => $sender_info_data['id'],
										'pickup_address_id' => $sender_pickup_address_info_data['id'],
										'order_product_detail_id' => $order_product_detail_id,
										'deliver_address_id' => $receiver_address_id,
										'order_type' => $order_type,
									);
									$shipping_order_data = get_shiping_price($sender_info_data['id'], $get_logistic_info['id'], $sender_address_info_data['pincode'], base64_decode($post['customer_info']['pincode']), '0', $order_type, $order_product_detail_data['volumetric_weight'], $order_product_detail_data['physical_weight'], ($order_product_detail_data['product_quantity'] * $order_product_detail_data['product_value']), 1, 18);

									if ($shipping_order_data['status'] == 1) {
										$tmp_single_order_data['logistic_id'] = $shipping_order_data['data'][0]['logistic_id'];
										$tmp_single_order_data['total_shipping_amount'] = $shipping_order_data['data'][0]['total'];
										//$tmp_single_order_data['is_web'] = '1';
										$update_order_product_detail_data['cod_charge'] = $shipping_order_data['data'][0]['cod_ammount'];
										$insert_tmp_order = $this->Common_model->insert($tmp_single_order_data, 'temp_forward_order_master');

										$log_data['shipping_order_data'] = $shipping_order_data;
										$log_data['temp_singe_order_data'] = $tmp_single_order_data;

										if ($insert_tmp_order) {
											$update_data['order_no'] = 'PDL' . $sender_info_data['id'] . '-' . $insert_tmp_order . 'S';

											$this->Common_model->update($update_data, 'temp_forward_order_master', array('id' => $insert_tmp_order));
											$log_data['update_order_no'] = $this->db->last_query();
											$this->Common_model->update($update_order_product_detail_data, 'order_product_detail', array('id' => $order_product_detail_id));

											$log_data['update_order_detail'] = $this->db->last_query();

											$logistic_name = $this->Common_model->getSingle_data('*', 'logistic_master', array('id' => $tmp_single_order_data['logistic_id']));

											$log_data['logistic_data'] = $logistic_name;

											if ($logistic_name['api_name'] == "Delhivery_Surface" || $logistic_name['api_name'] == 'Xpressbees_Surface' || $logistic_name['api_name'] == 'Ekart_Surface') {
												$zship_sender_id = "";

												$pickup_address_fetch_row_info = $this->Common_model->getSingle_data('*', 'sender_address_master', array('id' => $sender_info_data['api_pickup_address_id']));

												$log_data['zship_pickup_address'] = $pickup_address_fetch_row_info;

												if ($pickup_address_fetch_row_info['zship_sender_id'] == "") {
													$email = (!empty($this->input->post('customer_email'))) ? $this->input->post('customer_email') : "sample@gmail.com";
													$pickup_address_fetch_row_info['email'] = $email;
													$zship_sender_id = $this->create_address_in_api($pickup_address_fetch_row_info);
												} else {
													$zship_sender_id = $pickup_address_fetch_row_info['zship_sender_id'];
												}
												if ($zship_sender_id != '') {
													$this->load->helper('zship_new');
													$response = create_order_zship($insert_tmp_order);
												} else {
													$arr[] = array('success' => 1, 'message' => "Address not created in API ");
												}
											} else if ($logistic_name['api_name'] == 'Xpressbees_Direct') {
												$repeat = 0;
												$response = xpressbees_direct::xpressbees_order($insert_tmp_order, 0);
												if ($response['status'] == 0 && $response['message'] == 'AWB Already Exists' && $repeat == 0) {
													$response = xpressbees_direct::xpressbees_order($insert_tmp_order, 1);
													$createOrder_response_log['order_response_repeat'] = $response;
													$repeat++;
												}
											} else if ($logistic_name['api_name'] == 'Ekart_Direct') {
												$response = ekart_direct::ekart_order($insert_tmp_order, 0);
											} else if ($logistic_name['api_name'] == 'Ecom_Direct') {
												$response = ecom_direct::ecom_order($insert_tmp_order, 0);
											} else if ($logistic_name['api_name'] == 'Udaan_Direct') {
												$this->load->helper('udaan_direct');
												$response = Udaan_Direct::create_order($insert_tmp_order, 0);
											}
											$createOrder_response_log['order_response'] = $response;
											file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_pre_airwaybill_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
											if ($response['status'] == 0) {
												$arr[] = $response;
											} else {
												if ($logistic_name['api_name'] == "Delhivery_Surface" || $logistic_name['api_name'] == 'Xpressbees_Surface' || $logistic_name['api_name'] == 'Ekart_Surface') {
													$arr[] = array('success' => 1, 'AWBNo' => base64_encode($response['AWBNo']), 'message' => "Your request has been accepted and order is in process");
												} else {
													$arr[] = array('success' => 1, 'AWBNo' => base64_encode($response['AWBNo']), 'message' => "Order Create successfully");
												}
											}
										} else {
											$this->move_order($tmp_single_order_data, "Error From Data Insertation");
											$log_data['move_order_query'] = $this->db->last_query();
											$arr[] = array('success' => 0, 'message' => "Error From Data Insertation");
										}
									} else {
										$this->move_order($tmp_single_order_data, $shipping_order_data['message']);
										$log_data['move_order_query'] = $this->db->last_query();
										// $tmp_single_order_id = $this->Common_model->insert($tmp_single_order_data, 'error_order_master');
										$arr[] = array('success' => 0, 'message' => $shipping_order_data['message']);
									}
								} else {
									$arr[] = array('success' => 0, 'message' => "Invalid airwaybill_number.");
								}
							} else {
								$arr[] = array('success' => 0, 'message' => "airwaybill_number Not Provided.");
							}
						} else {
							$arr[] = array('success' => 0, 'message' => "pickup_id Not Provided.");
						}
					} else {
						$arr[] = array('success' => 0, 'message' => "Invalid Credintial OR WebAccess not Allowed.");
					}
				} else {
					$arr[] = array('success' => 0, 'message' => "UKEY Not Provided.");
				}
			} else {
				$arr[] = array('success' => 0, 'message' => "UID Not Provided.");
			}
		} else {
			$arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
		}

		$log_data['result'] = $arr;

		file_put_contents(APPPATH . 'logs/custom_api_log/' . date("d-m-Y") . '_create_pre_airwaybill_order.txt', print_r($log_data, true), FILE_APPEND);
		// header('Content-type: application/json');
		// echo json_encode($arr);
		dd($arr);
	}

	public function shopify_webhook_data/*_old*/()
	{
		file_put_contents(APPPATH . 'logs/shopify_webhook_log/' . date("d-m-Y") . '_create_order.txt', "\n-------------- Start Create Order --------------\n", FILE_APPEND);

		$post = @file_get_contents("php://input");
		// $post =  '{"id":2788258119829,"email":"","closed_at":null,"created_at":"2020-10-01T11:19:04+05:30","updated_at":"2020-10-01T15:18:30+05:30","number":1283,"note":null,"token":"c6d3d370cefea6229d165ad5957e96da","gateway":"Cash on Delivery (COD)","test":false,"total_price":"1299.00","subtotal_price":"1299.00","total_weight":0,"total_tax":"0.00","taxes_included":false,"currency":"INR","financial_status":"voided","confirmed":true,"total_discounts":"0.00","total_line_items_price":"1299.00","cart_token":"","buyer_accepts_marketing":false,"name":"#2283","referring_site":"https:\/\/thebigbazzar.com\/collections\/frontpage\/products\/copy-of-new-nubia-alpha-watch-mobile-phone","landing_site":"\/wallets\/checkouts.json","cancelled_at":"2020-10-01T15:18:30+05:30","cancel_reason":"customer","total_price_usd":"17.59","checkout_token":"1817bcc23098c6245bfe05685c4ebaa7","reference":null,"user_id":null,"location_id":null,"source_identifier":null,"source_url":null,"processed_at":"2020-10-01T11:19:03+05:30","device_id":null,"phone":"+919500822338","customer_locale":"en","app_id":580111,"browser_ip":"157.46.82.239","landing_site_ref":null,"order_number":2283,"discount_applications":[],"discount_codes":[],"note_attributes":[],"payment_gateway_names":["Cash on Delivery (COD)"],"processing_method":"manual","checkout_id":14954287988885,"source_name":"web","fulfillment_status":null,"tax_lines":[],"tags":"","contact_email":null,"order_status_url":"https:\/\/thebigbazzar.com\/47044329621\/orders\/c6d3d370cefea6229d165ad5957e96da\/authenticate?key=2b21644fed4d16438e56e06b58d99ff7","presentment_currency":"INR","total_line_items_price_set":{"shop_money":{"amount":"1299.00","currency_code":"INR"},"presentment_money":{"amount":"1299.00","currency_code":"INR"}},"total_discounts_set":{"shop_money":{"amount":"0.00","currency_code":"INR"},"presentment_money":{"amount":"0.00","currency_code":"INR"}},"total_shipping_price_set":{"shop_money":{"amount":"0.00","currency_code":"INR"},"presentment_money":{"amount":"0.00","currency_code":"INR"}},"subtotal_price_set":{"shop_money":{"amount":"1299.00","currency_code":"INR"},"presentment_money":{"amount":"1299.00","currency_code":"INR"}},"total_price_set":{"shop_money":{"amount":"1299.00","currency_code":"INR"},"presentment_money":{"amount":"1299.00","currency_code":"INR"}},"total_tax_set":{"shop_money":{"amount":"0.00","currency_code":"INR"},"presentment_money":{"amount":"0.00","currency_code":"INR"}},"line_items":[{"id":6079921258645,"variant_id":36541695492245,"title":"U78 PLUS Smart Watch","quantity":1,"sku":"","variant_title":"","vendor":"The Big Bazzar","fulfillment_service":"manual","product_id":5804813648021,"requires_shipping":true,"taxable":false,"gift_card":false,"name":"U78 PLUS Smart Watch","variant_inventory_management":null,"properties":[],"product_exists":true,"fulfillable_quantity":0,"grams":0,"price":"1299.00","total_discount":"0.00","fulfillment_status":null,"price_set":{"shop_money":{"amount":"1299.00","currency_code":"INR"},"presentment_money":{"amount":"1299.00","currency_code":"INR"}},"total_discount_set":{"shop_money":{"amount":"0.00","currency_code":"INR"},"presentment_money":{"amount":"0.00","currency_code":"INR"}},"discount_allocations":[],"duties":[],"admin_graphql_api_id":"gid:\/\/shopify\/LineItem\/6079921258645","tax_lines":[],"origin_location":{"id":2334154064021,"country_code":"IN","province_code":"GJ","name":"The Big Bazar","address1":"yogi chock","address2":"","city":"surat","zip":"395006"}}],"fulfillments":[],"refunds":[{"id":682450026645,"order_id":2788258119829,"created_at":"2020-10-01T15:18:30+05:30","note":null,"user_id":62406983829,"processed_at":"2020-10-01T15:18:30+05:30","restock":true,"duties":[],"admin_graphql_api_id":"gid:\/\/shopify\/Refund\/682450026645","refund_line_items":[{"id":193428324501,"quantity":1,"line_item_id":6079921258645,"location_id":53725298837,"restock_type":"cancel","subtotal":1299.0,"total_tax":0.0,"subtotal_set":{"shop_money":{"amount":"1299.00","currency_code":"INR"},"presentment_money":{"amount":"1299.00","currency_code":"INR"}},"total_tax_set":{"shop_money":{"amount":"0.00","currency_code":"INR"},"presentment_money":{"amount":"0.00","currency_code":"INR"}},"line_item":{"id":6079921258645,"variant_id":36541695492245,"title":"U78 PLUS Smart Watch","quantity":1,"sku":"","variant_title":"","vendor":"The Big Bazzar","fulfillment_service":"manual","product_id":5804813648021,"requires_shipping":true,"taxable":false,"gift_card":false,"name":"U78 PLUS Smart Watch","variant_inventory_management":null,"properties":[],"product_exists":true,"fulfillable_quantity":0,"grams":0,"price":"1299.00","total_discount":"0.00","fulfillment_status":null,"price_set":{"shop_money":{"amount":"1299.00","currency_code":"INR"},"presentment_money":{"amount":"1299.00","currency_code":"INR"}},"total_discount_set":{"shop_money":{"amount":"0.00","currency_code":"INR"},"presentment_money":{"amount":"0.00","currency_code":"INR"}},"discount_allocations":[],"duties":[],"admin_graphql_api_id":"gid:\/\/shopify\/LineItem\/6079921258645","tax_lines":[],"origin_location":{"id":2334154064021,"country_code":"IN","province_code":"GJ","name":"The Big Bazar","address1":"yogi chock","address2":"","city":"surat","zip":"395006"}}}],"transactions":[{"id":3445821833365,"order_id":2788258119829,"kind":"void","gateway":"Cash on Delivery (COD)","status":"success","message":"Marked the Cash on Delivery (COD) payment as voided","created_at":"2020-10-01T15:18:29+05:30","test":false,"authorization":null,"location_id":null,"user_id":null,"parent_id":3445420032149,"processed_at":"2020-10-01T15:18:29+05:30","device_id":null,"receipt":{},"error_code":null,"source_name":"web","amount":"0.00","currency":"INR","admin_graphql_api_id":"gid:\/\/shopify\/OrderTransaction\/3445821833365"}],"order_adjustments":[]}],"total_tip_received":"0.0","original_total_duties_set":null,"current_total_duties_set":null,"admin_graphql_api_id":"gid:\/\/shopify\/Order\/2788258119829","shipping_lines":[{"id":2283267719317,"title":"Standard","price":"0.00","code":"Standard","source":"shopify","phone":null,"requested_fulfillment_service_id":null,"delivery_category":null,"carrier_identifier":null,"discounted_price":"0.00","price_set":{"shop_money":{"amount":"0.00","currency_code":"INR"},"presentment_money":{"amount":"0.00","currency_code":"INR"}},"discounted_price_set":{"shop_money":{"amount":"0.00","currency_code":"INR"},"presentment_money":{"amount":"0.00","currency_code":"INR"}},"discount_allocations":[],"tax_lines":[]}],"billing_address":{"first_name":"Imran ","address1":"Saradi mansion ","phone":"+91 95 0082 2338","city":"Tamilnadu vellore","zip":"632012","province":"Tamil Nadu","country":"India","last_name":"Imran","address2":"Shop","company":null,"latitude":12.9319571,"longitude":79.1407421,"name":"Imran  Imran","country_code":"IN","province_code":"TN"},"shipping_address":{"first_name":"Imran ","address1":"Saradi mansion ","phone":" 95 0082 2338","city":"Tamilnadu vellore","zip":"632012","province":"Tamil Nadu","country":"India","last_name":"Imran","address2":"Shop","company":"","latitude":12.9319571,"longitude":79.1407421,"name":"Imran  Imran","country_code":"IN","province_code":"TN"},"client_details":{"browser_ip":"157.46.82.239","accept_language":"en-GB,en-US;q=0.9,en;q=0.8","user_agent":"Mozilla\/5.0 (Linux; Android 9; SM-A750F Build\/PPR1.180610.011; wv) AppleWebKit\/537.36 (KHTML, like Gecko) Version\/4.0 Chrome\/85.0.4183.101 Mobile Safari\/537.36 [FB_IAB\/FB4A;FBAV\/289.0.0.40.121;]","session_hash":null,"browser_width":412,"browser_height":726},"customer":{"id":4078820917397,"email":null,"accepts_marketing":false,"created_at":"2020-09-30T23:26:16+05:30","updated_at":"2020-10-01T11:19:04+05:30","first_name":"Imran ","last_name":"Imran","orders_count":2,"state":"disabled","total_spent":"2598.00","last_order_id":2788258119829,"note":null,"verified_email":true,"multipass_identifier":null,"tax_exempt":false,"phone":"+919500822338","tags":"","last_order_name":"#2283","currency":"INR","accepts_marketing_updated_at":"2020-10-01T11:19:04+05:30","marketing_opt_in_level":null,"admin_graphql_api_id":"gid:\/\/shopify\/Customer\/4078820917397","default_address":{"id":4959917736085,"customer_id":4078820917397,"first_name":"Imran ","last_name":"Imran","company":null,"address1":"Saradi mansion ","address2":"Shop","city":"Tamilnadu vellore","province":"Tamil Nadu","country":"India","zip":"632012","phone":"+91 95 0082 2338","name":"Imran  Imran","province_code":"TN","country_code":"IN","country_name":"India","default":true}}}';

		// $post = '{"id":3805979312288,"admin_graphql_api_id":"gid:\/\/shopify\/Order\/3805979312288","app_id":580111,"browser_ip":"103.233.94.247","buyer_accepts_marketing":false,"cancel_reason":null,"cancelled_at":null,"cart_token":null,"checkout_id":20245899182240,"checkout_token":"6e7aa6a33c83a0529b9200f4fe1332e4","client_details":{"accept_language":"en-IN,en;q=0.9","browser_height":754,"browser_ip":"103.233.94.247","browser_width":1519,"session_hash":null,"user_agent":"Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/89.0.4389.114 Safari\/537.36"},"closed_at":null,"confirmed":true,"contact_email":null,"created_at":"2021-04-13T16:22:27+05:30","currency":"INR","current_subtotal_price":"299.00","current_subtotal_price_set":{"shop_money":{"amount":"299.00","currency_code":"INR"},"presentment_money":{"amount":"299.00","currency_code":"INR"}},"current_total_discounts":"0.00","current_total_discounts_set":{"shop_money":{"amount":"0.00","currency_code":"INR"},"presentment_money":{"amount":"0.00","currency_code":"INR"}},"current_total_duties_set":null,"current_total_price":"352.82","current_total_price_set":{"shop_money":{"amount":"352.82","currency_code":"INR"},"presentment_money":{"amount":"352.82","currency_code":"INR"}},"current_total_tax":"53.82","current_total_tax_set":{"shop_money":{"amount":"53.82","currency_code":"INR"},"presentment_money":{"amount":"53.82","currency_code":"INR"}},"customer_locale":"en","device_id":null,"discount_codes":[],"email":"","financial_status":"pending","fulfillment_status":"fulfilled","gateway":"Cash on Delivery (COD)","landing_site":"\/wallets\/checkouts.json","landing_site_ref":null,"location_id":null,"name":"#1001","note":null,"note_attributes":[],"number":1,"order_number":1001,"order_status_url":"https:\/\/darmoon.myshopify.com\/55899160736\/orders\/836767ee5bba45d99bbf4b19c43fe98a\/authenticate?key=400e9664c5f43f85108e3fdd890bbbb9","original_total_duties_set":null,"payment_gateway_names":["Cash on Delivery (COD)"],"phone":"+919820138782","presentment_currency":"INR","processed_at":"2021-04-13T16:22:26+05:30","processing_method":"manual","reference":null,"referring_site":"https:\/\/darmoon.myshopify.com\/products\/zippered-skinny-jeans-85?_pos=1\u0026_psq=j\u0026_ss=e\u0026_v=1.0","source_identifier":null,"source_name":"web","source_url":null,"subtotal_price":"299.00","subtotal_price_set":{"shop_money":{"amount":"299.00","currency_code":"INR"},"presentment_money":{"amount":"299.00","currency_code":"INR"}},"tags":"","tax_lines":[{"price":"53.82","rate":0.18,"title":"IGST","price_set":{"shop_money":{"amount":"53.82","currency_code":"INR"},"presentment_money":{"amount":"53.82","currency_code":"INR"}}}],"taxes_included":false,"test":false,"token":"836767ee5bba45d99bbf4b19c43fe98a","total_discounts":"0.00","total_discounts_set":{"shop_money":{"amount":"0.00","currency_code":"INR"},"presentment_money":{"amount":"0.00","currency_code":"INR"}},"total_line_items_price":"299.00","total_line_items_price_set":{"shop_money":{"amount":"299.00","currency_code":"INR"},"presentment_money":{"amount":"299.00","currency_code":"INR"}},"total_outstanding":"352.82","total_price":"352.82","total_price_set":{"shop_money":{"amount":"352.82","currency_code":"INR"},"presentment_money":{"amount":"352.82","currency_code":"INR"}},"total_price_usd":"4.72","total_shipping_price_set":{"shop_money":{"amount":"0.00","currency_code":"INR"},"presentment_money":{"amount":"0.00","currency_code":"INR"}},"total_tax":"53.82","total_tax_set":{"shop_money":{"amount":"53.82","currency_code":"INR"},"presentment_money":{"amount":"53.82","currency_code":"INR"}},"total_tip_received":"0.00","total_weight":0,"updated_at":"2021-04-13T16:41:15+05:30","user_id":null,"billing_address":{"first_name":"paras","address1":"b604","phone":"9820138782","city":"mumbai","zip":"401202","province":"Maharashtra","country":"India","last_name":"mehta","address2":"agrwal","company":null,"latitude":19.3729595,"longitude":72.82200639999999,"name":"paras mehta","country_code":"IN","province_code":"MH"},"customer":{"id":5159189610656,"email":null,"accepts_marketing":false,"created_at":"2021-04-13T16:21:41+05:30","updated_at":"2021-04-13T16:22:27+05:30","first_name":"paras","last_name":"mehta","orders_count":1,"state":"disabled","total_spent":"352.82","last_order_id":3805979312288,"note":null,"verified_email":true,"multipass_identifier":null,"tax_exempt":false,"phone":"+919820138782","tags":"","last_order_name":"#1001","currency":"INR","accepts_marketing_updated_at":"2021-04-13T16:22:27+05:30","marketing_opt_in_level":null,"admin_graphql_api_id":"gid:\/\/shopify\/Customer\/5159189610656","default_address":{"id":6330645938336,"customer_id":5159189610656,"first_name":"paras","last_name":"mehta","company":null,"address1":"b604","address2":"agrwal","city":"mumbai","province":"Maharashtra","country":"India","zip":"401202","phone":"9820138782","name":"paras mehta","province_code":"MH","country_code":"IN","country_name":"India","default":true}},"discount_applications":[],"fulfillments":[{"id":3314110365856,"admin_graphql_api_id":"gid:\/\/shopify\/Fulfillment\/3314110365856","created_at":"2021-04-13T16:41:15+05:30","location_id":61809426592,"name":"#1001.1","order_id":3805979312288,"receipt":{},"service":"manual","shipment_status":null,"status":"success","tracking_company":null,"tracking_number":null,"tracking_numbers":[],"tracking_url":null,"tracking_urls":[],"updated_at":"2021-04-13T16:41:15+05:30","line_items":[{"id":9812166017184,"admin_graphql_api_id":"gid:\/\/shopify\/LineItem\/9812166017184","fulfillable_quantity":0,"fulfillment_service":"manual","fulfillment_status":"fulfilled","gift_card":false,"grams":0,"name":"Zippered Skinny Jeans 85 - 26","origin_location":{"id":2885892047008,"country_code":"IN","province_code":"MH","name":"darmoon","address1":"desi","address2":"Desi","city":"Bassein","zip":"401202"},"price":"299.00","price_set":{"shop_money":{"amount":"299.00","currency_code":"INR"},"presentment_money":{"amount":"299.00","currency_code":"INR"}},"product_exists":true,"product_id":6642481627296,"properties":[],"quantity":1,"requires_shipping":true,"sku":null,"taxable":true,"title":"Zippered Skinny Jeans 85","total_discount":"0.00","total_discount_set":{"shop_money":{"amount":"0.00","currency_code":"INR"},"presentment_money":{"amount":"0.00","currency_code":"INR"}},"variant_id":39729535680672,"variant_inventory_management":null,"variant_title":"26","vendor":"LadyStyle","tax_lines":[{"price":"53.82","price_set":{"shop_money":{"amount":"53.82","currency_code":"INR"},"presentment_money":{"amount":"53.82","currency_code":"INR"}},"rate":0.18,"title":"IGST"}],"duties":[],"discount_allocations":[]}]}],"line_items":[{"id":9812166017184,"admin_graphql_api_id":"gid:\/\/shopify\/LineItem\/9812166017184","fulfillable_quantity":0,"fulfillment_service":"manual","fulfillment_status":"fulfilled","gift_card":false,"grams":0,"name":"Zippered Skinny Jeans 85 - 26","origin_location":{"id":2885892047008,"country_code":"IN","province_code":"MH","name":"darmoon","address1":"desi","address2":"Desi","city":"Bassein","zip":"401202"},"price":"299.00","price_set":{"shop_money":{"amount":"299.00","currency_code":"INR"},"presentment_money":{"amount":"299.00","currency_code":"INR"}},"product_exists":true,"product_id":6642481627296,"properties":[],"quantity":1,"requires_shipping":true,"sku":null,"taxable":true,"title":"Zippered Skinny Jeans 85","total_discount":"0.00","total_discount_set":{"shop_money":{"amount":"0.00","currency_code":"INR"},"presentment_money":{"amount":"0.00","currency_code":"INR"}},"variant_id":39729535680672,"variant_inventory_management":null,"variant_title":"26","vendor":"LadyStyle","tax_lines":[{"price":"53.82","price_set":{"shop_money":{"amount":"53.82","currency_code":"INR"},"presentment_money":{"amount":"53.82","currency_code":"INR"}},"rate":0.18,"title":"IGST"}],"duties":[],"discount_allocations":[]}],"refunds":[],"shipping_address":{"first_name":"paras","address1":"b604","phone":"9820138782","city":"mumbai","zip":"401202","province":"Maharashtra","country":"India","last_name":"mehta","address2":"agrwal","company":null,"latitude":19.3729595,"longitude":72.82200639999999,"name":"paras mehta","country_code":"IN","province_code":"MH"},"shipping_lines":[{"id":3196344238240,"carrier_identifier":null,"code":"Standard","delivery_category":null,"discounted_price":"0.00","discounted_price_set":{"shop_money":{"amount":"0.00","currency_code":"INR"},"presentment_money":{"amount":"0.00","currency_code":"INR"}},"phone":null,"price":"0.00","price_set":{"shop_money":{"amount":"0.00","currency_code":"INR"},"presentment_money":{"amount":"0.00","currency_code":"INR"}},"requested_fulfillment_service_id":null,"source":"shopify","title":"Standard","tax_lines":[],"discount_allocations":[]}]}';
		// $_GET['UID'] = '74be2da0b32a3dac5166df0dcaeaaa3d';
		// $_GET['UKEY'] = '74b3993ae23b5e05132b67b8d7ac2caf';
		$log_data12['post_data'] = $post;
		$log_data12['post_data_json_decode'] = json_decode($post, true);
		$log_data12['get_data'] = $_GET;
		file_put_contents(APPPATH . 'logs/shopify_webhook_log/' . date("d-m-Y") . '_log.txt', "\n" . print_r($log_data12, true), FILE_APPEND);
		// dd($post);
		if (isset($post) && $post != '') {
			$log_data['post_data1'] = $post;
			$post = json_decode($post, true);
			$log_data['post_data_json_decode1'] = $post;
			$sender_info_data = $this->Common_model->getSingleRowArray(array("api_is_web_access" => '1', "api_user_id" => $_GET['UID'], "api_key" => $_GET['UKEY']), "id,api_pickup_address_id", "sender_master");

			if ($sender_info_data) {
				$sender_address_info_data = $this->Common_model->getSingleRowArray(array("id" => $sender_info_data['api_pickup_address_id']), "pincode", "sender_address_master");

				$log_data['sender_address_info'] = $sender_address_info_data;

				switch ($post['gateway']) {
					case 'Cash on Delivery (COD)':
						$order_type = '1';
						$cod_amount = $post['current_total_price'];
						break;
					case 'cash_on_delivery':
						$order_type = '1';
						$cod_amount = $post['current_total_price'];
						break;
					default:
						$order_type = '0';
						$cod_amount = '0';
						break;
				}

				//dd($post['shipping_address']);
				$receiver_address_data = array(
					'sender_id' => $sender_info_data['id'],
					'name' => $post['billing_address']['first_name'] . " " . $post['billing_address']['last_name'],
					'mobile_no' => str_replace(" ", "", $post['billing_address']['phone']),
					'address_1' => $post['billing_address']['address1'],
					'address_2' => $post['billing_address']['address2'],
					'city' => $post['billing_address']['city'],
					'state' => $post['billing_address']['province'],
					'pincode' => $post['billing_address']['zip'],
				);

				$log_data['receiver_address_data'] = $receiver_address_data;

				$receiver_address_id = $this->Common_model->insert($receiver_address_data, 'receiver_address');
				$order_product_detail_data = array(
					'physical_weight' => 0.5,
					'height' => 15,
					'width' => 15,
					'length' => 10,
					'volumetric_weight' => ((15 + 15 + 10) / 4500),
					'product_name' => $post['line_items'][0]['title'],
					'product_quantity' => $post['line_items'][0]['quantity'],
					'product_value' => $post['line_items'][0]['price'],
					'cod_amount' => $cod_amount,
				);

				$log_data['order_product_detail_data'] = $order_product_detail_data;

				$order_product_detail_id = $this->Common_model->insert($order_product_detail_data, 'order_product_detail');

				$tmp_single_order_data = array(
					'customer_order_no' => $post['id'],
					'sender_id' => $sender_info_data['id'],
					'pickup_address_id' => $sender_info_data['api_pickup_address_id'],
					'order_product_detail_id' => $order_product_detail_id,
					'deliver_address_id' => $receiver_address_id,
					'order_type' => $order_type,
				);

				// $this->load->helper('get_shiping_price');
				$shipping_order_data = get_shiping_price($sender_info_data['id'], null, $sender_address_info_data['pincode'], $post['billing_address']['zip'], '0', $order_type, $order_product_detail_data['volumetric_weight'], $order_product_detail_data['physical_weight'], ($order_product_detail_data['product_quantity'] * $order_product_detail_data['product_value']), 1);

				// dd($shipping_order_data);

				if ($shipping_order_data['status'] == 1) {

					$tmp_single_order_data['logistic_id'] = $shipping_order_data['data'][0]['logistic_id'];
					$tmp_single_order_data['total_shipping_amount'] = $shipping_order_data['data'][0]['total'];
					//$tmp_single_order_data['is_web'] = '1';
					$update_order_product_detail_data['cod_charge'] = $shipping_order_data['data'][0]['cod_ammount'];
					$insert_tmp_order = $this->Common_model->insert($tmp_single_order_data, 'temp_forward_order_master');

					$log_data['shipping_order_data'] = $shipping_order_data;
					$log_data['temp_singe_order_data'] = $tmp_single_order_data;

					if ($insert_tmp_order) {
						$update_data['order_no'] = 'PDL' . $sender_info_data['id'] . '-' . $insert_tmp_order . 'S';

						$this->Common_model->update($update_data, 'temp_forward_order_master', array('id' => $insert_tmp_order));
						$log_data['update_order_no'] = $this->db->last_query();
						$this->Common_model->update($update_order_product_detail_data, 'order_product_detail', array('id' => $order_product_detail_id));

						$log_data['update_order_detail'] = $this->db->last_query();

						$logistic_name = $this->Common_model->getSingle_data('*', 'logistic_master', array('id' => $tmp_single_order_data['logistic_id']));

						$log_data['logistic_data'] = $logistic_name;

						if ($logistic_name['api_name'] == "Delhivery_Surface" || $logistic_name['api_name'] == 'Xpressbees_Surface' || $logistic_name['api_name'] == 'Ekart_Surface') {
							$zship_sender_id = "";

							$pickup_address_fetch_row_info = $this->Common_model->getSingle_data('*', 'sender_address_master', array('id' => $sender_info_data['api_pickup_address_id']));

							$log_data['zship_pickup_address'] = $pickup_address_fetch_row_info;

							if ($pickup_address_fetch_row_info['zship_sender_id'] == "") {
								$email = (!empty($this->input->post('customer_email'))) ? $this->input->post('customer_email') : "sample@gmail.com";
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
								$arr[] = array('success' => 1, 'message' => "Address not created in API ");
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
						}
						if ($response['status'] == 0) {
							$arr[] = $response;
						} else {
							if ($logistic_name['api_name'] == "Delhivery_Surface" || $logistic_name['api_name'] == 'Xpressbees_Surface' || $logistic_name['api_name'] == 'Ekart_Surface') {
								$arr[] = array('success' => 1, 'message' => "Your request has been accepted and order is in process");
							} else {
								$arr[] = array('success' => 1, 'message' => "Order Create successfully");
							}
						}
					} else {
						$this->move_order($tmp_single_order_data, "Error From Shopify");
						$log_data['move_order_query'] = $this->db->last_query();
						$arr[] = array('success' => 0, 'message' => "Error From Shopify");
					}
				} else {
					$this->move_order($tmp_single_order_data, $shipping_order_data['message']);
					$log_data['move_order_query'] = $this->db->last_query();
					// $tmp_single_order_id = $this->Common_model->insert($tmp_single_order_data, 'error_order_master');
					$arr[] = array('success' => 0, 'message' => $shipping_order_data['message']);
				}
			} else {
				$arr[] = array('success' => 0, 'message' => "Invalid Credintial OR WebAccess not Allowed");
			}
		} else {
			$arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
		}

		$log_data['result'] = $arr;

		file_put_contents(APPPATH . 'logs/shopify_webhook_log/' . date("d-m-Y") . '_log.txt', print_r($log_data, true), FILE_APPEND);
		// header('Content-type: application/json');
		// echo json_encode($arr);
		dd($arr);
	}

	public function move_order($data, $error)
	{
		$this->Common_model->insert($data, 'error_order_master');
		$error_id = $this->db->insert_id();
		$errordata = array(
			'order_Error_id' => $error_id,
			'error' => $error,
		);
		$this->Common_model->insert($errordata, 'order_error_log');
	}



	public function get_api_order_trackdetail()
	{
		$post = json_decode(@file_get_contents("php://input"), true);
		$log_data['post_data'] = $post;

		if (isset($post) && $post != '') {
			$customer_result_data = $this->Common_model->getRowArray(array("api_is_web_access" => "1", "api_user_id" => $post['UID'], "api_key" => $post['UKEY']), "id,api_pickup_address_id", "sender_master");
			if ($customer_result_data) {

				$order_id = $this->Common_model->getRowArray(["awb_number" => base64_decode($post['airwaybill_number'])], 'id', 'forward_order_master');
				// dd($order_id);
				$order_status_info = $this->Common_model->getall_data('*', "order_tracking_detail", array("order_id" => $order_id[0]['id']));
				// dd(json_encode($order_status_info));
				if (!empty($order_status_info)) {
					$arr = array('success' => 1, 'data' => @$order_status_info);
				} else {
					$arr = array('success' => 0, 'message' => "Invalid Airwaybill number");
				}
			} else {
				$arr[] = array('success' => 0, 'message' => "Invalid Credintial OR WebAccess not Allowed");
			}
		} else {
			$arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
		}

		file_put_contents(APPPATH . 'Log_Upload/custom_api_order_log/' . date("d-m-Y") . '__' . @$customer_result_data['id'] . '__trackorder__log.txt', "\n-------------------------------------------------\n" . print_r($log_data, true), FILE_APPEND);

		header('Content-type: application/json');
		echo json_encode($arr);
	}
}
