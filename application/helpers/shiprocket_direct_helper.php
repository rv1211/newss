<?php
class shiprocket_direct
{
	/**
	 * delhivery API Order Create
	 * @return Response
	 */
	public static function create_order($order_id, $bulk = 0, $is_express = 0)
	{


		$log_data['process_start_time'] = date("d-m-y H:i:s");
		$error = $success = "";
		$CI = &get_instance();
		$CI->load->model('Create_singleorder_awb');
		$CI->load->model('Common_model');
		$CI->load->helper('Wallet');
		$CI->load->library('session');
		$path = APPPATH . 'logs/shiprocket_order/';
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}

		$awbNumber = '';
		switch ($bulk) {
			case '1':
				$temp_table_name = 'temp_order_master';
				$shipment_type = 'FORWARD';
				$single_order_info = $CI->Create_singleorder_awb->get_order_data($order_id, $temp_table_name);
				// $order_id_for_api =  CUSTOM::remove_special_characters_and_extra_space($single_order_info["order_no"]);
				$isBulk = "B";
				break;
			default:
				$temp_table_name = 'temp_forward_order_master';
				$shipment_type = 'FORWARD';
				$single_order_info = $CI->Create_singleorder_awb->get_order_data($order_id, $temp_table_name);
				//$order_id_for_api =  CUSTOM::remove_special_characters_and_extra_space($single_order_info["order_no"]);
				$isBulk = "S";
				break;
		}
		if ($single_order_info["order_no"] == '') {
			$order_id_for_api =  'SSL' . CUSTOM::remove_special_characters_and_extra_space(str_replace("_", "-", $single_order_info["id"] . '-' . rand(001, 999) . $isBulk));
		} else {
			$order_id_for_api =  CUSTOM::remove_special_characters_and_extra_space(str_replace("_", "-", $single_order_info["order_no"]));
		}



		// $log_data['order_data_result_from_order_id'] = $order_id;
		// $error = $success = $log_id = "";
		// $kyc_Detail = $CI->Common_model->getSingle_data('id, gst_no', "kyc_verification_master", array('sender_id' => $single_order_info['sender_id']));
		// $sender_Detail = $CI->Common_model->getSingle_data('name', "sender_master", array('id' => $single_order_info['sender_id']));
		// $logistic_name = $CI->Common_model->getSingle_data('logistic_name, api_name', 'logistic_master', array('id' => $single_order_info['logistic_id']));
		// $logisticName = str_replace(' ', '_', strtolower(trim($logistic_name['api_name'])));

		// if ($single_order_info['awb_number'] != '') {
		// 	$awbNumber = $single_order_info['awb_number'];
		// } else {
		// 	$air_waybill_no_data = $CI->Common_model->getSingle_data('id, awb_number', $logisticName . '_airwaybill', array('is_used' => '1', 'type' => $single_order_info['order_type'], 'for_what' => '2'));
		// 	$awbNumber = $air_waybill_no_data['awb_number'];
		// }

		if (empty($single_order_info['city'])) {
			$receiverAdd = $CI->Common_model->getSingle_data('city,state', 'pincode_master', array('pincode' => @$single_order_info['pincode']));
			$single_order_info['city'] = @$receiverAdd['city'];
			$single_order_info['state'] = @$receiverAdd['state'];
		}
		if (empty($single_order_info['pickup_city'])) {
			$pickupAdd = $CI->Common_model->getSingle_data('city,state', 'pincode_master', array('pincode' => @$single_order_info['pickup_pincode']));
			$single_order_info['pickup_city'] = @$pickupAdd['city'];
			$single_order_info['pickup_state'] = @$pickupAdd['state'];
		}

		$customer_address = $single_order_info['address_1'];
		if (@$single_order_info['address_2'] != "") {
			$customer_address .= ', ' . $single_order_info['address_2'];
		}


		if ($single_order_info['order_type'] == '0') {
			$typeName = 'Prepaid';
			$cod_amount = '0';
		} else {
			$typeName = 'COD';
			$cod_amount = $single_order_info['cod_amount'];
		}


		if ($single_order_info['igst_amount'] == '' || $single_order_info['igst_amount'] == '0.00') {
			$order_charge = floatval($single_order_info['total_shipping_amount']) + floatval($single_order_info['sgst_amount']) + floatval($single_order_info['cgst_amount']);
			$taxVal = floatval($single_order_info['sgst_amount']) + floatval($single_order_info['cgst_amount']);
			$cgst = @$single_order_info['cgst_amount'];
			$sgst = @$single_order_info['sgst_amount'];
			$igst = '0.00';
		} else {
			$order_charge = (floatval($single_order_info['total_shipping_amount']) + floatval($single_order_info['igst_amount']));
			$taxVal = floatval($single_order_info['igst_amount']);
			$cgst = '0.00';
			$sgst = '0.00';
			$igst = @$single_order_info['igst_amount'];
		}


