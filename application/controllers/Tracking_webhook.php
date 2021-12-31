<?php
class Tracking_webhook extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->db->cache_delete_all();
	}


	public function get_xpressbees_tracking_detail()
	{
		$post = @file_get_contents("php://input");
		$log_data['post_data'] = $post;
		$array = json_decode($post, true);

		if ($array['Remarks'] != "") {
			$single_order_info = $this->Common_model->getSingleRowArray(array('airwaybill_no' => $array['AWBNO']), 'id,order_status_id,order_id', 'order_airwaybill_detail');
			$log_data['single_order_info'] = $single_order_info;
			if (!empty($single_order_info)) {
				$insert_order_tracking_detail = array(
					'order_id' => $single_order_info['order_id'],
					'scan_date_time' => date("Y-m-d H:i:s", strtotime($array['StatusDate'] . " " . $array['StatusTime'])),
					'remark' => $array['Remarks'],
					'location' => $array['CurrentLocation'],
				);

				$order_update_data = $this->set_order_status(strtolower($array['Remarks']), date("Y-m-d", strtotime($array['StatusDate'])));

				if ($order_update_data['order_status_id'] == '9') {
					$status = $this->db->select('order_id')->from('order_airwaybill_detail')->where('airwaybill_no', $array['AWBNO'])->where('order_status_id', '9')->get()->result_array();
					// if (empty($status)) {
					$result = wallet_direct::refund_wallet(trim($array['AWBNO']), '0', '2');
					$log_data['walelt_data'] = $status;
					$log_data['wallet_debit_responce'] = $result;
					// }
				}

				if ($order_update_data['order_status_id'] == '14') {
					$status = $this->db->select('order_id')->from('order_airwaybill_detail')->where('airwaybill_no', $array['AWBNO'])->where('order_status_id', '14')->get()->result_array();
					// if (empty($status)) {
					$result = wallet_direct::refund_wallet(trim($array['AWBNO']), '1', '2');
					$log_data['walelt_data'] = $status;
					$log_data['wallet_credit_responce'] = $result;
					// }
				}

				$single_order_status_info = $this->Common_model->getSingleRowArray(array('order_status_id' => $order_update_data['order_status_id']), 'status_name', 'order_status');
				$insert_order_tracking_detail['scan'] = $single_order_status_info['status_name'];

				// if ($single_order_info['order_status_id'] != $order_update_data['order_status_id']) {
				$this->Common_model->insert($insert_order_tracking_detail, 'order_tracking_detail');

				$this->Common_model->update($order_update_data, 'order_airwaybill_detail', array('order_id' => $single_order_info['order_id']));
				$log_data['status_update_query'] = $this->db->last_query();
				// }
			}
		}
		file_put_contents(APPPATH . 'logs/tracking_webhook_log/' . date("d-m-Y") . '_xpressbees_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
	}

	function set_order_status($order_status, $scan_date_time)
	{
		switch (strtolower($order_status)) {
			case 'manifested':
				$order_update_data['order_status_id'] = '1';
				break;
			case 'not picked':
				$order_update_data['order_status_id'] = '8';
				break;
			case 'data received':
				$order_update_data['order_status_id'] = '1';
				break;
			case 'new':
				$order_update_data['order_status_id'] = '1';
				break;
			case 'booked':
				$order_update_data['order_status_id'] = '1';
				break;
			case "in_transit":
			case 'in transit':
				$order_update_data['order_status_id'] = '3';
				break;
			case 'scheduled':
				$order_update_data['order_status_id'] = '3';
				break;
			case 'drs prepared':
				$order_update_data['order_status_id'] = '3';
				break;
			case 'assigned_for_seller_pickup':
			case 'pickup created':
			case 'ofp':
				$order_update_data['order_status_id'] = '2';
				break;
			case 'pickdone':
				$order_update_data['order_status_id'] = '3';
				break;
			case 'picked':
				$order_update_data['order_status_id'] = '3';
				break;
			case 'pickup done':
				$order_update_data['order_status_id'] = '3';
				break;
			case 'intransit':
				$order_update_data['order_status_id'] = '3';
				break;
			case 'assigned for pickup':
				$order_update_data['order_status_id'] = '2';
				break;
			case 'out for pickup':
				$order_update_data['order_status_id'] = '2'; //change
				break;
			case 'pickup not done':
				$order_update_data['order_status_id'] = '8';
				break;
			case 'on hold':
				$order_update_data['order_status_id'] = '3';
				break;
			case 'pending':
				$order_update_data['order_status_id'] = '3';
				break;
			case "sent_to_fwd":
			case 'sent to forward':
				$order_update_data['order_status_id'] = '3';
				break;
			case "recd_at_fwd_hub":
			case 'received at forward hub':
				$order_update_data['order_status_id'] = '3';
				break;
			case "recd_at_fwd_dc":
			case 'received at dc':
				$order_update_data['order_status_id'] = '3';
				break;
			case "recd_at_an_intermediate_dc":
			case 'reached at destination':
				$order_update_data['order_status_id'] = '3';
				break;
			case 'reached at destination':
				$order_update_data['order_status_id'] = '3';
				break;
			case 'oda (out of delivery area)':
				$order_update_data['status'] = '18'; //change
				break;
			case "assigned_for_delivery":
			case 'assigned for customer delivery':
				$order_update_data['order_status_id'] = '5';
				break;
			case "ofd":
			case 'out for delivery':
				$order_update_data['order_status_id'] = '5';
				break;
			case 'dispatched':
				$order_update_data['order_status_id'] = '5';
				break;
			case 'address incomplete':
				$order_update_data['order_status_id'] = '18'; //chage
				break;
			case 'long pincode':
				$order_update_data['order_status_id'] = '18'; //change
				break;
			case 'customer not available':
				$order_update_data['order_status_id'] = '18'; //change
				break;
			case 'cod amount not ready':
				$order_update_data['order_status_id'] = '18'; //cha
				break;
			case 'customer wants open delivery':
				$order_update_data['order_status_id'] = '18'; //change
				break;
			case 'customer wants future delivery':
				$order_update_data['order_status_id'] = '18'; //change
				break;
			case 'shipment missroute':
				$order_update_data['order_status_id'] = '18'; //change
				break;
			case 'customer validation failure':
				$order_update_data['order_status_id'] = '18'; //change
				break;
			case 'entry not permitted due to regulations':
				$order_update_data['order_status_id'] = '18'; //change
				break;
			case 'customer not available':
				$order_update_data['order_status_id'] = '18'; //change
				break;
			case 'customer not available x customer out of station':
				$order_update_data['order_status_id'] = '18'; //change
				break;
			case 'customer not available x customer not available at given address and not reachable over phone':
				$order_update_data['status'] = '18'; //change
				break;
			case 'customer wants evening delivery':
				$order_update_data['status'] = '18'; //change
				break;
			case 'self collect':
				$order_update_data['status'] = '18'; //change
				break;

			case 'delivered':
				$order_update_data['order_status_id'] = '6';
				$order_update_data['delivery_date'] = date('Y-m-d', strtotime($scan_date_time));
				break;
			case 'delivered to customer':
				$order_update_data['order_status_id'] = '6';
				$order_update_data['delivery_date'] = date('Y-m-d', strtotime($scan_date_time));
				break;
			case 'cancelled by customer':
				$order_update_data['order_status_id'] = '9'; //change
				break;
			case "cancelled_by_customer":
			case 'cancelled by seller':
				$order_update_data['order_status_id'] = '1'; //change
				break;
			case 'cancelled':
				$order_update_data['order_status_id'] = '1'; //change
				break;
			case "cid":
			case 'not delivered':
			case "seller_initiated_delay":
			case "nc":
			case "na":
			case "reopen_ndr":
				$order_update_data['order_status_id'] = '18'; //c
				break;
			case 'rto notified':
				$order_update_data['order_status_id'] = '9';
				break;
			case "nondelivereddispute":
				$order_update_data['order_status_id'] = '18'; //change
				break;
			case 'customer refused to accept':
				$order_update_data['order_status_id'] = '18'; //change
				break;
			case "sent_to_rev":
			case 'rto manifested':
				$order_update_data['order_status_id'] = '9';
				break;
			case "recd_at_rev_hub":
			case "rts":
			case 'rto processed & forwarded':
				$order_update_data['order_status_id'] = '10';
				break;
			case 'rto process initiated':
				$order_update_data['order_status_id'] = '10';
				break;
			case 'return to origin':
				$order_update_data['order_status_id'] = '10';
				break;
			case 'rto processing':
				$order_update_data['order_status_id'] = '10';
				break;
			case 'return undelivered':
				$order_update_data['order_status_id'] = '10';
				break;
			case 'rto in transit':
				$order_update_data['order_status_id'] = '11';
				break;
			case 'return to origin intransit':
				$order_update_data['order_status_id'] = '11';
				break;
			case 'reached at origin':
				$order_update_data['order_status_id'] = '11';
				break;
			case 'reached at origin':
				$order_update_data['order_status_id'] = '11';
				break;
			case "rts_nd":
			case 'rto undelivered':
				$order_update_data['status'] = '11';
				break;
			case 'rto returned':
				$order_update_data['order_status_id'] = '12';
				break;
			case 'rto dispatched':
				$order_update_data['order_status_id'] = '12';
				break;
			case 'return to origin out for delivery':
				$order_update_data['order_status_id'] = '12';
				break;
			case 'rto out for delivery':
				$order_update_data['status'] = '12';
				break;
			case "rts_d":
			case 'rto delivered':
				$order_update_data['order_status_id'] = '14';
				$order_update_data['delivery_date'] = date('Y-m-d', strtotime($scan_date_time));
				break;
			case 'return delivered':
				$order_update_data['order_status_id'] = '14';
				$order_update_data['delivery_date'] = date('Y-m-d', strtotime($scan_date_time));
				break;
			case 'rto':
				$order_update_data['order_status_id'] = '14';
				$order_update_data['delivery_date'] = date('Y-m-d', strtotime($scan_date_time));
				break;
			case 'returned':
				$order_update_data['order_status_id'] = '14';
				$order_update_data['delivery_date'] = date('Y-m-d', strtotime($scan_date_time));
				break;
			case 'on_hold':
			case 'lost':
				$order_update_data['order_status_id'] = '18';
				break;
			default:
				$order_update_data['order_status_id'] = '18';
				break;
		}
		return $order_update_data;
	}

	function set_order_status_rto($order_status, $scan_date_time)
	{
		switch (strtolower($order_status)) {
			case 'in transit':
				$order_update_data['order_status_id'] = '9';
				break;

			case 'intransit':
				$order_update_data['order_status_id'] = '9';
				break;

			case 'pending':
				$order_update_data['order_status_id'] = '11';
				break;

			case 'dispatched':
				$order_update_data['order_status_id'] = '11';
				break;

			case 'rto':
				$order_update_data['order_status_id'] = '18'; //chage
				break;
		}
		return $order_update_data;
	}


	public function ecom_tracking_webhook()
	{
		$path = APPPATH . 'logs/ecom_order/';
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}
		$post = file_get_contents('php://input');
		// $post = ' { "awb" : "8816899459", "datetime" : "2021-05-11 10:00:00", "status" : "999","reason_code" : "999", "reason_code_number" : "999", "location" : "MUMBAI", "Employee" : "ZEESHANKHANPATHAN", "status_update_number" : "148473601", "order_number" : "PDL1-1162S","city" : "MUMBAI","ref_awb" : ""}';
		$log_data['post_response'] = $post;
		$array = json_decode($post, true);
		$log_data['post_data'] = $array;

		if (!empty($array['awb']) && !empty($array['status']) && !empty($array['status_update_number'])) {

			$single_order_info = $this->Common_model->getSingleRowArray(array('airwaybill_no' => $array['awb']), 'id,order_status_id,order_id,order_type', 'order_airwaybill_detail');
			$log_data['single_order_info'] = $single_order_info;
			// dd($single_order_info);
			if (!empty($single_order_info)) {

				$status_data = $this->Common_model->getSingleRowArray(array('status_code' => $array['status']), '*', 'ecom_tracking_status');

				$insert_order_tracking_detail = array(
					'order_id' => $single_order_info['order_id'],
					'scan_date_time' => date("Y-m-d H:i:s", strtotime($array['datetime'])),
					'remark' => $status_data['remarks'],
					'location' => $array['location'],
				);


				if ($status_data['status_id'] == '11' && in_array($single_order_info['order_status_id'], array('5', '3', '18'))) {
					$status = $this->db->select('order_id')->from('order_airwaybill_detail')->where('airwaybill_no', $array['awb'])->where('order_status_id', '11')->get()->result_array();
					//if (!empty($status)) {

					$result = wallet_direct::refund_wallet(trim($array['awb']), '0', '2');
					$log_data['walelt_data'] = $status;
					$log_data['wallet_debit_responce'] = $result;
					//}
				}

				if ($status_data['status_id'] == '6'  &&  in_array($single_order_info['order_status_id'], array('9', '10', '11', '12'))) {
					$status = $this->db->select('order_id')->from('order_airwaybill_detail')->where('airwaybill_no', $array['awb'])->where('order_status_id', '14')->get()->result_array();

					$status_data['status_id'] = '14';

					//if (!empty($status)) {
					$result = wallet_direct::refund_wallet(trim($array['awb']), '1', '2');
					$log_data['walelt_data'] = $status;
					$log_data['wallet_credit_responce'] = $result;
					//}
				}

				$single_order_status_info = $this->Common_model->getSingleRowArray(array('order_status_id' => $status_data['status_id']), 'status_name', 'order_status');

				$insert_order_tracking_detail['scan'] = $single_order_status_info['status_name'];

				$log_data['status_update_query'] = $this->db->last_query();
				$log_data['scan'] = $insert_order_tracking_detail['scan'];

				// if ($single_order_info['order_status_id'] != $status_data['status_id']) {
				$this->Common_model->insert($insert_order_tracking_detail, 'order_tracking_detail');
				$tracking_status = $this->db->affected_rows();

				$update_data1 = [
					'order_status_id' => $status_data['status_id'],
					'delivery_date' => ($status_data['status_id'] == '14' || $status_data['status_id'] == '6')  ?  date('Y-m-d ', strtotime($array['datetime'])) : null,
				];


				$this->Common_model->update($update_data1, 'order_airwaybill_detail', array('order_id' => $single_order_info['order_id']));
				$awb_update_status = $this->db->affected_rows();
				$log_data['status_update_query'] = $this->db->last_query();


				if ($awb_update_status == 0 || $tracking_status == 0 || $awb_update_status == '0' || $tracking_status == '0') {
					$array = ['awb' => $array['awb'], 'status' => 'false', 'reason' => "data can't be update in system", 'status_update_number' => $array['status_update_number']];
					echo json_encode($array);
				} else {
					$array = ['awb' => $array['awb'], 'status' => 'true', 'status_update_number' => $array['status_update_number']];
					echo json_encode($array);
				}
			} else {
				$array = ['awb' => $array['awb'], 'status' => 'false', 'reason' => "Order data not found in our database", 'status_update_number' => $array['status_update_number']];
				echo json_encode($array);
			}
		} else {
			$array = ['awb' => $array['awb'], 'status' => 'false', 'reason' => "Something missing in data", 'status_update_number' => $array['status_update_number']];
			echo json_encode($array);
		}


		file_put_contents(APPPATH . 'logs/ecom_order/' . date("d-m-Y") . '_tracking_webhook_responce.txt', "\n------- Start Log ------\n" . print_r($log_data, true) . "\n\n", FILE_APPEND);
		file_put_contents(APPPATH . 'logs/ecom_order/' . date("d-m-Y") . '_tracking_webhook_responce.txt', "\n------- END Log ------\n\n", FILE_APPEND);
	}

	public function udaan_tracking_webhook()
	{
		// dd("sdf");
		$path = APPPATH . 'logs/udaan_tracking/';
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}
		$post_data = file_get_contents('php://input');
		$log_data['post_response'] = $post_data;
		$data = json_decode($post_data, true);
		$log_data['post_data'] = $data;

		$order_id = $this->db->distinct()->select('usd.* ,fom.id,fom.awb_number')->from('order_udaan_shipment_id_detail as usd')->join('forward_order_master as fom', 'usd.order_id = fom.id')->where('usd.udaan_shipment_id', $data['awbNumber'])->get()->row_array();


		$single_order_info = $this->Common_model->getSingleRowArray(array('airwaybill_no' => $order_id['awb_number']), 'id,order_status_id,order_id,order_type', 'order_airwaybill_detail');
		// dd($single_order_info);

		$log_data['single_order_info'] = $single_order_info;


		if (!empty($single_order_info)) {
			if ($data['status'] != "") {

				$insert_order_tracking_detail = array(
					'order_id' => $single_order_info['order_id'],
					'scan_date_time' => date("Y-m-d H:i:s", strtotime($data['statusUpdateDate'])) . " " . date("H:i:s", strtotime($data['statusUpdateTime'])),
					'remark' => $data['statusDescription'],
					'location' => $data['currentLocation'],
				);


				$order_update_data = $this->set_order_status_uddan(strtoupper($data['status']), date("Y-m-d", strtotime($data['statusUpdateDate'])) . " " . date("H:i:s", strtotime($data['statusUpdateTime'])));

				// dd($order_update_data);

				if ($order_update_data['order_status_id'] == '9') {
					$status = $this->db->select('order_id')->from('order_airwaybill_detail')->where('airwaybill_no', $order_id['awb_number'])->where('order_status_id', '9')->get()->result_array();

					//if (!empty($status)) {
					$result = wallet_direct::refund_wallet(trim($order_id['awb_number']), '0', '2');
					$log_data['wallet_data'] = $status;
					$log_data['wallet_debit_responce'] = $result;
					//}
				}


				if ($order_update_data['order_status_id'] == '14') {
					$status = $this->db->select('order_id')->from('order_airwaybill_detail')->where('airwaybill_no', $order_id['awb_number'])->where('order_status_id', '14')->get()->result_array();
					// dd($status);
					// if (!empty($status)) {
					$result = wallet_direct::refund_wallet(trim($order_id['awb_number']), '1', '2');
					$log_data['wallet_data'] = $status;
					$log_data['wallet_credit_responce'] = $result;
					//}
				}
			}
		}


		$single_order_status_info = $this->Common_model->getSingleRowArray(array('order_status_id' => $order_update_data['order_status_id']), 'status_name', 'order_status');
		$insert_order_tracking_detail['scan'] = $single_order_status_info['status_name'];

		// if ($single_order_info['order_status_id'] != $order_update_data['order_status_id']) {
		$this->Common_model->insert($insert_order_tracking_detail, 'order_tracking_detail');

		$this->Common_model->update($order_update_data, 'order_airwaybill_detail', array('order_id' => $single_order_info['order_id']));
		$log_data['status_update_query'] = $this->db->last_query();


		file_put_contents(APPPATH . 'logs/udaan_tracking/' . date("d-m-Y") . '_tracking_webhook_responce.txt', "\n------- Start Log ------\n" . print_r($log_data, true) . "\n\n", FILE_APPEND);
		file_put_contents(APPPATH . 'logs/udaan_tracking/' . date("d-m-Y") . '_tracking_webhook_responce.txt', "\n------- END Log ------\n\n", FILE_APPEND);
	}

	public function ekart_tracking_webhook()
	{
		$path = APPPATH . 'logs/ekart_tracking/';
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}
		$post_data = file_get_contents('php://input');
		$log_data['post_response'] = $post_data;
		$data = json_decode($post_data, true);
		$log_data['post_data'] = $data;
		$postData = $_POST;
		$log_data['postData'] = $postData;

		file_put_contents(APPPATH . 'logs/ekart_tracking/' . date("d-m-Y") . '_tracking_webhook_responce.txt', "\n------- Start Log ------\n" . print_r($log_data, true) . "\n\n", FILE_APPEND);
		file_put_contents(APPPATH . 'logs/ekart_tracking/' . date("d-m-Y") . '_tracking_webhook_responce.txt', "\n------- END Log ------\n\n", FILE_APPEND);
	}

	public function set_order_status_uddan($order_status, $scan_date_time)
	{
		switch ($order_status) {
			case 'FW_PICKUP_CREATED':
			case 'FW_PICKUP_FAILED':
			case 'FW_PICKED_NOT_VERIFIED':
			case 'FW_OUT_FOR_PICKUP':
				$order_update_data['order_status_id'] = '1';
				break;

			case 'FW_HUB_OUTSCAN':
			case 'FW_HUB_INSCAN':
			case 'FW_PICKED_UP':
			case 'FW_RAD':
				$order_update_data['order_status_id'] = '3';
				break;

			case 'FW_OUT_FOR_DELIVERY':
				$order_update_data['order_status_id'] = '5';
				break;

			case 'FW_DELIVERY_ATTEMPTED':
			case 'CANCELLED':
				$order_update_data['order_status_id'] = '18';
				break;

			case 'FW_DELIVERED':
				$order_update_data['order_status_id'] = '6';
				$order_update_data['delivery_date'] = date('Y-m-d', strtotime($scan_date_time));
				break;

			case 'Cancelled':
				$order_update_data['order_status_id'] = '18';
				break;

			case 'RT_RTO_MARKED':
				$order_update_data['order_status_id'] = '9';
				break;

			case 'RT_HUB_INSCAN':
			case 'RT_HUB_OUTSCAN':
			case 'RT_RAD':
			case 'RT_OUT_FOR_DELIVERY':
				$order_update_data['order_status_id'] = '11';
				break;

			case 'RT_DELIVERED':
				$order_update_data['order_status_id'] = '14';
				$order_update_data['delivery_date'] = date('Y-m-d', strtotime($scan_date_time));
				break;

			default:
				$order_update_data['order_status_id'] = '18';
				break;
		}

		return $order_update_data;
	}

	public function get_delhivery_tracking_detail()
	{
		$post = @file_get_contents("php://input");
		$log_data['post_data'] = $post;
		$array = json_decode($post, true);

		if ($array['Shipment']['Status']['Status'] != "") {
			$single_order_info = $this->Common_model->getSingleRowArray(array('airwaybill_no' => $array['Shipment']['AWB']), 'id,order_status_id,order_id', 'order_airwaybill_detail');
			$log_data['single_order_info'] = $single_order_info;

			if (!empty($single_order_info)) {
				$insert_order_tracking_detail = array(
					'order_id' => $single_order_info['order_id'],
					'scan_date_time' => date("Y-m-d H:i:s", strtotime(str_replace("T", " ", $array['Shipment']['Status']['StatusDateTime']))),
					'remark' => $array['Shipment']['Status']['Instructions'],
					'location' => $array['Shipment']['Status']['StatusLocation'],
				);
				// dd($array);
				if (strcmp($array['Shipment']['Status']['StatusType'], 'RT') == 0) {
					$order_update_data =
						$this->set_order_status_rto(strtolower($array['Shipment']['Status']['Status']), date("Y-m-d H:i:s", strtotime(str_replace("T", " ", $array['Shipment']['Status']['StatusDateTime']))));
				} else {
					$order_update_data =
						$this->set_order_status(strtolower($array['Shipment']['Status']['Status']), date("Y-m-d H:i:s", strtotime(str_replace("T", " ", $array['Shipment']['Status']['StatusDateTime']))));
				}

				if ($order_update_data['order_status_id'] == '9') {
					$status = $this->db->select('order_id')->from('order_airwaybill_detail')->where('airwaybill_no', $array['Shipment']['AWB'])->where('order_status_id', '9')->get()->result_array();
					// if (empty($status)) {
					$result = wallet_direct::refund_wallet(trim($array['Shipment']['AWB']), '0', '2');
					$log_data['walelt_data'] = $status;
					$log_data['wallet_debit_responce'] = $result;
					// }
				}

				if ($order_update_data['order_status_id'] == '14') {
					$status = $this->db->select('order_id')->from('order_airwaybill_detail')->where('airwaybill_no', $array['Shipment']['AWB'])->where('order_status_id', '14')->get()->result_array();
					// if (empty($status)) {
					$result = wallet_direct::refund_wallet(trim($array['Shipment']['AWB']), '1', '2');
					$log_data['walelt_data'] = $status;
					$log_data['wallet_credit_responce'] = $result;
					// }
				}

				$single_order_status_info = $this->Common_model->getSingleRowArray(array('order_status_id' => $order_update_data['order_status_id']), 'status_name', 'order_status');
				$insert_order_tracking_detail['scan'] = $single_order_status_info['status_name'];

				// if ($single_order_info['order_status_id'] != $order_update_data['order_status_id']) {
				$this->Common_model->insert($insert_order_tracking_detail, 'order_tracking_detail');

				$this->Common_model->update($order_update_data, 'order_airwaybill_detail', array('order_id' => $single_order_info['order_id']));
				$log_data['status_update_query'] = $this->db->last_query();
			}
		}
		file_put_contents(APPPATH . 'logs/tracking_webhook_log/' . date("d-m-Y") . '_delhivery_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
	}

	public function get_shadowfax_tracking_detail()
	{
		// get order data for tracking 
		$this->load->model('Tracking_model');


		$orders = $this->Tracking_model->get_order();

		// dd($orders);

		foreach ($orders as $key => $value) {
			$log_data['AWBNO'] = $value['awb_number'];
			// call the curl
			$res = array();
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL =>	"https://dale.shadowfax.in/api/v3/clients/orders/" . $value['awb_number'] . "/track/?format=json",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"authorization: Token b34fdf73427b803c627cbfebd04de1aa9c57ce71",
					"content-type: application/json",
				),
			));
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
				$res['Error'] = $err;
				$log_data['Error'] = $err;
			} else {
				$tracking_details = json_decode($response, "true");
				$log_data['Tracking_deils'] =  $tracking_details['tracking_details'];
				foreach ($tracking_details['tracking_details'] as $track_key => $track_value) {
					// dd($value['tracking_id']);
					// Compate last status store in database and latest staus that arrived
					if ($value['tracking_id'] == "" || $value['tracking_id'] < $track_key) {
						$data = ['tracking_id' => $track_key];
						$this->Common_model->update($data, "forward_order_master", ['awb_number' => $value['awb_number']]);

						$single_order_info = $this->Common_model->getSingleRowArray(array('airwaybill_no' => $value['awb_number']), 'id,order_status_id,order_id', 'order_airwaybill_detail');
						$log_data['single_order_info'] = $single_order_info;

						if (!empty($single_order_info)) {

							$insert_order_tracking_detail = array(
								'order_id' => $single_order_info['order_id'],
								'scan_date_time' => date("Y-m-d H:i:s", strtotime(str_replace("Z", "", str_replace("T", " ", $track_value['created'])))),
								'remark' => $track_value['remarks'],
								'location' => $track_value['location'],
							);

							$order_update_data = $this->set_order_status(strtolower($track_value['status_id']), date("Y-m-d H:i:s", strtotime(str_replace("Z", "", str_replace("T", " ", $track_value['created'])))));

							if ($order_update_data['order_status_id'] == '9') {
								$status = $this->db->select('order_id')->from('order_airwaybill_detail')->where('airwaybill_no', $value['awb_number'])->where('order_status_id', '9')->get()->result_array();
								// if (empty($status)) {
								$result = wallet_direct::refund_wallet(trim($value['awb_number']), '0', '2');
								$log_data['walelt_data'] = $status;
								$log_data['wallet_debit_responce'] = $result;
								// }
							}

							if ($order_update_data['order_status_id'] == '14') {
								$status = $this->db->select('order_id')->from('order_airwaybill_detail')->where('airwaybill_no', $value['awb_number'])->where('order_status_id', '14')->get()->result_array();
								// if (empty($status)) {
								$result = wallet_direct::refund_wallet(trim($value['awb_number']), '1', '2');
								$log_data['walelt_data'] = $status;
								$log_data['wallet_credit_responce'] = $result;
								// }
							}

							$single_order_status_info = $this->Common_model->getSingleRowArray(array('order_status_id' => $order_update_data['order_status_id']), 'status_name', 'order_status');
							$insert_order_tracking_detail['scan'] = $single_order_status_info['status_name'];

							// if ($single_order_info['order_status_id'] != $order_update_data['order_status_id']) {
							$this->Common_model->insert($insert_order_tracking_detail, 'order_tracking_detail');

							$this->Common_model->update($order_update_data, 'order_airwaybill_detail', array('order_id' => $single_order_info['order_id']));
							$log_data['status_update_query'] = $this->db->last_query();
						}
					}
					file_put_contents(APPPATH . 'logs/tracking_webhook_log/' . date("d-m-Y") . '_Shadowfax_log.txt', "\n------- Start Log ------\n\n" . print_r($log_data, true), FILE_APPEND);
				}
			}
		}
		file_put_contents(APPPATH . 'logs/tracking_webhook_log/' . date("d-m-Y") . '_Shadowfax_log.txt', "\n------- End Log ------------\n", FILE_APPEND);
	}

	public function ship_rocket_webhook()
	{
		$path = APPPATH . 'logs/shiproket_tracking/';
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}
		$post = file_get_contents('php://input');
		$post = ' {
			"awb": 59629792084,
			"current_status": "Delivered",
			"order_id": "13905312",
			"current_timestamp": "2021-07-02 16:41:59",
			"etd": "2021-07-02 16:41:59",
			"current_status_id": 7,
			"shipment_status": "Delivered",
			"shipment_status_id": 7,
			"channel_order_id": "enter your channel order id",
			"channel": "enter your channel name",
			"courier_name": "enter courier_name",
			"scans": [
			{
			"date": "2019-06-25 12:08:00",
			"activity": "SHIPMENT DELIVERED",
			"location": "PATIALA"
			},
			{
			"date": "2019-06-25 12:06:00",
			"activity": "NECESSARY CHARGES PENDING FROM CONSIGNEE",
			"location": "PATIALA"
			},
			{
			"date": "2019-06-25 10:18:00",
			"activity": "SHIPMENT OUT FOR DELIVERY",
			"location": "PATIALA"
			},
			{
			"date": "2019-06-25 09:40:00",
			"activity": "SHIPMENT ARRIVED",
			"location": "PATIALA"
			},
			{
			"date": "2019-06-25 07:32:00",
			"activity": "SHIPMENT FURTHER CONNECTED",
			"location": "AMBALA AIR HUB"
			},
			{
			"date": "2019-06-25 07:03:00",
			"activity": "SHIPMENT ARRIVED AT HUB",
			"location": "AMBALA AIR HUB"
			},
			{
			"date": "2019-06-25 00:45:00",
			"activity": "SHIPMENT FURTHER CONNECTED",
			"location": "KAPASHERA HUB"
			},
			{
			"date": "2019-06-25 00:20:00",
			"activity": "SHIPMENT ARRIVED AT HUB",
			"location": "KAPASHERA HUB"
			},
			{
			"date": "2019-06-24 23:17:00",
			"activity": "SHIPMENT FURTHER CONNECTED",
			"location": "COD PROCESSING CENTRE I"
			},
			{
			"date": "2019-06-24 21:14:00",
			"activity": "SHIPMENT ARRIVED",
			"location": "COD PROCESSING CENTRE I"
			},
			{
			"date": "2019-06-24 18:56:00",
			"activity": "SHIPMENT PICKED UP",
			"location": "COD PROCESSING CENTRE I"
			}
			]
			}';
		$log_data1['post_response'] = $post;
		$array = json_decode($post, true);
		$log_data1['post_data'] = $array;
		file_put_contents(APPPATH . 'logs/shiproket_tracking/' . date("d-m-Y") . '_tracking_webhook_responce.txt', "\n------- Start Log ------\n" . print_r($log_data1, true) . "\n\n", FILE_APPEND);

		if (!empty($array['awb']) && !empty($array['current_status']) && !empty($array['order_id'])) {

			$single_order_info = $this->Common_model->getSingleRowArray(array('airwaybill_no' => $array['awb']), 'id,order_status_id,order_id,order_type', 'order_airwaybill_detail');
			$log_data['single_order_info'] = $single_order_info;
			// dd($single_order_info);
			if (!empty($single_order_info)) {

				$status_data = $this->Common_model->getSingleRowArray(array('status_code' => $array['status']), '*', 'ecom_tracking_status');

				$insert_order_tracking_detail = array(
					'order_id' => $single_order_info['order_id'],
					'scan_date_time' => date("Y-m-d H:i:s", strtotime($array['datetime'])),
					'remark' => $status_data['remarks'],
					'location' => $array['location'],
				);

				if ($status_data['status_id'] == '11' && in_array($single_order_info['order_status_id'], array('5', '3', '18'))) {
					$status = $this->db->select('order_id')->from('order_airwaybill_detail')->where('airwaybill_no', $array['awb'])->where('order_status_id', '11')->get()->result_array();
					//if (!empty($status)) {

					$result = wallet_direct::refund_wallet(trim($array['awb']), '0', '2');
					$log_data['walelt_data'] = $status;
					$log_data['wallet_debit_responce'] = $result;
					//}
				}

				if ($status_data['status_id'] == '6'  &&  in_array($single_order_info['order_status_id'], array('9', '10', '11', '12'))) {
					$status = $this->db->select('order_id')->from('order_airwaybill_detail')->where('airwaybill_no', $array['awb'])->where('order_status_id', '14')->get()->result_array();

					$status_data['status_id'] = '14';

					//if (!empty($status)) {
					$result = wallet_direct::refund_wallet(trim($array['awb']), '1', '2');
					$log_data['walelt_data'] = $status;
					$log_data['wallet_credit_responce'] = $result;
					//}
				}

				$single_order_status_info = $this->Common_model->getSingleRowArray(array('order_status_id' => $status_data['status_id']), 'status_name', 'order_status');

				$insert_order_tracking_detail['scan'] = $single_order_status_info['status_name'];

				$log_data['status_update_query'] = $this->db->last_query();
				$log_data['scan'] = $insert_order_tracking_detail['scan'];

				// if ($single_order_info['order_status_id'] != $status_data['status_id']) {
				$this->Common_model->insert($insert_order_tracking_detail, 'order_tracking_detail');
				$tracking_status = $this->db->affected_rows();

				$update_data1 = [
					'order_status_id' => $status_data['status_id'],
					'delivery_date' => ($status_data['status_id'] == '14' || $status_data['status_id'] == '6')  ?  date('Y-m-d ', strtotime($array['datetime'])) : null,
				];


				$this->Common_model->update($update_data1, 'order_airwaybill_detail', array('order_id' => $single_order_info['order_id']));
				$awb_update_status = $this->db->affected_rows();
				$log_data['status_update_query'] = $this->db->last_query();


				if ($awb_update_status == 0 || $tracking_status == 0 || $awb_update_status == '0' || $tracking_status == '0') {
					$array = ['awb' => $array['awb'], 'status' => 'false', 'reason' => "data can't be update in system", 'status_update_number' => $array['status_update_number']];
					echo json_encode($array);
				} else {
					$array = ['awb' => $array['awb'], 'status' => 'true', 'status_update_number' => $array['status_update_number']];
					echo json_encode($array);
				}
			} else {
				$array = ['awb' => $array['awb'], 'status' => 'false', 'reason' => "Order data not found in our database", 'status_update_number' => $array['status_update_number']];
				echo json_encode($array);
			}
		} else {
			$array = ['awb' => $array['awb'], 'status' => 'false', 'reason' => "Something missing in data", 'status_update_number' => $array['status_update_number']];
			echo json_encode($array);
		}

		file_put_contents(APPPATH . 'logs/shiproket_tracking/' . date("d-m-Y") . '_tracking_webhook_responce.txt', print_r($log_data, true) . "\n------- END Log ------\n\n", FILE_APPEND);
	}
}
