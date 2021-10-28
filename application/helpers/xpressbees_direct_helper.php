<?php
class xpressbees_direct
{
	/**
	 * Xpressbees API Order Create
	 * @return Response
	 */
	public static function xpressbees_order($order_id, $is_repeat = 0, $bulk = 0)
	{
		$log_data['process_start_time'] = date("d-m-y H:i:s");
		$error = $success = $log_id = $awbNumber = "";

		$CI = &get_instance();
		$CI->load->model('Create_singleorder_awb');
		$CI->load->model('Common_model');
		$CI->load->library('session');

		$path = APPPATH . 'logs/xpressbees_order/';
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}

		if ($bulk == 1) {
			$single_order_info = $CI->Create_singleorder_awb->get_multiple_order_list_bulk($order_id);
			$temp_table_name = 'temp_order_master';
			$isBulk = 'B';
		} else {
			$single_order_info = $CI->Create_singleorder_awb->get_multiple_order_list($order_id);
			$temp_table_name = 'temp_forward_order_master';
			$isBulk = 'S';
		}

		$kyc_Detail = $CI->Common_model->getSingle_data('id, gst_no', "kyc_verification_master", array('sender_id' => $single_order_info['sender_id']));
		$log_data['order_data_result_from_order_id'] = $order_id;

		if ($single_order_info['order_type'] == '0') {
			$order_type = '2';
			$typeName = 'PrePaid';
		} else {
			$order_type = '1';
			$typeName = 'COD';
		}

		$logistic_name = $CI->Common_model->getSingle_data('logistic_name, api_name', 'logistic_master', array('id' => $single_order_info['logistic_id']));
		$logisticName = str_replace(' ', '_', strtolower(trim($logistic_name['api_name'])));

		if ($single_order_info['awb_number'] != '') {
			$awbNumber = $single_order_info['awb_number'];
		} else {
			$air_waybill_no_data = $CI->db->select('id,awb_number')->from($logisticName . "_airwaybill")->where('is_used', '1')->where('for_what', '2')->where('type', $order_type)->limit(1)->get()->row_array();
			$awbNumber = $air_waybill_no_data['awb_number'];
		}
		if ($single_order_info['igst_amount'] == '' || $single_order_info['igst_amount'] == '0.00') {
			$order_charge = floatval($single_order_info['total_shipping_amount']) + floatval($single_order_info['sgst_amount']) + floatval($single_order_info['cgst_amount']);
		} else {
			$order_charge = (floatval($single_order_info['total_shipping_amount']) + floatval($single_order_info['igst_amount']));
		}