		// if ($awbNumber != '') {
		$product_sku = @$single_order_info['product_sku'] != '' ? @$single_order_info['product_sku'] : @$single_order_info['product_name'];
		$walletSufficient = API::check_wallet($single_order_info['sender_id'], $order_charge);
		// dd($walletSufficient);

		if (@$single_order_info['is_return_address_same_as_pickup'] == '0' && $bulk == 0) {
			$returnAddress = $CI->Common_model->getSingle_data('*', 'return_address', array('id' => $single_order_info['return_address_id']));
			$return_name = CUSTOM::remove_special_characters_and_extra_space(@$returnAddress['name']);
			$return_address1 = @$returnAddress['address_1'];
			$return_address2 = @$returnAddress['address_2'];
			if (empty($returnAddress['city'])) {
				$return_city_db = $CI->Common_model->getSingle_data('city,state', 'pincode_master', array('pincode' => @$returnAddress['pincode']));
				$return_city = @$return_city_db['city'];
				$return_state = @$return_city_db['state'];
			} else {
				$return_city = @$returnAddress['city'];
				$return_state = @$returnAddress['state'];
			}
			$return_city = @$returnAddress['city'];
			$return_state = @$returnAddress['state'];
			$return_pincode = @$returnAddress['pincode'];
			$return_phone = @$returnAddress['mobile_no'];
		} else {
			$return_name = CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_warehouseName']);
			$return_address1 = @$single_order_info['pickup_address_1'];
			$return_address2 = @$single_order_info['pickup_address_2'];
			$return_address = $return_address1 . " " . $return_address2;
			$return_city = @$single_order_info['pickup_city'];
			$return_state = @$single_order_info['pickup_state'];
			$return_pincode = @$single_order_info['pickup_pincode'];
			$return_phone = @$single_order_info['pickup_contactNo'];
		}

		// $pickupAdd	= $single_order_info['pickup_address_1'];
		// if (!empty($single_order_info['pickup_address_2'])) {
		// 	$pickupAdd .= " " . $single_order_info['pickup_address_2'];
		// }

		// Pickup Address Create using API

		$CI->load->helper('curlrequest');
		$token = $CI->Common_model->getSingle_data('*', 'zship_token_master');
		$isPickup = 1;
		if (@$single_order_info['shiprocket_pickup_id'] == '' || @$single_order_info['shiprocket_pickup_id'] == null) {
			file_put_contents(APPPATH . 'logs/shiprocket_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_shiprocket_order_' . $single_order_info['sender_id'] . '_log.txt', "\n ------ Start Pickup Address API --------------", FILE_APPEND);
			$pickup_address_body = '{
				"pickup_location": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_warehouseName']) . '",
				"name": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_contactName']) . '",
				"email": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_email']) . '",
				"phone": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_contactNo']) . '",
				"address": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_address_1']) . '",
				"address_2": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_address_2']) . '",
				"city": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_city']) . '",
				"state":"' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_state']) . '",
				"country": "India",
				"pin_code": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_pincode']) . '"
			}';

			$log_data_pick['pickup_address_body'] = $pickup_address_body;

			$response_pickup = CUSTOM::curl_request('application/json', $token['shiprocket_token'], $CI->config->item('SHIPROCKET_PICKUP_ADDRESS_URL'), $pickup_address_body, "POST", "", "", "", "2");
			$log_data_pick['pickup_response'] = $response_pickup;

