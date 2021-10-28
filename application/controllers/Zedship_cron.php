<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Zedship_cron extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->model('Zship_cron_model');
		$this->load->helper('get_shiping_price_new');
	}
	public function index()
	{
		// dd($data);
		file_put_contents(APPPATH . 'logs/zship_cron/' . date("d-m-Y") . 'cron_log.txt', "------- Start Log ------\n\n\n", FILE_APPEND);
		$this->load->helper('zship_new');
		$data = $this->db->select('temp_order_master.*,lm.logistic_name,lm.api_name')->from('temp_order_master')->where('is_flag', '1')->where('is_process', '0')->where('is_running', '0')->join('logistic_master as lm', 'lm.id= temp_order_master.logistic_id')->limit(40, 0)->order_by('temp_order_master.id', 'DESC')->get()->result_array();

		$ids = array_column($data, 'id');

		if (empty($data)) {
			echo "No record to Process";
			file_put_contents(APPPATH . 'logs/zship_cron/' . date("d-m-Y") . 'cron_log.txt', "No Record To Process" . date("h:i:s") . "\n\n\n", FILE_APPEND);
			die();
		}
		$this->db->where_in('id', $ids)->update('temp_order_master', ['is_running' => '1']);
		// $this->db->update('temp_order_master',['is_flag' => '0']);        
		// dd($ids);
		//sdf
		$success_count = $error_count = 0;
		$zship = $Xpressbees = $Ekart = $ecom = $Udaan = 0;
		foreach ($data as $key => $value) {

			// $check_duplicate = $this->db->select('fom.order_no')->from('forward_order_master as fom')->where('order_no', $value['order_no'])->get()->row_array();
			// dd($check_duplicate);
			// if($check_duplicate['order_no'])
			// {
			//     $data  = ['remarks' => 'duplicate order found'];
			//     $this->db->where('order_no',$check_duplicate['order_no']);
			//     $this->db->update('temp_order_master',$data);
			//     continue;
			// }


			$log_data['logistic'] = $value['api_name'];
			if ($value['api_name'] == "Delhivery_Surface" || $value['api_name'] == 'Xpressbees_Surface' || $value['api_name'] == 'Ekart_Surface') {
				$sender_data = $this->db->select('*')->from('sender_address_master')->where('id', $value['pickup_address_id'])->get()->row_array();
				// dd($sender_data);
				$log_data['orders'] = $sender_data;
				$log_data['sender_data'] = $sender_data;
				$log_data['time'] = date("h:s:i");
				if ($sender_data['zship_sender_id'] == "") {
					$this->create_address_in_api($sender_data);
				}
				$response = create_order_zship($value['id'], '1');
				// $log_data['api_name'][] = $value['api_name'];
				// $log_data['orderNo'][] = $value['order_no'];
				// $zship++;
				// $log_data['api_count'][] = $zship;
			} else if ($value['api_name'] == 'Xpressbees_Direct') {
				$repeat = 0;
				$response = xpressbees_direct::xpressbees_order($value['id'], 0, '1');
				$log_data['order_response'] = $response;
				if ($response['status'] == 0 && $response['message'] == 'AWB Already Exists' && $repeat == 0) {
					$response = xpressbees_direct::xpressbees_order($value['id'], 1, '1');
					$log_data['order_response_repeat'] = $response;
					$repeat++;
				}
				// $log_data['api_name'][] = $value['api_name'];
				// $log_data['orderNo'][] = $value['order_no'];
				// $Xpressbees++;
				// $log_data['api_count'][] = $Xpressbees;
			} else if ($value['api_name'] == 'Xpressbeesair_Direct') {
				$repeat = 0;

				$response = xpressbeesair_direct::xpressbeesair_order($value['id'], 0, '1');
				$log_data['order_response'] = $response;
				if ($response['status'] == 0 && $response['message'] == 'AirWayBillNO Already exists' && $repeat == 0) {
					$response = xpressbeesair_direct::xpressbeesair_order($value['id'], 1, '1');
					$log_data['order_response_repeat'] = $response;
					$repeat++;
				}
			} else if ($value['api_name'] == 'Ekart_Direct') {
				// $this->load->helper('ecart_direct');
				$response = ekart_direct::ekart_order($value['id'], '1');
				// $log_data['order_response_repeat'] = $response;
				// $log_data['api_name'][] = $value['api_name'];
				// $log_data['orderNo'][] = $value['order_no'];
				// $Ekart++;
				// $log_data['api_count'][] = $Ekart;
			} else if ($value['api_name'] == 'Ecom_Direct') {
				$response = ecom_direct::ecom_order($value['id'], '1');
				// $log_data['order_response_repeat'] = $response;
				// $log_data['api_name'][] = $value['api_name'];
				// $log_data['orderNo'][] = $value['order_no'];
				// $ecom++;
				// $log_data['api_count'][] = $ecom;
			} else if ($value['api_name'] == 'Udaan_Direct') {
				$this->load->helper('udaan_direct');
				$response = Udaan_Direct::create_order($value['id'], '1');
				// $log_data['order_response_repeat'] = $response;
				// $log_data['api_name'][] = $value['api_name'];
				// $log_data['orderNo'][] = $value['order_no'];
				// $Udaan++;
				// $log_data['api_count'][] = $Udaan;
			} else if ($value['api_name'] == "Delhivery_Direct") {
				$this->load->helper('delhiver_direct');
				$response = delhiver_direct::create_order($value['id'], 1);
			} else if ($value['api_name'] == 'Deliverysexpress_Direct') {
				$this->load->helper('delhiver_direct');
				$response = delhiver_direct::create_order($value['id'], 1, 1);
			} else if ($value['api_name'] == 'Shadowfax_Direct') {
				$this->load->helper('shadowfax_direct');
				$response = shadowfax_direct::create_order($value['id'], 1);
				$createOrder_response_log['order_response'] = $response;
				file_put_contents(APPPATH . 'logs/create_order_simple/' . date("d-m-Y") . '_create_order.txt', print_r($createOrder_response_log, true), FILE_APPEND);
			}
			if ($response['status'] == 1) {
				$success_count++;
			} else {
				$error_count++;
			}
		}
		$log_data['success_count'] = $success_count;
		$log_data['error_count'] = $error_count;
		file_put_contents(APPPATH . 'logs/zship_cron/' . date("d-m-Y") . 'cron_log.txt', "\n" . print_r($log_data, true) . "\n\n", FILE_APPEND);
		echo "  Success Order :  " . $success_count;
		echo "<br>  Error Order :" . $error_count;

		file_put_contents(APPPATH . 'logs/zship_cron/' . date("d-m-Y") . 'cron_log.txt', "------- end Log ------\n\n\n", FILE_APPEND);
	}

	// Insert Pickup Address In ZSHIP
	public function create_address_in_api($pickup_address_fetch_row_info)
	{

		$token_detail = $this->Common_model->getSingle_data('*', 'zship_token_master', '');
		$address = $pickup_address_fetch_row_info['address_line_1'];
		if ($pickup_address_fetch_row_info['address_line_2'] != "") {
			$address .= ", " . $pickup_address_fetch_row_info['address_line_2'];
		}
		$address .= ", " . $pickup_address_fetch_row_info['city'] . ", " . $pickup_address_fetch_row_info['state'];

		$request_body = 'name=' . urlencode($pickup_address_fetch_row_info['warehouse_name']) . '&company=' . urlencode($pickup_address_fetch_row_info['contact_person_name']) . '&email=' . urlencode($pickup_address_fetch_row_info['contact_email']) . '&address=' . urlencode($address) . '&phone=' . urlencode($pickup_address_fetch_row_info['contact_no']) . '&pincode=' . urlencode($pickup_address_fetch_row_info['pincode']) . '';
		$response['api-request-body'] = $request_body;

		$curl_response = CUSTOM::curl_request('application/x-www-form-urlencoded', $token_detail['token'], $this->config->item('ZSHIP_API_SAVE_SENDER_URL'), $request_body, "POST");

		$response['curl_response'] = $curl_response;
		if (@$curl_response['error_response'] != "") {
			$response['error_response'] = $curl_response['error_response'];
		} else {
			if ($curl_response['success_response']['status'] == 200) {
				if ($curl_response['success_response']['message']['sender_id'] != "") {
					$response['success_response'] = "create in api order suceessfuly.";
					$data['zship_sender_id'] = $curl_response['success_response']['message']['sender_id'];
					$this->Common_model->update($data, 'sender_address_master', array('id' => $pickup_address_fetch_row_info['id']));
				} else {
					$response['error_response'] = $curl_response['success_response']['message'];
				}
			} elseif ($curl_response['success_response']['status'] == 401) {
				$response['error_response'] = $curl_response['success_response']['message'];
			} elseif ($curl_response['success_response']['status'] == 400) {
				if (is_array($response['success_response']['message'])) {
					$response['error_response'] = "Invalid Request.";
				} else {
					$response['error_response'] = $curl_response['success_response']['message'];
				}
			}
		}
		return $response;
	}

	public function tracking_cron()
	{
		$post_data = file_get_contents('php://input');
		$log_data['response_data'] = $post_data;
		// $post_data = '{"status":200,"info":{"status_count":1,"status":[{"tracking_id":"6221711954831","order_id":"SRTN1","provider":"delhivery","shipment_status":"rto created","description":"OTP verified cancellation","status_time":"2021-04-15 17:47:31"}]}}';
		$data = json_decode($post_data, true);
		$log_data['response_post_data'] = $data;
		file_put_contents(APPPATH . 'logs/zship_tracking/' . date("d-m-Y") . 'tracking_log.txt', "------- Start Log ------\n" . print_r($log_data, true) . "\n\n", FILE_APPEND);

		if ($data['status'] == 200) {
			if ($data['info']['status_count'] > 0) {
				foreach ($data['info']['status'] as $single) {
					$orderData = array();
					$match = array('out for delivery', 'rto intransit', 'ndr', 'rto created', 'rto delivered', 'intransit', 'created', 'delivered', 'ofd', 'Out For Pickup');
					$replace = array('Dispatched', 'RTO In Transit', 'NDR', 'RTO Manifested', 'RTO', 'In Transit', 'Created', 'Delivered', 'Dispatched', 'OFP');
					$order_master_data = $this->Zship_cron_model->get_order_data(trim($single['tracking_id']));
					$logData['order_master_data'] = $order_master_data;
					$logData['order_master_query'] = $this->db->last_query();

					$orderStatus = str_replace($match, $replace, $single['shipment_status']);
					if ($single['tracking_id'] == $order_master_data['awb_number']) {
						$data_track['scan_date_time'] = $single['status_time'];
						$data_track['scan'] = $single['shipment_status'];

						$data_track['remark'] = (empty($single['description']) ? "NA" : $single['description']);
						$data_track['order_id'] = $order_master_data['id'];
						$data_track['create_date'] = date("Y-m-d H:i:s");
						$logData['trackData'] = $data_track;
						$result = $this->Common_model->insert($data_track, 'order_tracking_detail');
						$logData['trackResult'] = $result;

						if ($single['shipment_status'] == 'delivered') {
							$orderStatus = $this->Common_model->getSingle_data('order_status_id', 'order_status', array('status_name' => trim($orderStatus)));
							$logData['statusQuery'] = $this->db->last_query();
							$orderData['order_status_id'] = $orderStatus['order_status_id'];
							$orderData['delivery_date'] = date("Y-m-d");
							$logData['statusData'] = $orderData;
							$orderResult = $this->Common_model->update($orderData, 'order_airwaybill_detail', array('order_id' => $order_master_data['id']));
							$logData['statusResult'] = $orderResult;
							// } else if ($single['shipment_status'] == "rto created" && $order_master_data['order_type'] == 0) {
						} else {
							if ($single['shipment_status'] == "rto created") {

								$status = $this->db->select('order_id')->from('order_airwaybill_detail')->where('airwaybill_no', $single['tracking_id'])->where('order_status_id', '9')->get()->result_array();

								if (empty($status)) {
									$result = wallet_direct::refund_wallet(trim($single['tracking_id']), '0', '2');
									$log_data['walelt_data'] = $status;
									$log_data['wallet_debit_responce'] = $result;
								}
							}

							if ($single['shipment_status'] == 'rto delivered') {
								$status = $this->db->select('order_id')->from('order_airwaybill_detail')->where('airwaybill_no', $single['tracking_id'])->where('order_status_id', '14')->get()->result_array();
								if (empty($status)) {
									$result = wallet_direct::refund_wallet(trim($single['tracking_id']), '1', '2');
									$log_data['walelt_data'] = $status;
									$log_data['wallet_debit_responce'] = $result;
								}
								$orderData['delivery_date'] = date("Y-m-d");
							}

							$orderStatus = $this->Common_model->getSingle_data('order_status_id', 'order_status', array('status_name' => trim($orderStatus)));
							$logData['statusQuery'] = $this->db->last_query();
							$orderData['order_status_id'] = $orderStatus['order_status_id'];
							$logData['statusData'] = $orderData;
							$orderResult = $this->Common_model->update($orderData, 'order_airwaybill_detail', array('order_id' => $order_master_data['id']));
							$logData['statusResult'] = $orderResult;
						}
						file_put_contents(APPPATH . 'logs/zship_tracking/' . date("d-m-Y") . 'tracking_log.txt', print_r($logData, true) . "\n------- End Log ------\n\n", FILE_APPEND);
					} else {
						$logData1['error'] = 'No data in Webhook';
						$logData1['single_data'] = $single;
						file_put_contents(APPPATH . 'logs/zship_tracking/' . date("d-m-Y") . 'tracking_log.txt', print_r($logData1, true) . "\n------- End Log ------\n\n", FILE_APPEND);
					}
					file_put_contents(APPPATH . 'logs/zship_tracking/' . date("d-m-Y") . 'tracking_log.txt', print_r($logData, true) . "\n------- End Log ------\n\n", FILE_APPEND);
				}
			} else {
				$logData1['error'] = 'No data in Webhook';
				file_put_contents(APPPATH . 'logs/zship_tracking/' . date("d-m-Y") . 'tracking_log.txt', print_r($logData1, true) . "\n------- End Log ------\n\n", FILE_APPEND);
			}
		} else {
			$logData1['error'] = 'Error From Webhook';
			file_put_contents(APPPATH . 'logs/zship_tracking/' . date("d-m-Y") . 'tracking_log.txt', print_r($logData1, true) . "\n------- End Log ------\n\n", FILE_APPEND);
		}
		file_put_contents(APPPATH . 'logs/zship_tracking/' . date("d-m-Y") . 'tracking_log.txt', print_r($logData1, true) . "\n------- End Log ------\n\n", FILE_APPEND);
	}

	// public function process_priority($order_id, $error_message = "")
	// {
	//     $order_data = $this->Zship_cron_model->get_order($order_id);
	//     $logistic_priority = $this->db->select('priority,logistic_id')->from('logistic_priority')->where('sender_id', $order_data['sender_id'])->order_by('priority', "ASC")->get()->result_array();
	//     // lq();
	//     // dd($order_data);
	//     // dd($logistic_priority);

	//     foreach ($logistic_priority as $key => $single_priority) {
	//         unset($logistic_priority[$key]);
	//         if ($single_priority['logistic_id'] == $order_data['logistic_id']) {
	//             break;
	//         }
	//     }

	//     $logistic_priority = array_values($logistic_priority);
	//     // dd($logistic_priority);

	//     if (empty($logistic_priority)) {
	//         $awbNumber = empty($order_data['awb_number']) ? " " : $order_data['awb_number'];
	//         $orderResponse = wallet_direct::debit_wallet($order_id, 'temp_order_master', $awbNumber, $order_data['order_no'], $error_message, '1');
	//     } else {

	//         $newlogistic_id = $logistic_priority[0]['logistic_id'];
	//         // dd($newlogistic_id);
	//         $get_total_amount = get_shiping_price($order_data['sender_id'], $newlogistic_id, $order_data['pickup_pincode'], $order_data['receiver_pincode'], 1, $order_data['order_type'], $order_data['volumetric_weight'], $order_data['physical_weight'], $order_data['cod_amount'], 1, 18);
	//         // dd($get_total_amount);

	//         if ($get_total_amount['status'] == 1) {
	//             $inserdata3['logistic_id'] = $get_total_amount['data'][0]['logistic_id'];
	//             $inserdata3['total_shipping_amount'] = $get_total_amount['data'][0]['subtotal'];
	//             $inserdata3['sgst_amount'] = $get_total_amount['data'][0]['tax']['SGST'];
	//             $inserdata3['cgst_amount'] = $get_total_amount['data'][0]['tax']['CGST'];
	//             $inserdata3['igst_amount'] = $get_total_amount['data'][0]['tax']['IGST'];
	//             $inserdata3['is_flag'] = 1;
	//             $inserdata3['is_process'] = 0;
	//             $inserdata1['cod_charge'] = $get_total_amount['data'][0]['cod_ammount'];

	//             try {
	//                 $update_data_order =  $this->Zship_cron_model->update_order($inserdata3, $order_id);
	//                 $update_data_detial = $this->Zship_cron_model->update_order_detail($inserdata1, $order_data['order_product_detail_id']);
	//                 if (empty($update_data_detial) || empty($update_data_order)) {
	//                     throw new Exception("Database Error in cron");
	//                     $res['status'] = 0;
	//                     $res['message'] = "Order is proceed successfully";
	//                 }
	//             } catch (exception $e) {
	//                 $log_data['error']  = $e->getMessage();
	//                 $res['status'] = 0;
	//                 $res['message'] = "Data can't be updated for priority";
	//             }
	//         } else {
	//             $error_message = $get_total_amount['message'];
	//             $awbNumber = empty($order_data['awb_number']) ? " " : $order_data['awb_number'];
	//             wallet_direct::debit_wallet($order_id, 'temp_order_master', $awbNumber, $order_data['order_no'], $error_message, '1');
	//             $res['status'] = 0;
	//             $res['message'] = $error_message;
	//         }
	//     }
	// }
}

/* End of file Controllername.php */
