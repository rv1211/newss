<?php
class API
{
	/**
	 * Xpressbees API Order Create
	 * @return Response
	 */
	static function xpressbees_order($order_id, $is_repeat = 0, $bulk = 0)
	{
		$log_data['process_start_time'] = date("d-m-y H:i:s");
		$error = $success = $log_id = $awbNumber = "";

		$CI = &get_instance();
		$CI->load->model('Create_singleorder_awb');
		$CI->load->model('Common_model');
		$CI->load->library('session');
		if ($bulk == 1) {
			$single_order_info = $CI->Create_singleorder_awb->get_multiple_order_list_bulk($order_id);
		} else {
			$single_order_info = $CI->Create_singleorder_awb->get_multiple_order_list($order_id);
		}

		// dd($single_order_info);
		// $single_order_info = $result[0];
		$kyc_Detail = $CI->Common_model->getSingle_data('id, gst_no', "kyc_verification_master", array('sender_id' => $single_order_info['sender_id']));
		$log_data['order_data_result_from_order_id'] = $order_id;

		if ($single_order_info['order_type'] == '0') {
			$order_type = '2';
			$typeName = 'prepaid';
		} else {
			$order_type = '1';
			$typeName = 'cod';
		}

		$logistic_name = $CI->Common_model->getSingle_data('logistic_name, api_name', 'logistic_master', array('id' => $single_order_info['logistic_id']));
		$logisticName = str_replace(' ', '_', strtolower(trim($logistic_name['api_name'])));


		if ($single_order_info['awb_number'] != '') {
			$awbNumber = $single_order_info['awb_number'];
		} else {
			$air_waybill_no_data = $CI->Common_model->getSingle_data('id, awb_number', $logisticName . '_airwaybill', array('is_used' => '1', 'type' => $order_type, 'for_what' => '2'));
			// lq();
			dd($air_waybill_no_data);
			$awbNumber = $air_waybill_no_data['awb_number'];
		}
		if ($single_order_info['igst_amount'] == '' || $single_order_info['igst_amount'] == '0.00') {
			$order_charge = floatval($single_order_info['total_shipping_amount']) + floatval($single_order_info['sgst_amount']) + floatval($single_order_info['cgst_amount']);
		} else {
			$order_charge = (floatval($single_order_info['total_shipping_amount']) + floatval($single_order_info['igst_amount']));
		}

		if ($awbNumber != "") {
			$customer_address = $single_order_info['address_1'];
			if (@$single_order_info['address_2'] != "") {
				$customer_address .= ', ' . $single_order_info['address_2'];
			}
			$full_pickup_address = $single_order_info['pickup_address_1'];
			if (@$single_order_info['pickup_address_2'] != "") {
				$full_pickup_address .= ', ' . $single_order_info['pickup_address_2'];
			}

			if (@$single_order_info['is_return_address_same_as_pickup'] == '0' && $bulk == 0) {
				$returnAddress = $CI->Common_model->getSingle_data('*', 'return_address', array('id' => $single_order_info['return_address_id']));
				$return_name = CUSTOM::remove_special_characters_and_extra_space(@$returnAddress['name']);
				$return_address = @$returnAddress['address_1'];
				if ($returnAddress['address_2'] != "") {
					$return_address .= ", " . $returnAddress['address_2'];
				}
				$return_city = @$returnAddress['city'];
				$return_state = @$returnAddress['state'];
				$return_pincode = @$returnAddress['pincode'];
				$return_phone = @$returnAddress['mobile_no'];
			} else {
				$return_name = CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_warehouseName']);
				$return_address = @$full_pickup_address;
				$return_city = @$single_order_info['pickup_city'];
				$return_state = @$single_order_info['pickup_state'];
				$return_pincode = @$single_order_info['pickup_pincode'];
				$return_phone = @$single_order_info['pickup_contactNo'];
			}
			if ($bulk == 1) {
				$order_id_for_api = "XB-Order" . CUSTOM::remove_special_characters_and_extra_space($single_order_info["id"]);
			} else {
				$order_id_for_api = CUSTOM::remove_special_characters_and_extra_space($single_order_info["order_no"]);
			}
			$body = '{
				        "XBkey": "' . $CI->config->item('XPRESSBEES_ORDER_KEY') . '",
				        "VersionNumber": "' . $CI->config->item('XPRESSBEES_ORDER_KEY_VERSION') . '",
				        "ManifestDetails": {
							"ManifestID": "' . mt_rand(0, (int) 99999999999) . '",
							"OrderType": "' . CUSTOM::remove_special_characters_and_extra_space($typeName) . '",
							"OrderNo": "' . CUSTOM::remove_special_characters_and_extra_space($order_id_for_api) . '",
							"PaymentStatus": "' . CUSTOM::remove_special_characters_and_extra_space($typeName) . '",
							"PickupVendor": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['pickup_warehouseName']) . '",
							"PickVendorPhoneNo": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['pickup_contactNo']) . '",
							"PickVendorAddress": "' . CUSTOM::remove_special_characters_and_extra_space($full_pickup_address) . '",
							"PickVendorCity": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['pickup_city']) . '",
							"PickVendorState": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['pickup_state']) . '",
							"PickVendorPinCode": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['pickup_pincode']) . '",
							"CustomerName": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['name']) . '",
							"CustomerCity": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['city']) . '",
							"CustomerState": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['state']) . '",
							"ZipCode": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['pincode']) . '",
							"CustomerAddressDetails":
			          		[{
					            "Type": "Primary",
					            "Address": "' . CUSTOM::remove_special_characters_and_extra_space($customer_address) . '"
			            	}],
		        			"CustomerMobileNumberDetails":
			          		[{
								"Type": "Primary",
								"MobileNo": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['mobile_no']) . '"
							}],
							"RTOName": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_name) . '",
							"RTOMobileNo": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_phone) . '",
							"RTOAddress": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_address) . '",
							"RTOToCity": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_city) . '",
							"RTOToState": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_state) . '",
					        "RTOPinCode": "' . @$return_pincode . '",';
			if ($typeName == 'cod') {
				$body .= '"CollectibleAmount": "' . $single_order_info['cod_amount'] . '",';
			}
			$body .= '"DeclaredValue": ' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['product_value']) . ',
					        "AirWayBillNO": "' . CUSTOM::remove_special_characters_and_extra_space($awbNumber) . '",
					        "ServiceType": "SD",
					        "Quantity": ' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['product_quantity']) . ',
					        "PickupVendorCode": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['pickup_id']) . '",
					        "GSTMultiSellerInfo": [{
						        "ProductDesc": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['product_name']) . '",
						        "SellerName": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['pickup_warehouseName']) . '",
						        "InvoiceDate":"' . date("d-m-Y") . '",
						        "SellerGSTRegNumber":"' . CUSTOM::remove_special_characters_and_extra_space(@$kyc_Detail['gst_no']) . '",
						        "SellerAddress": "' . CUSTOM::remove_special_characters_and_extra_space($full_pickup_address) . '",
						        "SellerPincode": ' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['pickup_pincode']) . ',
						        "TaxableValue": 18,
						        "SGSTAmount":' . $single_order_info['sgst_amount'] . ',
						        "CGSTAmount":' . $single_order_info['cgst_amount'] . ',
						        "GSTTaxTotal":' . $single_order_info['igst_amount'] . ',
						        "HSNCode": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['id']) . '"
			        		}]
			        	}
	        		}';
			$log_data['order_xpressbees_body'] = $body;
			// dd($body);
			$response = CUSTOM::curl_request('application/json', '', $CI->config->item('XPRESSBEES_ORDER_API_URL'), $body, "POST");
			$log_data['order_xpressbees_curl_response'] = $response;
			file_put_contents(APPPATH . 'logs/xpressbees_order/' . date("d-m-Y") . '_xpressbees_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
			// dd($response);
			if (@$response['error_response'] != '') {
				$log_data['order_xpressbees_curl_error'] = $response['error_response'];
				$orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
				$log_data['order_query'] = $CI->db->last_query();
				$new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 0, $bulk, $order_id_for_api, $response['error_response']);
				$log_data['move_order_query'] = $new_order_data;
				$error = "Your Order Failed to Shipped due to some error. ";
				file_put_contents(APPPATH . 'logs/xpressbees_order/' . date("d-m-Y") . '_xpressbees_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
			} else if (@$response['success_response']['AddManifestDetails'][0]['ReturnMessage'] == 'AWB Already Exists') {
				$log_data['order_xpressbees_error'] = @$response['success_response'];
				if ($is_repeat == 1) {
					$orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
					$log_data['order_query'] = $CI->db->last_query();
					$new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 0, $bulk, $order_id_for_api, @$response['success_response']['AddManifestDetails'][0]['ReturnMessage']);
					$log_data['move_order_query'] = $new_order_data;
				}
				$deleteAwb = $CI->Common_model->delete($logisticName . '_airwaybill', array('awb_number' => $awbNumber));
				$log_data['awb_query'] = $CI->db->last_query();

				$aebData['awb_number'] = '';
				if ($bulk == 1) {
					$orderAwb = $CI->Common_model->update($aebData, 'temp_order_master', array('id' => $order_id));
					$log_data['awb_order_query'] = $CI->db->last_query();
				} else {
					$orderAwb = $CI->Common_model->update($aebData, 'temp_forward_order_master', array('id' => $order_id));
					$log_data['awb_order_query'] = $CI->db->last_query();
				}
				$error = "AWB Already Exists";
				file_put_contents(APPPATH . 'logs/xpressbees_order/' . date("d-m-Y") . '_xpressbees_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
			} else if (@$response['success_response']['AddManifestDetails'][0]['ReturnMessage'] != 'successful') {
				$log_data['order_xpressbees_error'] = @$response['success_response'];
				$orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
				$log_data['order_query'] = $CI->db->last_query();
				$new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 0, $bulk, $order_id_for_api, @$response['success_response']['AddManifestDetails'][0]['ReturnMessage']);
				$log_data['move_order_query'] = $new_order_data;
				$error = "Your Order Failed to Shipped due to error." . @$response['success_response']['AddManifestDetails'][0]['ReturnMessage'];
				file_put_contents(APPPATH . 'logs/xpressbees_order/' . date("d-m-Y") . '_xpressbees_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
			} else if (@$response['success_response']['AddManifestDetails'][0]['ReturnMessage'] == 'Invalid xbAccessKey') {
				$log_data['order_xpressbees_error'] = @$response['success_response'];
				$orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
				$log_data['order_query'] = $CI->db->last_query();
				$new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 0, $bulk, $order_id_for_api, @$response['success_response']['AddManifestDetails'][0]['ReturnMessage']);
				$log_data['move_order_query'] = $new_order_data;
				$error = "Your Order Failed to Shipped due to error." . @$response['success_response']['AddManifestDetails'][0]['ReturnMessage'];
				file_put_contents(APPPATH . 'logs/xpressbees_order/' . date("d-m-Y") . '_xpressbees_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
			} else {
				end:
				$CI->db->trans_start();
				$CI->db->trans_strict(FALSE);
				$getwallet_data = $CI->Common_model->getSingle_data('id,email,wallet_balance,allow_credit,allow_credit_limit', 'sender_master', array('id' => $single_order_info['sender_id']));
				$wallet = $getwallet_data['wallet_balance'];
				$wallet_total = ($getwallet_data['wallet_balance'] - $order_charge);

				if ($wallet_total < 500) {
					$temp_wallet_balance = ($getwallet_data['wallet_balance'] - 500);
					$temp_order_cost = $order_charge - $temp_wallet_balance;
					if ($getwallet_data['allow_credit'] == 1) {
						if ($getwallet_data['allow_credit_limit'] >= $temp_order_cost) {
							$order_amount = ($getwallet_data['allow_credit_limit'] - $temp_order_cost);
							$debit_amount = $CI->Create_singleorder_awb->debit_wallet($temp_wallet_balance, $temp_order_cost, $single_order_info['sender_id']);
							$update_order = $CI->Create_singleorder_awb->update_amount($order_charge, $order_id, $bulk);
							$delete_awb  = $CI->Create_singleorder_awb->delete_awb($awbNumber, $logisticName);
							if ($debit_amount == true) {
								$orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
								$log_data['order_query'] = $CI->db->last_query();
								$new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 1, $bulk, $order_id_for_api, '');
								$log_data['move_order_query'] = $new_order_data;
								if (!empty($awbNumber)) {
									$fOrderId = $CI->db->insert_id;
									$data['order_id'] = $fOrderId;
									$data['airwaybill_no'] = $awbNumber;
									$data['order_status_id'] = 1;
									$data['order_type'] = $single_order_info['order_type'];
									$CI->Create_singleorder_awb->insert_barcode($data);
								}

								$log_data['payment_status'] = "paid";
								$log_data['wallet_balance'] = $temp_wallet_balance;
								$log_data['allow_credit_limit'] = $temp_order_cost;


								$total_wallet_balance = @$getwallet_data['wallet_balance'] - str_replace(",", "", $order_charge);
								$log_data['total_wallet_balance'] = $total_wallet_balance;
								$success = 'Your Order Shipped Successfully ';
							} else {
								$error = "Amount Cant be debiteds";
							}
							//WALLET MATHI $temp_wallet_balance
							//CREDIT MATHI $temp_order_cost
						} else {
							$error = "You have not sufficient wallet balance ,Recharge your wallet";
						}
					} else {
						$error = "You have not sufficient wallet balance ,Recharge your wallet";
					}
				} else {
					$log_data['payment_status'] = "paid";
					$debit_amount = $CI->Create_singleorder_awb->delete_direct_amount($wallet_total, $single_order_info['sender_id']);
					$update_order = $CI->Create_singleorder_awb->update_amount($single_order_info['total_shipping_amount'], $order_id);
					$log_data['order_amount_query'] = $CI->db->last_query();
					$delete_awb  = $CI->Create_singleorder_awb->delete_awb($awbNumber, $logisticName);
					$log_data['awb_query'] = $CI->db->last_query();
					if ($debit_amount == true) {
						$log_data['wallet_amount'] = $debit_amount;
						$orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
						$log_data['order_query'] = $CI->db->last_query();
						$new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 1, $bulk, $order_id_for_api, '');
						$log_data['move_order_query'] = $new_order_data;
						if (!empty($awbNumber)) {
							$fOrderId = $CI->db->insert_id;
							$data['order_id'] = $fOrderId;
							$data['airwaybill_no'] = $awbNumber;
							$data['order_status_id'] = 1;
							$data['order_type'] = $single_order_info['order_type'];
							$CI->Create_singleorder_awb->insert_barcode($data);
						}
						$success = "Order Created Successfully";
					} else {
						$error = "Amount Cant be debiteds";
					}

					$CI->db->trans_complete();

					if ($CI->db->trans_status() === FALSE) {
						# Something went wrong.
						$CI->db->trans_rollback();
						$error = "Something Went Wrong";
					} else {
						$CI->db->trans_commit();
						$success = "order Created Successfully";
					}
				}
				$log_data['process_end_time'] = date("d-m-y H:i:s");
				file_put_contents(APPPATH . 'logs/xpressbees_order/' . date("d-m-Y") . '_xpressbees_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
			}
		} else {
			$error = "waybill no not available";
		}
		if ($success) {
			$res['status'] = "1";
			$res['message'] = $success;
		} else {
			$res['status'] = "0";
			$res['message'] = $error;
		}
		return $res;
	}

	/**
	 * Xpressbees API Cancel Order
	 * @return Response
	 */
	static function xpressbees_cancel_order($order_id)
	{
		$CI = &get_instance();
		$CI->load->model('Create_singleorder_awb');
		$CI->load->model('Common_model');
		$CI->load->library('session');

		$log_data = array();
		$order_detail = $CI->Common_model->getSingle_data('id, awb_number', 'forward_order_master', array('id' => $order_id));
		// Cancel Order code start
		$cancel_order_body = ' {
				"XBkey":"' . $CI->config->item('XPRESSBEES_ORDER_KEY') . '",
				"AWBNumber":"24343621014076",
				"RTOReason":"Test Order Cancellation"
			}';
		$log_data['cancel_order_body'] = $cancel_order_body;
		$cancel_order_response = CUSTOM::curl_request('application/json', '', $CI->config->item('XPRESSBEES_ORDER_CANCEL_ORDER'), $cancel_order_body, "POST");
		$log_data['cancel_order_response'] = $cancel_order_response;
		file_put_contents(APPPATH . 'logs/xpressbees_order/' . date("d-m-Y") . '_xpressbees_cancel_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		dd($cancel_order_response);
	}

	/**
	 * Ecart API Order Create
	 * @return Response
	 */
	static function ecart_order($order_id, $bulk = 0)
	{
		$CI = &get_instance();
		$CI->load->model('Create_singleorder_awb');
		$CI->load->model('Common_model');
		$CI->load->library('session');
		if ($bulk == 1) {
			$single_order_info = $CI->Create_singleorder_awb->get_multiple_order_list_bulk($order_id);
		} else {
			$single_order_info = $CI->Create_singleorder_awb->get_multiple_order_list($order_id);
		}

		$log_data['process_start_time'] = date("d-m-y H:i:s");
		$error = $success = $log_id = "";
		// $single_order_info = $result[0];
		// dd($single_order_info);
		$kyc_Detail = $CI->Common_model->getSingle_data('id, gst_no', "kyc_verification_master", array('sender_id' => $single_order_info['sender_id']));
		$sender_Detail = $CI->Common_model->getSingle_data('name', "sender_master", array('id' => $single_order_info['sender_id']));
		$log_data['order_data_result_from_order_id'] = $order_id;

		if ($single_order_info['igst_amount'] == '' || $single_order_info['igst_amount'] == '0.00') {
			$order_charge = floatval($single_order_info['total_shipping_amount']) + floatval($single_order_info['sgst_amount']) + floatval($single_order_info['cgst_amount']);
			$taxVal = floatval($single_order_info['sgst_amount']) + floatval($single_order_info['cgst_amount']);
		} else {
			$order_charge = (floatval($single_order_info['total_shipping_amount']) + floatval($single_order_info['igst_amount']));
			$taxVal = floatval($single_order_info['igst_amount']);
		}

		if ($single_order_info['order_type'] == '0') {
			$trackingNo = $CI->config->item('ECART_MERCHANT_CODE') . 'P' . rand(1111111111, 9999999999);
		} else {
			$trackingNo = $CI->config->item('ECART_MERCHANT_CODE') . 'C' . rand(1111111111, 9999999999);
		}
		if ($bulk == 1) {
			$order_id_for_api = "ECART-" . CUSTOM::remove_special_characters_and_extra_space($single_order_info["id"]);
		} else {
			$order_id_for_api = CUSTOM::remove_special_characters_and_extra_space($single_order_info["order_no"]);
		}

		if (@$single_order_info['is_return_address_same_as_pickup'] == '0' && $bulk == 0) {
			$returnAddress = $CI->Common_model->getSingle_data('*', 'return_address', array('id' => $single_order_info['return_address_id']));
			$return_name = CUSTOM::remove_special_characters_and_extra_space(@$returnAddress['name']);
			$return_address1 = @$returnAddress['address_1'];
			$return_address2 = @$returnAddress['address_2'];
			$return_city = @$returnAddress['city'];
			$return_state = @$returnAddress['state'];
			$return_pincode = @$returnAddress['pincode'];
			$return_phone = @$returnAddress['mobile_no'];
		} else {
			$return_name = CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_warehouseName']);
			$return_address1 = @$single_order_info['pickup_address_1'];
			$return_address2 = @$single_order_info['pickup_address_2'];
			$return_city = @$single_order_info['pickup_city'];
			$return_state = @$single_order_info['pickup_state'];
			$return_pincode = @$single_order_info['pickup_pincode'];
			$return_phone = @$single_order_info['pickup_contactNo'];
		}
		$maxWeight = @$single_order_info['volumetric_weight'] > @$single_order_info['physical_weight'] ? @$single_order_info['physical_weight'] : @$single_order_info['volumetric_weight'];
		$body = '{
					"client_name": "' . $CI->config->item('ECART_MERCHANT_CODE') . '",
					"services": [
						{
							"service_code": "REGULAR",
							"service_details": [
								{
									"service_leg": "FORWARD",
									"service_data": {
										"vendor_name":"' . @$sender_Detail['name'] . '",
										"amount_to_collect": ' . @$single_order_info['total_shipping_amount'] . ',
										"delivery_type": "SMALL",
										"source": {
											"address": {
												"first_name": "' . $return_name . '",
												"address_line1": "' . @$single_order_info['pickup_address_1'] . '",
												"address_line2": "' . @$single_order_info['pickup_address_2'] . '",
												"pincode": "' . @$single_order_info['pickup_pincode'] . '",
												"city": "' . @$single_order_info['pickup_city'] . '",
												"state": "' . @$single_order_info['pickup_state'] . '",
												"primary_contact_number": "' . @$single_order_info['pickup_contactNo'] . '"
											}
										},
										"destination": {
											"address": {
												"first_name": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['name']) . '",
												"address_line1": "' . @$single_order_info['address_1'] . '",
												"address_line2": "' . @$single_order_info['address_2'] . '",
												"pincode": "' . @$single_order_info['pincode'] . '",
												"city": "' . @$single_order_info['city'] . '",
												"state": "' . @$single_order_info['state'] . '",
												"primary_contact_number": "' . @$single_order_info['mobile_no'] . '"
											}
										},
										"return_location": {
											"address": {
												"first_name": "' . $return_name . '",
												"address_line1": "' . $return_address1 . '",
												"address_line2": "' . $return_address2 . '",
												"pincode": "' . $return_pincode . '",
												"city": "' . $return_city . '",
												"state": "' . $return_state . '",
												"primary_contact_number": "' . $return_phone . '"
											}
										}
									},
									"shipment": {
										"client_reference_id": "CR-' . @$single_order_info['order_no'] . '",
										"tracking_id": "' . $trackingNo . '",
										"shipment_value": ' . @$single_order_info['total_shipping_amount'] . ',
										"shipment_dimensions": {
											"length": {
												"value": ' . @$single_order_info['length'] . '
											},
											"breadth": {
												"value": ' . @$single_order_info['width'] . '
											},
											"height": {
												"value": ' . @$single_order_info['height'] . '
											},
											"weight": {
												"value": ' . @$maxWeight . '
											}
										},
										"return_label_desc_1": "",
										"return_label_desc_2": "",
										"shipment_items": [
											{
												"product_id": "PRO-' . @$single_order_info['productId'] . '",
												"product_title": "' . @$single_order_info['product_name'] . '",
												"quantity": ' . @$single_order_info['product_quantity'] . ',
												"cost": {
													"total_sale_value": ' . @$single_order_info['total_shipping_amount'] . ',
													"total_tax_value": ' . @$taxVal . ',
													"tax_breakup":{
														"cgst":' . @$single_order_info['cgst_amount'] . ',
														"sgst":' . @$single_order_info['sgst_amount'] . ',
														"igst": ' . @$single_order_info['igst_amount'] . '
													}
												},
												"seller_details": {
													"seller_reg_name": "' . @$single_order_info['packing_slip_warehouse_name'] . '",
													"gstin_id":""
												},
												"item_attributes": [
													{
														"name": "order_id",
														"value": "' . @$order_id_for_api . '"
													},
													{
														"name": "invoice_id",
														"value": "INV' . @$single_order_info['order_no'] . '"
													},{
														"name": "item_dimensions",
														"value": "l:b:h:w"
													}
												]
											}
										]
									}
								}
							]
						}
					]
				}';
		$log_data['order_ecart_body'] = $body;
		$response = CUSTOM::curl_request('application/json', $CI->config->item('ECART_AUTHORIZATION'), $CI->config->item('ECART_API_URL'), $body, "POST", $CI->config->item('ECART_MERCHANT_CODE'));
		$log_data['order_ecart_curl_response'] = $response;
		file_put_contents(APPPATH . 'logs/ecart_order/' . date("d-m-Y") . '_ecart_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		// dd($response);
		if (@$response['error_response'] != '') {
			$log_data['order_xpressbees_curl_error'] = $response['error_response'];
			$orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
			$log_data['order_query'] = $CI->db->last_query();
			$new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 0, $bulk, $order_id_for_api, $response['error_response']);
			$log_data['move_order_query'] = $new_order_data;
			$error = "Your Order Failed to Shipped due to some error. ";
			file_put_contents(APPPATH . 'logs/ecart_order/' . date("d-m-Y") . '_ecart_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		} else if (@$response['success_response']['response'][0]['status'] == 'REQUEST_REJECTED') {
			$log_data['order_xpressbees_error'] = @$response['success_response'];
			$orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
			$log_data['order_query'] = $CI->db->last_query();
			$new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 0, $bulk, $order_id_for_api, @$response['success_response']['response'][0]['message'][0]);
			$log_data['move_order_query'] = $new_order_data;
			$error = "Your Order Failed to Shipped due to some error.";
			file_put_contents(APPPATH . 'logs/ecart_order/' . date("d-m-Y") . '_ecart_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		} else if (@$response['success_response']['response'][0]['status'] == 'REQUEST_RECEIVED') {
			$CI->db->trans_start();
			$CI->db->trans_strict(FALSE);
			$getwallet_data = $CI->Common_model->getSingle_data('id,email,wallet_balance,allow_credit,allow_credit_limit', 'sender_master', array('id' => $single_order_info['sender_id']));
			$wallet = $getwallet_data['wallet_balance'];
			$wallet_total = ($getwallet_data['wallet_balance'] - $order_charge);

			if ($wallet_total < 500) {
				$temp_wallet_balance = ($getwallet_data['wallet_balance'] - 500);
				$temp_order_cost = $order_charge - $temp_wallet_balance;
				if ($getwallet_data['allow_credit'] == 1) {
					if ($getwallet_data['allow_credit_limit'] >= $temp_order_cost) {
						$order_amount = ($getwallet_data['allow_credit_limit'] - $temp_order_cost);
						$debit_amount = $CI->Create_singleorder_awb->debit_wallet($temp_wallet_balance, $temp_order_cost, $single_order_info['sender_id']);
						$update_order = $CI->Create_singleorder_awb->update_amount($order_charge, $order_id, $bulk);
						// $delete_awb  = $CI->Create_singleorder_awb->delete_awb($awbNumber, $logisticName);
						if ($debit_amount == true) {
							$orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
							array_push($orderdata, $trackingNo);
							$log_data['order_query'] = $CI->db->last_query();
							$new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 1, $bulk, $order_id_for_api, '');
							$log_data['move_order_query'] = $new_order_data;
							$fOrderId = $CI->db->insert_id();
							$data['order_id'] = $fOrderId;
							$data['airwaybill_no'] = $trackingNo;
							$data['order_status_id'] = 1;
							$data['order_type'] = $single_order_info['order_type'];
							$log_data['barcode_order_info'] = $data;
							$CI->Create_singleorder_awb->insert_barcode($data);
							$log_data['payment_status'] = "paid";
							$log_data['wallet_balance'] = $temp_wallet_balance;
							$log_data['allow_credit_limit'] = $temp_order_cost;
							$total_wallet_balance = @$getwallet_data['wallet_balance'] - str_replace(",", "", $order_charge);
							$log_data['total_wallet_balance'] = $total_wallet_balance;
							$success = 'Your Order Shipped Successfully ';
						} else {
							$error = "Amount Cant be debiteds";
							$log_data['orderError'] = $error;
						}
					} else {
						$error = "You have not sufficient wallet balance ,Recharge your wallet";
						$log_data['orderError'] = $error;
					}
				} else {
					$error = "You have not sufficient wallet balance ,Recharge your wallet";
					$log_data['orderError'] = $error;
				}
			} else {
				$log_data['payment_status'] = "paid";
				$debit_amount = $CI->Create_singleorder_awb->delete_direct_amount($wallet_total, $single_order_info['sender_id']);
				$update_order = $CI->Create_singleorder_awb->update_amount($single_order_info['total_shipping_amount'], $order_id);
				$log_data['order_amount_query'] = $CI->db->last_query();
				// $delete_awb  = $CI->Create_singleorder_awb->delete_awb($awbNumber, $logisticName);
				// $log_data['awb_query'] = $CI->db->last_query();
				if ($debit_amount == true) {
					$log_data['wallet_amount'] = $debit_amount;
					$orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
					$log_data['order_query'] = $CI->db->last_query();
					array_push($orderdata, $trackingNo);
					$new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 1, $bulk, $order_id_for_api, '');
					$log_data['move_order_query'] = $new_order_data;
					$fOrderId = $CI->db->insert_id();
					$data['order_id'] = $fOrderId;
					$data['airwaybill_no'] = $trackingNo;
					$data['order_status_id'] = 1;
					$data['order_type'] = $single_order_info['order_type'];
					$log_data['barcode_order_info'] = $data;
					$CI->Create_singleorder_awb->insert_barcode($data);
					$success = "Order Created Successfully";
				} else {
					$error = "Amount Cant be debited";
					$log_data['orderError'] = $error;
				}
				$CI->db->trans_complete();
				if ($CI->db->trans_status() === FALSE) {
					# Something went wrong.
					$CI->db->trans_rollback();
					$error = "Something Went Wrong";
				} else {
					$CI->db->trans_commit();
					$success = "Order Created Successfully";
				}
			}
			$log_data['process_end_time'] = date("d-m-y H:i:s");
			file_put_contents(APPPATH . 'logs/ecart_order/' . date("d-m-Y") . '_ecart_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		} else {
			$log_data['order_xpressbees_error'] = @$response['success_response'];
			$orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
			$log_data['order_query'] = $CI->db->last_query();
			if (@$response['success_response']['unauthorised'] != '') {
				$error_message = @$response['success_response']['unauthorised'];
			} else if (@$response['success_response']['failed'] != '') {
				$error_message = @$response['success_response']['failed'];
			} else {
				$error_message = 'Something Went Wrong';
			}
			$new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 0, $bulk, $order_id_for_api, @$error_message);
			$log_data['move_order_query'] = $new_order_data;
			// $deleteAwb = $CI->Common_model->delete($logisticName . '_airwaybill', array('awb_number' => $awbNumber));
			// $log_data['awb_query'] = $CI->db->last_query();
			$error = $error_message;
			file_put_contents(APPPATH . 'logs/ecart_order/' . date("d-m-Y") . '_ecart_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		}
		if ($success) {
			$res['status'] = "1";
			$res['message'] = $success;
		} else {
			$res['status'] = "0";
			$res['message'] = $error;
		}
		return $res;
	}

	/**
	 * Ecom API Order Create
	 * @return Response
	 */
	static function ecom_order($order_id, $bulk = 0)
	{
		die("cjhadifjasdf");
		$CI = &get_instance();
		$CI->load->model('Create_singleorder_awb');
		$CI->load->model('Common_model');
		$CI->load->library('session');

		if ($bulk == 1) {
			$single_order_info = $CI->Create_singleorder_awb->get_multiple_order_list_bulk($order_id);
		} else {
			$single_order_info = $CI->Create_singleorder_awb->get_multiple_order_list($order_id);
		}
	
		$log_data['process_start_time'] = date("d-m-y H:i:s");
		$error = $success = $log_id = "";
		// $single_order_info = $result;
		dd($single_order_info);
		$kyc_Detail = $CI->Common_model->getSingle_data('id, gst_no', "kyc_verification_master", array('sender_id' => $single_order_info['sender_id']));
		$sender_Detail = $CI->Common_model->getSingle_data('name', "sender_master", array('id' => $single_order_info['sender_id']));
		$log_data['order_data_result_from_order_id'] = $order_id;
		$logistic_name = $CI->Common_model->getSingle_data('logistic_name, api_name', 'logistic_master', array('id' => $single_order_info['logistic_id']));
		$logisticName = str_replace(' ', '_', strtolower(trim($logistic_name['api_name'])));

		if ($single_order_info['awb_number'] != '') {
			$awbNumber = $single_order_info['awb_number'];
		} else {
			$air_waybill_no_data = $CI->Common_model->getSingle_data('id, awb_number', $logisticName . '_airwaybill', array('is_used' => '1', 'type' => $single_order_info['order_type'], 'for_what' => '2'));
			$awbNumber = $air_waybill_no_data['awb_number'];
		}

		if ($single_order_info['order_type'] == '0') {
			$product = 'PPD';
		} else {
			$product = 'COD';
		}

		if ($single_order_info['igst_amount'] == '' || $single_order_info['igst_amount'] == '0.00') {
			$order_charge = floatval($single_order_info['total_shipping_amount']) + floatval($single_order_info['sgst_amount']) + floatval($single_order_info['cgst_amount']);
			$taxVal = floatval($single_order_info['sgst_amount']) + floatval($single_order_info['cgst_amount']);
			$taxName = @$single_order_info['pickup_state'] . ' CGST and ' . @$single_order_info['pickup_state'] . ' SGST';
			$cgst = @$single_order_info['cgst_amount'];
			$sgst = @$single_order_info['sgst_amount'];
			$igst = '0.00';
			$gstRate = '9.0';
			$igstRate = '0.0';
		} else {
			$order_charge = (floatval($single_order_info['total_shipping_amount']) + floatval($single_order_info['igst_amount']));
			$taxVal = floatval($single_order_info['igst_amount']);
			$taxName = @$single_order_info['pickup_state'] . ' IGST';
			$cgst = '0.00';
			$sgst = '0.00';
			$igst = @$single_order_info['igst_amount'];
			$gstRate = '0.0';
			$igstRate = '18.0';
		}

		if ($bulk == 1) {
			$order_id_for_api = "ECOM-" . CUSTOM::remove_special_characters_and_extra_space($single_order_info["id"]);
		} else {
			$order_id_for_api = CUSTOM::remove_special_characters_and_extra_space($single_order_info["order_no"]);
		}

		if (@$single_order_info['is_return_address_same_as_pickup'] == '0' && $bulk == 0) {
			$returnAddress = $CI->Common_model->getSingle_data('*', 'return_address', array('id' => $single_order_info['return_address_id']));
			$return_name = CUSTOM::remove_special_characters_and_extra_space(@$returnAddress['name']);
			$return_address1 = @$returnAddress['address_1'];
			$return_address2 = @$returnAddress['address_2'];
			$return_city = @$returnAddress['city'];
			$return_state = @$returnAddress['state'];
			$return_pincode = @$returnAddress['pincode'];
			$return_phone = @$returnAddress['mobile_no'];
		} else {
			$return_name = CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_warehouseName']);
			$return_address1 = @$single_order_info['pickup_address_1'];
			$return_address2 = @$single_order_info['pickup_address_2'];
			$return_pincode = @$single_order_info['pickup_pincode'];
			$return_phone = @$single_order_info['pickup_contactNo'];
		}
		$maxWeight = @$single_order_info['volumetric_weight'] > @$single_order_info['physical_weight'] ? @$single_order_info['physical_weight'] : @$single_order_info['volumetric_weight'];

		// $awbNumber = @$single_order_info['awb_number'];
		$body = '[{
					"AWB_NUMBER": "' . @$awbNumber . '",
					"ORDER_NUMBER": "' . $order_id_for_api . '",
					"PRODUCT": "' . $product . '",
					"CONSIGNEE":"' . @$single_order_info['name'] . '",
					"CONSIGNEE_ADDRESS1": "' . @$single_order_info['address_1'] . '",
					"CONSIGNEE_ADDRESS2": "' . @$single_order_info['address_2'] . '",
					"CONSIGNEE_ADDRESS3": "",
					"DESTINATION_CITY": "' . @$single_order_info['city'] . '",
					"PINCODE": "' . @$single_order_info['pincode'] . '",
					"STATE": "' . @$single_order_info['state'] . '",
					"MOBILE": "' . @$single_order_info['mobile_no'] . '",
					"TELEPHONE": "",
					"ITEM_DESCRIPTION": "' . @$single_order_info['product_name'] . '",
					"PIECES": ' . @$single_order_info['package_count'] . ',
					"COLLECTABLE_VALUE": ' . @$single_order_info['cod_amount'] . ',
					"DECLARED_VALUE": ' . $order_charge . ',
					"ACTUAL_WEIGHT": ' . @$single_order_info['physical_weight'] . ',
					"VOLUMETRIC_WEIGHT": ' . @$single_order_info['volumetric_weight'] . ',
					"LENGTH": ' . @$single_order_info['length'] . ',
					"BREADTH": ' . @$single_order_info['width'] . ',
					"HEIGHT": ' . @$single_order_info['height'] . ',
					"PICKUP_NAME": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_warehouseName']) . '",
					"PICKUP_ADDRESS_LINE1": "' . @$single_order_info['pickup_address_1'] . '",
					"PICKUP_ADDRESS_LINE2": "' . @$single_order_info['pickup_address_2'] . '",
					"PICKUP_PINCODE": "' . @$single_order_info['pickup_pincode'] . '",
					"PICKUP_PHONE": "' . @$single_order_info['pickup_contactNo'] . '",
					"PICKUP_MOBILE": "' . @$single_order_info['pickup_contactNo'] . '",
					"RETURN_NAME": "' . $return_name . '",
					"RETURN_ADDRESS_LINE1": "' . $return_address1 . '",
					"RETURN_ADDRESS_LINE2": "' . $return_address2 . '",
					"RETURN_PINCODE": "' . $return_pincode . '",
					"RETURN_PHONE": "' . $return_phone . '",
					"RETURN_MOBILE": "' . $return_phone . '",
					"DG_SHIPMENT": "false",
					"ADDITIONAL_INFORMATION": {
						"DELIVERY_TYPE": "",
						"SELLER_TIN": "' . @$single_order_info['product_name'] . '",
						"INVOICE_NUMBER": "IN-' . CUSTOM::remove_special_characters_and_extra_space($single_order_info["order_no"]) . '",
						"INVOICE_DATE": "' . date('d-m-Y', strtotime($single_order_info['created_date'])) . '",
						"PICKUP_TYPE": "' . @$single_order_info['pickup_warehouseName'] . '",
						"SELLER_GSTIN": "' . @$kyc_Detail['gst_no'] . '",
						"GST_HSN": "' . @$single_order_info['product_sku'] . '",
						"GST_TAX_NAME": "' . @$taxName . '",
						"GST_TAX_BASE": ' . @$taxVal . ',
						"DISCOUNT": 0.0,
						"GST_TAX_RATE_CGSTN": ' . $gstRate . ',
						"GST_TAX_RATE_SGSTN": ' . $gstRate . ',
						"GST_TAX_RATE_IGSTN": ' . $igstRate . ',
						"GST_TAX_TOTAL": ' . $taxVal . ',
						"GST_TAX_CGSTN": ' . $cgst . ',
						"GST_TAX_SGSTN": ' . $sgst . ',
						"GST_TAX_IGSTN": ' . $igst . '
					}
				}]';
		$log_data['order_ecom_body'] = $body;
		$request_body = 'username=' . urlencode($CI->config->item('ECOM_API_USER')) . '&password=' . urlencode($CI->config->item('ECOM_API_PASS')) . '&json_input=' . urlencode($body);
		// $log_data['order_ecom_url'] = $request_body;
		$response = CUSTOM::curl_request('application/json', '', $CI->config->item('ECOM_API_URL'), $request_body, "POST", '');
		$log_data['order_ecom_curl_response'] = $response;
		file_put_contents(APPPATH . 'logs/ecom_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_ecom_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		if (@$response['error_response'] != '') {
			$log_data['order_xpressbees_curl_error'] = $response['error_response'];
			$orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
			$log_data['order_query'] = $CI->db->last_query();
			$new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 0, $bulk, $order_id_for_api, $response['error_response']);
			$log_data['move_order_query'] = $new_order_data;
			$error = "Your Order Failed to Shipped due to some error.";
			file_put_contents(APPPATH . 'logs/ecom_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_ecom_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		} else if (@$response['success_response'] == '') {
			$log_data['order_xpressbees_curl_error'] = $response['error_response'];
			$orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
			$log_data['order_query'] = $CI->db->last_query();
			$new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 0, $bulk, $order_id_for_api, $response['error_response']);
			$log_data['move_order_query'] = $new_order_data;
			$error = "Your Order Failed to Shipped due to some error.";
			file_put_contents(APPPATH . 'logs/ecom_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_ecom_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		} else if (@$response['success_response']['shipments'][0]['success'] == 1 || @$response['success_response']['shipments'][0]['success'] == '1') {
			$CI->db->trans_start();
			$CI->db->trans_strict(FALSE);
			$getwallet_data = $CI->Common_model->getSingle_data('id,email,wallet_balance,allow_credit,allow_credit_limit', 'sender_master', array('id' => $single_order_info['sender_id']));
			$wallet = $getwallet_data['wallet_balance'];
			$wallet_total = ($getwallet_data['wallet_balance'] - $order_charge);
			if ($wallet_total < 500) {
				$temp_wallet_balance = ($getwallet_data['wallet_balance'] - 500);
				$temp_order_cost = $order_charge - $temp_wallet_balance;
				if ($getwallet_data['allow_credit'] == 1) {
					if ($getwallet_data['allow_credit_limit'] >= $temp_order_cost) {
						$order_amount = ($getwallet_data['allow_credit_limit'] - $temp_order_cost);
						$debit_amount = $CI->Create_singleorder_awb->debit_wallet($temp_wallet_balance, $temp_order_cost, $single_order_info['sender_id']);
						$update_order = $CI->Create_singleorder_awb->update_amount($order_charge, $order_id, $bulk);
						$delete_awb  = $CI->Create_singleorder_awb->delete_awb($awbNumber, $logisticName);
						if ($debit_amount == true) {
							$orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
							$log_data['order_query'] = $CI->db->last_query();
							$new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 1, $bulk, $order_id_for_api, '');
							$log_data['move_order_query'] = $new_order_data;
							$delete_awb  = $CI->Create_singleorder_awb->delete_awb($awbNumber, $logisticName);
							$log_data['awb_query'] = $CI->db->last_query();

							$fOrderId = $CI->db->insert_id;
							$data['order_id'] = $fOrderId;
							$data['airwaybill_no'] = $awbNumber;
							$data['order_status_id'] = 1;
							$data['order_type'] = $single_order_info['order_type'];
							$CI->Create_singleorder_awb->insert_barcode($data);

							$log_data['payment_status'] = "paid";
							$log_data['wallet_balance'] = $temp_wallet_balance;
							$log_data['allow_credit_limit'] = $temp_order_cost;


							$total_wallet_balance = @$getwallet_data['wallet_balance'] - str_replace(",", "", $order_charge);
							$log_data['total_wallet_balance'] = $total_wallet_balance;
							$success = 'Your Order Shipped Successfully ';
						} else {
							$error = "Amount Cant be debiteds";
							$log_data['orderError'] = $error;
						}
					} else {
						$error = "You have not sufficient wallet balance ,Recharge your wallet";
						$log_data['orderError'] = $error;
					}
				} else {
					$error = "You have not sufficient wallet balance ,Recharge your wallet";
					$log_data['orderError'] = $error;
				}
			} else {
				$log_data['payment_status'] = "paid";
				$debit_amount = $CI->Create_singleorder_awb->delete_direct_amount($wallet_total, $single_order_info['sender_id']);
				$update_order = $CI->Create_singleorder_awb->update_amount($single_order_info['total_shipping_amount'], $order_id);
				$log_data['order_amount_query'] = $CI->db->last_query();
				if ($debit_amount == true) {
					$log_data['wallet_amount'] = $debit_amount;
					$orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
					$log_data['order_query'] = $CI->db->last_query();
					$new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 1, $bulk, $order_id_for_api, '');
					$log_data['move_order_query'] = $new_order_data;
					$delete_awb  = $CI->Create_singleorder_awb->delete_awb($awbNumber, $logisticName);
					$log_data['awb_query'] = $CI->db->last_query();

					$fOrderId = $CI->db->insert_id;
					$data['order_id'] = $fOrderId;
					$data['airwaybill_no'] = $awbNumber;
					$data['order_status_id'] = 1;
					$data['order_type'] = $single_order_info['order_type'];
					$CI->Create_singleorder_awb->insert_barcode($data);

					$success = "Order Created Successfully";
				} else {
					$error = "Amount Cant be debiteds";
					$log_data['orderError'] = $error;
				}

				$CI->db->trans_complete();

				if ($CI->db->trans_status() === FALSE) {
					# Something went wrong.
					$CI->db->trans_rollback();
					$error = "Something Went Wrong";
				} else {
					$CI->db->trans_commit();
					$success = "order Created Successfully";
				}
			}
			$log_data['process_end_time'] = date("d-m-y H:i:s");
			file_put_contents(APPPATH . 'logs/ecom_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_ecom_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		} else {
			$log_data['order_xpressbees_error'] = @$response['success_response'];
			$orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
			$log_data['order_query'] = $CI->db->last_query();
			$new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 0, $bulk, $order_id_for_api, @$response['success_response']['shipments'][0]['reason']);
			$log_data['move_order_query'] = $new_order_data;

			$deleteAwb = $CI->Common_model->delete($logisticName . '_airwaybill', array('awb_number' => $awbNumber));
			$log_data['awb_query'] = $CI->db->last_query();
			$error = @$response['success_response']['shipments'][0]['reason'];
			file_put_contents(APPPATH . 'logs/ecom_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_ecom_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		}
		if ($success) {
			$res['status'] = "1";
			$res['message'] = $success;
		} else {
			$res['status'] = "0";
			$res['message'] = $error;
		}
		return $res;
	}

	/**
	 * Shadowfax API Order Create
	 * @return Response
	 */
	static function shadowfax_order($order_id, $bulk = 0)
	{
		$CI = &get_instance();
		$CI->load->model('Create_singleorder_awb');
		$CI->load->model('Common_model');
		$CI->load->library('session');
		if ($bulk == 1) {
			$single_order_info = $CI->Create_singleorder_awb->get_multiple_order_list_bulk($order_id);
		} else {
			$single_order_info = $CI->Create_singleorder_awb->get_multiple_order_list($order_id);
		}

		$log_data['process_start_time'] = date("d-m-y H:i:s");
		$error = $success = $log_id = "";
		// $single_order_info = $result;
		// dd($single_order_info);
		$kyc_Detail = $CI->Common_model->getSingle_data('id, gst_no', "kyc_verification_master", array('sender_id' => $single_order_info['sender_id']));
		$sender_Detail = $CI->Common_model->getSingle_data('name', "sender_master", array('id' => $single_order_info['sender_id']));
		$log_data['order_data_result_from_order_id'] = $order_id;
		$logistic_name = $CI->Common_model->getSingle_data('logistic_name, api_name', 'logistic_master', array('id' => $single_order_info['logistic_id']));
		$logisticName = str_replace(' ', '_', strtolower(trim($logistic_name['api_name'])));

		if ($bulk == 1) {
			$order_id_for_api = "SHADOW-" . CUSTOM::remove_special_characters_and_extra_space($single_order_info["id"]);
		} else {
			$order_id_for_api = CUSTOM::remove_special_characters_and_extra_space($single_order_info["order_no"]);
		}

		if (@$single_order_info['is_return_address_same_as_pickup'] == '0' && $bulk == 0) {
			$returnAddress = $CI->Common_model->getSingle_data('*', 'return_address', array('id' => $single_order_info['return_address_id']));
			$return_name = CUSTOM::remove_special_characters_and_extra_space(@$returnAddress['name']);
			$return_address1 = @$returnAddress['address_1'];
			$return_address2 = @$returnAddress['address_2'];
			$return_city = @$returnAddress['city'];
			$return_state = @$returnAddress['state'];
			$return_pincode = @$returnAddress['pincode'];
			$return_phone = @$returnAddress['mobile_no'];
		} else {
			$return_name = CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_warehouseName']);
			$return_address1 = @$single_order_info['pickup_address_1'];
			$return_address2 = @$single_order_info['pickup_address_2'];
			$return_pincode = @$single_order_info['pickup_pincode'];
			$return_phone = @$single_order_info['pickup_contactNo'];
		}
		$maxWeight = @$single_order_info['volumetric_weight'] > @$single_order_info['physical_weight'] ? @$single_order_info['physical_weight'] : @$single_order_info['volumetric_weight'];

		$awbNumber = @$single_order_info['awb_number'];
		$body = '{
			    	"order_details": {
			    		"client_order_id": "' . CUSTOM::remove_special_character_and_extra_space(@$single_order_info->order_no) . '",
			    		"actual_weight": ' . (@$single_order_info->phy_weight * 1000) . ',
			    		"volumetric_weight": ' . (@$single_order_info->vol_weight * 1000) . ',
			    		"product_value": ' . @$single_order_info->product_mrp . ',
			    		"payment_mode": "' . @$single_order_info->order_type . '",';
		if (@$single_order_info->order_type == 'cod') {
			$body .= '"cod_amount": "' . @$single_order_info->cod_amount . '",';
		}
		$body .= '"total_amount": ' . @$single_order_info->shipping_charge . '
			    	},
			    	"customer_details": {
					    "name": "' . CUSTOM::remove_special_character_and_extra_space(@$single_order_info->customer_name) . '",
					    "contact": ' . CUSTOM::remove_special_character_and_extra_space(@$single_order_info->customer_mobile) . ',
					    "address_line_1": "' . CUSTOM::remove_special_character_and_extra_space(@$single_order_info->customer_address1) . '",
					    "address_line_2": "' . CUSTOM::remove_special_character_and_extra_space(@$single_order_info->customer_address2) . '",
					    "city": "' . CUSTOM::remove_special_character_and_extra_space(@$single_order_info->city) . '",
					    "state": "' . CUSTOM::remove_special_character_and_extra_space(@$single_order_info->state) . '",
					    "pincode": ' . @$single_order_info->pincode . '
				  	},
				  	"pickup_details": {
					    "name": "' . CUSTOM::remove_special_character_and_extra_space(@$single_pickup_address_info->warehouse_name) . '",
					    "contact": ' . CUSTOM::remove_special_character_and_extra_space(@$single_pickup_address_info->warehouse_contact_no) . ',
					    "address_line_1": "' . CUSTOM::remove_special_character_and_extra_space(@$single_pickup_address_info->address_1) . '",
					    "address_line_2": "' . CUSTOM::remove_special_character_and_extra_space(@$single_pickup_address_info->address_2) . '",
					    "city": "' . CUSTOM::remove_special_character_and_extra_space(@$single_pickup_address_info->city) . '",
					    "state": "' . CUSTOM::remove_special_character_and_extra_space(@$single_pickup_address_info->state) . '",
					    "pincode": ' . @$single_pickup_address_info->pincode . '
				  	},
				  	"rts_details": {
					    "name": "' . CUSTOM::remove_special_character_and_extra_space(@$return_name) . '",
					    "contact": ' . CUSTOM::remove_special_character_and_extra_space(@$return_phone) . ',
					    "address_line_1": "' . CUSTOM::remove_special_character_and_extra_space(@$return_address1) . '",
					    "address_line_2": "' . CUSTOM::remove_special_character_and_extra_space(@$return_address2) . '",
					    "city": "' . CUSTOM::remove_special_character_and_extra_space(@$return_city) . '",
					    "state": "' . CUSTOM::remove_special_character_and_extra_space(@$return_state) . '",
					    "pincode": ' . @$return_pincode . '
				  	},
				  	"product_details": [
				    	{
							"sku_name": "' . CUSTOM::remove_special_character_and_extra_space(@$single_order_info->product_description) . '",
							"price": ' . @$single_order_info->product_mrp . ',
					      	"seller_details": {
					        	"gstin_number": "' . CUSTOM::remove_special_character_and_extra_space(@$user_kyc_infodata->gst_no) . '"
					      	},
					      	"taxes": {
						        "cgst": ' . (@$single_order_info->gst_charge / 2) . ',
						        "sgst": ' . (@$single_order_info->gst_charge / 2) . ',
						        "igst": 0,
						        "total_tax": ' . @$single_order_info->gst_charge . '
					      	}
					    }
				  	]
				}';
		$log_data['order_ecom_body'] = $body;
		$request_body = 'username=' . urlencode($CI->config->item('ECOM_API_USER')) . '&password=' . urlencode($CI->config->item('ECOM_API_PASS')) . '&json_input=' . urlencode($body);
		// $log_data['order_ecom_url'] = $request_body;
		$response = CUSTOM::curl_request('application/json', '', $CI->config->item('ECOM_API_URL'), $request_body, "POST", '');
		$log_data['order_ecom_curl_response'] = $response;
		file_put_contents(APPPATH . 'logs/ecom_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_ecom_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		if (@$response['error_response'] != '') {
			$log_data['order_xpressbees_curl_error'] = $response['error_response'];
			$orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
			$log_data['order_query'] = $CI->db->last_query();
			$new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 0, $bulk, $order_id_for_api, $response['error_response']);
			$log_data['move_order_query'] = $new_order_data;
			$error = "Your Order Failed to Shipped due to some error.";
			file_put_contents(APPPATH . 'logs/ecom_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_ecom_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		} else if (@$response['success_response'] == '') {
			$log_data['order_xpressbees_curl_error'] = $response['error_response'];
			$orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
			$log_data['order_query'] = $CI->db->last_query();
			$new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 0, $bulk, $order_id_for_api, $response['error_response']);
			$log_data['move_order_query'] = $new_order_data;
			$error = "Your Order Failed to Shipped due to some error.";
			file_put_contents(APPPATH . 'logs/ecom_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_ecom_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		} else if (@$response['success_response']['shipments'][0]['success'] == 1 || @$response['success_response']['shipments'][0]['success'] == '1') {
			$CI->db->trans_start();
			$CI->db->trans_strict(FALSE);
			$getwallet_data = $CI->Common_model->getSingle_data('id,email,wallet_balance,allow_credit,allow_credit_limit', 'sender_master', array('id' => $single_order_info['sender_id']));
			$wallet = $getwallet_data['wallet_balance'];
			$wallet_total = ($getwallet_data['wallet_balance'] - $order_charge);

			if ($wallet_total < 500) {
				$temp_wallet_balance = ($getwallet_data['wallet_balance'] - 500);
				$temp_order_cost = $order_charge - $temp_wallet_balance;
				if ($getwallet_data['allow_credit'] == 1) {
					if ($getwallet_data['allow_credit_limit'] >= $temp_order_cost) {
						$order_amount = ($getwallet_data['allow_credit_limit'] - $temp_order_cost);
						$debit_amount = $CI->Create_singleorder_awb->debit_wallet($temp_wallet_balance, $temp_order_cost, $single_order_info['sender_id']);
						$update_order = $CI->Create_singleorder_awb->update_amount($order_charge, $order_id, $bulk);
						$delete_awb  = $CI->Create_singleorder_awb->delete_awb($awbNumber, $logisticName);
						if ($debit_amount == true) {
							$orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id);
							$log_data['order_query'] = $CI->db->last_query();
							$new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 1, $bulk, $order_id_for_api, '');
							$log_data['move_order_query'] = $new_order_data;
							$delete_awb  = $CI->Create_singleorder_awb->delete_awb($awbNumber, $logisticName);
							$log_data['awb_query'] = $CI->db->last_query();

							$fOrderId = $CI->db->insert_id;
							$data['order_id'] = $fOrderId;
							$data['airwaybill_no'] = $awbNumber;
							$data['order_status_id'] = 1;
							$data['order_type'] = $single_order_info['order_type'];
							$CI->Create_singleorder_awb->insert_barcode($data);

							$log_data['payment_status'] = "paid";
							$log_data['wallet_balance'] = $temp_wallet_balance;
							$log_data['allow_credit_limit'] = $temp_order_cost;


							$total_wallet_balance = @$getwallet_data['wallet_balance'] - str_replace(",", "", $order_charge);
							$log_data['total_wallet_balance'] = $total_wallet_balance;
							$success = 'Your Order Shipped Successfully ';
						} else {
							$error = "Amount Cant be debiteds";
							$log_data['orderError'] = $error;
						}
					} else {
						$error = "You have not sufficient wallet balance ,Recharge your wallet";
						$log_data['orderError'] = $error;
					}
				} else {
					$error = "You have not sufficient wallet balance ,Recharge your wallet";
					$log_data['orderError'] = $error;
				}
			} else {
				$log_data['payment_status'] = "paid";
				$debit_amount = $CI->Create_singleorder_awb->delete_direct_amount($wallet_total, $sender_id);
				$update_order = $CI->Create_singleorder_awb->update_amount($single_order_info['total_shipping_amount'], $order_id);
				$log_data['order_amount_query'] = $CI->db->last_query();
				if ($debit_amount == true) {
					$log_data['wallet_amount'] = $debit_amount;
					$orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
					$log_data['order_query'] = $CI->db->last_query();
					$new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 1, $bulk, $order_id_for_api, '');
					$log_data['move_order_query'] = $new_order_data;
					$delete_awb  = $CI->Create_singleorder_awb->delete_awb($awbNumber, $logisticName);
					$log_data['awb_query'] = $CI->db->last_query();

					$fOrderId = $CI->db->insert_id;
					$data['order_id'] = $fOrderId;
					$data['airwaybill_no'] = $awbNumber;
					$data['order_status_id'] = 1;
					$data['order_type'] = $single_order_info['order_type'];
					$CI->Create_singleorder_awb->insert_barcode($data);

					$success = "Order Created Successfully";
				} else {
					$error = "Amount Cant be debiteds";
					$log_data['orderError'] = $error;
				}

				$CI->db->trans_complete();

				if ($CI->db->trans_status() === FALSE) {
					# Something went wrong.
					$CI->db->trans_rollback();
					$error = "Something Went Wrong";
				} else {
					$CI->db->trans_commit();
					$success = "order Created Successfully";
				}
			}
			$log_data['process_end_time'] = date("d-m-y H:i:s");
			file_put_contents(APPPATH . 'logs/ecom_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_ecom_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		} else {
			$log_data['order_xpressbees_error'] = @$response['success_response'];
			$orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
			$log_data['order_query'] = $CI->db->last_query();
			$new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 0, $bulk, $order_id_for_api, @$response['success_response']['shipments'][0]['reason']);
			$log_data['move_order_query'] = $new_order_data;

			$deleteAwb = $CI->Common_model->delete($logisticName . '_airwaybill', array('awb_number' => $awbNumber));
			$log_data['awb_query'] = $CI->db->last_query();
			$error = $error_message;
			file_put_contents(APPPATH . 'logs/ecom_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_ecom_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		}
		if ($success) {
			$res['status'] = "1";
			$res['message'] = $success;
		} else {
			$res['status'] = "0";
			$res['message'] = $error;
		}
		return $res;
	}

	/**
	 * Wallet Deduct (Working)
	 * @return Response
	 */
	static function order_debit_wallet($orderId, $error = '', $bulk = 0, $is_awb = 0)
	{
		$CI = &get_instance();
		$CI->load->model('Create_singleorder_awb');
		$CI->load->model('Common_model');
		$CI->load->library('session');

		$logData['orderId'] = $orderId;
		$getwallet_data  = $CI->Create_singleorder_awb->get_wallet_info($orderId, $bulk);


		$awb_table = strtolower($getwallet_data['api_name']);
		$sender_id = $getwallet_data['sender_id'];
		$order_charge = 0;
		$wallet = $getwallet_data['wallet_balance'];
		$order_id_for_api = $getwallet_data['order_no'];
		$awb_no = $getwallet_data['awb_number'];


		if (!empty($error)) {
			$orderdata = $CI->Create_singleorder_awb->get_all_order_data($getwallet_data['order_id'], $bulk);
			$logData['getAll_data'] = $CI->db->last_query();
			$new_order_data = $CI->Create_singleorder_awb->move_order($getwallet_data['order_id'], $orderdata, 0, $bulk, $order_id_for_api, $error);
			$logData['order_move'] = $new_order_data;
		} else {
			if ($getwallet_data['igst_amount'] == 0.00) {
				$order_charge = floatval($getwallet_data['cgst_amount']) + floatval($getwallet_data['sgst_amount']) + floatval($getwallet_data['total_shipping_amount']);
			} else {
				$order_charge = floatval($getwallet_data['igst_amount'])  + floatval($getwallet_data['total_shipping_amount']);
			}

			$wallet_total = ($getwallet_data['wallet_balance'] - $order_charge);
			$order_id =  $getwallet_data['order_id'];
			if ($wallet_total < 500) {
				$temp_wallet_balance = ($getwallet_data['wallet_balance'] - 500);
				$temp_order_cost = $order_charge - $temp_wallet_balance;
				if ($getwallet_data['allow_credit'] == 1) {
					if ($getwallet_data['allow_credit_limit'] >= $temp_order_cost) {
						$order_amount = ($getwallet_data['allow_credit_limit'] - $temp_order_cost);
						if (!empty($awb_no)) {
							$debit_amount = $CI->Create_singleorder_awb->debit_wallet($temp_wallet_balance, $temp_order_cost, $sender_id);
							$logData['wallet_debit_query'] = $CI->db->last_query();
							$update_order = $CI->Create_singleorder_awb->update_amount($order_charge, $order_id, $bulk);
							$logData['wallet_amount'] = $CI->db->last_query();
							if ($is_awb == 1) {
								$delete_awb  = $CI->Create_singleorder_awb->delete_awb($awb_no, $awb_table);
							}
						}
						if ($debit_amount == true) {
							$orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
							$logData['getAll_data'] = $CI->db->last_query();
							$new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 1, $bulk, $order_id_for_api, '');
							$logData['order_move'] = $new_order_data;

							$fOrderId = $CI->db->insert_id();
							$data['order_id'] = $fOrderId;
							$data['airwaybill_no'] = $awb_no;
							$data['order_status_id'] = 1;
							$data['order_type'] = '0';
							$CI->Create_singleorder_awb->insert_barcode($data);
							file_put_contents(APPPATH . 'logs/zship_api/' . date("d-m-Y") . '_' . $sender_id . '_log.txt', "\n------------------------ END LOG FOR SINGLE ORDER INSERT FROM CREDIT -------------" . date("d-m-Y H:i:s") . "-----------------------\n", FILE_APPEND);

							$log_data['payment_status'] = "paid";
							$log_data['wallet_balance'] = $temp_wallet_balance;
							$log_data['allow_credit_limit'] = $temp_order_cost;


							$total_wallet_balance = @$getwallet_data->wallet_credit - str_replace(",", "", $order_charge);
							file_put_contents(APPPATH . 'logs/zship_api/' . date("d-m-Y") . '_' . $sender_id . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
							$responce['status'] = "1";
							$responce['message'] = "Order Created Successfully";
						} else {
							$responce['status'] = "0";
							$responce['message'] = "Amount Cant be debited";
						}
						//WALLET MATHI $temp_wallet_balance
						//CREDIT MATHI $temp_order_cost
					} else {
						$responce['status'] = "0";
						$responce['message'] = "You have not sufficient wallet balance ,Recharge your wallet";
					}
				} else {
					$responce['status'] = "0";
					$responce['message'] = "You have not sufficient wallet balance ,Recharge your wallet";
				}
			} else {
				$log_data['payment_status'] = "paid";
				file_put_contents(APPPATH . 'logs/zship_api/' . date("d-m-Y") . '_' . $sender_id . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
				file_put_contents(APPPATH . 'logs/zship_api/' . date("d-m-Y") . '_' . $sender_id . '_log.txt', "\n---------------------- START LOG FOR SINGLE ORDER INSERT FROM wallet -------------" . date("d-m-Y H:i:s") . "-----------------------\n", FILE_APPEND);
				if (!empty($awb_no)) {
					// $delete_awb  = $CI->Create_singleorder_awb->delete_awb($awb_no, $awb_table);
					$debit_amount = $CI->Create_singleorder_awb->delete_direct_amount($wallet_total, $sender_id);
					$update_order = $CI->Create_singleorder_awb->update_amount($order_charge, $order_id);
				}
				if ($debit_amount == true) {
					$log_data['wallet_amount'] = $debit_amount;
					file_put_contents(APPPATH . 'logs/zship_api/' . date("d-m-Y") . '_' . $sender_id . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);

					$responce['status'] = "1";
					$responce['message'] = "Order Created Successfully";
					$orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
					$new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 1, $bulk, $order_id_for_api, '');
					// if (!empty($awb_no)) {
					$fOrderId = $CI->db->insert_id;
					$data['order_id'] = $fOrderId;
					$data['airwaybill_no'] = $awb_no;
					$data['order_status_id'] = 1;
					$data['order_type'] = '0';
					$CI->Create_singleorder_awb->insert_barcode($data);
					// }
					// return $responce;
				} else {
					$responce['status'] = "0";
					$responce['message'] = "Amount Cant be debited";
					// return $responce;
				}

				$CI->db->trans_complete();

				if ($CI->db->trans_status() === FALSE) {
					# Something went wrong.
					$CI->db->trans_rollback();
					$responce['status'] = "0";
					$responce['message'] = "Something Went Wrong";
					// return $responce;
				} else {
					$CI->db->trans_commit();
					$responce['status'] = "1";
					$responce['message'] = "order Created Successfully";
					// return $responce;
				}
			}
		}
		file_put_contents(APPPATH . 'logs/order_wallet/' . date("d-m-Y") . '_' . $sender_id . '_order_wallet_log.txt', "\n" . print_r($logData, true), FILE_APPEND);
		// return $responce;
	}
}
