<?php
class ecom_direct
{
	/**
	 * Ecom API Order Create
	 * @return Response
	 */
	static function ecom_order($order_id, $bulk = 0)
	{
		$CI = &get_instance();
		$CI->load->model('Create_singleorder_awb');
		$CI->load->model('Common_model');
		$CI->load->library('session');
		if ($bulk == 1) {
			$single_order_info = $CI->Create_singleorder_awb->get_multiple_order_list_bulk($order_id);
			$temp_table_name = 'temp_order_master';
			$isBulk = 'B';
		} else {
			$single_order_info = $CI->Create_singleorder_awb->get_multiple_order_list($order_id);
			$temp_table_name = 'temp_forward_order_master';
			$isBulk = 'S';
		}



		$log_data['process_start_time'] = date("d-m-y H:i:s");
		$error = $success = $log_id = "";
		$kyc_Detail = $CI->Common_model->getSingle_data('id, gst_no', "kyc_verification_master", array('sender_id' => $single_order_info['sender_id']));
		$sender_Detail = $CI->Common_model->getSingle_data('name', "sender_master", array('id' => $single_order_info['sender_id']));
		$log_data['order_data_result_from_order_id'] = $order_id;
		$logistic_name = $CI->Common_model->getSingle_data('logistic_name, api_name', 'logistic_master', array('id' => $single_order_info['logistic_id']));
		$logisticName = str_replace(' ', '_', strtolower(trim($logistic_name['api_name'])));

		if ($single_order_info['awb_number'] != '') {
			$awbNumber = $single_order_info['awb_number'];
		} else {
			if ($single_order_info['order_type'] == 0 || $single_order_info['order_type'] == '0') {
				$type = '2';
			} else {
				$type = '1';
			}

			$air_waybill_no_data = $CI->Common_model->getSingle_data('id, awb_number', $logisticName . '_airwaybill', array('is_used' => '1', 'type' => $type, 'for_what' => '2'));
			$log_data['query'] = $CI->db->last_query();
			// 			dd($log_data);
			$awbNumber = $air_waybill_no_data['awb_number'];
		}




		$product = $single_order_info['order_type'] == '0' ? 'PPD' : 'COD';

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

		if ($single_order_info["order_no"] == '') {
			$order_id_for_api =  'SSL' . CUSTOM::remove_special_characters_and_extra_space(str_replace("_", "-", $single_order_info["id"] . '-' . rand(001, 999) . $isBulk));
		} else {
			$order_id_for_api =  CUSTOM::remove_special_characters_and_extra_space(str_replace("_", "-", $single_order_info["order_no"]));
		}

		if ($awbNumber != '') {
			$walletSufficient = API::check_wallet($single_order_info['sender_id'], $order_charge);

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
				$return_pincode = @$single_order_info['pickup_pincode'];
				$return_phone = @$single_order_info['pickup_contactNo'];
			}
			$body = '[{
						"AWB_NUMBER": "' . @$awbNumber . '",
						"ORDER_NUMBER": "' . $order_id_for_api . '",
						"PRODUCT": "' . CUSTOM::remove_special_characters_and_extra_space(@$product) . '",
						"CONSIGNEE":"' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['name']) . '",
						"CONSIGNEE_ADDRESS1": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['address_1']) . '",
						"CONSIGNEE_ADDRESS2": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['address_2']) . '",
						"CONSIGNEE_ADDRESS3": "",
						"DESTINATION_CITY": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['city']) . '",
						"PINCODE": "' . @$single_order_info['pincode'] . '",
						"STATE": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['state']) . '",
						"MOBILE": "' . @$single_order_info['mobile_no'] . '",
						"TELEPHONE": "",
						"ITEM_DESCRIPTION": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['product_name']) . '",
						"PIECES": "' . @$single_order_info['product_quantity'] . '",
						"COLLECTABLE_VALUE": ' . @$single_order_info['cod_amount'] . ',
						"DECLARED_VALUE": ' . $order_charge . ',
						"ACTUAL_WEIGHT": ' . @$single_order_info['physical_weight'] . ',
						"VOLUMETRIC_WEIGHT": ' . @$single_order_info['volumetric_weight'] . ',
						"LENGTH": ' . @$single_order_info['length'] . ',
						"BREADTH": ' . @$single_order_info['width'] . ',
						"HEIGHT": ' . @$single_order_info['height'] . ',
						"PICKUP_NAME": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_warehouseName']) . '",
						"PICKUP_ADDRESS_LINE1": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_address_1']) . '",
						"PICKUP_ADDRESS_LINE2": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_address_2']) . '",
						"PICKUP_PINCODE": "' . @$single_order_info['pickup_pincode'] . '",
						"PICKUP_PHONE": "' . @$single_order_info['pickup_contactNo'] . '",
						"PICKUP_MOBILE": "' . @$single_order_info['pickup_contactNo'] . '",
						"RETURN_NAME": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_name) . '",
						"RETURN_ADDRESS_LINE1": "' . CUSTOM::remove_special_characters_and_extra_space($return_address1) . '",
						"RETURN_ADDRESS_LINE2": "' . CUSTOM::remove_special_characters_and_extra_space($return_address2) . '",
						"RETURN_PINCODE": "' . $return_pincode . '",
						"RETURN_PHONE": "' . $return_phone . '",
						"RETURN_MOBILE": "' . $return_phone . '",
						"DG_SHIPMENT": "false",
						"ADDITIONAL_INFORMATION": {
							"DELIVERY_TYPE": "",
							"SELLER_TIN": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['product_name']) . '",
							"INVOICE_NUMBER": "IN-' . CUSTOM::remove_special_characters_and_extra_space($single_order_info["order_no"]) . '",
							"INVOICE_DATE": "' . date('d-m-Y', strtotime($single_order_info['created_date'])) . '",
							"PICKUP_TYPE": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_warehouseName']) . '",
							"SELLER_GSTIN": "' . @$kyc_Detail['gst_no'] . '",
							"GST_HSN": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['product_sku']) . '",
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

			if ($walletSufficient == 1) {
				$request_body = 'username=' . urlencode($CI->config->item('ECOM_API_USER')) . '&password=' . urlencode($CI->config->item('ECOM_API_PASS')) . '&json_input=' . urlencode($body);
				$response = CUSTOM::curl_request('application/json', '', $CI->config->item('ECOM_API_URL'), $request_body, "POST", '');
				$log_data['order_ecom_curl_response'] = $response;
				file_put_contents(APPPATH . 'logs/ecom_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_ecom_order_' . $single_order_info['sender_id'] . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
				if (@$response['success_response']['shipments'][0]['success'] == 1 || @$response['success_response']['shipments'][0]['success'] == '1') {
					// Success Response
					$log_data1['Status'] = "success From API.";
					$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, '', '1');
					$log_data1['orderResponse'] = $orderResponse;
					file_put_contents(APPPATH . 'logs/ecom_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_ecom_order_' . $single_order_info['sender_id'] . '_log.txt', "\n" . print_r($log_data1, true), FILE_APPEND);
					$success = 'Your Order Shipped Successfully ';
				} else {
					if (@$response['error_response'] != '') {
						$log_data1['Status'] = "Error from Curl.";
						$errorMsg = @$response['error_response'];
					} else if (@$response['success_response']['shipments'][0]['reason'] != '') {
						$log_data1['Status'] = "Error from Order.";
						$errorMsg = @$response['success_response']['shipments'][0]['reason'];
					} else {
						$log_data1['Status'] = "Error from Curl.";
						$errorMsg = 'No Response from Curl';
					}
					$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, $errorMsg, '1');
					$log_data1['orderResponse'] = $orderResponse;
					file_put_contents(APPPATH . 'logs/ecom_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_ecom_order_' . $single_order_info['sender_id'] . '_log.txt', "\n" . print_r($log_data1, true), FILE_APPEND);
					$error = "Your Order Failed to Shipped due to error." . @$errorMsg;
				}
			} else {
				$log_data1['Status'] = "You have not sufficient wallet balance,Recharge your wallet";
				$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, "You have not sufficient wallet balance,Recharge your wallet", '1');
				$log_data1['orderResponse'] = $orderResponse;
				file_put_contents(APPPATH . 'logs/ecom_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_ecom_order_' . $single_order_info['sender_id'] . '_log.txt', "\n" . print_r($log_data1, true), FILE_APPEND);
				$error = "You have not sufficient wallet balance,Recharge your wallet";
			}
		} else {
			$log_data1['Status'] = "Waybill not available";
			$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, "Waybill not available");
			$log_data1['orderResponse'] = $orderResponse;
			file_put_contents(APPPATH . 'logs/ecom_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_ecom_order_' . $single_order_info['sender_id'] . '_log.txt', "\n" . print_r($log_data1, true), FILE_APPEND);
			$error = "Waybill not available";
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

	static function cancel_order($order_id)
	{
		file_put_contents(APPPATH . 'logs/ecom_order/' . date("d-m-Y") . '_ecom_cancel_order_log.txt', "\n", FILE_APPEND);

		$CI = &get_instance();
		$CI->load->model('Create_singleorder_awb');
		$CI->load->model('Common_model');
		$CI->load->library('session');

		$log_data = array();
		$order_detail = $CI->Common_model->getSingleRowArray(array('id' => $order_id), 'id, awb_number', 'forward_order_master');

		// Cancel Order code start
		$request_body = 'username=' . urlencode($CI->config->item('ECOM_API_USER')) . '&password=' . urlencode($CI->config->item('ECOM_API_PASS')) . '&awbs=' . urlencode($order_detail['awb_number']);
		$log_data['order'] = $order_detail;
		$curl_response = CUSTOM::curl_request('application/json', '', $CI->config->item('ECOM_CANCEL_ORDER'), $request_body, "POST", '');
		$log_data['cancel_order_body'] = $request_body;
		$log_data['cancel_order_response'] = $curl_response;
		file_put_contents(APPPATH . 'logs/ecom_order/' . date("d-m-Y") . '_ecom_cancel_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		return 1;
	}
}
