<?php
class wallet_direct
{
	/**
	 * Wallet Deduct
	 * @return Response
	 */
	static function debit_wallet($order_id, $temp_table_name, $awbNumber, $order_no, $error = '', $is_delete = 1, $udaan_shipmentIds = '', $ecart_requestId = '', $shipr_order_id = '', $shpr_shipment_id = '')
	{
		$CI = &get_instance();
		$CI->load->model('Create_singleorder_awb');
		$CI->load->model('Common_model');
		$CI->load->library('session');

		$path = APPPATH . 'logs/wallet_log/';
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}

		$log_data['process_start_time'] = date("d-m-y H:i:s");
		$orderdata = $CI->Common_model->getSingle_data('*', $temp_table_name, array('id' => $order_id));
		$log_data['awb_number'] = $awbNumber;
		$log_data['order_data'] = $orderdata;
		$log_data['shipr_order_id'] = $shipr_order_id;
		$log_data['shpr_shipment_id'] = $shpr_shipment_id;
		$log_data['order_no'] = $order_no;
		$log_data['order_query'] = $CI->db->last_query();
		$logistic = $CI->Common_model->getSingle_data('api_name', 'logistic_master', array('id' => $orderdata['logistic_id']));
		$log_data['logistic_query'] = $CI->db->last_query();
		$log_data['logistic'] = $logistic['api_name'];
		file_put_contents(APPPATH . 'logs/wallet_log/' . date("d-m-Y") . '_wallet_' . $orderdata['sender_id'] . '_log.txt', "\n-------------- Start Wallet Log -----------------\n" . print_r($log_data, true), FILE_APPEND);

