<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Codremittance_cron extends CI_Controller
{

	public $data;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('Codremittance_model');
	}

	public function calculate_cod_remittance()
	{
		$path = APPPATH . 'logs/cod_remittance/';
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}

		$userList = $this->db->distinct()->select('sm.id, sm.email, sm.name, kvm.gst_no, ba.state')->from('sender_master as sm')->join('kyc_verification_master kvm', 'kvm.sender_id = sm.id')->join('billing_address ba', 'ba.sender_id = sm.id')->order_by('sm.id', "ASC")->get()->result_array();

		if (!empty($userList)) {
			foreach ($userList as $userVal) {
				$log_data['date'] = date('Y-m-d H:s:i');
				file_put_contents(APPPATH . 'logs/cod_remittance/' . date("d-m-Y") . '_log.txt', "\n------- Start Log (" . $userVal['id'] . ") ------\n" . print_r($log_data, true), FILE_APPEND);
				//get user detail
				$first_date = date('Y-m-d', strtotime('-200 days'));
				$last_date = date('Y-m-d', strtotime('-1 days'));
				$result = $this->fetchOrderList($userVal, $first_date, $last_date);
				$log_dat1['result'] = $result;
				file_put_contents(APPPATH . 'logs/cod_remittance/' . date("d-m-Y") . '_log.txt', print_r($log_dat1, true) . "\n------- End Log (" . $userVal['id'] . ") ------\n", FILE_APPEND);
				echo "<pre>";
				print_r($result);
				echo "</pre>";
			}
		} else {
			// No user Found
			echo 'No User Found.<br>';
			$log_data['date'] = date('Y-m-d H:s:i');
			$log_data['Message'] = 'No User Found.';
			file_put_contents(APPPATH . 'logs/cod_remittance/' . date("d-m-Y") . '_log.txt', print_r($log_data, true) . "\n------- End Log ------\n", FILE_APPEND);
		}
	}

	public function fetchOrderList($userVal, $first_date, $last_date)
	{
		$total_cod_amount = $total_rto_amount = $freight_charges_from_cod = 0;

		$order_log1['first_date'] = $first_date;
		$order_log1['last_date'] = $last_date;
		file_put_contents(APPPATH . 'logs/cod_remittance/' . date("d-m-Y") . '_log.txt', "\n------- Start Order List Log ------\n" . print_r($order_log1, true), FILE_APPEND);

		$status_where = "(os.status_name='Delivered' || os.status_name='Returned' || os.status_name='RTO')";
		$date_where = "(oad.delivery_date BETWEEN '" . $first_date . "' AND '" . $last_date . "')";
		$orderData = $this->db->select('fom.id,fom.sender_id, fom.order_no, fom.order_type, fom.logistic_id, ra.pincode as delever_pincode, sam.pincode as pickup_pincode, rea.pincode as return_pincode, fom.is_return_address_same_as_pickup, opd.cod_amount, opd.physical_weight, opd.volumetric_weight, os.status_name')->from('forward_order_master as fom')->join('order_airwaybill_detail oad', 'oad.order_id = fom.id')->join('order_product_detail opd', 'opd.id = fom.order_product_detail_id')->join('order_status os', 'os.order_status_id = oad.order_status_id')->join('receiver_address ra', 'ra.id = fom.deliver_address_id')->join('sender_address_master sam', 'sam.id = fom.pickup_address_id')->join('return_address rea', 'rea.id = fom.return_address_id', 'left')->where('fom.sender_id', $userVal['id'])->where($status_where)->where($date_where)->order_by('fom.id', "ASC")->get()->result_array();
		$data_log['order_query'] = $this->db->last_query();
		$data_log['order_query_result'] = $orderData;
		if (!empty($orderData)) {
			$crf_id = rand();
			$utr_id = $this->GenerateUTRId();
			$cod_data['crf_id'] = $crf_id;
			$cod_data['utr_id'] = $utr_id;
			$cod_data['cod_create_date'] = date('Y-m-d', strtotime('Friday'));
			$cod_data['freight_charges_from_cod'] = '0';
			$cod_data['remittance_method'] = 'Prepaid';
			$cod_data['remittance_status'] = 'Pending';
			$cod_data['remarks'] = 'Remitted';
			$cod_remittance_id = $this->Common_model->insert($cod_data, 'cod_remittance');

			$data_log['cod_remittance_query'] = $this->db->last_query();
			$data_log['cod_remittance_result'] = $cod_remittance_id;
			file_put_contents(APPPATH . 'logs/cod_remittance/' . date("d-m-Y") . '_log.txt', print_r($data_log, true), FILE_APPEND);
			foreach ($orderData as $orderVal) {
				$cod_amt = $rto_amt = 0;
				$order_log = array();
				if ($orderVal['status_name'] == 'Delivered' && $orderVal['order_type'] == '1') { // 1 - cod, 0 - prepaid 
					$total_cod_amount += $orderVal['cod_amount'];
					$cod_amt = $orderVal['cod_amount'];
					$order_log['cod_amount'] = $cod_amt;
					$order_log['total_cod_amount'] = $total_cod_amount;

					$cod_detail_data['cod_remittance_id'] = $cod_remittance_id;
					$cod_detail_data['sender_id'] = $orderVal['sender_id'];
					$cod_detail_data['order_id'] = $orderVal['id'];
					$cod_detail_data['cod_amount'] = $cod_amt;
					$cod_detail_data['rto_amount'] = $rto_amt;
					$cod_remittance_detail_id = $this->Common_model->insert($cod_detail_data, 'cod_remittance_order_detail');

					$order_log['cod_remittance_detail_query'] = $this->db->last_query();
					$order_log['cod_remittance_detail_result'] = $cod_remittance_detail_id;
					file_put_contents(APPPATH . 'logs/cod_remittance/' . date("d-m-Y") . '_log.txt', print_r($order_log, true), FILE_APPEND);
				} else if (($orderVal['status_name'] == 'Returned' && $orderVal['order_type'] == '0') || ($orderVal['status_name'] == 'RTO' && $orderVal['order_type'] == '0')) {
					$to_pin = $orderVal['is_return_address_same_as_pickup'] == '0' ? $orderVal['return_pincode'] : $orderVal['pickup_pincode'];
					$shipment_type = $orderVal['status_name'] == 'Returned' ? '1' : '2'; // 1 - reverce, 2 - rto
					$this->load->helper('get_shiping_price');
					$result = get_shiping_price($orderVal['sender_id'], $orderVal['logistic_id'], $orderVal['delever_pincode'], $to_pin, $shipment_type, $orderVal['order_type'], $orderVal['volumetric_weight'], $orderVal['physical_weight'], $orderVal['cod_amount'], '0', '18');
					$order_log['get_shiping_price'] = $result;
					if ($result['status'] == true) {
						$total_rto_amount += $result['data'][0]['subtotal'];
						$rto_amt = $result['data'][0]['subtotal'];
						$order_log['rto_amount'] = $rto_amt;
						$order_log['total_rto_amount'] = $total_rto_amount;

						$cod_detail_data['cod_remittance_id'] = $cod_remittance_id;
						$cod_detail_data['sender_id'] = $orderVal['sender_id'];
						$cod_detail_data['order_id'] = $orderVal['id'];
						$cod_detail_data['cod_amount'] = $cod_amt;
						$cod_detail_data['rto_amount'] = $rto_amt;
						$cod_remittance_detail_id = $this->Common_model->insert($cod_detail_data, 'cod_remittance_order_detail');

						$order_log['cod_remittance_detail_query'] = $this->db->last_query();
						$order_log['cod_remittance_detail_result'] = $cod_remittance_detail_id;
						file_put_contents(APPPATH . 'logs/cod_remittance/' . date("d-m-Y") . '_log.txt', print_r($order_log, true), FILE_APPEND);
					} else {
						// Error
						$order_log['orderNo'] = $orderVal['order_no'];
						$order_log['cod_remittance_detail_result'] = $result['message'];
						file_put_contents(APPPATH . 'logs/cod_remittance/' . date("d-m-Y") . '_log.txt', print_r($order_log, true), FILE_APPEND);
					}
				} else {
					// No status match
					$order_log['orderNo'] = $orderVal['order_no'];
					$order_log['order_status'] = $orderVal['status_name'];
					$order_log['cod_remittance_detail_result'] = 'No status match.';
					file_put_contents(APPPATH . 'logs/cod_remittance/' . date("d-m-Y") . '_log.txt', print_r($order_log, true), FILE_APPEND);
				}
			}
			if ($total_cod_amount == 0 && $total_rto_amount == 0) {
				$delete_cod = $this->Common_model->delete('cod_remittance', array('id' => $cod_remittance_id));
				$order_log1['cod_remittance_delete_query'] = $this->db->last_query();
				$order_log1['cod_remittance_delete_result'] = $delete_cod;
				file_put_contents(APPPATH . 'logs/cod_remittance/' . date("d-m-Y") . '_log.txt', print_r($order_log1, true) . "\n------- End Order List Log ------\n", FILE_APPEND);
				return 'No Total COD Amount or RTO Amount Found.';
			} else {
				$cod_data1['sender_id'] = $orderVal['sender_id'];
				$cod_data1['cod_available'] = $total_cod_amount;
				$cod_data1['rto_reversal_amount'] = $total_rto_amount;
				$cod_data1['remittance_amount'] = ($total_cod_amount - $total_rto_amount);
				$cod_data1['remain_amount'] = ($total_cod_amount - $total_rto_amount);
				$update_cod = $this->Common_model->update($cod_data1, 'cod_remittance', array('id' => $cod_remittance_id));
				$order_log1['cod_remittance_update_query'] = $this->db->last_query();
				$order_log1['cod_remittance_update_result'] = $update_cod;
				file_put_contents(APPPATH . 'logs/cod_remittance/' . date("d-m-Y") . '_log.txt', print_r($order_log1, true) . "\n------- End Order List Log ------\n", FILE_APPEND);
				return 'Success.';
			}
		} else {
			// No order Found
			$data_log['Message'] = 'No Order Found.';
			file_put_contents(APPPATH . 'logs/cod_remittance/' . date("d-m-Y") . '_log.txt', print_r($data_log, true) . "\n------- End Order List Log ------\n", FILE_APPEND);
			return 'No Order Found.';
		}
	}

	public function GenerateUTRId()
	{
		$utr_id = $this->db->select('utr_id')->from('cod_remittance')->order_by('id', 'DESC')->limit('1')->get()->row_array();
		if (!empty($utr_id)) {
			$str = str_replace("SSL", "", $utr_id['utr_id']);
			$num = $str + 1;
		} else {
			$num = 1;
		}
		$utr_id = "SSL" . sprintf("%04d", $num);
		return $utr_id;
	}
}