			if (@$response_pickup['error_response'] != '') {
				$isPickup = 0;
				$res['error'] = "cURL Error #:" . str_replace('ShipRocket', '', $response_pickup['error_response']);
				$log_data_pick['pickup_address_curl_error'] = str_replace('ShipRocket', '', $response_pickup['error_response']);
				$error = $res['error'];
			} else {
				$log_data_pick['pickup_address_response'] = $response_pickup['success_response'];
				if (!empty($response_pickup['success_response']['success'])) {

					$pickData['shiprocket_pickup_id'] = $response_pickup['success_response']['pickup_id'];

					$pick_query = $CI->Common_model->update($pickData, 'sender_address_master', array('id' => @$single_order_info['pickup_address_id']));
					$log_data['pickup_query'] = $CI->db->last_query();
					$log_data_pick['success'] = 'Pickup Address Add Successfully';
				} else if ($response_pickup['success_response']['errors']['pickup_location']) {
					$pickupError = $response_pickup['success_response']['errors']['pickup_location'];
					if (in_array('The pickup location has already been taken.', $pickupError)) {
						$log_data_pick['success'] = 'Pickup Address already exist';
					} else {
						$log_data_pick['error'] = str_replace('ShipRocket', '', $pickupError);
						$error = str_replace('ShipRocket', '', $pickupError);
						$isPickup = 0;
					}
				} else {
					$isPickup = 0;
					$log_data_pick['error'] = str_replace('ShipRocket', '', $response_pickup['success_response']['message']);
					$error = str_replace('ShipRocket', '', $response_pickup['success_response']['message']);
				}
			}
			file_put_contents(APPPATH . 'logs/shiprocket_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_shiprocket_order_' . $single_order_info['sender_id'] . '_log.txt', "\n" . print_r($log_data_pick, true) . "\n ------ End Pickup Address API --------------", FILE_APPEND);
		}


		if ($isPickup != 0) {
			$body = '{
				"order_id": "' . $order_id_for_api . '",
				"order_date": "' . date('Y-m-d H:i', strtotime(@$single_order_info['created_date'])) . '",
				"pickup_location": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_warehouseName']) . '",
				"channel_id": "' . $CI->config->item('SHIPROCKET_CHANNEL_ID') . '",
				"comment": "",
				"billing_customer_name": "' . $return_name . '",
				"billing_last_name": "",
				"billing_address": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_address1) . '",
				"billing_address_2": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_address2) . '",
				"billing_city": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_city) . '",
				"billing_pincode": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_pincode) . '",
				"billing_state": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_state) . '",
				"billing_country": "India",
				"billing_email": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_email']) . '",
				"billing_phone": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_phone) . '",
				"shipping_is_billing": true,
				"shipping_customer_name": "",
				"shipping_last_name": "",
				"shipping_address": "",
				"shipping_address_2": "",
				"shipping_city": "",
				"shipping_pincode": "",
				"shipping_country": "",
				"shipping_state": "",
				"shipping_email": "",
				"shipping_phone": "",
				"order_items": [
					{
					"name": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['product_name']) . '",
					"sku": "' . CUSTOM::remove_special_characters_and_extra_space(@$product_sku) . '",
					"units": ' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['product_quantity']) . ',
					"selling_price": "' . CUSTOM::remove_special_characters_and_extra_space(@$order_charge) . '",
					"discount": "",
					"tax": "",
					"hsn": ""
					}
				],
				"payment_method": "' . $typeName . '",
				"shipping_charges": 0,
				"giftwrap_charges": 0,
				"transaction_charges": 0,
				"total_discount": 0,
				"sub_total": ' . CUSTOM::remove_special_characters_and_extra_space(@$order_charge) . ',
				"length": ' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['length']) . ',
				"breadth": ' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['width']) . ',
				"height": ' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['height']) . ',
				"weight": ' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['physical_weight']) . '
			}';

			$log_data['order_shiproket_body'] = $body;

			if ($walletSufficient == 1) {
				$response = CUSTOM::curl_request('application/json', $token['shiprocket_token'], $CI->config->item('SHIPROCKET_ORDER_API_URL'), $body, "POST", "", "", "", "2");

				$log_data['order_delhivery_curl_response'] = $response;

				file_put_contents(APPPATH . 'logs/shiprocket_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_shiprocket_order_' . $single_order_info['sender_id'] . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
				// dd($response);
				if (!empty($response['success_response']) && ($response['success_response']['status_code'] == 1 || $response['success_response']['status_code'] == '1')) {
					// Success
					if ($response['success_response']['awb_code'] == '') {
						$awb_body = '{
						"shipment_id": "' . $response['success_response']['shipment_id'] . '",
						"courier_id": "' . @$single_order_info['courier_id'] . '"
					}';
						$log_data1['awb_body'] = $awb_body;
						$awb_response = CUSTOM::curl_request('application/json', $token['shiprocket_token'], $CI->config->item('SHIPROCKET_GENERATE_AWB_URL'), $awb_body, "POST", "", "", "", "2");
						$log_data1['awb_rwsponse'] = $awb_response;
						if (!empty($awb_response['success_response']) && ($awb_response['success_response']['awb_assign_status'] == '1' || $awb_response['success_response']['awb_assign_status'] == 1)) {
							$awbNumber = $awb_response['success_response']['response']['data']['awb_code'];
							$success = "success From API.";
							$log_data1['Status'] = $success;
							$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, '', '0', '', '', $response['success_response']['order_id'], $response['success_response']['shipment_id']);
							$log_data1['orderResponse'] = $orderResponse;
							file_put_contents(APPPATH . 'logs/shiprocket_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_shiprocket_order_' . $single_order_info['sender_id'] . '_log.txt', "\n" . print_r($log_data1, true), FILE_APPEND);
						} else {
							$log_data1['Status'] = str_replace('ShipRocket', '', @$awb_response['success_response']['message']);
							$errorMsg = str_replace('ShipRocket', '', @$awb_response['success_response']['message']);
							$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, $errorMsg, '0');
							$log_data1['orderResponse'] = $orderResponse;
							file_put_contents(APPPATH . 'logs/shiprocket_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_shiprocket_order_' . $single_order_info['sender_id'] . '_log.txt', "\n" . print_r($log_data1, true), FILE_APPEND);
							$error = "Your Order Failed to Shipped due to error." . @$errorMsg;
						}
					} else {
						$awbNumber = $response['success_response']['awb_code'];
						$success = "success From API.";
						$log_data1['Status'] = $success;
						$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, '', '0', '', '', $response['success_response']['order_id'], $response['success_response']['shipment_id']);
						$log_data1['orderResponse'] = $orderResponse;
						file_put_contents(APPPATH . 'logs/shiprocket_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_shiprocket_order_' . $single_order_info['sender_id'] . '_log.txt', "\n" . print_r($log_data1, true), FILE_APPEND);
					}
				} else {
					// Error
					if (@$response['error_response'] != '') {
						$log_data1['Status'] = str_replace('ShipRocket', '', @$response['error_response']);
						$errorMsg = str_replace('ShipRocket', '', @$response['error_response']);
					} else if (@$response['success_response']['status_code'] != '1') {
						$log_data1['Status'] = str_replace('ShipRocket', '', @$response['success_response']['message']);
						$errorMsg = str_replace('ShipRocket', '', @$response['success_response']['message']);
					} else {
						$log_data1['Status'] = "Error from Curl.";
						$errorMsg = 'No Response from Curl';
					}
					$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, $errorMsg, '0');
					$log_data1['orderResponse'] = $orderResponse;
					file_put_contents(APPPATH . 'logs/shiprocket_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_shiprocket_order_' . $single_order_info['sender_id'] . '_log.txt', "\n" . print_r($log_data1, true), FILE_APPEND);
					$error = "Your Order Failed to Shipped due to error." . @$errorMsg;
				}
			} else {
				$log_data1['Status'] = "You have not sufficient wallet balance,Recharge your wallet";
				$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, "You have not sufficient wallet balance,Recharge your wallet", '0');
				$log_data1['orderResponse'] = $orderResponse;
				file_put_contents(APPPATH . 'logs/shiprocket_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_shiprocket_order_' . $single_order_info['sender_id'] . '_log.txt', "\n" . print_r($log_data1, true), FILE_APPEND);
				$error = "You have not sufficient wallet balance,Recharge your wallet";
			}
		} else {
			$log_data1['Status'] = $error;
			$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, $error, '0');
			$log_data1['orderResponse'] = $orderResponse;
			file_put_contents(APPPATH . 'logs/shiprocket_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_shiprocket_order_' . $single_order_info['sender_id'] . '_log.txt', "\n" . print_r($log_data1, true), FILE_APPEND);
		}

		if ($success) {
			$res['status'] = "1";
			$res['message'] = $success;
			$res['AWBNo'] = $awbNumber;
		} else {
			$res['status'] = "0";
			$res['message'] = $error;
		}
		return $res;
	}

	static function cancel_order($order_id, $is_express = 0)
	{
		file_put_contents(APPPATH . 'logs/shiprocket_order/' . date("d-m-Y") . '_shiprocket_cancel_order_log.txt', "\n--------------------- Start Cancel Order ---------------------\n", FILE_APPEND);

		$CI = &get_instance();
		$CI->load->model('Create_singleorder_awb');
		$CI->load->model('Common_model');
		$CI->load->library('session');

		$log_data = array();
		$order_detail = $CI->Common_model->getSingleRowArray(array('id' => $order_id), 'id, shipr_order_id', 'forward_order_master');
		$token = $CI->Common_model->getSingle_data('*', 'zship_token_master');
		// Cancel Order code start
		$cancel_order_body = '{
				"ids":[' . $order_detail['shipr_order_id'] . ']
			}';
		$log_data['cancel_order_body'] = $cancel_order_body;
		$cancel_order_response = CUSTOM::curl_request('application/json', $token['shiprocket_token'], $CI->config->item('SHIPROCKET_CANCEL_ORDER_URL'), $cancel_order_body, "POST", "", "", "", "2");

		$log_data['cancel_order_response'] = $cancel_order_response;
		file_put_contents(APPPATH . 'logs/shiprocket_order/' . date("d-m-Y") . '_shiprocket_cancel_order_log.txt', print_r($log_data, true) . "\n--------------------- End Cancel Order ---------------------\n", FILE_APPEND);
		return 1;
	}
}
