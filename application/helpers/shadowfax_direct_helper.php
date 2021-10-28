<?php
class shadowfax_direct
{
	/**
	 * Shadowfax API Order Create
	 * @return Response
	 */
	public static function create_order($order_id, $bulk = 0)
	{

		$log_data['process_start_time'] = date("d-m-y H:i:s");
		$error = $success = "";


		$CI = &get_instance();
		$CI->load->model('Create_singleorder_awb');
		$CI->load->model('Common_model');
		$CI->load->helper('Wallet');
		$CI->load->library('session');

		$path = APPPATH . 'logs/shadowfax_order/';
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
		// lq();
		// dd($single_order_info);

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
			$return_city = @$single_order_info['pickup_city'];
			$return_state = @$single_order_info['pickup_state'];
			$return_pincode = @$single_order_info['pickup_pincode'];
			$return_phone = @$single_order_info['pickup_contactNo'];
		}
		$body = '{
						"order_details": {
							"client_order_id": "' . @$order_id_for_api . '",
							"actual_weight": "' . @$single_order_info['physical_weight'] . '",
							"volumetric_weight": "' . @$single_order_info['volumetric_weight'] . '",
							"product_value": "' . @$single_order_info['product_value'] . '",
							"payment_mode": "' . CUSTOM::remove_special_characters_and_extra_space(@$typeName) . '",
							"cod_amount": "' . @$cod_amount . '",
							"total_amount": "' . @$order_charge . '"
						},
						"customer_details": {
							"name": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['name']) . '",
							"contact": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['mobile_no']) . '",
							"address_line_1": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['address_1']) . '",
							"address_line_2": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['address_2']) . '",
							"city": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['city']) . '",
							"state": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['state']) . '",
							"pincode": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pincode']) . '"
						},
						"pickup_details": {
							"name": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_contactName']) . '",
							"contact": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_contactNo']) . '",
							"address_line_1": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_address_1']) . '",
							"address_line_2": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_address_2']) . '",
							"city": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_city']) . '",
							"state": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_state']) . '",
							"pincode": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_pincode']) . '"
						},
						"rts_details": {
							"name": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_name) . '",
							"contact": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_phone) . '",
							"address_line_1": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_address1) . '",
							"address_line_2": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_address2) . '",
							"city": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_city) . '",
							"state": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_state) . '",
							"pincode": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_pincode) . '"
						},
						"product_details": [
							{
								"sku_name": "' . CUSTOM::remove_special_characters_and_extra_space(@$product_sku) . '",
								"price": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['product_value']) . '",
								"taxes": {
									"cgst": "' . @$cgst . '",
									"sgst": "' . @$sgst . '",
									"igst": "' . @$igst . '",
									"total_tax": "' . @$taxVal . '"
								}
							}
						]
					}';
		$log_data['order_shadowfax_body'] = $body;


		if ($walletSufficient == 1) {
			$response = CUSTOM::curl_request('application/json', $CI->config->item('SHADOWFAX_TOKEN'), $CI->config->item('SHADOWFAX_ORDER_URL'), $body, "POST", "", "", "", "1");
			$log_data['order_shadowfax_curl_response'] = $response;

			file_put_contents(APPPATH . 'logs/shadowfax_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_shadowfax_order_' . $single_order_info['sender_id'] . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);

			if (strcmp($response['success_response']['message'], "Success") == 0  && !empty($response['success_response']['data'])) {
				$log_data1['Status'] = "success From API.";
				$success = "Order Created Successfully";
				$awbNumber = $response['success_response']['data']['awb_number'];
				$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, '', '0');
			} else {
				if (@$response['error_response'] != '') {
					$log_data1['Status'] = "Error from Curl.";
					$errorMsg = @$response['error_response'];
				} else if (@$response['success_response']['message'] != '') {
					$log_data1['Status'] = "Error from Order.";
					$errorMsg = @$response['success_response']['message'];
				} else {
					$log_data1['Status'] = "Error from Curl.";
					$errorMsg = 'No Response from Curl';
				}
				$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, $errorMsg, '0');
				$log_data1['orderResponse'] = $orderResponse;
				file_put_contents(APPPATH . 'logs/shadowfax_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_shadowfax_order_' . $single_order_info['sender_id'] . '_log.txt', "\n" . print_r($log_data1, true), FILE_APPEND);
				$error = "Your Order Failed to Shipped due to error." . @$errorMsg;
			}
		} else {
			$log_data1['Status'] = "You have not sufficient wallet balance,Recharge your wallet";
			$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, "You have not sufficient wallet balance,Recharge your wallet", '0');
			$log_data1['orderResponse'] = $orderResponse;
			file_put_contents(APPPATH . 'logs/shadowfax_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_shadowfax_order_' . $single_order_info['sender_id'] . '_log.txt', "\n" . print_r($log_data1, true), FILE_APPEND);
			$error = "You have not sufficient wallet balance,Recharge your wallet";
		}
		// } else {
		// 	$log_data1['Status'] = "Waybill not available";
		// 	$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, "Waybill not available");
		// 	$log_data1['orderResponse'] = $orderResponse;
		// 	file_put_contents(APPPATH . 'logs/shadowfax_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_shadowfax_order_' . $single_order_info['sender_id'] . '_log.txt', "\n" . print_r($log_data1, true), FILE_APPEND);
		// 	$error = "Waybill not available";
		// }
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

	static function cancel_order($order_id)
	{
		file_put_contents(APPPATH . 'logs/shadowfax_order/' . date("d-m-Y") . '_shadowfax_cancel_order_log.txt', "\n", FILE_APPEND);

		$CI = &get_instance();
		$CI->load->model('Create_singleorder_awb');
		$CI->load->model('Common_model');
		$CI->load->library('session');

		$log_data = array();
		$order_detail = $CI->Common_model->getSingleRowArray(array('id' => $order_id), 'id, awb_number', 'forward_order_master');
		// dd($order_detail);
		// Cancel Order code start
		$cancel_order_body = ' {
				"request_id":"' . $order_detail['awb_number'] . '",
				"cancel_remarks":"Request cancelled by customer"
			}';
		// dd($cancel_order_body);
		$log_data['cancel_order_body'] = $cancel_order_body;
		$cancel_order_response = CUSTOM::curl_request('application/json', $CI->config->item('SHADOWFAX_TOKEN'), $CI->config->item('SHADOWFAX_CANCEL_ORDER_URL'), $cancel_order_body, "POST", "", "", "", "1");
		$log_data['cancel_order_body'] = $cancel_order_body;
		$log_data['cancel_order_response'] = $cancel_order_response;
		file_put_contents(APPPATH . 'logs/shadowfax_order/' . date("d-m-Y") . '_shadowfax_cancel_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		return 1;
	}
}