		if (!empty($error)) {
			$log_error['order_error'] = $error;
			$errorOrder = wallet_direct::move_order($order_id, $logistic['api_name'], $awbNumber, $orderdata, $order_no, $error, $temp_table_name, 'error_order_master', $is_delete, $udaan_shipmentIds, $ecart_requestId);
			$log_error['move_order'] = $errorOrder;
			file_put_contents(APPPATH . 'logs/wallet_log/' . date("d-m-Y") . '_wallet_' . $orderdata['sender_id'] . '_log.txt', "\n" . print_r($log_error, true), FILE_APPEND);
			$responce['status'] = "0";
			$responce['message'] = $error;
		} else {
			$walletSufficient = 0;
			$getwallet_data = $CI->Common_model->getSingle_data('id,email,wallet_balance,allow_credit,allow_credit_limit', 'sender_master', array('id' => $orderdata['sender_id']));

			if ($orderdata['igst_amount'] == 0.00) {
				$order_charge = floatval($orderdata['cgst_amount']) + floatval($orderdata['sgst_amount']) + floatval($orderdata['total_shipping_amount']);
			} else {
				$order_charge = floatval($orderdata['igst_amount'])  + floatval($orderdata['total_shipping_amount']);
			}
			if (0 < $getwallet_data['wallet_balance']) {
				$remain_balance = $getwallet_data['wallet_balance'] - $order_charge;
			} else {
				$remain_balance = $order_charge;
			}
			// $remain_balance = $getwallet_data['wallet_balance'] - $order_charge;
			if ($getwallet_data['allow_credit'] == '1') {
				// Allow Credit
				if ($remain_balance < 0) {
					// minus balance
					if ($getwallet_data['allow_credit_limit'] > abs($remain_balance) && $getwallet_data['allow_credit_limit'] != 0) {
						// Debit success
						$wallet_debit = wallet_direct::wallet_update($order_id, $logistic['api_name'], $awbNumber, $orderdata, $temp_table_name, $getwallet_data, $order_charge, $order_no, '0', $is_delete, $udaan_shipmentIds, $ecart_requestId, $shipr_order_id, $shpr_shipment_id);
						$log_order['wallet_debit'] = $wallet_debit;
						file_put_contents(APPPATH . 'logs/wallet_log/' . date("d-m-Y") . '_wallet_' . $orderdata['sender_id'] . '_log.txt', "\n" . print_r($log_order, true), FILE_APPEND);
						$responce['status'] = $wallet_debit == 'success' ? '1' : "0";
						$responce['message'] = $wallet_debit;
					} else {
						// unsufficiant balance
						$errorMsg = 'You have not sufficient wallet balance,Recharge your wallet';
						$log_order['order_error'] = $errorMsg;
						$errorOrder = wallet_direct::move_order($order_id, $logistic['api_name'], $awbNumber, $orderdata, $order_no, $errorMsg, $temp_table_name, 'error_order_master', $is_delete, $udaan_shipmentIds, $ecart_requestId);
						$log_order['move_order'] = $errorOrder;
						file_put_contents(APPPATH . 'logs/wallet_log/' . date("d-m-Y") . '_wallet_' . $orderdata['sender_id'] . '_log.txt', "\n" . print_r($log_order, true), FILE_APPEND);
						$responce['status'] = $errorOrder != '0' ? '1' : "0";
						$responce['message'] = $errorMsg;
					}
				} else {
					// debit from wallat
					$wallet_debit = wallet_direct::wallet_update($order_id, $logistic['api_name'], $awbNumber, $orderdata, $temp_table_name, $getwallet_data, $order_charge, $order_no, '1', $is_delete, $udaan_shipmentIds, $ecart_requestId, $shipr_order_id, $shpr_shipment_id);
					$log_order['wallet_debit'] = $wallet_debit;
					file_put_contents(APPPATH . 'logs/wallet_log/' . date("d-m-Y") . '_wallet_' . $orderdata['sender_id'] . '_log.txt', "\n" . print_r($log_order, true), FILE_APPEND);
					$responce['status'] = $wallet_debit == 'success' ? '1' : "0";
					$responce['message'] = $wallet_debit;
				}
			} else {
				// No Allow Credit
				if ($remain_balance >= 000) {
					// Cut from Wallat
					$wallet_debit = wallet_direct::wallet_update($order_id, $logistic['api_name'], $awbNumber, $orderdata, $temp_table_name, $getwallet_data, $order_charge, $order_no, '1', $is_delete, $udaan_shipmentIds, $ecart_requestId, $shipr_order_id, $shpr_shipment_id);
					$log_order['wallet_debit'] = $wallet_debit;
					file_put_contents(APPPATH . 'logs/wallet_log/' . date("d-m-Y") . '_wallet_' . $orderdata['sender_id'] . '_log.txt', "\n" . print_r($log_order, true), FILE_APPEND);
					$responce['status'] = $wallet_debit == 'success' ? '1' : "0";
					$responce['message'] = $wallet_debit;
				} else {
					// unsufficiant balance
					$errorMsg = 'You have not sufficient wallet balance,Recharge your wallet';
					$log_order['order_error'] = $errorMsg;
					$errorOrder = wallet_direct::move_order($order_id, $logistic['api_name'], $awbNumber, $orderdata, $order_no, $errorMsg, $temp_table_name, 'error_order_master', $is_delete, $udaan_shipmentIds, $ecart_requestId);
					$log_order['move_order'] = $errorOrder;
					file_put_contents(APPPATH . 'logs/wallet_log/' . date("d-m-Y") . '_wallet_' . $orderdata['sender_id'] . '_log.txt', "\n" . print_r($log_order, true), FILE_APPEND);
					$responce['status'] = $errorOrder != '0' ? '1' : "0";
					$responce['message'] = $errorMsg;
				}
			}
		}
		return $responce;
	}

	// Debit Amount
	static function wallet_update($order_id, $api_name, $awbNumber, $orderdata, $temp_table_name, $getwallet_data, $order_charge, $order_no, $is_wallet, $is_delete, $udaan_shipmentIds, $ecart_requestId, $shipr_order_id = '', $shpr_shipment_id = '')
	{
		$CI = &get_instance();
		$CI->load->model('Common_model');
		$remain_balance = $getwallet_data['wallet_balance'] - $order_charge;
		$amount_credit = $getwallet_data['allow_credit_limit'] - abs($remain_balance);
		$wallet_data = array(
			'wallet_balance' => $remain_balance
		);
		$update_wallet = $CI->Common_model->update($wallet_data, 'sender_master', array('id' => $orderdata['sender_id']));
		$log_order['update_wallet_query'] = $CI->db->last_query();

		if ($update_wallet == true) {
			$amount_data = array(
				'paid_amount' => $order_charge,
				'remain_amount' => '0'
			);
			$orderdata['paid_amount'] = $order_charge;
			$orderdata['remain_amount'] = '0';
			$update_amount = $CI->Common_model->update($amount_data, $temp_table_name, array('id' => $order_id));
			$log_order['update_amount_query'] = $CI->db->last_query();
			$log_order['update_amount_result'] = $update_amount;

			$orderdata['shipr_order_id'] = $shipr_order_id;
			$orderdata['shpr_shipment_id'] = $shpr_shipment_id;
			$last_insertId = wallet_direct::move_order($order_id, $api_name, $awbNumber, $orderdata, $order_no, '', $temp_table_name, 'forward_order_master', $is_delete, $udaan_shipmentIds, $ecart_requestId);
			$log_order['move_order'] = $last_insertId;

			$wallet_trancection_log = [
				'sender_id' => $orderdata['sender_id'],
				'order_id' => $last_insertId,
				'debit' => $order_charge,
				'runningbalance' => $remain_balance,
				'remarks' => "Order id :" . $order_no . ", Awb Number:" . $awbNumber,
			];
			$insert_transaction_wallet = $CI->Common_model->insert($wallet_trancection_log, 'wallet_transaction');
			$log_order['transaction_wallet_query'] = $CI->db->last_query();
			file_put_contents(APPPATH . 'logs/wallet_log/' . date("d-m-Y") . '_wallet_' . $orderdata['sender_id'] . '_log.txt', "\n" . print_r($log_order, true), FILE_APPEND);
			// $errorOrder = wallet_direct::move_order($order_id, $api_name, $awbNumber, $orderdata, $order_no, '', $temp_table_name, 'forward_order_master', $is_delete, $udaan_shipmentIds, $ecart_requestId);
			// $log_order2['move_order'] = $errorOrder;

			$log_order2['payment_status'] = "paid";
			$log_order2['wallet_balance'] = $remain_balance;
			$log_order2['allow_credit_limit'] = $order_charge;
			$log_order2['wallet_trancation'] = $wallet_trancection_log;
			file_put_contents(APPPATH . 'logs/wallet_log/' . date("d-m-Y") . '_wallet_' . $orderdata['sender_id'] . '_log.txt', "\n" . print_r($log_order2, true), FILE_APPEND);
			$msg = "success";
		} else {
			// Amount cant be debited from wallet 
			$log_order['order_error'] = 'Amount cant be debited from wallet';
			$errorOrder = wallet_direct::move_order($order_id, $api_name, $awbNumber, $orderdata, $order_no, 'Amount cant be debited from wallet', $temp_table_name, 'error_order_master', $is_delete, $udaan_shipmentIds, $ecart_requestId);
			$log_order['move_order'] = $errorOrder;
			file_put_contents(APPPATH . 'logs/wallet_log/' . date("d-m-Y") . '_wallet_' . $orderdata['sender_id'] . '_log.txt', "\n" . print_r($log_order, true), FILE_APPEND);
			$msg = "error";
		}
		return $msg;
	}

	// Move Order
	static function move_order($order_id, $api_name, $awbNumber, $orderdata, $order_no, $error, $temp_table_name, $order_table, $is_delete, $udaan_shipmentIds, $ecart_requestId)
	{
		$CI = &get_instance();
		$CI->load->model('Common_model');
		$log_data = array();

		if ($is_delete == '1' || $is_delete == 1) {
			// if (strpos($api_name, 'Xpress') !== false) {
			// 	switch ($api_name) {
			// 		case 'Xpressbees_Direct':
			// 			$delete_awb = $CI->Common_model->delete(strtolower(trim($api_name)) . "_airwaybill", array('awb_number' => $awbNumber));
			// 			break;
			// 		case 'Xpressbeesair_Direct';
			// 			$delete_awb = $CI->Common_model->delete(strtolower('Xpressbees_Direct') . "_airwaybill", array('awb_number' => $awbNumber));
			// 			break;
			// 	}
			// } else {
			$delete_awb = $CI->Common_model->delete(strtolower(trim($api_name)) . "_airwaybill", array('awb_number' => $awbNumber));
			// }
			$log_data['awb_delete_query'] = $CI->db->last_query();
		}

		unset($orderdata['id'], $orderdata['updated_date'], $orderdata['created_date'], $orderdata['is_process'], $orderdata['is_flag'], $orderdata['error_message'], $orderdata['is_created']);
		if ($temp_table_name == 'temp_order_master') {
			unset($orderdata['is_running']);
		}
		$orderdata['customer_order_no'] = $orderdata['customer_order_no'] == '' ? $order_no : $orderdata['customer_order_no'];
		$orderdata['order_no'] = $orderdata['order_no'] == '' ? $order_no : $orderdata['order_no'];
		$orderdata['awb_number'] = $orderdata['awb_number'] == '' ? $awbNumber : $orderdata['awb_number'];


		$inser_order = $CI->Common_model->insert($orderdata, $order_table);
		$log_data['move_order_query'] = $CI->db->last_query();
		$last_order_id = $CI->db->insert_id();
		$log_data['last_insert_id'] = $last_order_id;
		if ($order_table == 'error_order_master') {
			$logarr = array(
				'order_Error_id' => $last_order_id,
				'error' => $error
			);
			$log_query = $CI->Common_model->insert($logarr, 'order_error_log');
			$log_data['order_log_query'] = $CI->db->last_query();
		} else {
			$barcode_data = array(
				'order_id' => $last_order_id,
				'airwaybill_no' => $awbNumber,
				'order_status_id' => '1',
				'order_type' => '0'
			);
			if ($ecart_requestId != '') {
				$barcode_data['ecart_request_id'] = $ecart_requestId;
			}
			$barcode_query = $CI->Common_model->insert($barcode_data, 'order_airwaybill_detail');
			$log_data['barcode_query'] = $CI->db->last_query();

			if ($udaan_shipmentIds != '') {
				$shipment_data = array(
					'order_id' => $last_order_id,
					'udaan_shipment_id' => $udaan_shipmentIds
				);
				$shipment_query = $CI->Common_model->insert($shipment_data, 'order_udaan_shipment_id_detail');
				$log_data['shipment_query'] = $CI->db->last_query();
			}
		}

		$delete_temp_order = $CI->Common_model->delete($temp_table_name, array('id' => $order_id));
		$log_data['delete_temp_order_query'] = $CI->db->last_query();
		file_put_contents(APPPATH . 'logs/wallet_log/' . date("d-m-Y") . '_wallet_' . $orderdata['sender_id'] . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		return $last_order_id;
	}

	public static function refund_wallet($awbNumber, $wallet_status, $shipment_type = 1)
	{
		$CI = &get_instance();
		$CI->load->model('Common_model');
		$success = $error = '';

		$log_data['awbNumber'] = $awbNumber;
		file_put_contents(APPPATH . 'logs/wallet_log/' . date("d-m-Y") . '_wallet_rto_log.txt', "\n ----------- Start RTO wallet Transaction-------------\n" . print_r($log_data, true) . "", FILE_APPEND);
		// wallet_status 0-debit and shipment_type 0-forward, 1-reverce
		if ($wallet_status == '0') {
			// debit from wallet
			$log_order['Type'] = 'Debit';
			$orderData = $CI->db->select('fom.id, fom.sender_id, fom.logistic_id, fom.order_type, fom.order_no, sm.wallet_balance, sm.allow_credit_limit, ra.pincode as from_pin, sam.pincode as to_pin, opd.volumetric_weight, opd.physical_weight, opd.cod_amount')->from('forward_order_master as fom')->join('sender_master as sm', 'fom.sender_id = sm.id')->join('order_airwaybill_detail as oad', 'fom.id = oad.order_id')->join('receiver_address as ra', 'fom.deliver_address_id = ra.id')->join('sender_address_master as sam', 'fom.pickup_address_id = sam.id')->join('order_product_detail as opd', 'fom.order_product_detail_id = opd.id')->where('oad.airwaybill_no', $awbNumber)->get()->row_array();
			$log_order['order_query'] = $CI->db->last_query();
			$log_order['order_query_result'] = $orderData;
			$remark = "Deduct RTO Created for Order id :" . $orderData['order_no'] . ", Awb Number:" . $awbNumber;
			$transactionLog = $CI->db->select('id')->from('wallet_transaction')->where("remarks LIKE '%$remark%'")->get()->row_array();
			if (empty($transactionLog) && !empty($orderData)) {

				$CI->load->helper('get_shiping_price');
				$total_shipping_price = get_shiping_price($orderData['sender_id'], $orderData['logistic_id'], $orderData['from_pin'], $orderData['to_pin'], $shipment_type, $orderData['order_type'], $orderData['volumetric_weight'], $orderData['physical_weight'], $orderData['cod_amount'], 0, 18);
				$log_order['$total_shipping_price'] = $total_shipping_price;
				if ($total_shipping_price['status'] == true) {
					// success
					$orderCharge = $total_shipping_price['data'][0]['subtotal'];
					$total_balance = $orderData['wallet_balance'] - $orderCharge;
					$wallet_data = array(
						'wallet_balance' => $total_balance
					);
					$update_wallet = $CI->Common_model->update($wallet_data, 'sender_master', array('id' => $orderData['sender_id']));
					$log_order['update_wallet_query'] = $CI->db->last_query();

					$wallet_trancection_log = [
						'sender_id' => $orderData['sender_id'],
						'order_id' => $orderData['id'],
						'debit' => $orderCharge,
						'runningbalance' => $total_balance,
						'remarks' => "Deduct RTO Created for Order id :" . $orderData['order_no'] . ", Awb Number:" . $awbNumber,
					];
					$insert_transaction_wallet = $CI->Common_model->insert($wallet_trancection_log, 'wallet_transaction');
					$log_order['transaction_wallet_query'] = $CI->db->last_query();
				} else {
					// error $total_shipping_price['message']
					$orderCharge = $total_shipping_price['data'][0]['subtotal'];
					$total_balance = $orderData['wallet_balance'] - $orderCharge;
					$wallet_data = array(
						'wallet_balance' => $total_balance
					);
					$update_wallet = $CI->Common_model->update($wallet_data, 'sender_master', array('id' => $orderData['sender_id']));
					$log_order['update_wallet_query'] = $CI->db->last_query();

					$wallet_trancection_log = [
						'sender_id' => $orderData['sender_id'],
						'order_id' => $orderData['id'],
						'debit' => $orderCharge,
						'runningbalance' => $total_balance,
						'remarks' => "Deduct RTO Created for Order id :" . $orderData['order_no'] . ", Awb Number:" . $awbNumber,
					];
					$insert_transaction_wallet = $CI->Common_model->insert($wallet_trancection_log, 'wallet_transaction');
					$log_order['transaction_wallet_query'] = $CI->db->last_query();
				}
				$success = 'Deduct RTO Created for Awb Number:' . $awbNumber;
			} else {
				$error = 'Already Debited for Awb Number:' . $awbNumber;
			}
		} else {
			// credit from wallet
			$log_order['Type'] = 'Credit';
			$orderData = $CI->db->select('fom.id, fom.sender_id, fom.logistic_id, fom.order_type, fom.order_no, sm.wallet_balance, opd.cod_charge')->from('forward_order_master as fom')->join('sender_master as sm', 'fom.sender_id = sm.id')->join('order_airwaybill_detail as oad', 'fom.id = oad.order_id')->where('oad.airwaybill_no', $awbNumber)->join('order_product_detail as opd', 'fom.order_product_detail_id = opd.id')->get()->row_array();

			$remark = "Credit COD charge for Order id :" . $orderData['order_no'] . ", Awb Number:" . $awbNumber;
			$transactionLog = $CI->db->select('id')->from('wallet_transaction')->where("remarks LIKE '%$remark%'")->get()->row_array();
			if (empty($transactionLog)) {
				$cod_charge = $CI->Common_model->getSingle_data('id', 'manage_price', array('logistic_id' => $orderData['logistic_id'], 'is_cod_charge_return' => '1'));

				if (!empty($cod_charge) && $orderData['order_type'] == '1') {
					// Credit Cod charge in user wallet
					$total_balance = $orderData['wallet_balance'] + $orderData['cod_charge'];
					$wallet_data = array(
						'wallet_balance' => $total_balance
					);
					$update_wallet = $CI->Common_model->update($wallet_data, 'sender_master', array('id' => $orderData['sender_id']));
					$log_order['update_wallet_query'] = $CI->db->last_query();

					// add Wallet transaction Log
					$wallet_trancection_log = [
						'sender_id' => $orderData['sender_id'],
						'order_id' => $orderData['id'],
						'credit' => $orderData['cod_charge'],
						'runningbalance' => $total_balance,
						'remarks' => "Credit COD charge for Order id :" . $orderData['order_no'] . ", Awb Number:" . $awbNumber,
					];
					$insert_transaction_wallet = $CI->Common_model->insert($wallet_trancection_log, 'wallet_transaction');
					$log_order['transaction_wallet_query'] = $CI->db->last_query();
					$success = 'COD charge Credited for for Awb Number:' . $awbNumber;
				} else {
					$error = 'No COD charge return for Awb Number:' . $awbNumber;
				}
			} else {
				$error = 'Already COD charge Credited for Awb Number:' . $awbNumber;
			}
		}
		file_put_contents(APPPATH . 'logs/wallet_log/' . date("d-m-Y") . '_wallet_rto_log.txt', "\n" . print_r($log_order, true) . "\n ----------- End RTO wallet Transaction-------------\n\n", FILE_APPEND);
		if ($success) {
			$res['status'] = "1";
			$res['message'] = $success;
		} else {
			$res['status'] = "0";
			$res['message'] = $error;
		}
		return $res;
	}
}
