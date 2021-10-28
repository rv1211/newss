<?php
class Udaan_Direct
{
	/**
	 * Udaan Direct API Order Create
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


		if ($single_order_info['awb_number'] != '') {
			$awbNumber = $single_order_info['awb_number'];
		} else {
			$awbno_data = $CI->Common_model->getSingleRowArray(array('is_used' => 1, 'for_what' => '2'), 'awb_number, id', "udaan_direct_airwaybill");
			$awbno_update_data['is_used'] = 2;
			$awbNumber = $awbno_data['awb_number'];
			$CI->Common_model->update($awbno_update_data, "udaan_direct_airwaybill", array('awb_number' => $awbno_data['awb_number']));
		}

		if ($awbNumber != "") {
			$walletSufficient = API::check_wallet($single_order_info['sender_id'], $single_order_info['total_shipping_amount']);

			if ($walletSufficient == 1) {
				if ($single_order_info['udaan_sender_orgid'] == "") {
					$add_api_pickup_address = udaan_direct::create_pickup_address($single_order_info['pickup_warehouseName'], $single_order_info['pickup_contactName'], $single_order_info['pickup_contactNo'], $single_order_info['pickup_address_1'], $single_order_info['pickup_address_2'], $single_order_info['pickup_city'], $single_order_info['pickup_state'], $single_order_info['pickup_pincode']);

					if ($add_api_pickup_address['error'] != "") {
						$error = $add_api_pickup_address['error'];
						$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, $add_api_pickup_address['error'], '0');
						$log_data['orderResponse'] = $orderResponse;
						file_put_contents(APPPATH . 'logs/udaan_awb/' . date("d-m-Y") . '_udaan_create_order.txt', "\n" . print_r($log_data, true), FILE_APPEND);
						$error = "waybill no not available";
					} else {
						$udaan_sender_orgid = $update_pickup_addresss_data['udaan_sender_orgid'] = $add_api_pickup_address['udaan_sender_orgid'];
						$CI->Common_model->update($update_pickup_addresss_data, 'sender_address_master', array('id' => $single_order_info['pickup_id']));
					}
				} else {
					$udaan_sender_orgid = $single_order_info['udaan_sender_orgid'];
				}
				if ($udaan_sender_orgid != "") {
					switch ($single_order_info['order_type']) {
						case '1':
							$collectibleAmount = ($single_order_info['cod_amount'] * 100);
							break;
						default:
							$collectibleAmount = 0;
							break;
					}
					switch ($single_order_info['is_seller_info']) {
						case '1':
							$unitName = $single_order_info['pickup_warehouseName'];
							break;
						default:
							$unitName = @$single_order_info['packing_slip_warehouse_name'];
							break;
					}

					$body = '{
						"awbNumber": "' . $awbNumber . '",
						"orderId": "' . $order_id_for_api . '",
						"orderType": "' . $shipment_type . '",
						"orderParty": "THIRD_PARTY",
						"orderPartyOrgId": "' . $CI->config->item('UDAAN_ORGID') . '",
						"sourceOrgUnitDetails": {
							"orgUnitId": "' . $udaan_sender_orgid . '",
							"representativePersonName": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['pickup_contactName']) . '",
							"unitName": "' . CUSTOM::remove_special_characters_and_extra_space($unitName) . '",
							"contactNumPrimary": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['pickup_contactNo']) . '",
							"contactNumSecondary": "",
							"gstIn": "",
							"address": {
								"addressLine1": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['pickup_warehouseName']) . '",
								"addressLine2": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['pickup_address_1']) . '",
								"addressLine3": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['pickup_address_2']) . '",
								"city": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['pickup_city']) . '",
								"state": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['pickup_state']) . '",
								"pincode": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['pickup_pincode']) . '"
							}
						},
						"billToOrgUnitDetails": {
							"orgUnitId": "ORUBHSG6W1WNVD6K4GGS1BKLW4DFR",
							"representativePersonName": "Dhruv Patel",
							"unitName": "ShipSecure Logistics",
							"contactNumPrimary": "9909944133",
							"contactNumSecondary": "9909944133",
							"gstIn": "24AECFS0983G1Z2",
							"address": {
								"addressLine1": "306 vishala supreme",
								"addressLine2": "opp nikol torrent power station",
								"addressLine3": "Nikol",
								"city": "Ahmedabad",
								"state": "GUJARAT",
								"pincode": "382350"
							}
						},
						"destinationOrgUnitDetails": {
							"representativePersonName": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['name']) . '",
							"unitName": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['name']) . '",
							"contactNumPrimary": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['mobile_no']) . '",
							"contactNumSecondary": "",
							"gstIn": "",
							"address": {
								"addressLine1": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['address_1']) . '",
								"addressLine2": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['address_2']) . '",
								"addressLine3": "",
								"city": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['city']) . '",
								"state": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['state']) . '",
								"pincode": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['pincode']) . '"
							}
						},
						"category": "Default",
						"collectibleAmount": ' . CUSTOM::remove_special_characters_and_extra_space($collectibleAmount) . ',
						"boxDetails": {
							"numOfBoxes": 1,
							"totalBoxWeight": ' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['physical_weight']) . ',
							"boxDetails": []
						},
						"goodsDetails": {
							"goodsDetailsList": [{
								"itemTitle": "' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['product_name']) . '",
								"hsnCode": "",
								"unitPrice": ' . ($single_order_info['product_value'] * 100) . ',
								"unitQty": ' . CUSTOM::remove_special_characters_and_extra_space($single_order_info['product_quantity']) . ',
								"taxPercentage": 0
							}]
						},
						"goodsInvoiceDetails": {
							"invoiceNumber": "' . $order_id_for_api . '",
							"ewayBill": "",
							"invoiceDocUrls": [""],
							"goodsInvoiceAmount": ' . ($single_order_info['product_value'] * 100) . ',
							"goodsInvoiceTaxAmount": 0
						},
						"orderNotes": ""
					}';
					$log_data['order_udaan_body'] = $body;

					$response = CUSTOM::curl_request('application/json', $CI->config->item('UDAAN_CLIENTID'), $CI->config->item('UDAAN_API_URL'), $body, 'POST');

					$log_data['order_udaan_curl_response'] = $response;
					if (@$response['success_response'] == '') {
						$log_data['order_udaan_curl_error'] = @$response;
						$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, "curl error", '1');
						$log_data['orderResponse'] = $orderResponse;
						file_put_contents(APPPATH . 'logs/udaan_awb/' . date("d-m-Y") . '_udaan_create_order.txt', "\n" . print_r($log_data, true), FILE_APPEND);
						$error = "blank responce from curl";
					} else {
						if ($response['success_response']['response'] != "") {
							$log_data['Status'] = "success From API.";
							$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, '', '1', $response['success_response']['response']['shippingLabelDetails']['shipmentIds'][0]);
							$log_data['orderResponse'] = $orderResponse;
							file_put_contents(APPPATH . 'logs/udaan_awb/' . date("d-m-Y") . '_udaan_create_order.txt', "\n" . print_r($log_data, true), FILE_APPEND);
							$success = 'Your Order Shipped Successfully ';
						} else {
							$error = "";
							$error = $response['success_response']['responseMessage'];
							if ($error == "") {
								$error = $response['success_response']['message'];
							}
							if ($error == "") {
								$error = "Uddan SERVER ERROR";
							}
							$log_data['Status'] = $error;
							$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, $error, '1');
							$log_data['orderResponse'] = $orderResponse;
							file_put_contents(APPPATH . 'logs/udaan_awb/' . date("d-m-Y") . '_udaan_create_order.txt', "\n" . print_r($log_data, true), FILE_APPEND);
							$error = $response['success_response']['responseMessage'];
						}
					}
				} else {
					$log_data['Status'] = "Order origin id not generate due to some reason " . $add_api_pickup_address['error'];
					$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, "Order origin id not generate due to some reason " . $add_api_pickup_address['error'], '1');
					$log_data['orderResponse'] = $orderResponse;
					file_put_contents(APPPATH . 'logs/udaan_awb/' . date("d-m-Y") . '_udaan_create_order.txt', "\n" . print_r($log_data, true), FILE_APPEND);
					$error = "Order origin id not generate due to some reason " . $add_api_pickup_address['error'];
				}
			} else {
				$log_data['Status'] = "You have not sufficient wallet balance,Recharge your wallet";
				$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, "You have not sufficient wallet balance,Recharge your wallet", '1');
				$log_data['orderResponse'] = $orderResponse;
				file_put_contents(APPPATH . 'logs/udaan_awb/' . date("d-m-Y") . '_udaan_create_order.txt', "\n" . print_r($log_data, true), FILE_APPEND);
				$error = "You have not sufficient wallet balance,Recharge your wallet";
			}
		} else {
			$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awbNumber, $order_id_for_api, "waybill no not available", '0');
			$log_data['orderResponse'] = $orderResponse;
			file_put_contents(APPPATH . 'logs/udaan_awb/' . date("d-m-Y") . '_udaan_create_order.txt', "\n" . print_r($log_data, true), FILE_APPEND);
			$error = "waybill no not available";
		}
		if ($success) {
			$res['status'] = 1;
			$res['message'] = $success;
			$res['AWBNo'] = $awbNumber;
		} else {
			$res['status'] = 0;
			$res['message'] = $error;
		}
		return $res;
	}

	/**
	 * Udaan Direct Pickup Address Api
	 */
	public static function create_pickup_address($warehouse_name, $pickup_contactName, $warehouse_contact_no, $address_1, $address_2, $city, $state, $pincode)
	{
		$CI = &get_instance();
		file_put_contents(APPPATH . 'logs/udaan_awb/' . date("d-m-Y") . '_udaan_pickup_address.txt', "\n----------------------------------START ADD UDAAN PICKUP ADDRESS FOR USER -------------------------------------\n", FILE_APPEND);
		$body = '{
			    "orgUnitId" : "",
			    "addressLine1" : "' . CUSTOM::remove_special_characters_and_extra_space($address_1) . '",
			    "addressLine2" : "' . CUSTOM::remove_special_characters_and_extra_space($address_2) . '",
			    "addressLine3" : "",
			    "city" : "' . CUSTOM::remove_special_characters_and_extra_space($city) . '",
			    "state" : "' . CUSTOM::remove_special_characters_and_extra_space($state) . '",
			    "pincode" : "' . CUSTOM::remove_special_characters_and_extra_space($pincode) . '",
			    "unitName" : "' . CUSTOM::remove_special_characters_and_extra_space($warehouse_name) . '",
			    "representativeName" : "' . CUSTOM::remove_special_characters_and_extra_space($pickup_contactName) . '",
			    "mobileNumber" : "' . CUSTOM::remove_special_characters_and_extra_space($warehouse_contact_no) . '",
			    "gstin" : ""
			}';
		$log_data['udaan_pickup_address_body'] = $body;
		$response = CUSTOM::curl_request('application/json', $CI->config->item('UDAAN_CLIENTID'), $CI->config->item('UDAAN_PICKUP_ADDRESS_URL'), $body, 'POST');

