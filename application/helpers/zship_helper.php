<?php
function create_order_zship($order_id, $bulk = 0)
{
	// $logistic_name = "Delhivery_Surface";
	$CI = &get_instance();
	$CI->load->model('Create_singleorder_awb');
	$CI->load->model('Common_model');
	$CI->load->library('session');
	if ($bulk == 1) {
		$result = $CI->Create_singleorder_awb->get_multiple_order_list_bulk($order_id);
	} else {
		$result = $CI->Create_singleorder_awb->get_multiple_order_list($order_id);
	}

	// dd($result);

	$awb_no = '';
	$awb_table = '';
	// lq();
	// dd($result);
	// $awb_no = "";
	// if (($result[0]['awb_number'] == "")) {
	//     if ($result[0]["order_type"] == 0) {
	//         $type = "2";
	//     } else {
	//         $type = "1";
	//     }
	//     $get_awb_no = $CI->Create_singleorder_awb->get_awbno($awb_table, $type);
	//     $awb_no = $get_awb_no->awb_number;
	//     $update_awb_no = $CI->Create_singleorder_awb->update_awb($order_id, $awb_no);
	// } else {
	//     $awb_no  = $result[0]['awb_number'];
	// }
	$awb_no  = ($result['awb_number'] != "") ? $result['awb_number'] : '';
	$sender_id  = $result['sender_id'];
	$awb_table =  strtolower($result['api_name']) . '_airwaybill';
	$responce = [];
	// dd($awb_table);
	if (empty($result["zship_sender_id"])) {
		return  "Zship Sender Id Not Created";
	}

	$CI->config->load('config');

	$request_body = '{"service" : "' .  (!empty($result['logistic_name']) ? $result['logistic_name'] : $CI->config->item('ZSHIP_SERVICES')) . '",
            "sender_id" : ' . $result["zship_sender_id"] . ',
             "shipment_info": [ ';

	$string = "";
	echo '<pre>';
	print_r($result);
	echo '</pre>';
	// exit();
	foreach ($result as $single_order) {
		echo '<pre>';
		print_r($single_order);
		echo '</pre>';
		// exit();
		$order_id_array[$single_order["id"]] = $single_order["id"];
		if ($single_order["order_type"] == 0) {
			$cod_type = "no";
		} else {
			$cod_type = "yes";
		}

		$address = $single_order["address_1"];
		if ($single_order["address_2"] != "") {
			$address .= ", " . $single_order["address_2"];
		}

		$address .= ", " . $single_order["city"] . ", " . $single_order["state"];

		if (!empty($awb_no)) {
			$string = '"tracking_id" :"' . $awb_no . '",';
		}
		//  else {
		//     $responce['status'] = "0";
		//     $responce['message'] = "Waybillno can't be found";
		//     return $responce;
		// }

		if ($bulk) {
			$order_id_for_api = "B" . CUSTOM::remove_special_characters_and_extra_space($single_order["order_no"]);
		} else {
			$order_id_for_api = "S" . CUSTOM::remove_special_characters_and_extra_space($single_order["order_no"]);
		}

		$volue_weight = @$single_order['volumetric_weight'];
		$phy_weight = @$single_order['physical_weight'];

		if (empty($s) && empty($phy_weight)) {
			$responce['status'] = "0";
			$responce['message'] = "Weight can't be found";
			return $responce;
		} else {
			$weight_api = min($volue_weight, $phy_weight);
			if (empty($weight_api)) {
				$responce['status'] = "0";
				$responce['message'] = "Weight can't be found";
				return $responce;
			}
		}
		$request_sub_body[] = '{
                    "order_id" : "' . $order_id_for_api . '",' . ((!empty($string)) ?  $string : "") . '
                    "cod" : "' . $cod_type . '",
                    "weight" : ' . $weight_api . ',
                    "consignee" : {
                    "name" : "' . CUSTOM::remove_special_characters_and_extra_space($single_order["name"]) . '",
                    "address" : "' . CUSTOM::remove_special_characters_and_extra_space(trim($address)) . '",
                    "pincode" : "' . CUSTOM::remove_special_characters_and_extra_space($single_order["pincode"]) . '",
                    "phone" : "' . CUSTOM::remove_special_characters_and_extra_space($single_order["mobile_no"]) . '"
                },
                "shipment_details":
                    [
                    {
                        "description" : "' . CUSTOM::remove_special_characters_and_extra_space($single_order["product_name"]) . '",
                        "quantity" : ' . $single_order['product_quantity'] . ',
                        "price_per_unit" : ' . $single_order["product_value"] . '
                    }
                    ]
                }';
	}

	$request_body .= implode(",", $request_sub_body);
	$request_body .= ']
            }';

	dd($request_body);
	$responce['request_body'] = $request_body;
	$token_detail = $CI->Common_model->getAllData('zship_token_master');
	$curl_response = CUSTOM::curl_request('application/json', $token_detail[0]->token, $CI->config->item('ZSHIP_CREATE_ORDER_URL'), $request_body, "POST");


	// exit();

	if (@$curl_response['error_response'] != "") {

		$orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
		$new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 0, $bulk, $order_id_for_api, $curl_response['error_response']);
		$responce['status']  = "0";
		$responce['message'] = $curl_response['error_response'];
	} else {
		if ($curl_response['success_response'] != "") {
			if ($curl_response['success_response']['status'] == 200) {
				$total_count = $curl_response['success_response']['message']['total_count'];
				$accepted_count = $curl_response['success_response']['message']['accepted_count'];
				$total_order_response_2 = $curl_response['success_response']['message']['shipments'];

				foreach ($total_order_response_2 as $key => $value) {
					if ($value['status'] == 1) {
						end:
						// $CI->Create_singleorder_awb->update_order_status($single_order["order_no"]);
						// $orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id);
						// $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 1, $bulk, $order_id_for_api, '');
						if (!empty($awb_no)) {
							$delete_awb  = $CI->Create_singleorder_awb->delete_awb($awb_no, $awb_table);
						}


						// $getwallet_data = $CI->Common_model->getSingle_data('id,email,wallet_balance,allow_credit,allow_credit_limit', 'sender_master', array('id' => $sender_id));
						// $wallet = $getwallet_data['wallet_balance'];
						// $wallet_total = ($getwallet_data['wallet_balance'] - $order_charge);

						// if ($wallet_total < 500) {
						//     $temp_wallet_balance = ($getwallet_data['wallet_balance'] - 500);
						//     $temp_order_cost = $order_charge - $temp_wallet_balance;
						//     if ($getwallet_data['allow_credit'] == 1) {
						//         if ($getwallet_data['allow_credit_limit'] >= $temp_order_cost) {
						//             $order_amount = ($getwallet_data['allow_credit_limit'] - $temp_order_cost);
						//             if (!empty($awb_no)) {
						//                 $debit_amount = $CI->Create_singleorder_awb->debit_wallet($temp_wallet_balance, $temp_order_cost, $sender_id);
						//                 $update_order = $CI->Create_singleorder_awb->update_amount($order_charge, $order_id, $bulk);
						//                 $delete_awb  = $CI->Create_singleorder_awb->delete_awb($awb_no, $awb_table);
						//             }
						//             if ($debit_amount == true) {
						//                 $orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
						//                 $new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 1, $bulk, $order_id_for_api, '');
						//                 // if (!empty($awb_no)) {
						//                 $fOrderId = $CI->db->insert_id;
						//                 $data['order_id'] = $fOrderId;
						//                 $data['airwaybill_no'] = $awb_no;
						//                 $data['order_status_id'] = 1;
						//                 $data['order_type'] = $result[0]['order_type'];
						//                 $CI->Create_singleorder_awb->insert_barcode($data);
						//                 // }
						//                 file_put_contents(APPPATH . 'logs/zship_api/' . date("d-m-Y") . '_' . $result[0]['sender_id'] . '_log.txt', "\n------------------------ END LOG FOR SINGLE ORDER INSERT FROM CREDIT -------------" . date("d-m-Y H:i:s") . "-----------------------\n", FILE_APPEND);

						//                 $log_data['payment_status'] = "paid";
						//                 $log_data['wallet_balance'] = $temp_wallet_balance;
						//                 $log_data['allow_credit_limit'] = $temp_order_cost;


						//                 $total_wallet_balance = @$getwallet_data->wallet_credit - str_replace(",", "", $order_charge);
						//                 file_put_contents(APPPATH . 'logs/zship_api/' . date("d-m-Y") . '_' . $result[0]['sender_id'] . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
						//                 $responce['status'] = "1";
						//                 $responce['message'] = "Order Created Successfully";
						//             } else {
						//                 $responce['status'] = "0";
						//                 $responce['message'] = "Amount Cant be debited";
						//             }
						//             //WALLET MATHI $temp_wallet_balance
						//             //CREDIT MATHI $temp_order_cost
						//         } else {
						//             $responce['status'] = "0";
						//             $responce['message'] = "You have not sufficient wallet balance ,Recharge your wallet";
						//         }
						//     } else {
						//         $responce['status'] = "0";
						//         $responce['message'] = "You have not sufficient wallet balance ,Recharge your wallet";
						//     }
						// } else {
						//     $log_data['payment_status'] = "paid";
						//     file_put_contents(APPPATH . 'logs/zship_api/' . date("d-m-Y") . '_' . $result[0]['sender_id'] . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
						//     file_put_contents(APPPATH . 'logs/zship_api/' . date("d-m-Y") . '_' . $result[0]['sender_id'] . '_log.txt', "\n---------------------- START LOG FOR SINGLE ORDER INSERT FROM wallet -------------" . date("d-m-Y H:i:s") . "-----------------------\n", FILE_APPEND);
						//     if (!empty($awb_no)) {
						//         $delete_awb  = $CI->Create_singleorder_awb->delete_awb($awb_no, $awb_table);
						//         $debit_amount = $CI->Create_singleorder_awb->delete_direct_amount($wallet_total, $sender_id);
						//         $update_order = $CI->Create_singleorder_awb->update_amount($order_charge, $order_id);
						//     }
						//     if ($debit_amount == true) {
						//         $log_data['wallet_amount'] = $debit_amount;
						//         file_put_contents(APPPATH . 'logs/zship_api/' . date("d-m-Y") . '_' . $result[0]['sender_id'] . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);

						//         $responce['status'] = "1";
						//         $responce['message'] = "Order Created Successfully";
						//         $orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
						//         $new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 1, $bulk, $order_id_for_api, '');
						//         // if (!empty($awb_no)) {
						//         $fOrderId = $CI->db->insert_id;
						//         $data['order_id'] = $fOrderId;
						//         $data['airwaybill_no'] = $awb_no;
						//         $data['order_status_id'] = 1;
						//         $data['order_type'] = $result[0]['order_type'];
						//         $CI->Create_singleorder_awb->insert_barcode($data);
						//         // }
						//         // return;
						//     } else {
						//         $responce['status'] = "0";
						//         $responce['message'] = "Amount Cant be debited";
						//         // return;
						//     }

						//     $CI->db->trans_complete();

						//     if ($CI->db->trans_status() === FALSE) {
						//         # Something went wrong.
						//         $CI->db->trans_rollback();
						//         $responce['status'] = "0";
						//         $responce['message'] = "Something Went Wrong";
						//     } else {
						//         $CI->db->trans_commit();
						//         $responce['status'] = "1";
						//         $responce['message'] = "order Created Successfully";
						//     }
						// }
					} else {
						if ($curl_response['success_response']['message']['shipments'][0]['info'] == 'accepted') {
							goto end;
						} else {
							if (!empty($awb_no)) {
								$delete_awb  = $CI->Create_singleorder_awb->delete_awb($awb_no, $awb_table);
							}
							// $orderdata = $CI->Create_singleorder_awb->get_all_order_data($order_id, $bulk);
							// $new_order_data = $CI->Create_singleorder_awb->move_order($order_id, $orderdata, 0, $bulk, $curl_response['success_response']['message']['shipments'][0]['info']);
							$responce['status'] = 0;
							$responce['message'] = $curl_response['success_response']['message']['shipments'][0]['info'];
						}
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
				$responce['status'] = "0";
				$responce['message'] = $curl_response['success_response']['message'];
			}
		} else {
			$responce['status'] = "0";
			$responce['message'] = "Token Expierd";
		}
	}

	return $responce;
}
