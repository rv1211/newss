<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Bug_fixer extends CI_Controller
{

	public function refund_success_delete_order($order_id)
	{
		$CI = &get_instance();

		$CI->load->model('Create_singleorder_awb');

		$order_data = $CI->db->select('fom.*, sm.wallet_balance')->from('forward_order_master as fom')->where('fom.is_delete', '1')->where('fom.id', $order_id)->join('sender_master as sm', 'fom.sender_id = sm.id')->get()->row_array();
		$log_data['order_data_info'] = $order_data;

		if (empty($order_data)) {
			$error = "No Order Found !!!";
		} else {
			$success = $error = "";
			$refund_amout = $order_data['paid_amount'];
			try {
				$CI->db->trans_start(false);
				$wallet_balance = $order_data['wallet_balance'];
				$update_amount = $wallet_balance + $refund_amout;

				$log_data['wallet_balance_in_wallet'] = $wallet_balance;
				$log_data['update_amount_in_wallet'] = $update_amount;
				$data = [
					'wallet_balance' => $update_amount,
				];
				$CI->db->where('id', $order_data['sender_id'])->update('sender_master', $data);
				$log_data['update_amount_update_query'] = $CI->db->last_query();

				$wallet_trancection_log = [
					'sender_id' => $order_data['sender_id'],
					'order_id' => $order_id,
					'credit' => $refund_amout,
					'runningbalance' => $update_amount,
					'remarks' => "Refund Credited Of Order id :" . $order_data['order_no'] . ", Awb Number :" . $order_data['awb_number'],
				];

				$CI->Create_singleorder_awb->update_tranction($wallet_trancection_log);
				$log_data['wallet_transaction'] = $wallet_trancection_log;
				$CI->db->trans_complete();

				if ($CI->db->trans_status() === false) {
					$CI->db->trans_rollback();
				} else {
					$success = "Amount Credited Successfully";
					$CI->db->trans_commit();
				}

				if (!empty($db_error)) {
					$log_data['throw_error'] = $db_error;
					throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
				}
			} catch (Exception $th) {
				$log_data['catch_error'] = $th->getMessage();
				$error = $th->getMessage();
			}
		}
		file_put_contents(APPPATH . 'logs/wallet_transaction/' . date("d-m-Y") . '_refund_wallet_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		if ($success != "") {
			echo $success;
		} else {
			echo  $error;
		}
	}

	public function test_get_price()
	{
		$this->load->helper('get_shiping_price');
		$total_shipping_price = get_shiping_price('72', '', '395010', '201301', '0', '0', '0.00', '0.90', '948.00', 1, 18);
		// $total_shipping_price_return = get_shiping_price('19', '1', '201301', '395010', '1', '0', '0.60', '0.60', '2500.00', 1, 18);
		// $total_shipping_price_rto = get_shiping_price('38', '2', '636011', '395010', '2', '1', '0.00', '0.80', '1049.00', 0, 18);
		echo "<pre>";
		// echo "Forward:<br>";
		// print_r($total_shipping_price);
		// echo "<br>return:<br>";
		// print_r($total_shipping_price_return);
		echo "<br>RTO:<br>";
		print_r($total_shipping_price);
		exit;
	}

	public function balak_delivery_date()
	{
		$sql = "SELECT * FROM `order_airwaybill_detail` WHERE `order_status_id` = '14' AND `delivery_date` = '0000-00-00' ORDER BY `delivery_date` DESC ";
		$query = $this->db->query($sql);
		$res = $query->result();
		foreach ($res as $single) {
			$sql1 = "SELECT * FROM `order_tracking_detail` WHERE `scan` ='rto delivered' AND `order_id` = " . $single->order_id . " ORDER BY id";
			$query1 = $this->db->query($sql1);
			$res1 = $query1->row();

			$update = "UPDATE `order_airwaybill_detail` SET `delivery_date` = '" . date('Y-m-d', strtotime($res1->scan_date_time)) . "' WHERE `order_airwaybill_detail`.`id` = " . $single->id;
			$this->db->query($update);
		}
	}
	public function balak_delivery_date_isnull()
	{
		$sql = "SELECT * FROM `order_airwaybill_detail` WHERE `order_status_id` = '14' AND `delivery_date` IS NULL ORDER BY `delivery_date` DESC ";
		$query = $this->db->query($sql);
		$res = $query->result();
		foreach ($res as $single) {
			$sql1 = "SELECT * FROM `order_tracking_detail` WHERE `scan` ='rto delivered' AND `order_id` = " . $single->order_id . " ORDER BY id";
			$query1 = $this->db->query($sql1);
			$res1 = $query1->row();

			$update = "UPDATE `order_airwaybill_detail` SET `delivery_date` = '" . date('Y-m-d', strtotime($res1->scan_date_time)) . "' WHERE `order_airwaybill_detail`.`id` = " . $single->id;
			$this->db->query($update);
		}
	}

	public function third_manageprice()
	{
		$sql = "SELECT * FROM `sender_manage_price` GROUP BY manage_price_id ORDER BY `manage_price_id` ASC ";
		$query = $this->db->query($sql);
		$res = $query->result();
		foreach ($res as $single) {
			$sql1 = "SELECT * FROM `manage_price` WHERE  `id` = " . $single->manage_price_id;
			$query1 = $this->db->query($sql1);
			$res1 = $query1->row_array();
			if (empty($res1)) {
				$array[] = $single->manage_price_id;
				$update = "DELETE FROM `sender_manage_price` WHERE `manage_price_id` = " . $single->manage_price_id;
				$this->db->query($update);
			}

			// $update = "UPDATE `order_airwaybill_detail` SET `delivery_date` = '" . date('Y-m-d', strtotime($res1->scan_date_time)) . "' WHERE `order_airwaybill_detail`.`id` = " . $single->id;
			// $this->db->query($update);
		}

		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}

	public function rto_refund_wallet()
	{
		$this->load->model('Common_model');
		$order_data = $this->db->select('id,order_id,debit,runningbalance')->from('wallet_transaction')->where("remarks LIKE '%Deduct RTO Created%'")->order_by('id', 'DESC')->get()->result_array();
		$error_log = array();
		dd($order_data);
		if (!empty($order_data)) {
			foreach ($order_data as $orderVal) {
				echo "<br>---------------- Start ---------------------------<br>";
				echo "<pre>";
				print_r($orderVal);
				$orderData = $this->db->select('fom.id, fom.sender_id, fom.logistic_id, fom.order_type, fom.order_no, sm.wallet_balance, sm.allow_credit_limit, ra.pincode as from_pin, sam.pincode as to_pin, opd.volumetric_weight, opd.physical_weight, opd.cod_amount, oad.airwaybill_no')->from('forward_order_master as fom')->join('sender_master as sm', 'fom.sender_id = sm.id')->join('order_airwaybill_detail as oad', 'fom.id = oad.order_id')->join('receiver_address as ra', 'fom.deliver_address_id = ra.id')->join('sender_address_master as sam', 'fom.pickup_address_id = sam.id')->join('order_product_detail as opd', 'fom.order_product_detail_id = opd.id')->where('fom.id', $orderVal['order_id'])->get()->row_array();
				$this->load->helper('get_shiping_price');
				$total_shipping_price = get_shiping_price($orderData['sender_id'], $orderData['logistic_id'], $orderData['from_pin'], $orderData['to_pin'], '2', $orderData['order_type'], $orderData['volumetric_weight'], $orderData['physical_weight'], $orderData['cod_amount'], 0, 18);
				print_r($orderData);
				print_r($total_shipping_price);
				echo "</pre><br>";
				if ($total_shipping_price['status'] == true) {
					// success
					$orderCharge = $total_shipping_price['data'][0]['subtotal'];
					if ($orderCharge != "Rulse Is Not Proper It's Infinite") {
						if ($orderCharge < $orderVal['debit']) {
							$total_balance = $orderVal['debit'] - $orderCharge;
							$wallet_data = array(
								'wallet_balance' => $orderData['wallet_balance'] + $total_balance
							);
							$update_wallet = $this->Common_model->update($wallet_data, 'sender_master', array('id' => $orderData['sender_id']));
							echo $this->db->last_query() . "<br>";

							$wallet_trancection_log = [
								'sender_id' => $orderData['sender_id'],
								'order_id' => $orderData['id'],
								'credit' => $total_balance,
								'runningbalance' => $orderData['wallet_balance'] + $total_balance,
								'remarks' => "Credit RTO Charge for wallet adjuct for Order id :" . $orderData['order_no'] . ", Awb Number:" . $orderData['airwaybill_no'],
							];
							$insert_transaction_wallet = $this->Common_model->insert($wallet_trancection_log, 'wallet_transaction');
							echo $this->db->last_query() . "<br>";
						} else if ($orderCharge > $orderVal['debit']) {
							$total_balance = $orderCharge - $orderVal['debit'];
							$wallet_data = array(
								'wallet_balance' => $orderData['wallet_balance'] - $total_balance
							);
							$update_wallet = $this->Common_model->update($wallet_data, 'sender_master', array('id' => $orderData['sender_id']));
							echo $this->db->last_query() . "<br>";

							$wallet_trancection_log = [
								'debit' => $orderCharge,
								'runningbalance' => $orderData['wallet_balance'] - $total_balance,
							];
							$update_transaction_wallet = $this->Common_model->update($wallet_trancection_log, 'wallet_transaction', array('id' => $orderVal['id']));
							// $insert_transaction_wallet = $this->Common_model->insert($wallet_trancection_log, 'wallet_transaction');
							echo $this->db->last_query() . "<br>";
						}
					} else {
						echo "error<br>";
						$error_log[] = $orderVal['order_id'];
					}
				} else {
					echo "error<br>";
					$error_log[] = $orderVal['order_id'];
				}
				echo "<br>---------------- End ---------------------------<br>";
			}
		}
		echo "<pre>";
		print_r($error_log);
	}

	public function get_subtotal()
	{
		$this->load->helper('get_shiping_price_new');
		$total_shipping_price = get_shiping_price('37', '', '394210', '752002', '1', '1', '0.14933333333333', '0.8', '582', '1', '18');
		echo "<pre>";
		print_r($total_shipping_price);
		exit;
	}

	public function rto_refund_wallet_new()
	{
		$this->load->model('Common_model');
		$sender_data = $this->db->select('id, wallet_balance')->from('sender_master')->get()->result_array();
		echo "<pre>";
		print_r($sender_data);
		echo "<br>";
		foreach ($sender_data as $senderVal) {
			$wallet_data = $this->db->select_sum('debit')->from('wallet_transaction')->where("remarks LIKE '%Deduct RTO Created%'")->where('sender_id', $senderVal['id'])->get()->row_array();
			echo $this->db->last_query() . "<br>";
			print_r($wallet_data);
			echo "<br>";
			if (!empty($wallet_data) || $wallet_data['debit'] != '0') {
				$walletData = array(
					'wallet_balance' => $senderVal['wallet_balance'] + $wallet_data['debit']
				);
				$update_wallet = $this->Common_model->update($walletData, 'sender_master', array('id' => $senderVal['id']));
				echo $this->db->last_query() . "<br>";

				$walletRTOData = array(
					'debit' => '0.00'
				);
				$this->db->where('sender_id', $senderVal['id'])->where("remarks LIKE '%Deduct RTO Created%'")->update('wallet_transaction', $walletRTOData);
				echo $this->db->last_query() . "<br>";
			}
		}
	}
	public function city_state()
	{

		$sql = "SELECT * FROM receiver_address WHERE state='' OR city='' ";
		$query = $this->db->query($sql);
		$res = $query->result();


		foreach ($res as $single) {
			$pincode = $single->pincode;
			$sql2 = "SELECT * FROM pincode_master WHERE pincode LIKE('%$pincode%')";

			$query2 = $this->db->query($sql2);
			$res2 = $query2->row();
			echo "<br>";
			echo $this->db->last_query();

			if (empty($res2)) {
				continue;
			}
			$update = "UPDATE receiver_address SET state='" . $res2->state . "' , city='" . $res2->city . "' WHERE id = " . $single->id;
			$query3 = $this->db->query($update);
			echo "<br>";
			echo $this->db->last_query();
		}
	}


	public function test()
	{
		$this->load->helper('delivery_direct_helper');
		delhiver_direct::cancel_order(10, 0);
	}


	public function clear_bulk_stuck()
	{

		$sql = "UPDATE `temp_order_master` SET `is_running` = '0' WHERE `temp_order_master`.`is_flag` = '1'";
		$query = $this->db->query($sql);

		$this->session->set_flashdata('message', "Bulk Order Queue Reset Successfull");
		redirect('clear-stuck');
	}


	public function clear_bulk()
	{
		load_admin_view("bulk_order", "clear_queue");
	}
}   

/* End of file bu.php */