		if (@$response['success_response']['response'] == '') {
			$res['error'] = "cURL Error #:" . $response['success_response']['responseMessage'];
			$log_data['pickup_address_curl_error'] = $response['success_response'];
		} else {
			$log_data['pickup_address_response'] = $response['success_response'];
			// $log_data['pickup_address_json_response'] = $res;
			if (@$response['success_response']['responseMessage'] == 'Request processed Successfully') {
				$res['success'] = 'Pickup Address Add Successfully';
				$res['udaan_sender_orgid'] = $response['success_response']['response']['orgUnitId'];
			} else {
				$res['error'] = @$response['success_response']['responseMessage'];
			}
		}
		file_put_contents(APPPATH . 'logs/udaan_awb/' . date("d-m-Y") . '_udaan_pickup_address.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		file_put_contents(APPPATH . 'logs/udaan_awb/' . date("d-m-Y") . '_udaan_pickup_address.txt', "\n----------------------------------END ADD UDAAN PICKUP ADDRESS FOR USER -------------------------------------\n", FILE_APPEND);

		return $res;
	}

	/**
	 * Udaan Direct AWB generate
	 */
	public static function generate_awb()
	{
		$CI = &get_instance();
		$curl_response = CUSTOM::curl_request('application/json', $CI->config->item('UDAAN_CLIENTID'), $CI->config->item('UDAAN_AWBNO_GENERATE_API_URL') . "2000", "", "POST");
		$awb_log['curl_response'] = $curl_response;
		if (!empty($curl_response)) {
			if (!empty($curl_response['success_response'])) {
				if ($curl_response['success_response']['responseMessage'] == 'Request processed Successfully') {
					if (!empty($curl_response['success_response']['response'])) {
						foreach ($curl_response['success_response']['response'] as $awbVal) {
							$awbdata[] = array(
								'awb_number' => $awbVal,
								'is_used' => '1',
							);
						}
						$awb_log['insert_body'] = $awbdata;

						$result = $CI->db->insert_batch('udaan_direct_airwaybill', $awbdata);
						$awb_log['insert_result'] = $result;
						if (!empty($result)) {
							$awb_log['success'] = "AWB Generated Successfully";
						} else {
							$awb_log['error'] = "AWB Generate Failed!!";
						}
					}
				} else {
					$awb_log['error'] = $curl_response['success_response']['responseMessage'];
				}
			} else {
				$awb_log['error'] = $curl_response['error_response'];
			}
		} else {
			$awb_log['error'] = 'Something Went Wrong!!!';
		}
		file_put_contents(APPPATH . 'logs/udaan_awb/' . date("d-m-Y") . '_udaan_awb.txt', print_r($awb_log, true) . "\n------------------- Get AWB End ---------------\n", FILE_APPEND);
		return $awb_log;
	}

	/**
	 * Udaan Direct Cancel Order
	 */
	public static function cancel_order($order_id)
	{
		$CI = &get_instance();
		$CI->load->model('Common_model');
		$CI->load->library('session');

		$log_data = array();
		$order_detail = $CI->Common_model->getSingleRowArray(array('id' => $order_id), 'id, awb_number', 'forward_order_master');
		// Cancel Order code start
		$cancel_order_response = CUSTOM::curl_request('application/json', $CI->config->item('UDAAN_CLIENTID'), $CI->config->item('UDAAN_ORDER_CANCEL_ORDER') . $order_detail['awb_number'], "", "POST");
		$log_data['cancel_order_response'] = $cancel_order_response;
		file_put_contents(APPPATH . 'logs/udaan_awb/' . date("d-m-Y") . '_udaan_cancel_order.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		return 1;
	}
}
