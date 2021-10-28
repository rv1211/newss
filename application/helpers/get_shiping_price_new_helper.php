<?php
if (!function_exists('get_shiping_price')) {

	function get_shiping_price($sender_id, $logistic_ids = NUll, $from_pin, $to_pin, $shipment_type, $order_typ, $volumetric_weight, $physical_weight, $collectable_amount, $is_bulk = 0, $gst = 18)
	{
		$CI = &get_instance();
		$user_type = $CI->session->userdata('userType');

		$path = APPPATH . 'logs/get_shiping_price_new/';
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}
		$log_data = array('date' => date('Y-m-d H:s:i'), 'sender_id' => $sender_id, 'logistic_ids' => $logistic_ids, 'from_pin' => $from_pin, 'to_pin' => $to_pin, 'shipment_type' => $shipment_type, 'volumetric_weight' => $volumetric_weight, 'physical_weight' => $physical_weight, 'collectable_amount' => $collectable_amount, 'is_bulk' => $is_bulk, 'gst' => $gst);
		file_put_contents(APPPATH . 'logs/get_shiping_price_new/' . date("d-m-Y") . '_log.txt', "\n\n------- Start Log ------\n" . print_r($log_data, true), FILE_APPEND);

		// GET LOGISTICS IDS WHERE IS ACTIVE
		if ($logistic_ids == NULL) {
			if ($user_type == "4" || $user_type == 4) {
				$user_data = $CI->db->get_where('sender_master', array('id =' => $sender_id))->result();
				if (!empty($user_data)) {
					$logistic_ids = $CI->db->select('logistic_id')->from('assign_logistic_sender as als')->join('logistic_master lm', 'lm.id = als.logistic_id')->where('als.sender_id', $sender_id)->where('lm.is_active', "1")->group_by('lm.id')->get()->result_array();
					$logistic_ids = array_column($logistic_ids, 'logistic_id');
				} else {
					$log_data1['logistic_error'] = "User Have Not Any Active Logistic Assigned";
					file_put_contents(APPPATH . 'logs/get_shiping_price_new/' . date("d-m-Y") . '_log.txt', print_r($log_data1, true), FILE_APPEND);
					return ['status' => FALSE, 'message' => "User Have Not Any Active Logistic Assigned"];
				}
			} else {
				$user_data = $CI->db->get_where('user_master', array('id =' => $sender_id))->result();
				$logistic_ids = $CI->db->select('id')->from('logistic_master')->where('is_active', '1')->get()->result_array();
				$logistic_ids = array_column($logistic_ids, 'id');
			}
		} else {
			// CHECK IN ARRAY OR NOT
			if (is_array($logistic_ids)) {
				$logistic_ids = $logistic_ids;
			} else {
				$logistic_ids = array($logistic_ids);
			}
		}
		$data_log['logistic_ids'] = $logistic_ids;
		// IF IS BULK THAN SET ARRAY ACCORDING TO PRIORITY
		if ($is_bulk == 1) {
			$logistic_priority = $CI->db->select('priority,logistic_id')->from('logistic_priority')->where('sender_id', $sender_id)->order_by('priority', "ASC")->get()->result_array();
			$logistic_ids_old = $logistic_ids;
			if (!empty($logistic_priority)) {
				foreach ($logistic_priority as $key => $l_p_val) {
					if (in_array($l_p_val['logistic_id'], $logistic_ids)) {
						$logistic_ids_new[] = $l_p_val['logistic_id'];
						if (($key1 = array_search($l_p_val['logistic_id'], $logistic_ids_old)) !== false) {
							unset($logistic_ids_old[$key1]);
						}
					}
				}
			}
			if (!empty($logistic_ids_new) && !empty($logistic_ids_old)) {
				$logistic_ids = array_merge($logistic_ids_new, $logistic_ids_old);
			} elseif (!empty($logistic_ids_new)) {
				$logistic_ids = $logistic_ids_new;
			} elseif (!empty($logistic_ids_old)) {
				$logistic_ids = $logistic_ids_old;
			} else {
				$logistic_ids = $logistic_ids;
			}
			$data_log['bulk_logistic_ids'] = $logistic_ids;
		}

		// CHECK FROM_PINCODE AND TO_PINCODE IS AWAILABEL OR NOT FOR SHIPMENT_TYPE AND ORDER_TYPE
		if ($from_pin == "" || $from_pin == null || $from_pin == NULL && $from_pin == "null") {
			$log_data2['logistic_error'] = "From Pincode Is Not Set";
			file_put_contents(APPPATH . 'logs/get_shiping_price_new/' . date("d-m-Y") . '_log.txt', print_r($log_data2, true), FILE_APPEND);
			return ['status' => FALSE, 'message' => "From Pincode Is Not Set"];
		} elseif ($to_pin == "" || $to_pin == null || $to_pin == NULL && $to_pin == "null") {
			$log_data2['logistic_error'] = "To Pincode Is Not Set";
			file_put_contents(APPPATH . 'logs/get_shiping_price_new/' . date("d-m-Y") . '_log.txt', print_r($log_data2, true), FILE_APPEND);
			return ['status' => FALSE, 'message' => "To Pincode Is Not Set"];
		} else {
			// CHECK IN PINCODE_MASTER IS EXIST OR NOT THAN GET PINCODE ID FROM OR TO BOTH
			$from_pin_data = $CI->db->get_where('pincode_master', array('TRIM(pincode)' => trim($from_pin)))->result();
			if (empty($from_pin_data)) {
				$log_data2['logistic_error'] = "Sender Pincode Is Not Found In Our Database";
				file_put_contents(APPPATH . 'logs/get_shiping_price_new/' . date("d-m-Y") . '_log.txt', print_r($log_data2, true), FILE_APPEND);
				return ['status' => FALSE, 'message' => "Sender Pincode Is Not Found In Our Database"];
			} else {
				$from_pin_id = $from_pin_data[0]->id;
			}
			$to_pin_data = $CI->db->get_where('pincode_master', array('TRIM(pincode)' => trim($to_pin)))->result();

			if (empty($to_pin_data)) {

				$log_data2['logistic_error'] = "Reciver Pincode Is Not Found In Our Database";
				file_put_contents(APPPATH . 'logs/get_shiping_price_new/' . date("d-m-Y") . '_log.txt', print_r($log_data2, true), FILE_APPEND);
				return ['status' => FALSE, 'message' => "Reciver Pincode Is Not Found In Our Database"];
			} else {
				$to_pin_id = $to_pin_data[0]->id;
			}
		}
		// CHECK IN ALL LOGISTIC FOR ASSIGN OR NOT FOR SHIPMENT OR ORDERTYPE        

		foreach ($logistic_ids as $key => $l_id) {
			if ($order_typ == 1 && $shipment_type == '1') {
				$from_logistic_pin_data = $CI->db->select('id')->from('pincode_detail')->where('pincode_id', $from_pin_id)->where('logistic_id', $l_id)->where('is_cod', '1')->where('is_pickup', '1')->get();
				$to_logistic_pin_data = $CI->db->select('id')->from('pincode_detail')->where('pincode_id', $to_pin_id)->where('logistic_id', $l_id)->where('is_cod', '1')->get();
				if (empty($from_logistic_pin_data->row()) || $from_logistic_pin_data->row() == "" || $from_logistic_pin_data->row() == NULL || $from_logistic_pin_data->row() == null || $from_logistic_pin_data->row() == "NULL" || empty($to_logistic_pin_data->row()) || $to_logistic_pin_data->row() == "" || $to_logistic_pin_data->row() == NULL || $to_logistic_pin_data->row() == null || $to_logistic_pin_data->row() == "NULL") {
					unset($logistic_ids[array_search($l_id, $logistic_ids)]);
				}
			} elseif ($order_typ == 0 && $shipment_type == '0') {
				$from_logistic_pin_data = $CI->db->select('id')->from('pincode_detail')->where('pincode_id', $from_pin_id)->where('logistic_id', $l_id)->where('is_prepaid', '1')->where('is_pickup', '1')->get();
				$to_logistic_pin_data = $CI->db->select('id')->from('pincode_detail')->where('pincode_id', $to_pin_id)->where('logistic_id', $l_id)->where('is_prepaid', '1')->get();
				if (empty($from_logistic_pin_data->row()) || $from_logistic_pin_data->row() == "" || $from_logistic_pin_data->row() == NULL || $from_logistic_pin_data->row() == null || $from_logistic_pin_data->row() == "NULL" || empty($to_logistic_pin_data->row()) || $to_logistic_pin_data->row() == "" || $to_logistic_pin_data->row() == NULL || $to_logistic_pin_data->row() == null || $to_logistic_pin_data->row() == "NULL") {
					unset($logistic_ids[array_search($l_id, $logistic_ids)]);
				}
			} elseif ($order_typ == 0 && $shipment_type == '1') {
				$from_logistic_pin_data = $CI->db->select('id')->from('pincode_detail')->where('pincode_id', $from_pin_id)->where('logistic_id', $l_id)->where('is_prepaid', '1')->where('is_reverse_pickup', '1')->get();
				$to_logistic_pin_data = $CI->db->select('id')->from('pincode_detail')->where('pincode_id', $to_pin_id)->where('logistic_id', $l_id)->where('is_prepaid', '1')->get();
				if (empty($from_logistic_pin_data->row()) || $from_logistic_pin_data->row() == "" || $from_logistic_pin_data->row() == NULL || $from_logistic_pin_data->row() == null || $from_logistic_pin_data->row() == "NULL" || empty($to_logistic_pin_data->row()) || $to_logistic_pin_data->row() == "" || $to_logistic_pin_data->row() == NULL || $to_logistic_pin_data->row() == null || $to_logistic_pin_data->row() == "NULL") {
					unset($logistic_ids[array_search($l_id, $logistic_ids)]);
				}
			} elseif ($order_typ == 1 && $shipment_type == '0') {
				$from_logistic_pin_data = $CI->db->select('id')->from('pincode_detail')->where('pincode_id', $from_pin_id)->where('logistic_id', $l_id)->where('is_cod', '1')->where('is_reverse_pickup', '1')->get();
				$to_logistic_pin_data = $CI->db->select('id')->from('pincode_detail')->where('pincode_id', $to_pin_id)->where('logistic_id', $l_id)->where('is_cod', '1')->get();
				if (empty($from_logistic_pin_data->row()) || $from_logistic_pin_data->row() == "" || $from_logistic_pin_data->row() == NULL || $from_logistic_pin_data->row() == null || $from_logistic_pin_data->row() == "NULL" || empty($to_logistic_pin_data->row()) || $to_logistic_pin_data->row() == "" || $to_logistic_pin_data->row() == NULL || $to_logistic_pin_data->row() == null || $to_logistic_pin_data->row() == "NULL") {
					unset($logistic_ids[array_search($l_id, $logistic_ids)]);
				}
			} elseif ($shipment_type == '2') {
				// Not Check From And To pincode awailibility
				$shipment_type = '1';
				$shipment_type_previus = TRUE;
			} else {
				$log_data3['logistic_error'] = "Order Type Or Shipment Type is not valid";
				file_put_contents(APPPATH . 'logs/get_shiping_price_new/' . date("d-m-Y") . '_log.txt', print_r($log_data3, true), FILE_APPEND);
				return ['status' => FALSE, 'message' => "Order Type Or Shipment Type is not valid"];
			}
		}
		$data_log['pincode_available_logistic'] = $logistic_ids;

		// CHECK LOGISTICS ARE AWAILABE OR NOT AFTER CHECK PIN FROM TO TO AND ASSIGNED LOGISTICS
		if (empty($logistic_ids)) {
			$log_data4['logistic_error'] = "This Logistic Is Not Provide This Delivery For this Pincode";
			file_put_contents(APPPATH . 'logs/get_shiping_price_new/' . date("d-m-Y") . '_log.txt', print_r($log_data4, true), FILE_APPEND);
			return ['status' => FALSE, 'message' => "This Logistic Is Not Provide This Delivery For this Pincode"];
		}

		// IF SINGLE ORDER OR RETURN MULTIPLE LOGISTIC PRICE            
		foreach ($logistic_ids as $key => $l_id) {
			$logistic_rules[$l_id] = $CI->db->select('*')->from('sender_manage_price')->join('rule_master', 'rule_master.id = sender_manage_price.rule')->where('sender_id', $sender_id)->where('sender_manage_price.logistic_id', $l_id)->where('sender_manage_price.shipment_type', $shipment_type)->order_by('sender_manage_price.rule_index', 'ASC')->get()->result_array();
			if (empty($logistic_rules[$l_id])) {
				$logistic_rules[$l_id] = $CI->db->select('*')->from('manage_price')->join('rule_master', 'rule_master.id = manage_price.rule')->where('manage_price.logistic_id', $l_id)->where('manage_price.shipment_type', $shipment_type)->order_by('manage_price.rule_index', 'ASC')->get()->result_array();
			} elseif (empty($logistic_rules[$l_id])) {
				$log_data5['logistic_error'] = "Logistic Have No Rules";
				file_put_contents(APPPATH . 'logs/get_shiping_price_new/' . date("d-m-Y") . '_log.txt', print_r($log_data5, true), FILE_APPEND);
				return ['status' => FALSE, 'message' => "Logistic Have No Rules"];
			}
		}
		$logistic_rules = array_filter($logistic_rules);
		if (empty($logistic_rules)) {
			$log_data6['logistic_error'] = "Logistic Have No Rules";
			file_put_contents(APPPATH . 'logs/get_shiping_price_new/' . date("d-m-Y") . '_log.txt', print_r($log_data6, true), FILE_APPEND);
			return ['status' => FALSE, 'message' => "Logistic Have No Rules"];
		}
		// CHECK MANAGE PRICE TYPE
		$distance = getdistance($from_pin, $to_pin);
		$data_log['distance'] = $distance;
		if ($from_pin_data[0]->city == $to_pin_data[0]->city) {
			$mange_price_type = "within_city";
		} elseif ($from_pin_data[0]->state == $to_pin_data[0]->state) {
			$mange_price_type = "within_state";
		} elseif (trim(strtoupper($to_pin_data[0]->state)) == "JAMMU & KASHMIR" || trim(strtoupper($to_pin_data[0]->state)) == "JAMMU AND KASMIR" || trim(strtoupper($to_pin_data[0]->state)) == "JAMMU" || trim(strtoupper($to_pin_data[0]->state)) == "KASHMIR" || trim(strtoupper($to_pin_data[0]->state)) == "JAMMUKASHMIR" || trim(strtoupper($to_pin_data[0]->state)) == "JAMMU KASHMIR") {
			$mange_price_type = "jammu_karshmir";
		} elseif ($distance > 2500) {
			$mange_price_type = "special_zone";
		} else {
			$from_metro_or_not = $CI->db->get_where('metrocity_master', array('UPPER(TRIM(metrocity_name)) =' => strtoupper(trim($from_pin_data[0]->city)), "is_active" => '1'))->result();
			$to_metro_or_not = $CI->db->get_where('metrocity_master', array('UPPER(TRIM(metrocity_name)) =' => strtoupper(trim($to_pin_data[0]->city)), "is_active" => '1'))->result();
			if (!empty($from_metro_or_not) && !empty($to_metro_or_not)) {
				if ($distance < 1400) {
					$mange_price_type = "metro";
				} else {
					$mange_price_type = "metro_2";
				}
			} else {
				if ($distance < 1400) {
					$mange_price_type = "rest_of_india";
				} else {
					$mange_price_type = "rest_of_india_2";
				}
			}
		}
		$data_log['distance_city'] = $mange_price_type;
		$data_response['status'] = true;
		$user_state = $CI->db->select('state')->from('sender_address_master')->where('sender_id', $sender_id)->get()->result_array();
		if (!empty($user_state) && $user_state[0]['state'] != "") {
			$user_state = $user_state[0]['state'];
		} else {
			$log_data7['logistic_error'] = "der State Not Found";
			file_put_contents(APPPATH . 'logs/get_shiping_price_new/' . date("d-m-Y") . '_log.txt', print_r($log_data7, true), FILE_APPEND);
			return ['status' => FALSE, 'message' => "Sender State Not Found"];
		}
		foreach ($logistic_rules as $key => $rules) {
			$weight = ($physical_weight > $volumetric_weight) ? $physical_weight : $volumetric_weight;
			$shipment_type_previus = (isset($shipment_type_previus) && $shipment_type_previus === TRUE) ? TRUE : FALSE;
			$get_sub_total_and_cod = get_price_on_rules_per_logistic($weight, $rules, $mange_price_type, $order_typ, $collectable_amount, $shipment_type_previus);
			$sub_total = $get_sub_total_and_cod['total_price'];
			$cod_count = $get_sub_total_and_cod['cod_ammount'];
			$logist_data = $CI->db->get_where('logistic_master', array('id =' => $key))->row();
			$logistic_name = ucfirst($logist_data->logistic_name);
			$api_name = ucfirst($logist_data->api_name);
			if ($sub_total != false || $shipment_type_previus === TRUE) {
				$tax = get_get_with_detail_by_state($user_state, "MAHARASHTRA", $gst, $sub_total);
				$total = (($gst / 100) * $sub_total) + $sub_total;
				$data_response['data'][] = [
					"logistic_id" =>  $key,
					"logistic" => $logistic_name,
					"api_name" => $api_name,
					"total" => $total,
					"subtotal" => $sub_total,
					"tax" => $tax,
					"cod_ammount" => $cod_count,
				];
			} else {
				$data_response['status'] = false;
				$data_response['data'][] = [
					"logistic_id" =>  $key,
					"logistic" => $logistic_name,
					"api_name" => $api_name,
					"total" => "Rulse Is Not Proper It's Infinite",
					"subtotal" => "Rulse Is Not Proper It's Infinite",
					"tax" => "Rulse Is Not Proper It's Infinite",
					"cod_ammount" => $cod_count,
				];
			}
			if ($is_bulk == 1) {
				$data_log['data_response'] = $data_response;
				file_put_contents(APPPATH . 'logs/get_shiping_price_new/' . date("d-m-Y") . '_log.txt', print_r($data_log, true) . "\n------- End Log ------\n", FILE_APPEND);
				return $data_response;
			}
		}
		$data_log['data_response'] = $data_response;
		file_put_contents(APPPATH . 'logs/get_shiping_price_new/' . date("d-m-Y") . '_log.txt', print_r($data_log, true) . "\n------- End Log ------\n", FILE_APPEND);
		return $data_response;
	}

	// PRICE CALCULTION ON WEIGHT AND RULES
	if (!function_exists('get_price_on_rules_per_logistic')) {
		function get_price_on_rules_per_logistic($physical_weight, $rules, $mange_price_type, $order_typ, $collectable_amount, $shipment_type_previus = FALSE)
		{
			$rule_log['lable'] = 'Calculate on wetght and rules';
			$rule_log['physical_weight'] = $physical_weight;
			$rule_log['mange_price_type'] = $mange_price_type;
			$rule_log['rules'] = $rules;
			$rule_log['order_typ'] = $order_typ;
			$rule_log['collectable_amount'] = $collectable_amount;
			$rule_log['shipment_type_previus'] = $shipment_type_previus;
			file_put_contents(APPPATH . 'logs/get_shiping_price_new/' . date("d-m-Y") . '_log.txt', "\n------- Start Rules Log ------\n" . print_r($rule_log, true), FILE_APPEND);
			$total_weight = $physical_weight;
			$awailable_weight = 0;
			$incrimantal_weight = 0;
			$total_rows = count($rules) - 1;
			$total_price = 0;
			$CI = &get_instance();
			$cod_percentage = $rules[0]['cod_percentage'];
			$cod_ammount = $rules[0]['cod_price'];
			foreach ($rules as $key1 => $rul) {
				if ($key1 == 0 && $total_rows == 0) {
					$total_weight_in_count = 0;
					$CI->benchmark->mark('price_start');
					while ($incrimantal_weight < $total_weight) {
						$CI->benchmark->mark('price_end');
						if ($CI->benchmark->elapsed_time('price_start', 'price_end') > '0.05') {
							return false;
							break;
						}
						$awailable_weight = $awailable_weight - $rul['to_kg'];
						$incrimantal_weight = $incrimantal_weight + $rul['to_kg'];
						$total_weight_in_count = $total_weight_in_count + 1;
					}
					$total_price = $total_price + ($total_weight_in_count * $rul[$mange_price_type]);
				} elseif ($key1 == 0) {
					$awailable_weight = $total_weight - $rul['to_kg'];
					$incrimantal_weight = $incrimantal_weight + $rul['to_kg'];
					$total_price = $total_price + $rul[$mange_price_type];
				} elseif ($total_rows == $key1) {
					$total_weight_in_count = 0;
					$CI->benchmark->mark('price_start');
					while ($incrimantal_weight < $total_weight) {
						$CI->benchmark->mark('price_end');
						if ($CI->benchmark->elapsed_time('price_start', 'price_end') > '0.05') {
							return false;
							break;
						}
						$awailable_weight = $awailable_weight - $rul['from_kg'];
						$incrimantal_weight = $incrimantal_weight + $rul['from_kg'];
						$total_weight_in_count = $total_weight_in_count + 1;
					}
					$total_price = $total_price + ($total_weight_in_count * $rul[$mange_price_type]);
				} else {
					$total_weight_in_count = 0;
					$CI->benchmark->mark('price_start');
					while ($incrimantal_weight < $rul['to_kg']) {
						$CI->benchmark->mark('price_end');
						if ($CI->benchmark->elapsed_time('price_start', 'price_end') > '0.05') {
							return false;
							break;
						}
						$awailable_weight = $awailable_weight - $rul['from_kg'];
						$incrimantal_weight = $incrimantal_weight + $rul['from_kg'];
						$total_weight_in_count = $total_weight_in_count + 1;
					}
					$total_price = $total_price + ($total_weight_in_count * $rul[$mange_price_type]);
				}
			}
			// if (($order_typ == 1 && $shipment_type_previus !== TRUE) || $order_typ != 0) {
			if (($order_typ == 1 && $shipment_type_previus !== TRUE)) {
				$cod_percentage = ($cod_percentage / 100) * $collectable_amount;
				$percentage_ammount = ($cod_percentage > $cod_ammount) ? $cod_percentage : $cod_ammount;
				$total_price = $total_price + $percentage_ammount;
			} else {
				$total_price = $total_price;
				$percentage_ammount = 0;
			}
			$data_response = [
				'cod_ammount' => $percentage_ammount,
				'total_price' => $total_price,
			];
			$rule_log1['rule_data_response'] = $data_response;
			file_put_contents(APPPATH . 'logs/get_shiping_price_new/' . date("d-m-Y") . '_log.txt', print_r($rule_log1, true) . "\n------- End Rules Log ------\n", FILE_APPEND);
			return $data_response;
		}
	}

	// COUNT GST WITH STATE
	if (!function_exists('get_get_with_detail_by_state')) {
		function get_get_with_detail_by_state($from_state, $to_state, $gst, $get_price_per_logistic)
		{
			$gst_log['lable'] = 'Count GST with state';
			$gst_log['from_state'] = $from_state;
			$gst_log['to_state'] = $to_state;
			$gst_log['gst'] = $gst;
			$gst_log['get_price_per_logistic'] = $get_price_per_logistic;
			file_put_contents(APPPATH . 'logs/get_shiping_price_new/' . date("d-m-Y") . '_log.txt', "\n------- Start GST Log ------\n" . print_r($gst_log, true), FILE_APPEND);
			if ($from_state == $to_state) {
				$sgst = $gst / 2;
				$cgst = $gst / 2;
				$sgst_ammount = ($sgst / 100) * $get_price_per_logistic;
				$cgst_ammount = ($cgst / 100) * $get_price_per_logistic;
				$tax = [
					"TOTAL_TAX_AMMOUNT" => 0,
					"CGST_PERCENTAGE" => 0,
					"CGST" => 0,
					"SGST_PERCENTAGE" => 0,
					"SGST" => 0,
					"IGST_PERCENTAGE" => 0,
					"IGST" => 0,
				];
				// GST RETURN 0

				// "TOTAL_TAX_AMMOUNT" => ($cgst + $sgst),
				// "CGST_PERCENTAGE" => $cgst,
				// "CGST" => $cgst_ammount,
				// "SGST_PERCENTAGE" => $sgst,
				// "SGST" => $sgst_ammount,
				// "IGST_PERCENTAGE" => 0,
				// "IGST" => 0,
			} else {
				$igst_ammount = ($gst / 100) * $get_price_per_logistic;
				$tax = [
					"TOTAL_TAX_AMMOUNT" => 0,
					"CGST_PERCENTAGE" => 0,
					"CGST" => 0,
					"SGST_PERCENTAGE" => 0,
					"SGST" => 0,
					"IGST_PERCENTAGE" => 0,
					"IGST" => 0,
				];
				// GST RETURN 0

				// "TOTAL_TAX_AMMOUNT" => ($gst),
				// "CGST_PERCENTAGE" => 0,
				// "CGST" => 0,
				// "SGST_PERCENTAGE" => 0,
				// "SGST" => 0,
				// "IGST_PERCENTAGE" => $gst,
				// "IGST" => $igst_ammount,
			}
			$gst_log1['rule_data_response'] = $tax;
			file_put_contents(APPPATH . 'logs/get_shiping_price_new/' . date("d-m-Y") . '_log.txt', print_r($gst_log1, true) . "\n------- End GST Log ------\n", FILE_APPEND);
			return $tax;
		}
	}

	// GET DISTINCE BETWEEN FROM TO TO PINCODE
	if (!function_exists('getdistance')) {
		function getdistance($from_pincode, $to_pincode)
		{
			$dist_log['lable'] = 'Get distance';
			$dist_log['from_pincode'] = $from_pincode;
			$dist_log['to_pincode'] = $to_pincode;
			file_put_contents(APPPATH . 'logs/get_shiping_price_new/' . date("d-m-Y") . '_log.txt', "\n------- Start Distance Log ------\n" . print_r($dist_log, true), FILE_APPEND);

			$CI = &get_instance();
			$CI->benchmark->mark('11');
			$CI->load->database();
			$CI->load->model('Common_model');
			$DISTANCE_API = $CI->config->item('DISTANCE_API');
			if ($from_pincode == $to_pincode) {
				return 0;
			}

			$from_to_to = $CI->Common_model->getRow(array('from_pincode' => $from_pincode, 'to_pincode' => $to_pincode), 'distance', 'distance_master');
			if (!empty($from_to_to->distance)) {
				$dist_log1['distance_result'] = $from_to_to->distance;
				file_put_contents(APPPATH . 'logs/get_shiping_price_new/' . date("d-m-Y") . '_log.txt', print_r($dist_log1, true) . "\n------- End Distance Log ------\n", FILE_APPEND);
				return $from_to_to->distance;
			}

			$to_to_from = $CI->Common_model->getRow(array('from_pincode' => $to_pincode, 'to_pincode' => $from_pincode), 'distance', 'distance_master');

			if (!empty($to_to_from->distance)) {
				$dist_log1['distance_result'] = $to_to_from->distance;
				file_put_contents(APPPATH . 'logs/get_shiping_price_new/' . date("d-m-Y") . '_log.txt', print_r($dist_log1, true) . "\n------- End Distance Log ------\n", FILE_APPEND);
				return $to_to_from->distance;
			}
			$data_response = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=" . $from_pincode . "&destinations=" . $to_pincode . "&key=" . $DISTANCE_API);
			$data = json_decode($data_response);
			if (!empty($data->status)) {
				if (@$data->rows[0]->elements[0]->status != 'ZERO_RESULTS') {
					foreach ($data->rows[0]->elements as $road) {
						$distance = @$road->distance->value;
					}
					$distance_insert_data['from_pincode'] = $from_pincode;
					$distance_insert_data['to_pincode'] = $to_pincode;
					$distance_insert_data['distance'] = $distance / 1000;
					$CI->Common_model->insert($distance_insert_data, 'distance_master');

					$dist_log1['distance_result'] = $distance / 1000;
					file_put_contents(APPPATH . 'logs/get_shiping_price_new/' . date("d-m-Y") . '_log.txt', print_r($dist_log1, true) . "\n------- End Distance Log ------\n", FILE_APPEND);
					return $distance / 1000;
				}
			} else {
				$dist_log1['distance_result'] = 'Distance Not Found';
				file_put_contents(APPPATH . 'logs/get_shiping_price_new/' . date("d-m-Y") . '_log.txt', print_r($dist_log1, true) . "\n------- End Distance Log ------\n", FILE_APPEND);
				return ['status' => FALSE, 'message' => "Distance Not Found"];
			}
		}
	}
}