		if (@$single_order_info['product_sku'] != '') {
			$hnsCode = @$single_order_info['product_sku'];
		} else {
			$hnsCode = 'HNS-' . rand();
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

		$walletSufficient = API::check_wallet($single_order_info['sender_id'], $order_charge);

		if ($awbNumber != "") {
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
				if (empty($returnAddress['city'])) {
					$return_city_db = $CI->Common_model->getSingle_data('city,state', 'pincode_master', array('pincode' => @$returnAddress['pincode']));
					$return_city = @$return_city_db['city'];
					$return_state = @$return_city_db['state'];
				} else {
					$return_city = @$returnAddress['city'];
					$return_state = @$returnAddress['state'];
				}
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

			if ($walletSufficient == 1) {
				$body = '{
					"AirWayBillNO": "' . $awbNumber . '",
					"BusinessAccountName": "Ship Secure Logistics",
					"OrderNo": "' . CUSTOM::remove_special_characters_and_extra_space($order_id_for_api) . '",
					"OrderType": "' . $typeName . '",
					"CollectibleAmount":"' . $single_order_info['cod_amount'] . '",
					"DeclaredValue": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['product_value']) . '",
					"PickupType": "Vendor",
					"Quantity": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['product_quantity']) . '",
					"ServiceType": "SD",
					"DropDetails": {
						"Addresses": [{
							"Address": "' . CUSTOM::remove_special_characters_and_extra_space($customer_address) . '" ,
							"City": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['city']) . '",
							"EmailID": "",
							"Name": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['name']) . '",
							"PinCode": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pincode']) . '",
							"State": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['state']) . '",
							"Type": "Primary"
						}],
						"ContactDetails": [{
							"PhoneNo": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['mobile_no']) . '",
							"Type": "Primary",
							"VirtualNumber": null
						}]
					},
					"PickupDetails": {
						"Addresses": [{
							"Address": "' . CUSTOM::remove_special_characters_and_extra_space($full_pickup_address) . '",
							"City": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_city']) . '",
							"EmailID": "",
							"Name": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_warehouseName']) . '",
							"PinCode": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_pincode']) . '",
							"State": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_state']) . '",
							"Type": "Primary"
						}],
						"ContactDetails": [{
							"PhoneNo": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_contactNo']) . '",
							"Type": "Primary"
						}],
						"PickupVendorCode": "PIC-' . $order_id_for_api . '"
					},
					"RTODetails": {
						"Addresses": [{
							"Address": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_address) . '",
							"City": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_city) . '",
							"EmailID": "",
							"Name": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_name) . '",
							"PinCode": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_pincode) . '",
							"State": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_state) . '",
							"Type": "Primary"
						}],
						"ContactDetails": [{
							"PhoneNo": "' . CUSTOM::remove_special_characters_and_extra_space(@$return_phone) . '",
							"Type": "Primary"
						}]
					},
					"ManifestID": "' . mt_rand(0, (int) 99999999999) . '",
					"IsEssential":"false",
					"IsSecondaryPacking":"false",
					"PackageDetails": {
						"Dimensions": {
							"Height": "' . $single_order_info['height'] . '",
							"Length": "' . $single_order_info['length'] . '",
							"Width": "' . $single_order_info['width'] . '"
						},
						"Weight": {
							"BillableWeight": "1.5",
							"PhyWeight": "' . $single_order_info['physical_weight'] . '",
							"VolWeight": "' . $single_order_info['volumetric_weight'] . '"
						}
					},
					"GSTMultiSellerInfo": [{
						"SellerAddress": "' . CUSTOM::remove_special_characters_and_extra_space($full_pickup_address) . '",
						"SellerName": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['pickup_warehouseName']) . '",
						"SellerPincode": "' . @$single_order_info['pickup_pincode'] . '",
						"SupplySellerStatePlace": "' . @$single_order_info['pickup_state'] . '",
						"HSNDetails": [{
							"ProductCategory": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['product_name']) . '",
							"ProductDesc": "' . CUSTOM::remove_special_characters_and_extra_space(@$single_order_info['product_name']) . ' ",
							"CGSTAmount": "' . floatval($single_order_info['igst_amount']) . '",
							"SGSTAmount": "' . floatval($single_order_info['sgst_amount']) . '",
							"IGSTAmount": "' . floatval($single_order_info['cgst_amount']) . '",
							"Discount": null,
							"GSTTAXRateIGSTN": ' . $igstRate . ',
							"GSTTaxRateCGSTN": ' . $gstRate . ',
							"GSTTaxRateSGSTN": ' . $gstRate . ',
							"GSTTaxTotal": "' . $taxVal . '",
							"HSNCode": "' . $hnsCode . '",
							"ProductQuantity": ' . @$single_order_info['product_quantity'] . ',
							"TaxableValue": ' . $order_charge . '
						}]
					}]
				}';
				$log_data['order_xpressbees_body'] = $body;
				$token = $CI->db->select('xbtoken')->from('zship_token_master')->where('id', '1')->get()->row_array();
				$log_data['order_xpressbees_token'] = $token;
				$response = CUSTOM::curl_request('application/json', '', $CI->config->item('XPRESSBEES_ORDER_API_URL'), $body, "POST", "", "", $token['xbtoken']);
				$log_data['order_xpressbees_curl_response'] = $response;
				file_put_contents(APPPATH . 'logs/xpressbees_order/' . date("d-m-Y") . '_xpressbees_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
				if (@$response['success_response'] != '' && @$response['success_response']['ReturnMessage'] == 'Successfull') {
					// Success Response
					$log_data1['Status'] = "success From API.";

					$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, '', '1');

					$log_data1['orderResponse'] = $orderResponse;
					file_put_contents(APPPATH . 'logs/xpressbees_order/' . date("d-m-Y") . '_xpressbees_order_log.txt', "\n" . print_r($log_data1, true), FILE_APPEND);
					$success = 'Your Order Shipped Successfully ';
				} else {
					if (@$response['error_response'] != '') {
						$log_data1['Status'] = "Error from Curl.";
						$errorMsg = @$response['error_response'];
					} else {
						$log_data1['Status'] = @$response['success_response']['ReturnMessage'];
						$errorMsg = @$response['success_response']['ReturnMessage'];
					}
					if ($errorMsg == '') {
						$errorMsg = 'Error from Order.';
					}

					if ($errorMsg == '') {
						$log_data1['Status'] = "Error from Order.";
						$errorMsg = "Error from Order.";
					}

					$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, $errorMsg, '1');

					$log_data1['orderResponse'] = $orderResponse;
					file_put_contents(APPPATH . 'logs/xpressbees_order/' . date("d-m-Y") . '_xpressbees_order_log.txt', "\n" . print_r($log_data1, true), FILE_APPEND);
					$error = "Your Order Failed to Shipped due to error." . @$errorMsg;
				}
			} else {
				$log_data1['Status'] = "You have not sufficient wallet balance,Recharge your wallet";


				$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, "You have not sufficient wallet balance,Recharge your wallet", '1');


				$log_data1['orderResponse'] = $orderResponse;
				file_put_contents(APPPATH . 'logs/xpressbees_order/' . date("d-m-Y") . '_xpressbees_order_log.txt', "\n" . print_r($log_data1, true), FILE_APPEND);
				$error = "You have not sufficient wallet balance,Recharge your wallet";
			}
		} else {
			$log_data1['Status'] = "Waybill not available";

			$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, "Waybill not available");


			$log_data1['orderResponse'] = $orderResponse;
			file_put_contents(APPPATH . 'logs/xpressbees_order/' . date("d-m-Y") . '_xpressbees_order_log.txt', "\n" . print_r($log_data1, true), FILE_APPEND);
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

	/**
	 * xpressbees Direct Cancel Order
	 */
	public static function cancel_order($order_id)
	{
		$CI = &get_instance();
		$CI->load->model('Create_singleorder_awb');
		$CI->load->model('Common_model');
		$CI->load->library('session');

		$log_data = array();
		$order_detail = $CI->Common_model->getSingleRowArray(array('id' => $order_id), 'id, awb_number', 'forward_order_master');
		// Cancel Order code start
		$cancel_order_body = ' {
				"XBkey":"' . $CI->config->item('XPRESSBEES_ORDER_KEY') . '",
				"AWBNumber":"' . $order_detail['awb_number'] . '",
				"RTOReason":"Test Order Cancellation"
			}';
		$log_data['cancel_order_body'] = $cancel_order_body;
		$cancel_order_response = CUSTOM::curl_request('application/json', '', $CI->config->item('XPRESSBEES_ORDER_CANCEL_ORDER'), $cancel_order_body, "POST");
		$log_data['cancel_order_response'] = $cancel_order_response;
		file_put_contents(APPPATH . 'logs/xpressbees_order/' . date("d-m-Y") . '_xpressbees_cancel_order_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		return 1;
	}
}
