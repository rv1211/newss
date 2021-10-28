<?php
function create_order_zship($order_id, $logistic_name, $awb_no = "", $order_charge)
{
    $CI = &get_instance();
    $CI->load->model('Create_singleorder_awb');
    $CI->load->model('Common_model');
    $CI->load->library('session');
    $result = $CI->Create_singleorder_awb->get_multiple_order_list($order_id);

    if (empty($result[0]["zship_sender_id"])) {
        return  "Zship Sender Id Not Created";
    }
    $CI->config->load('config');


    $request_body = '{
            "service" : "' .  (!empty($logistic_name)) ? $logistic_name : $CI->config->item('ZSHIP_SERVICES') . '",
            "sender_id" : ' . $result[0]["zship_sender_id"] . ',
            "shipment_info": [ ';
    foreach ($result as $single_order) {
        // dd($single_order);
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




        $request_sub_body[] = '{
                    "order_id" : "TEST-PACK-' . CUSTOM::remove_special_characters_and_extra_space($single_order["id"]) . '",
                    "cod" : "' . $cod_type . '",
                    "weight" : 0.5,
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
                        "quantity" : 1,
                        "price_per_unit" : ' . $single_order["cod_amount"] . '
                    }
                    ]
                }';
    }

    $request_body .= implode(",", $request_sub_body);
    $request_body .= ']
            }';
    $token_detail = $CI->Common_model->getAllData('zship_token_master');
    $curl_response = CUSTOM::curl_request('application/json', $token_detail[0]->token, $CI->config->item('ZSHIP_CREATE_ORDER_URL'), $request_body, "POST");

    if (!empty($curl_response['success_response']))


        $CI->Common_model->delete('zship_airwaybill', array('awb_number' => $awb_no));

    foreach ($curl_response['success_response']['message']['shipments'] as $responce) {
        if ($responce['status'] == 1) {
            if ($order_charge) {


                $walletSufficient = API::check_wallet($result['sender_id'], $order_charge);



                $getwallet_data = $CI->Common_model->getSingle_data('id,email,wallet_balance,allow_credit,allow_credit_limit', 'sender_master', array('id' => $result['sender_id']));
                if (!empty($getwallet_data['wallet_balance'])) {
                    //total of remain balance after create order
                    $wallet_total = ($getwallet_data['wallet_balance'] - $order_charge);
                    if ($wallet_total < 500) {
                        $temp_wallet_balance = ($getwallet_data['wallet_balance'] - 500);
                        $temp_order_cost = $order_charge - $temp_wallet_balance;
                        //check allow credit
                        if ($getwallet_data['allow_credit'] == 1) {
                            if ($getwallet_data['allow_credit_limit'] > $temp_order_cost) {
                                $order_amount = ($getwallet_data['allow_credit_limit'] - $temp_order_cost);
                                $orderAmount = $order_charge;
                                //echo $orderAmount;exit;
                            } else {
                                return ['status' => FALSE, 'message' => "You have not sufficient wallet balance ,Recharge your wallet"];
                            }
                        } else {
                            return ['status' => FALSE, 'message' => "You have not sufficient wallet balance ,Recharge your wallet"];
                        }
                    } else {
                        $orderAmount = $order_charge;
                    }
                }
            }
        }
    }

    return $curl_response;
}
