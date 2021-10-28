<?php
class ekart_direct
{
	/**
	 * Ecart API Order Create
	 * @return Response
	 */

	static function ekart_order($order_id, $bulk = 0)
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

		if ($single_order_info["order_no"] == '') {
			$order_id_for_api =  'SSL' . CUSTOM::remove_special_characters_and_extra_space(str_replace("_", "-", $single_order_info["id"] . '-' . rand(001, 999) . $isBulk));
		} else {
			$order_id_for_api =  CUSTOM::remove_special_characters_and_extra_space(str_replace("_", "-", $single_order_info["order_no"]));
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

		$walletSufficient = 0;
		$getwallet_data = $CI->Common_model->getSingle_data('id,email,wallet_balance,allow_credit,allow_credit_limit', 'sender_master', array('id' => $single_order_info['sender_id']));

		$body = '{
					"client_name": "' . $CI->config->item('ECART_MERCHANT_CODE') . '",
					"services": [
						{
							"service_code": "REGULAR",
							"service_details": [
								{
									"service_leg": "FORWARD",
									"service_data": {
										"vendor_name":"' . CUSTOM::remove_special_characters_and_extra_space(@$sender_Detail['name']) . '",
										"amount_to_collect": ' . @$single_order_info['total_shipping_amount'] . ',
										"delivery_type": "SMALL",
										"source": {
											"address": {
												"first_name": "' .  CUSTOM::remove_special_characters_and_extra_space($return_name) . '",
												"address_line1": "' .  CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_address_1']) . '",
												"address_line2": "' .  CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_address_2']) . '",
												"pincode": "' .  CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_pincode']) . '",
												"city": "' . @$single_order_info['pickup_city'] . '",
												"state": "' . @$single_order_info['pickup_state'] . '",
												"primary_contact_number": "' . @$single_order_info['pickup_contactNo'] . '"
											}
										},
										"destination": {
											"address": {
												"first_name": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['name']) . '",
												"address_line1": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['address_1']) . '",
												"address_line2": "' .  CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['address_2']) . '",
												"pincode": "' . @$single_order_info['pincode'] . '",
												"city": "' . @$single_order_info['city'] . '",
												"state": "' . @$single_order_info['state'] . '",
												"primary_contact_number": "' . @$single_order_info['mobile_no'] . '"
											}
										},
										"return_location": {
											"address": {
												"first_name": "' .  CUSTOM::remove_special_characters_and_extra_space($return_name) . '",
												"address_line1": "' .  CUSTOM::remove_special_characters_and_extra_space($return_address1) . '",
												"address_line2": "' .  CUSTOM::remove_special_characters_and_extra_space($return_address2) . '",
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
												"product_title": "' .  CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['product_name']) . '",
												"quantity": ' .  CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['product_quantity']) . ',
												"cost": {
													"total_sale_value": ' .  CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['total_shipping_amount']) . ',
													"total_tax_value": ' . @$taxVal . ',
													"tax_breakup":{
														"cgst":' . @$single_order_info['cgst_amount'] . ',
														"sgst":' . @$single_order_info['sgst_amount'] . ',
														"igst": ' . @$single_order_info['igst_amount'] . '
													}
												},
												"seller_details": {
													"seller_reg_name": "' .  CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['packing_slip_warehouse_name']) . '",
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

		$walletSufficient = API::check_wallet($single_order_info['sender_id'], $single_order_info['total_shipping_amount']);
		if ($walletSufficient == 1) {
			$response = CUSTOM::curl_request('application/json', $CI->config->item('ECART_AUTHORIZATION'), $CI->config->item('ECART_API_URL'), $body, "POST", $CI->config->item('ECART_MERCHANT_CODE'));

			$log_data['order_ecart_curl_response'] = $response;
			file_put_contents(APPPATH . 'logs/ecart_order/' . date("d-m-Y") . '_ecart_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);

			if (@$response['error_response'] != '') {
				$log_data['order_xpressbees_curl_error'] = $response['error_response'];
				$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, '', $order_id_for_api, $response['error_response'], '0');
				$log_data['order_query'] = $CI->db->last_query();
				$error = "Your Order Failed to Shipped due to some error. ";
				file_put_contents(APPPATH . 'logs/ecart_order/' . date("d-m-Y") . '_ecart_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
			} else {
				if (@$response['success_response']['response'][0]['status'] == 'REQUEST_RECEIVED') {
					$log_data['Status'] = $response['success_response']['response'][0]['status'];
					$requst_id = $response['success_response']['request_id'];
					$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $trackingNo, $order_id_for_api, '', '0', '', $requst_id);
					$log_data['orderResponse'] = $orderResponse;
					file_put_contents(APPPATH . 'logs/udaan_awb/' . date("d-m-Y") . '_ecart_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
					$success = "Order Created Successfully";
				} else {
					$log_data1['Status'] = $response['success_response']['response'][0]['message'][0];
					$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $trackingNo, $order_id_for_api, $response['success_response']['response'][0]['message'][0], '1');
					$log_data1['orderResponse'] = $orderResponse;
					file_put_contents(APPPATH . 'logs/ecom_order/' . date("d-m-Y") . '_' . @$single_order_info['sender_id'] . '_ecom_order_' . $single_order_info['sender_id'] . '_ecart_order_log.txt', "\n" . print_r($log_data1, true), FILE_APPEND);
					$error = "You have not sufficient wallet balance,Recharge your wallet";
				}
			}
		} else {
			$log_data['Status'] = "You have not sufficient wallet balance,Recharge your wallet";
			$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, '', $order_id_for_api, "You have not sufficient wallet balance,Recharge your wallet", '0');
			$log_data['orderResponse'] = $orderResponse;
			file_put_contents(APPPATH . 'logs/ecart_order/' . date("d-m-Y") . '_ecart_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
			$error = "You have not sufficient wallet balance,Recharge your wallet";
		}
		if ($success) {
			$res['status'] = "1";
			$res['message'] = $success;
			$res['AWBNo'] = $trackingNo;
		} else {
			$res['status'] = "0";
			$res['message'] = $error;
		}
		return $res;
	}

	/**
	 * Ecart Direct Cancel Order
	 */
	public static function cancel_order($order_id)
	{
		$CI = &get_instance();
		$CI->load->model('Common_model');
		$CI->load->library('session');

		$log_data = array();
		$order_detail = $CI->db->select('fom.id, fom.awb_number, oad.ecart_request_id')->from('forward_order_master as fom')->join('order_airwaybill_detail as oad', 'fom.id = oad.order_id')->where('fom.id', $order_id)->get()->row_array();
		// $order_detail = $CI->Common_model->getSingleRowArray(array('id' => $order_id), 'id, awb_number', 'forward_order_master');
		// Cancel Order code start
		$cancel_order_body = '{
                "request_id": "' . $order_detail['ecart_request_id'] . '",
                "request_details": [
                    {
                        "tracking_id": "' . $order_detail['awb_number'] . '",
                        "reason": "Reason for cancellation"
                    }
                ]
            }';
		$log_data['cancel_order_body'] = $cancel_order_body;
		$cancel_order_response = CUSTOM::curl_request('application/json', $CI->config->item('ECART_AUTHORIZATION'), $CI->config->item('ECART_CANCEL_API_URL'), $cancel_order_body, "PUT", $CI->config->item('ECART_MERCHANT_CODE'));
		$log_data['cancel_order_response'] = $cancel_order_response;
		file_put_contents(APPPATH . 'logs/ecart_order/' . date("d-m-Y") . '_ecart_cancel_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		return 1;
	}
}
