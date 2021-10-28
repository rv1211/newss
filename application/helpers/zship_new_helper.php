<?php
function create_order_zship($order_id, $bulk = 0)
{
	$CI = &get_instance();
	$CI->load->model('Create_singleorder_awb');
	$CI->load->model('Common_model');
	$CI->load->library('session');
	$isBulk = "";
	if ($bulk == 1) {
		$result = $CI->Create_singleorder_awb->get_multiple_order_list_bulk($order_id);
		$temp_table_name = 'temp_order_master';
		$isBulk = 'B';
	} else {
		$result = $CI->Create_singleorder_awb->get_multiple_order_list($order_id);
		$temp_table_name = 'temp_forward_order_master';
		$isBulk = 'S';
	}


	$awb_no = '';
	$awb_table = '';
	$awb_no  = ($result['awb_number'] != "") ? $result['awb_number'] : '';
	$awb_table =  strtolower($result['api_name']);
	if (empty($result["zship_sender_id"])) {
		return  "Zship Sender Id Not Created";
	}
	$CI->config->load('config');

	$string = "";



	if ($result["order_no"] == '') {
		$order_id_for_api =  'SSL' . CUSTOM::remove_special_characters_and_extra_space(str_replace("_", "-", $result["id"] . '-' . rand(001, 999) . $isBulk));
	} else {
		$order_id_for_api =  CUSTOM::remove_special_characters_and_extra_space(str_replace("_", "-", $result["order_no"]));
	}
	file_put_contents(APPPATH . 'logs/create_order_zship_api/' . date("d-m-Y") . '_create_order_' . $result['sender_id'] . '.txt', "\n\n--------------------Start Creating Order -----------------------\n", FILE_APPEND);
	// $volue_weight = @$result['volumetric_weight'];
	// $phy_weight = @$result['physical_weight'];

	// if (empty($volue_weight) && empty($phy_weight)) {
	//     $responce['status'] = "0";
	//     $responce['message'] = "Weight can't be found";
	//     return $responce;
	// } else {
	//     $weight_api = min($volue_weight, $phy_weight);
	//     if (empty($weight_api)) {
	//         $responce['status'] = "0";
	//         $responce['message'] = "Weight can't be found";
	// return $responce;

	//     }$responce;
	// } else {
	//     $weight_api = min($volue_weight, $phy_weight);
	// }

	$order_id_array[$result["id"]] = $result["id"];
	if ($result["order_type"] == 0) {
		$cod_type = "no";
	} else {

		$cod_type = "yes";
	}

	$address = $result["address_1"];
	if ($result["address_2"] != "") {
		$address .= ", " . $result["address_2"];
	}

	$address .= ", " . $result["city"] . ", " . $result["state"];

	if (!empty($awb_no)) {
		$string = '"tracking_id" :"' . $awb_no . '",';
	}
	$request_body = '{"service" : "' .  (!empty($result['api_name']) ? $result['api_name'] : $CI->config->item('ZSHIP_SERVICES')) . '",
            "sender_id" : ' . $result["zship_sender_id"] . ',
             "shipment_info": [ {
                    "order_id" : "' . $order_id_for_api . '",' . ((!empty($string)) ?  $string : "") . '
                    "cod" : "' . $cod_type . '",
                    "weight" : 0.5,
                    "consignee" : {
                    "name" : "' . CUSTOM::remove_special_characters_and_extra_space($result["name"]) . '",
                    "address" : "' . CUSTOM::remove_special_characters_and_extra_space(trim($address)) . '",
                    "pincode" : "' . CUSTOM::remove_special_characters_and_extra_space($result["pincode"]) . '",
                    "phone" : "' . CUSTOM::remove_special_characters_and_extra_space($result["mobile_no"]) . '"
                },
                "shipment_details":
                    [
                    {
                        "description" : "' . CUSTOM::remove_special_characters_and_extra_space($result["product_name"]) . '",
                        "quantity" : ' . $result['product_quantity'] . ',
                        "price_per_unit" : ' . $result["product_value"] . '
                    }
                    ]
                }]
            }';

	// dd($request_body);
	$responce['request_body'] = $request_body;
	$token_detail = $CI->Common_model->getAllData('zship_token_master');



	$walletSufficient = API::check_wallet($result['sender_id'], $result['total_shipping_amount']);

	if ($walletSufficient == '1') {
		$curl_response = CUSTOM::curl_request('application/json', $token_detail[0]->token, $CI->config->item('ZSHIP_CREATE_ORDER_URL'), $request_body, "POST");

		$insert_order_log['request_body'] = $request_body;
		$insert_order_log['responce'] = $curl_response;


		if (@$curl_response['error_response'] != "") {
			$insert_order_log['error'] = $curl_response['error_response'];
			$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awb_no, $order_id_for_api, $curl_response['error_response'], '1');
			// $orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
			// $new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 0, $bulk, $order_id_for_api, $curl_response['error_response']);
			$responce['status']  = "0";
			$responce['message'] = $curl_response['error_response'];
		} else {
			if ($curl_response['success_response'] != "") {
				if ($curl_response['success_response']['status'] == 200) {
					if ($curl_response['success_response']['message']['shipments'][0]['status'] == 1) {
						end:
						$update_status =  $CI->Create_singleorder_awb->update_order_status($order_id, $bulk);
						if (!empty($awb_no)) {
							$delete_awb  = $CI->Create_singleorder_awb->delete_awb($awb_no, $awb_table);
							if ($delete_awb) {
								$responce['status'] = "1";
								$responce['message'] = "Your request Has been accepted and Order in process";
							} else {
								$responce['status'] = "0";
								$responce['message'] = "Awb can't be found";
							}
						}
						$responce['status'] = "1";
						$responce['message'] = "Your request Has been accepted and Order in process";
					} else {
						if ($curl_response['success_response']['message']['shipments'][0]['info'] == 'accepted') {
							goto end;
						} else {
							if (!empty($awb_no)) {
								$delete_awb  = $CI->Create_singleorder_awb->delete_awb($awb_no, $awb_table);
							}
							$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awb_no, $order_id_for_api, $curl_response['success_response']['message']['shipments'][0]['info'], '1');
							$responce['status'] = 0;
							$responce['message'] = $curl_response['success_response']['message']['shipments'][0]['info'];
						}
					}
				} elseif ($curl_response['success_response']['status'] == 400) {
					$error_message = "";
					if ($curl_response['success_response']['message']['service'] != "") {
						$error_message = $curl_response['success_response']['message']['service'];
					} elseif ($curl_response['success_response']['message']['shipment_info'] != "") {
						$error_message = $curl_response['success_response']['message']['shipment_info'];
					} elseif ($curl_response['success_response']['message']['sender_id'] != "") {
						$error_message = $curl_response['success_response']['message']['sender_id'];
					}
					$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awb_no, $order_id_for_api, $error_message, '1');
					$responce['status'] = "0";
					$responce['message'] = $error_message;
				}
			} else {
				$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awb_no, $order_id_for_api, "Token Expierd", '1');
				$responce['status'] = "0";
				$responce['message'] = "Token Expierd";
			}
		}
	} else {
		$error = "Insuficient Wallet Balance Recharge Your wallet and then come to us";
		$insert_order_log['error'] = $error;
		$orderResponse = wallet_direct::debit_wallet($order_id, $temp_table_name, $awb_no, $order_id_for_api, $error, '1');
		$responce['status']  = "0";
		$responce['message'] = $error;
	}

	$insert_order_log['order'] = $result;

	$responce['order_id'] = $order_id_for_api;

	file_put_contents(APPPATH . 'logs/create_order_zship_api/' . date("d-m-Y") . '_create_order_' . $result['sender_id'] . '.txt', print_r($insert_order_log, true), FILE_APPEND);

	file_put_contents(APPPATH . 'logs/create_order_zship_api/' . date("d-m-Y") . '_create_order_' . $result['sender_id'] . '.txt', "\n\n--------------------END Creating Order -----------------------\n", FILE_APPEND);
	return $responce;
}
