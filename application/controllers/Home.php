<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('home_model');
		// $this->load->model('order_model');
		// $this->load->model('admin_model');

		$this->load->helper('CURLREQUEST');
		$this->load->helper('CUSTOM');
	}

	public function FunctionName()
	{
		// $order_data = $this->Common_model->getResult(array('user_id' => 1212), 'id,waybill,logistics,shipping_charge,is_order_count', 'order_master', "id", "ASC");
		// foreach ($order_data as $single_order_info) {
		// 	echo "<pre>======================================================================================<br>";
		// 	print_r($single_order_info);
		// 	echo "</pre>";
		// 	$order_wallet_data = $this->Common_model->getResultArray(array('order_id' => $single_order_info->id, 'user_id' => 1212), '*', 'wallet_transaction', "id", "ASC");
		// 	echo "<pre>------------------------------<br>";
		// 	print_r($order_wallet_data);
		// 	echo "</pre>";
		// 	echo "<br>++++++++++++++++++++++<br>";
		// 	echo @$order_wallet_data[1]['id'];
		// 	echo "<br>";
		// 	echo @$order_wallet_data[1]['user_id'];
		// 	echo "<br>";
		// 	echo @$order_wallet_data[2]['id'];
		// 	echo "<br>";
		// 	echo @$order_wallet_data[2]['user_id'];
		// 	echo "<br>";
		// 	// if (@$order_wallet_data[1]['id']) {
		// 	// 	$update_data['user_id'] = 1018;
		// 	// 	$this->Common_model->update($order_wallet_data[1]['id'], $update_data, 'wallet_transaction', 'id');
		// 	// }
		// }

		$amt = 0;
		$order_wallet_data = $this->Common_model->getResultArray(array('user_id' => 294), '*', 'wallet_transaction', "id", "ASC");
		$wal_amt = 0;
		foreach ($order_wallet_data as $result12) {
			if ($result12['debit'] != "") {
				echo "debit";
				$wal_amt -= $result12['debit'];
			}
			if ($result12['credit'] != "") {
				echo "credit";
				echo "<br>";
				echo $result12['credit'];
				echo "<br>";
				$wal_amt += $result12['credit'];
			}
			echo "=============================================================================<br>";
			echo $wal_amt;
			echo "<br>";
			$data['balance'] = $wal_amt;
			echo "<br>";
			$this->Common_model->update($result12['id'], $data, 'wallet_transaction', 'id');
			echo $this->db->last_query();
			echo "<br>";
		}
	}

	public function package_slip_udaan_express($waybill)
	{
		$single_order_info = $this->Common_model->getRow(array("waybill" => $waybill), "waybill, pickup_address, customer_mobile, order_no, ship_length, ship_width, ship_height, phy_weight, create_date, order_type, city, state, seller_info, packing_slip_warehouse_name, pincode, product_description, customer_name, customer_address1, customer_address2, cod_amount, logistics, waybill_barcode_image, is_reverse, shipmentid_barcode_image, uddan_express_shipment_id", "order_master");
		if ($single_order_info->waybill != "") {
			$single_pickup_address_info = $this->Common_model->getRow(array("id" => $single_order_info->pickup_address), "warehouse_name,address_1,address_2", "pickup_address");
			$data['customer_mobile'] = $single_order_info->customer_mobile;
			$data['order_no'] = $single_order_info->order_no;
			$data['length'] = $single_order_info->ship_length;
			$data['width'] = $single_order_info->ship_width;
			$data['height'] = $single_order_info->ship_height;
			$data['phy_weight'] = $single_order_info->phy_weight;
			$data['create_date'] = date("d-m-Y H:i:s", strtotime($single_order_info->create_date));
			$data['order_type'] = @$single_order_info->order_type;
			$data['user_id'] = $this->userId;
			$data['destination'] = $single_order_info->city . " (" . $single_order_info->state . ")";
			switch ($single_order_info->seller_info) {
				case '1':
					$data['c_name'] = $single_pickup_address_info->warehouse_name;
					$data['sadd'] = $single_pickup_address_info->address_1 . " " . $single_pickup_address_info->address_2;
					break;
				default:
					$data['c_name'] = @$single_order_info->packing_slip_warehouse_name;
					break;
			}
			$data['pin'] = $single_order_info->pincode;
			$data['prd'] = $single_order_info->product_description;
			$data['name'] = $single_order_info->customer_name;
			$data['address'] = str_replace(",,", ",", $single_order_info->customer_address1 . "," . @$single_order_info->customer_address2 . "");
			$data['cod'] = $single_order_info->cod_amount;
			switch ($single_order_info->logistics) {
				case 'delhivery':
					$data['delhivery_logo'] = base_url() . '/assets/images/delhivery.jpg';
					$data['shipmentid_barcode_image'] = $data['uddan_express_shipment_id'] = "";
					break;
				case 'delhivery express':
					$data['delhivery_logo'] = base_url() . '/assets/images/delhivery.jpg';
					$data['shipmentid_barcode_image'] = $data['uddan_express_shipment_id'] = "";
					break;
				case 'shadowfax':
					$data['delhivery_logo'] = base_url() . "/assets/images/shadowfax.jpg";
					$data['shipmentid_barcode_image'] = $data['uddan_express_shipment_id'] = "";
					break;
				case 'Xpressbees Lite':
					$data['delhivery_logo'] = base_url() . "/assets/images/XBLogo_Small.jpg";
					$data['shipmentid_barcode_image'] = $data['uddan_express_shipment_id'] = "";
					break;
				case 'Xpressbees Express':
					$data['delhivery_logo'] = base_url() . "/assets/images/XBLogo_Small.jpg";
					$data['shipmentid_barcode_image'] = $data['uddan_express_shipment_id'] = "";
					break;
				case 'DTDC':
					$data['delhivery_logo'] = base_url() . "/assets/images/dtdc.jpg";
					$data['shipmentid_barcode_image'] = $data['uddan_express_shipment_id'] = "";
					break;
				case 'Udaan Express':
					$data['delhivery_logo'] = base_url() . "/assets/images/udaanexpress.png";
					if ($single_order_info->shipmentid_barcode_image != "") {
						$data['shipmentid_barcode_image'] = base_url() . 'upload/shipmentid_barcode/' . $single_order_info->shipmentid_barcode_image;
						$data['uddan_express_shipment_id'] = $single_order_info->uddan_express_shipment_id;
					} else {
						$data['uddan_express_shipment_id'] = $single_order_info->uddan_express_shipment_id;
						CUSTOM::barcode(base_url() . '/upload/shipmentid_barcode/' . $single_order_info->id . '.jpg', $single_order_info->uddan_express_shipment_id, 25, "horizontal", "Code39", "true", 1);
						$update_shipment_barcode_data['shipmentid_barcode_image'] = $single_order_info->id . ".jpg";
						$this->Common_model->update($single_order_info->id, $update_shipment_barcode_data, 'order_master', 'id');
						$data['shipmentid_barcode_image'] = base_url() . 'upload/shipmentid_barcode/' . $single_order_info->id . ".jpg";
					}
					break;
				default:
					$data['delhivery_logo'] = $data['shipmentid_barcode_image'] = $data['uddan_express_shipment_id'] = "";
					break;
			}
			if ($single_order_info->waybill_barcode_image != "") {
				$data['barcode'] = base_url() . 'upload/waybill_barcode/' . $single_order_info->waybill_barcode_image;
			} else {
				switch ($single_order_info->logistics) {
					case 'delhivery':
						$data['barcode'] = $this->createWaybillBarcodeImage($id, $single_order_info->logistics, $single_order_info->waybill, $this->config->item("DEHLIVERY_ORDER_API_TOKEN"));
						break;
					case 'delhivery express':
						$data['barcode'] = $this->createWaybillBarcodeImage($id, $single_order_info->logistics, $single_order_info->waybill, $this->config->item);
						break;
					default:
						$data['barcode'] = $this->createWaybillBarcodeImage($id, $single_order_info->logistics, $single_order_info->waybill, "");
						break;
				}
			}
		} else {
			$this->session->set_flashdata('error', 'Waybill No not found.');
			switch ($single_order_info->is_reverse) {
				case '0':
					redirect(base_url());
					break;
				default:
					redirect(base_url());
					break;
			}
		}
		$this->load->library('pdf');
		$html = $this->load->view('admin/package-slip-new1', $data, true);
		$this->pdf->createPDF($html, 'mypdf', false, 'A4', 'portrait');
	}

	function createWaybillBarcodeImage($order_id, $logistics, $waybill_no, $token = "")
	{
		switch ($logistics) {
			case 'delhivery':
				$response = CURLREQUEST::curlRequest("", "", "", $token, $this->config->item("DEHLIVERY_ORDER_PACKAGE_SLIP_URL") . "" . $waybill_no, "", 'GET');
				if (@$response['Error'] != '') {
					return $response['Error'];
				} else {
					file_put_contents($this->config->item("FILE_PATH") . '/upload/waybill_barcode/' . $order_id . '.jpg', base64_decode(str_replace("data:image/png;base64,", "", $response['Data']['packages'][0]['barcode'])));
					$data['waybill_barcode_image'] = $order_id . ".jpg";
					$this->Common_model->update($order_id, $data, 'order_master', 'id');
					return base_url() . 'upload/waybill_barcode/' . $order_id . ".jpg";
				}
				break;
			case 'delhivery express':
				$response = CURLREQUEST::curlRequest("", "", "", $token, $this->config->item("DEHLIVERY_ORDER_PACKAGE_SLIP_URL") . "" . $waybill_no, "", 'GET');
				if (@$response['Error'] != '') {
					return $response['Error'];
				} else {
					file_put_contents($this->config->item("FILE_PATH") . '/upload/waybill_barcode/' . $order_id . '.jpg', base64_decode(str_replace("data:image/png;base64,", "", $response['Data']['packages'][0]['barcode'])));
					$data['waybill_barcode_image'] = $order_id . ".jpg";
					$this->Common_model->update($order_id, $data, 'order_master', 'id');
					return base_url() . 'upload/waybill_barcode/' . $order_id . ".jpg";
				}
				break;
			default:
				CUSTOM::barcode(base_url() . '/upload/waybill_barcode/' . $order_id . '.jpg', $waybill_no, 25, "horizontal", "Code39", "true", 1);
				$data['waybill_barcode_image'] = $order_id . ".jpg";
				$this->Common_model->update($order_id, $data, 'order_master', 'id');
				return base_url() . 'upload/waybill_barcode/' . $order_id . ".jpg";
				break;
		}
	}

	public function index()
	{
		$this->load->view('template/header');
		$this->load->view('front/home');
		$this->load->view('template/footer');
	}
	public function login_user()
	{
		if (!$this->session->userdata('id')) {
			$this->load->view('front/login');
		} else {
			redirect('dashboard');
		}
	}
	public function contact_page()
	{
		$this->load->helper('captcha');
		$config = array(
			'img_url' => base_url() . 'upload/image_for_captcha/',
			'img_path' => 'upload/image_for_captcha/',
			'word_length' => 6,
			'img_width' => '120',
			'img_height' => 30,
			'font_size' => 14,
			'colors' => array(
				'background' => array(0, 0, 0),
				'border' => array(0, 0, 0),
				'text' => array(255, 255, 255),
				'grid' => array(0, 0, 0),
			),
		);

		$captcha = create_captcha($config);
		// dd($captcha);
		$this->session->unset_userdata('captcha_word');
		$this->session->set_userdata('captcha_word', $captcha['word']);
		$data['captchaimage'] = $captcha['image'];


		$this->load->view('template/header');
		$this->load->view('front/contact', $data);
		$this->load->view('template/footer');
	}
	public function refresh_captcha()
	{
		$this->load->helper('captcha');
		$config = array(
			'img_url' => base_url() . 'upload/image_for_captcha/',
			'img_path' => 'upload/image_for_captcha/',
			'word_length' => 6,
			'img_width' => '120',
			'img_height' => 30,
			'font_size' => 14,
			'colors' => array(
				'background' => array(0, 0, 0),
				'border' => array(0, 0, 0),
				'text' => array(255, 255, 255),
				'grid' => array(0, 0, 0),
			),
		);
		$captcha = create_captcha($config);
		$this->session->unset_userdata('captcha_word');
		$this->session->set_userdata('captcha_word', $captcha['word']);
		$captcha_word = $captcha['word'];
		$captchaimage = $captcha['image'];
		echo json_encode(array('captchaimage' => $captchaimage, 'captcha_word' => $captcha_word));
		exit();
	}
	public function about_us()
	{
		$this->load->view('template/header');
		$this->load->view('front/about');
		$this->load->view('template/footer');
	}
	public function save_contact()
	{
		$data['name'] = $this->input->post('name');
		$data['email'] = $this->input->post('email');
		$data['phone'] = $this->input->post('contact_no');
		$data['airwaybillno'] = $this->input->post('tracking_number');
		$data['date'] = date('Y/m/d h:i:sa');
		$email = trim($this->input->post('email'));
		$result = $this->home_model->insert_enquiry($data);
		if ($result) {
			$body = '<div class="text_para" ><img src="' . $img_path . '" with="150px"></div><br>
			                <div class="text_para"><p>You have received a new Enquiry..</p></div>
			                <br>
			                <div class="text_para"><p>Here are the details::</p></div>
			                <br>
			                <div class="text_para"><p><strong>Name:</strong> ' . $name . '</p></div>
			                <div class="text_para"><p><strong>Email:</strong> ' . $email . '</p></div>
			                <div class="text_para"><p><strong>Phone no:</strong> ' . $contact_no . '</p></div>
			                <div class="text_para"><p><strong>Airwaybill no:</strong> ' . $tracking_number . '</p></div>';
			$res = simpleMail("support@shipsecurelogistics.com", "ShipSecure : New Enquiry", $body);
			if ($res) {
				$this->session->set_flashdata("message", "Success!! Mail sent Successfully.");
				redirect('contact');
			} else {
				$this->session->set_flashdata("error", "Something went to wrong.");
				redirect('contact');
			}
		} else {
			$this->session->set_flashdata("error", "Something went to wrong.");
			redirect('contact');
		}
	}
	public function register()
	{
		if (!$this->session->userdata('id')) {
			$this->load->view('template/header');
			$this->load->view('front/signup');
			$this->load->view('template/footer');
		} else {
			redirect('dashboard');
		}
	}
	public function privacy_policy()
	{
		$this->load->view('template/header');
		$this->load->view('front/privacy_policy');
		$this->load->view('template/footer');
	}
	public function terms_conditions()
	{
		$this->load->view('template/header');
		$this->load->view('front/terms_conditions');
		$this->load->view('template/footer');
	}
	public function disclaimer()
	{
		$this->load->view('template/header');
		$this->load->view('front/disclaimer');
		$this->load->view('template/footer');
	}
	public function login_check()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$result = $this->home_model->login_check($email, $password);
		if ($result) {
			$id = $result->id;
			$user_type = $result->user_type;
			$error = "Site Under maintenance to upgrade system. very soon its available for you." . "<br>" . " sorry for inconvenience caused to you";
			if ($user_type == 0) {
				if ($result->isActive == '1') {
					$userData = (array) $result;
					$this->session->set_userdata($userData);
					$resultkyc = $this->home_model->check_availablity_user_in_kyc($id);
					if (empty($resultkyc)) {
						if (!file_exists(base_url() . '/upload/log_error/' . $result->id)) {
							mkdir(base_url() . '/upload/log_error/' . $result->id, 0777, true);
						}
						redirect('kyc-verification');
					} else {
						if ($result->customer_status == 'Approved') {
							$resultaddress = $this->home_model->check_availablity_user_in_address($id);
							if (empty($resultaddress)) {
								if (!file_exists(base_url() . '/upload/log_error/' . $result->id)) {
									mkdir(base_url() . '/upload/log_error/' . $result->id, 0777, true);
								}
								redirect('pickup-address');
							} else {
								if (!file_exists(base_url() . '/upload/log_error/' . $result->id)) {
									mkdir(base_url() . '/upload/log_error/' . $result->id, 0777, true);
								}
								redirect('view-order');
							}
						} else {
							if (!file_exists(base_url() . '/upload/log_error/' . $result->id)) {
								mkdir(base_url() . '/upload/log_error/' . $result->id, 0777, true);
							}
							redirect('approve-pending');
						}
					}
				} else {
					$this->session->set_flashdata('error', 'Your account is currently Inactive.Please contact administrator');
					redirect('login');
				}
			} elseif ($user_type == 2) {
				$userData = (array) $result;
				$this->session->set_userdata($userData);
				if (!file_exists(base_url() . '/upload/log_error/' . $result->id)) {
					mkdir(base_url() . '/upload/log_error/' . $result->id, 0777, true);
				}
				redirect('monthly-statment');
			} else {
				$userData = (array) $result;
				$this->session->set_userdata($userData);
				if (!file_exists(base_url() . '/upload/log_error/' . $result->id)) {
					mkdir(base_url() . '/upload/log_error/' . $result->id, 0777, true);
				}
				redirect('dashboard');
			}
		} else {
			$this->session->set_flashdata('error', 'Your Email Or Password Does Not Match');
			redirect('login');
		}
	}
	public function login_check_maintan()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$result = $this->home_model->login_check($email, $password);
		if ($result) {
			$id = $result->id;
			$user_type = $result->user_type;
			if ($id == '42' || $id == '505') {
				$userData = (array) $result;
				$this->session->set_userdata($userData);
				redirect('dashboard');
			} else {
				$error = "Site Under maintenance to upgrade system. very soon its available for you." . "<br>" . " sorry for inconvenience caused to you";
				$this->session->set_flashdata('error', $error);
				redirect('login');
			}
		} else {
			$this->session->set_flashdata('error', 'Your Email Or Password Does Not Match');
			redirect('login');
		}
	}
	public function register_user()
	{
		$data['name'] = $this->input->post('name');
		$data['email'] = $this->input->post('email');
		$data['phone'] = $this->input->post('phone');
		$data['user_type'] = "0";
		$data['password'] = $this->input->post('password');
		date_default_timezone_set('Asia/Kolkata');
		$data['date'] = date('Y-m-d H:i:s');
		$data['customer_status'] = 'Pending';
		$data['website'] = $this->input->post('website');
		$result = $this->home_model->insert_user($data);
		if ($result) {
			$img_path = base_url() . "assets/images/logo.png";
			$to_mail = "support@shipsecurelogistics.com";
			// $this->email->subject('ShipSecure : New Customer');
			$body = '<div class="text_para"><p>You have received a new Customer Detail: </p></div>
			                <br>
			                <div class="text_para"><p>Here are the details::</p></div>
			                <br>
			                <div class="text_para"><p><strong>Name:</strong> ' . $data['name'] . '</p></div>
			                <div class="text_para"><p><strong>Email:</strong> ' . $data['email'] . '</p></div>
			                <div class="text_para"><p><strong>Phone no:</strong> ' . $data['phone'] . '</p></div>
			                <br>
			                <div class="text_para" ><img src="' . $img_path . '" with="150px"></div>';
			$res = simpleMail($to_mail, 'ShipSecure : New Customer', $body);
			if ($res) {
				$to_mail = $data['email'];
				// $this->email->subject('ShipSecure : New Customer');
				$body = '<div class="text_para"><p>Greeting from Shipsecure logistics you have been successfully signed in our shipping network ,we are pleased to have you </p></div>
				                <br>
				                <div class="text_para" ><img src="' . $img_path . '" with="150px"></div>';
				$res1 = simpleMail($to_mail, 'New Registartion', $body);
				$result1 = $this->home_model->login_check($data['email'], $data['password']);
				if ($result1) {
					$userData = (array) $result1;
					$this->session->set_userdata($userData);
					redirect('kyc-verification');
				} else {
					$this->session->set_flashdata("message", "Register Successfully.");
					redirect('login');
				}
			} else {
				$this->session->set_flashdata("error", "Something went to wrong.");
				redirect('register');
			}
		} else {
			$this->session->set_flashdata("error", "Something went to wrong.");
			redirect('register');
		}
	}
	public function email($id = '')
	{
		$id = @$_SESSION['id'];
		$email = $this->input->post('email');
		echo $this->home_model->checkDuplicateEmail($email, $id);
		exit;
	}
	public function logout()
	{
		session_destroy();
		redirect(base_url());
	}
	public function track_order()
	{
		$data['track_data'] = "";
		$tracking_number = trim($this->input->post('tracking_number'));
		if ($tracking_number != "") {
			redirect('track-order-number/' . $tracking_number);
		} else {
			$this->load->view('template/header');
			if (@$this->input->post('tracking_number') != '') {
				$this->load->view('front/track_order', $data);
			} else {
				$this->load->view('front/track_order', $data);
			}
			$this->load->view('template/footer');
		}
	}
	public function track_order_number($tracking_number = "")
	{
		$data['track_data'] = "";
		if (@$tracking_number != '') {
			file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_track_order/' . date("d-m-Y") . '_log.txt', "\n---------------------------------------------------- START TRACK DATA -------------------------------------------------", FILE_APPEND);
			// $log_data1['tracking_data_tracking_number'] = $tracking_number = trim($this->input->post('tracking_number'));
			$message = $track_data = "";
			// dd($tracking_number);
			$result = $this->home_model->get_info(trim($tracking_number));
			// lq();

			// $result = $this->order_model->get_detail_from_waybill_no(trim($tracking_number));
			$log_data1['tracking_data_details'] = $result;
			file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_track_order/' . date("d-m-Y") . '_log.txt', "\n" . print_r($log_data1, true), FILE_APPEND);
			if ($result != "") {

				$address = $result->address_1;
				if (@$result->address_2 != "") {
					$address .= ",<br>" . $result->address_2;
				}
				switch ($result->api_name) {
					case 'Delhivery_Direct':
						$response = CURLREQUEST::curlTrackRequest("", $this->config->item('DEHLIVERY_ORDER_API_TOKEN'), $this->config->item('DEHLIVERY_ORDER_TRACK_ORDER') . "" . trim(trim($tracking_number)), "", 'GET');
						// dd($response);
						if (@$response['Error'] != '') {
							$tracking_array = array();
						} else {
							$date = date("d-m-Y", strtotime($response['Data']['ShipmentData'][0]['Shipment']['Status']['StatusDateTime']));
							$time = date("H:i:s", strtotime($response['Data']['ShipmentData'][0]['Shipment']['Status']['StatusDateTime']));
							$scan_count = count($response['Data']['ShipmentData'][0]['Shipment']['Scans']);
							$Instructions = array();
							$j = 0;
							for ($i = $scan_count - 1; $i >= 0; $i--) {
								if (!in_array(@$response['Data']['ShipmentData'][0]['Shipment']['Scans'][$i]['ScanDetail']['Instructions'], $Instructions)) {
									array_push($Instructions, @$response['Data']['ShipmentData'][0]['Shipment']['Scans'][$i]['ScanDetail']['Instructions']);
									$datetime = date("d-m-Y H:i:s", strtotime(@$response['Data']['ShipmentData'][0]['Shipment']['Scans'][$i]['ScanDetail']['ScanDateTime']));
									$tracking_array[$j]['scan_date_time'] = @$datetime;
									$tracking_array[$j]['scan'] = @$response['Data']['ShipmentData'][0]['Shipment']['Scans'][$i]['ScanDetail']['Scan'];
									$tracking_array[$j]['location'] = @$response['Data']['ShipmentData'][0]['Shipment']['Scans'][$i]['ScanDetail']['ScannedLocation'];
									$tracking_array[$j]['remark'] = @$response['Data']['ShipmentData'][0]['Shipment']['Scans'][$i]['ScanDetail']['Instructions'];
									$j++;
								}
							}
						}
						break;
					case 'Shadowfax_Direct':
						$response = CURLREQUEST::curlTrackRequest("", $this->config->item("SHADOWFAX_ORDER_API_TOKEN"), $this->config->item("SHADOWFAX_ORDER_URL") . "" . trim(trim($tracking_number)) . "" . $this->config->item("SHADOWFAX_ORDER_TRACK_ORDER_LAST_PART"), "", 'GET');
						if (@$response['Error'] != '') {
							$tracking_array = array();
						} else {
							$scan_count = count($response['Data']['tracking_details']);
							$j = 0;
							for ($i = $scan_count - 1; $i >= 0; $i--) {
								$date1 = @$response['Data']['tracking_details'][$i]['created'];
								$date1 = str_replace("T", "", @$date1);
								$date1 = str_replace("Z", "", @$date1);
								$datetime = date("d-m-Y H:i:s", strtotime(@$date1));
								$tracking_array[$j]['scan_date_time'] = @$datetime;
								$tracking_array[$j]['scan'] = str_replace("New", "Manifested", @$response['Data']['tracking_details'][$i]['status']);
								$tracking_array[$j]['location'] = @$response['Data']['tracking_details'][$i]['location'];
								$tracking_array[$j]['remark'] = @$response['Data']['tracking_details'][$i]['remarks'];
								$j++;
							}
						}
						break;
					case 'Dtdc_Direct':
						$response = CURLREQUEST::curlTrackRequest("DTDC", "", $this->config->item("DTDC_ORDER_TRACK_ORDER_FIRST_PART") . "" . trim(trim($tracking_number)) . "" . $this->config->item("DTDC_ORDER_TRACK_ORDER_LAST_PART"), "", 'GET');
						@$xml = simplexml_load_string(@$response['Data']);
						@$json = json_encode(@$xml);
						@$array = json_decode(str_replace("@", "", @$json), TRUE);
						if (@$response['Error'] != '' && @$array['CONSIGNMENT']['CNHEADER']['CNTRACK'] == 'false') {
							$tracking_array = array();
						} else {
							$date = date("d-m-Y", strtotime(@$result->create_date));
							$scan_count = count($array['CONSIGNMENT']['CNBODY']['CNACTION']);
							$j = 0;
							for ($i = $scan_count - 1; $i >= 0; $i--) {
								$datetime1 = @$array['CONSIGNMENT']['CNBODY']['CNACTION'][$i]['FIELD'][7]['attributes']['value'];
								$insertion = "-";
								$index = 2;
								$result = substr_replace($datetime1, $insertion, $index, 0);
								$index1 = 5;
								$datetime = substr_replace($result, $insertion, $index1, 0);
								$tracking_array[$j]['scan_date_time'] = @$datetime;
								$tracking_array[$j]['scan'] = str_replace("Booked", "Manifested", @$array['CONSIGNMENT']['CNBODY']['CNACTION'][$i]['FIELD'][1]['attributes']['value']);
								$tracking_array[$j]['location'] = @$array['CONSIGNMENT']['CNBODY']['CNACTION'][$i]['FIELD'][3]['attributes']['value'];
								$tracking_array[$j]['remark'] = @$array['CONSIGNMENT']['CNBODY']['CNACTION'][$i]['FIELD'][9]['attributes']['value'];
								$j++;
							}
						}
						break;
					case 'Xpressbees_Direct':
						$body = '{
			  				"XBkey":"' . $this->config->item("XPRESSBEES_ORDER_KEY") . '",
			  				"AWBNo":"' . trim($tracking_number) . '"
							}';
						$response = CURLREQUEST::curlTrackRequest("", "", $this->config->item("XPRESSBEES_ORDER_TRACK_ORDER"), $body, 'POST');
						if (@$response['Error'] != '') {
							$tracking_array = array();
						} else if (@$response['Data'][0]['ReturnMessage'] == 'Successful') {
							$date = date("d-m-Y", strtotime(@$result->create_date));
							$scan_count = count($response['Data'][0]['ShipmentSummary']);
							$j = 0;
							for ($i = 0; $i < $scan_count; $i++) {
								$datetime = date("d-m-Y", strtotime(@$response['Data'][0]['ShipmentSummary'][$i]['StatusDate']));
								$tracking_array[$j]['scan_date_time'] = @$datetime;
								$tracking_array[$j]['scan'] = str_replace("Data Received", "Manifested", @$response['Data'][0]['ShipmentSummary'][$i]['Status']);
								$tracking_array[$j]['location'] = @$response['Data'][0]['ShipmentSummary'][$i]['Location'];
								$tracking_array[$j]['remark'] = @$response['Data'][0]['ShipmentSummary'][$i]['Comment'];
								$j++;
							}
						}
						break;
					case 'Udaan_Direct':
						$response = CURLREQUEST::curlRequest($this->config->item("UDAAN_CLIENTID"), "", "", "", $this->config->item("UDAAN_ORDER_TRACK_ORDER") . "" . trim($tracking_number), "", 'GET');
						if (@$response['Error'] != '') {
							$tracking_array = array();
						} else if (@$response['Data']['responseMessage'] == 'Request processed Successfully') {
							if (@$response['Data']['response']['externalShipmentScans'] > 0) {
								$scan_count = count($response['Data']['response']['externalShipmentScans']);
								$j = 0;
								for ($i = 0; $i < $scan_count; $i++) {
									$udaan_expressArr = array('PICKUP_CREATED', 'OUT_FOR_PICKUP', 'PICKED_UP', 'PICKUP_FAILED', 'PICKED_NOT_VERIFIED', 'HUB_INSCAN', 'HUB_OUTSCAN', 'RAD', 'OUT_FOR_DELIVERY', 'DELIVERED');
									if ($response['Data']['response']['externalShipmentScans'][$i]['shipmentMovementType'] == 'FW') {
										$customeArr = array('Manifested', 'OFP', 'In Transit', 'OFP', 'OFP', 'In Transit', 'In Transit', 'Pending', 'Dispatched', 'Delivered');
									} else {
										$customeArr = array('RTO Manifested', 'RTO Processing', 'RTO In Transit', 'RTO Processing', 'RTO Processing', 'RTO In Transit', 'RTO In Transit', 'RTO In Transit', 'RTO Dispatched', 'Returned');
									}
									$tracking_array[$j]['scan_date_time'] = date("d-m-Y H:i:s", (@$response['Data']['response']['externalShipmentScans'][$i]['timestamp'] / 1000));
									$date = date("d-m-Y", (@$response['Data']['response']['externalShipmentScans'][$i]['timestamp'] / 1000));
									$tracking_array[$j]['scan'] = str_replace($udaan_expressArr, $customeArr, $response['Data']['response']['externalShipmentScans'][$i]['shipmentState']);
									$tracking_array[$j]['location'] = @$response['Data']['response']['externalShipmentScans'][$i]['city'];
									$tracking_array[$j]['remark'] = @$response['Data']['response']['externalShipmentScans'][$i]['comment'];
									$j++;
								}
							}
						}
						break;
					default:
						$tracking_array = array();
						break;
				}
			} else {
				$tracking_array = array();
			}

			if (!empty($tracking_array)) {
				$track_data = '<div class="panel-heading">
											<h6 class="panel-title">Track order Result</h6>
										</div>
										<form class="steps-async wizard clearfix" id="steps-uid-1">
											<div class="steps clearfix" id="track_order_result">
												<div class="col-md-12" style="margin-left: 10px;padding-bottom: 10px;">Order status for (' . $tracking_number . ') is <strong>' . $result->status_name . ' </strong>' . "" . '</strong><br> Date: <strong>' . $date . '</strong> ' . ''
					. '</div>
												</div>
												<hr>
												<div class="col-md-12" style="margin-left: 5px;padding-bottom: 10px;">
					                                <div class="col-md-4 col-md-offset-4">
					                                    <strong>Receiver Address</strong><br>
					                                    <div class="receiver-address">' . @$result->name . ',<br> ' . @$address . ',<br> ' . @$result->city . ' - ' . @$result->pincode . ',<br> ' . @$result->state . '<br> ' . "" . '</div>
					                                </div>
					                            </div>
					                            <div class="col-md-12" id="scan-content-div" style="padding-left:0px;padding-right:0px;border-top: 1px solid #BBB;">
					                            	<div class="table-responsive">
					                            		<table class="table table-striped">
					                            			<thead>
									                            <tr>
									                                <th>Scan Date</th>
									                                <th>Scan</th>
									                                <th>Location</th>
									                                <th>Remark</th>
									                            </tr>
									                        </thead>
		                        							<tbody>';
				$scan_count = count($tracking_array);
				foreach ($tracking_array as $single_order_detail) {
					$track_data .= '<tr>
				                                <td>' . date("d-m-Y H:i:s", strtotime($single_order_detail['scan_date_time'])) . '</td>
				                                <td>' . $single_order_detail['scan'] . '</td>
				                                <td>' . $single_order_detail['location'] . '</td>
				                                <td>' . $single_order_detail['remark'] . '</td>
				                            </tr>';
				}
				$track_data .= '</tbody> </table> </div> </div> </div> </form>';
			} else {
				$track_data = '<div class="panel-heading">
											<h6 class="panel-title">Track order Result</h6>
										</div><form class="steps-async wizard clearfix" id="steps-uid-1"> <div class="col-md-12" style="margin-left: 10px; padding: 10px; display: block;" id="no_order_found">Invalid tracking number</div> </form>';
			}
			$data['track_data'] = $track_data;
			$data['tracking_number'] = $tracking_number;
			file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_track_order/' . date("d-m-Y") . '_log.txt', "\n---------------------------------------------------- END TRACK DATA -------------------------------------------------", FILE_APPEND);
		}
		$this->load->view('template/header');
		if (@$this->input->post('tracking_number') != '') {
			$this->load->view('front/track_order', $data);
		} else {
			$this->load->view('front/track_order', $data);
		}
		$this->load->view('template/footer');
	}
	public function track_order_number_old($tracking_number = "")
	{
		$data['track_data'] = "";
		if (@$tracking_number != '') {
			file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_track_order/' . date("d-m-Y") . '_log.txt', "\n---------------------------------------------------- START TRACK DATA -------------------------------------------------", FILE_APPEND);
			// $log_data1['tracking_data_tracking_number'] = $tracking_number = trim($this->input->post('tracking_number'));
			$message = $track_data = "";
			$result = $this->order_model->get_detail_from_waybill_no(trim($tracking_number));
			$log_data1['tracking_data_details'] = $result;
			file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_track_order/' . date("d-m-Y") . '_log.txt', "\n" . print_r($log_data1, true), FILE_APPEND);
			if ($result != "") {
				$logistics = $result->logistics;
				$status = $result->status;
				$address = $result->customer_address1;
				if (@$result->customer_address2 != "") {
					$address .= ",<br>" . $result->customer_address2;
				}
				if ($logistics == 'delhivery' || $logistics == 'delhivery express') {
					if ($logistics == 'delhivery') {
						$response = CURLREQUEST::curlTrackRequest("", $this->config->item("DEHLIVERY_ORDER_API_TOKEN"), $this->config->item("DEHLIVERY_ORDER_TRACK_ORDER")  . "" . trim($tracking_number), "", 'GET');
						$for = 'DELHIVERY';
					}
					if ($logistics == 'delhivery express') {
						$response = CURLREQUEST::curlTrackRequest("", $this->config->item("DEHLIVERY_EXPRESS_ORDER_API_TOKEN"), $this->config->item("DEHLIVERY_ORDER_TRACK_ORDER") . "" . trim($tracking_number), "", 'GET');
						$for = 'DELHIVERY EXPRESS';
					}
					file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_track_order/' . date("d-m-Y") . '_log.txt', "\n---------------START FETCH TRACKING DATA USING " . $for . " OF " . $tracking_number . "--------------\n", FILE_APPEND);
					$log_data['tracking_data_by_delhivery'] = $response;
					file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_track_order/' . date("d-m-Y") . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
					file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_track_order/' . date("d-m-Y") . '_log.txt', "\n-------------END FETCH TRACKING DATA USING " . $for . " OF " . $tracking_number . "--------------\n\n", FILE_APPEND);
					if (@$response['Error'] != '') {
						$track_data .= '<div class="panel-heading">
											<h6 class="panel-title">Track order Result</h6>
										</div><form class="steps-async wizard clearfix" id="steps-uid-1"> <div class="col-md-12" style="margin-left:10px;padding-bottom: 10px;"> Unable to fetch tracking data</div> </form>';
					} else {
						$date = date("d-m-Y", strtotime($response['Data']['ShipmentData'][0]['Shipment']['Status']['StatusDateTime']));
						$time = date("H:i:s", strtotime($response['Data']['ShipmentData'][0]['Shipment']['Status']['StatusDateTime']));
						$track_data .= '<div class="panel-heading">
											<h6 class="panel-title">Track order Result</h6>
										</div>
										<form class="steps-async wizard clearfix" id="steps-uid-1">
											<div class="steps clearfix" id="track_order_result">
												<div class="col-md-12" style="margin-left: 10px;padding-bottom: 10px;">Order status for (' . $tracking_number . ') is <strong>' . $status . ' </strong>' . "" . '<br> Date: <strong>' . $date . '</strong>' . "" . '
													</div>
												</div>
												<hr>
												<div class="col-md-12" style="margin-left: 5px;padding-bottom: 10px;">
					                                <div class="col-md-4 col-md-offset-4">
					                                    <strong>Receiver Address</strong><br>
					                                    <div class="receiver-address">' . $response['Data']['ShipmentData'][0]['Shipment']['Consignee']['Name'] . ',<br> ' . $response['Data']['ShipmentData'][0]['Shipment']['Consignee']['Address1'][0] . ',<br> ' . $response['Data']['ShipmentData'][0]['Shipment']['Consignee']['City'] . ' - ' . $response['Data']['ShipmentData'][0]['Shipment']['Consignee']['PinCode'] . ',<br> ' . $response['Data']['ShipmentData'][0]['Shipment']['Consignee']['State'] . ',<br> ' . $response['Data']['ShipmentData'][0]['Shipment']['Consignee']['Country'] . '</div>
					                                </div>
					                            </div>
					                            <div class="col-md-12" id="scan-content-div" style="padding-left:0px;padding-right:0px;border-top: 1px solid #BBB;">
					                            	<div class="table-responsive">
					                            		<table class="table table-striped">
					                            			<thead>
									                            <tr>
									                                <th>Scan Date</th>
									                                <th>Scan</th>
									                                <th>Location</th>
									                                <th>Remark</th>
									                            </tr>
									                        </thead>
		                        							<tbody>';
						$scan_count = count($response['Data']['ShipmentData'][0]['Shipment']['Scans']);
						$Instructions = array();
						for ($i = $scan_count - 1; $i >= 0; $i--) {
							if (!in_array(@$response['Data']['ShipmentData'][0]['Shipment']['Scans'][$i]['ScanDetail']['Instructions'], $Instructions)) {
								array_push($Instructions, @$response['Data']['ShipmentData'][0]['Shipment']['Scans'][$i]['ScanDetail']['Instructions']);
								$datetime = date("d-m-Y H:i:s", strtotime(@$response['Data']['ShipmentData'][0]['Shipment']['Scans'][$i]['ScanDetail']['ScanDateTime']));
								$track_data .= '<tr>
				                                <td>' . @$datetime . '</td>
				                                <td>' . @$response['Data']['ShipmentData'][0]['Shipment']['Scans'][$i]['ScanDetail']['Scan'] . '</td>
				                                <td>' . @$response['Data']['ShipmentData'][0]['Shipment']['Scans'][$i]['ScanDetail']['ScannedLocation'] . '</td>
				                                <td>' . @$response['Data']['ShipmentData'][0]['Shipment']['Scans'][$i]['ScanDetail']['Instructions'] . '</td>
				                            </tr>';
							} else {
								$track_data .= "";
							}
						}
						$track_data .= '</tbody> </table> </div> </div> </div> </form>';
					}
				} else if ($logistics == 'shadowfax') {
					$response = CURLREQUEST::curlTrackRequest("", $this->config->item("SHADOWFAX_ORDER_API_TOKEN"), $this->config->item("SHADOWFAX_ORDER_URL")  . "" . trim($tracking_number) . "" . $this->config->item("SHADOWFAX_ORDER_TRACK_ORDER_LAST_PART"), "", 'GET');
					file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_track_order/' . date("d-m-Y") . '_log.txt', "\n---------------START FETCH TRACKING DATA USING SHADOWFAX OF " . $tracking_number . "--------------\n", FILE_APPEND);
					$log_data['tracking_data_by_shadowfax'] = $response;
					file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_track_order/' . date("d-m-Y") . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
					file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_track_order/' . date("d-m-Y") . '_log.txt', "\n---------------END FETCH TRACKING DATA USING SHADOWFAX OF " . $tracking_number . "--------------\n\n", FILE_APPEND);
					if (@$response['Error'] != '') {
						$track_data .= '<div class="panel-heading">
											<h6 class="panel-title">Track order Result</h6>
										</div><form class="steps-async wizard clearfix" id="steps-uid-1"> <div class="col-md-12" style="margin-left:10px;padding-bottom: 10px;"> Unable to fetch tracking data</div> </form>';
					} else {
						$date = date("d-m-Y", strtotime($response['Data']['order_details']['order_date']));
						$time = date("H:i:s", strtotime($response['Data']['order_details']['order_date']));
						$track_data .= '<div class="panel-heading">
											<h6 class="panel-title">Track order Result</h6>
										</div>
										<form class="steps-async wizard clearfix" id="steps-uid-1">
											<div class="steps clearfix" id="track_order_result">
												<div class="col-md-12" style="margin-left: 10px;padding-bottom: 10px;">Order status for (' . $tracking_number . ') is <strong>' . $status . ' </strong>' . "" . '</strong><br> Date: <strong>' . $date . '</strong> ' . '' . '</div>
												</div>
												<hr>
												<div class="col-md-12" style="margin-left: 5px;padding-bottom: 10px;">
					                                <div class="col-md-4 col-md-offset-4">
					                                    <strong>Receiver Address</strong><br>
					                                    <div class="receiver-address">' . @$response['Data']['order_details']['delivery_details']['name'] . ',<br> ' . @$response['Data']['order_details']['delivery_details']['address_line_1'] . ',<br> ' . @$response['Data']['order_details']['delivery_details']['city'] . ' - ' . @$response['Data']['order_details']['delivery_details']['pincode'] . ',<br> ' . @$response['Data']['order_details']['delivery_details']['state'] . '<br> ' . "" . '</div>
					                                </div>
					                            </div>
					                            <div class="col-md-12" id="scan-content-div" style="padding-left:0px;padding-right:0px;border-top: 1px solid #BBB;">
					                            	<div class="table-responsive">
					                            		<table class="table table-striped">
					                            			<thead>
									                            <tr>
									                                <th>Scan Date</th>
									                                <th>Scan</th>
									                                <th>Location</th>
									                                <th>Remark</th>
									                            </tr>
									                        </thead>
		                        							<tbody>';
						$scan_count = count($response['Data']['tracking_details']);
						for ($i = $scan_count - 1; $i >= 0; $i--) {
							$date1 = @$response['Data']['tracking_details'][$i]['created'];
							$date1 = str_replace("T", "", @$date1);
							$date1 = str_replace("Z", "", @$date1);
							$datetime = date("d-m-Y H:i:s", strtotime(@$date1));
							$track_data .= '<tr>
				                                <td>' . @$datetime . '</td>
				                                <td>' . str_replace("New", "Manifested", @$response['Data']['tracking_details'][$i]['status']) . '</td>
				                                <td>' . @$response['Data']['tracking_details'][$i]['location'] . '</td>
				                                <td>' . @$response['Data']['tracking_details'][$i]['remarks'] . '</td>
				                            </tr>';
						}
						$track_data .= '</tbody> </table> </div> </div> </div> </form>';
					}
					$track_data .= '</tbody> </table> </div> </div> </div> </form>';
				} else if ($logistics == 'DTDC') {
					$response = CURLREQUEST::curlTrackRequest("DTDC", "", $this->config->item("DTDC_ORDER_TRACK_ORDER_FIRST_PART") . "" . trim($tracking_number) . "" . $this->config->item("DTDC_ORDER_TRACK_ORDER_LAST_PART"), "", 'GET');
					file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_track_order/' . date("d-m-Y") . '_log.txt', "\n---------------START FETCH TRACKING DATA USING DTDC OF " . $tracking_number . "--------------\n", FILE_APPEND);
					@$xml = simplexml_load_string(@$response['Data']);
					@$json = json_encode(@$xml);
					@$array = json_decode(str_replace("@", "", @$json), TRUE);
					$log_data['tracking_data_by_dtdc'] = @$array;
					file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_track_order/' . date("d-m-Y") . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
					file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_track_order/' . date("d-m-Y") . '_log.txt', "\n---------------END FETCH TRACKING DATA USING DTDC OF " . $tracking_number . "--------------\n\n", FILE_APPEND);
					if (@$response['Error'] != '' && @$array['CONSIGNMENT']['CNHEADER']['CNTRACK'] == 'false') {
						$track_data .= '<div class="panel-heading">
											<h6 class="panel-title">Track order Result</h6>
										</div><form class="steps-async wizard clearfix" id="steps-uid-1"> <div class="col-md-12" style="margin-left:10px;padding-bottom: 10px;"> Unable to fetch tracking data</div> </form>';
					} else {
						$date = date("d-m-Y", strtotime(@$result->create_date));
						$track_data .= '<div class="panel-heading">
											<h6 class="panel-title">Track order Result</h6>
										</div>
										<form class="steps-async wizard clearfix" id="steps-uid-1">
											<div class="steps clearfix" id="track_order_result">
												<div class="col-md-12" style="margin-left: 10px;padding-bottom: 10px;">Order status for (' . $tracking_number . ') is <strong>' . $status . ' </strong>' . "" . '</strong><br> Date: <strong>' . $date . '</strong> ' . ''
							. '</div>
												</div>
												<hr>
												<div class="col-md-12" style="margin-left: 5px;padding-bottom: 10px;">
					                                <div class="col-md-4 col-md-offset-4">
					                                    <strong>Receiver Address</strong><br>
					                                    <div class="receiver-address">' . @$result->customer_name . ',<br> ' . @$address . ',<br> ' . @$result->city . ' - ' . @$result->pincode . ',<br> ' . @$result->state . '<br> ' . "" . '</div>
					                                </div>
					                            </div>
					                            <div class="col-md-12" id="scan-content-div" style="padding-left:0px;padding-right:0px;border-top: 1px solid #BBB;">
					                            	<div class="table-responsive">
					                            		<table class="table table-striped">
					                            			<thead>
									                            <tr>
									                                <th>Scan Date</th>
									                                <th>Scan</th>
									                                <th>Location</th>
									                                <th>Remark</th>
									                            </tr>
									                        </thead>
		                        							<tbody>';
						$scan_count = count($array['CONSIGNMENT']['CNBODY']['CNACTION']);
						for ($i = $scan_count - 1; $i >= 0; $i--) {
							$datetime1 = @$array['CONSIGNMENT']['CNBODY']['CNACTION'][$i]['FIELD'][7]['attributes']['value'];
							$insertion = "-";
							$index = 2;
							$result = substr_replace($datetime1, $insertion, $index, 0);
							$index1 = 5;
							$datetime = substr_replace($result, $insertion, $index1, 0);
							$track_data .= '<tr>
				                                <td>' . @$datetime . '</td>
				                                <td>' . str_replace("Booked", "Manifested", @$array['CONSIGNMENT']['CNBODY']['CNACTION'][$i]['FIELD'][1]['attributes']['value']) . '</td>
				                                <td>' . @$array['CONSIGNMENT']['CNBODY']['CNACTION'][$i]['FIELD'][3]['attributes']['value'] . '</td>
				                                <td>' . @$array['CONSIGNMENT']['CNBODY']['CNACTION'][$i]['FIELD'][9]['attributes']['value'] . '</td>
				                            </tr>';
						}
						$track_data .= '</tbody> </table> </div> </div> </div> </form>';
					}
					$track_data .= '</tbody> </table> </div> </div> </div> </form>';
				} else if ($logistics == 'Xpressbees Lite' || $logistics == 'Xpressbees Express') {
					file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_track_order/' . date("d-m-Y") . '_log.txt', "\n---------------START FETCH TRACKING DATA USING XPRESSBEES OF " . $tracking_number . "--------------\n", FILE_APPEND);
					$body = '{
					  	"XBkey":"' . $this->config->item("XPRESSBEES_ORDER_KEY")  . '",
					  	"AWBNo":"' . $tracking_number . '"
					}';
					$response = CURLREQUEST::curlTrackRequest("", "", $this->config->item("XPRESSBEES_ORDER_TRACK_ORDER"), $body, 'POST');
					$log_data['xpressbees_trackdata_body'] = $body;
					$log_data['tracking_data_by_xpressbees'] = $response;
					file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_track_order/' . date("d-m-Y") . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
					file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_track_order/' . date("d-m-Y") . '_log.txt', "\n---------------END FETCH TRACKING DATA USING XPRESSBEES OF " . $tracking_number . "--------------\n\n", FILE_APPEND);
					if (@$response['Error'] != '') {
						$track_data .= '<div class="panel-heading">
											<h6 class="panel-title">Track order Result</h6>
										</div><form class="steps-async wizard clearfix" id="steps-uid-1"> <div class="col-md-12" style="margin-left:10px;padding-bottom: 10px;"> Unable to fetch tracking data</div> </form>';
					} else if (@$response['Data'][0]['ReturnMessage'] == 'Invalid xbAccessKey' || @$response['Data'][0]['ReturnMessage'] == 'Details not found') {
						$track_data .= '<div class="panel-heading">
											<h6 class="panel-title">Track order Result</h6>
										</div><form class="steps-async wizard clearfix" id="steps-uid-1"> <div class="col-md-12" style="margin-left:10px;padding-bottom: 10px;"> Unable to fetch tracking data</div> </form>';
					} else if (@$response['Data'][0]['ReturnMessage'] === 'Successful' && @$response['Data'][0]['ReturnMessage'] != 'Invalid xbAccessKey') {
						$date = date("d-m-Y", strtotime(@$result->create_date));
						$track_data .= '<div class="panel-heading">
											<h6 class="panel-title">Track order Result</h6>
										</div>
										<form class="steps-async wizard clearfix" id="steps-uid-1">
											<div class="steps clearfix" id="track_order_result">
												<div class="col-md-12" style="margin-left: 10px;padding-bottom: 10px;">Order status for (' . $tracking_number . ') is <strong>' . $status . ' </strong>' . "" . '</strong><br> Date: <strong>' . $date . '</strong> ' . ''
							. '</div>
												</div>
												<hr>
												<div class="col-md-12" style="margin-left: 5px;padding-bottom: 10px;">
					                                <div class="col-md-4 col-md-offset-4">
					                                    <strong>Receiver Address</strong><br>
					                                    <div class="receiver-address">' . @$result->customer_name . ',<br> ' . @$address . ',<br> ' . @$result->city . ' - ' . @$result->pincode . ',<br> ' . @$result->state . '<br> ' . "" . '</div>
					                                </div>
					                            </div>
					                            <div class="col-md-12" id="scan-content-div" style="padding-left:0px;padding-right:0px;border-top: 1px solid #BBB;">
					                            	<div class="table-responsive">
					                            		<table class="table table-striped">
					                            			<thead>
									                            <tr>
									                                <th>Scan Date</th>
									                                <th>Scan</th>
									                                <th>Location</th>
									                                <th>Remark</th>
									                            </tr>
									                        </thead>
		                        							<tbody>';
						$scan_count = count($response['Data'][0]['ShipmentSummary']);
						for ($i = 0; $i < $scan_count; $i++) {
							$datetime = date("d-m-Y", strtotime(@$response['Data'][0]['ShipmentSummary'][$i]['StatusDate']));
							$track_data .= '<tr>
				                                <td>' . @$datetime . '</td>
				                                <td>' . str_replace("Data Received", "Manifested", @$response['Data'][0]['ShipmentSummary'][$i]['Status']) . '</td>
				                                <td>' . @$response['Data'][0]['ShipmentSummary'][$i]['Location'] . '</td>
				                                <td>' . @$response['Data'][0]['ShipmentSummary'][$i]['Comment'] . '</td>
				                            </tr>';
						}
						$track_data .= '</tbody> </table> </div> </div> </div> </form>';
					} else {
						$track_data .= '<div class="panel-heading">
											<h6 class="panel-title">Track order Result</h6>
										</div><form class="steps-async wizard clearfix" id="steps-uid-1"> <div class="col-md-12" style="margin-left: ' . @$response['Data'][0]['ReturnMessage'] . '</div> </form>';
					}
					$track_data .= '</tbody> </table> </div> </div> </div> </form>';
				}
			} else {
				$track_data .= '<div class="panel-heading">
											<h6 class="panel-title">Track order Result</h6>
										</div><form class="steps-async wizard clearfix" id="steps-uid-1"> <div class="col-md-12" style="margin-left: 10px; padding: 10px; display: block;" id="no_order_found">Invalid tracking number</div> </form>';
			}
			$data['track_data'] = $track_data;
			$data['tracking_number'] = $tracking_number;
			file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_track_order/' . date("d-m-Y") . '_log.txt', "\n---------------------------------------------------- END TRACK DATA -------------------------------------------------", FILE_APPEND);
		}
		$this->load->view('template/header');
		if (@$this->input->post('tracking_number') != '') {
			$this->load->view('front/track_order', $data);
		} else {
			$this->load->view('front/track_order', $data);
		}
		$this->load->view('template/footer');
	}

	public function price_get()
	{
		$this->load->helper('get_shiping_price');
		$message = "";
		file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_get_price/' . date("d-m-Y") . '_log.txt', "----------------------------------START HOME PAGE CALCULATION-------------------------------------\n", FILE_APPEND);
		$log_data1['pickup_pincode'] = $pincode = $this->input->post('pickup_pincode');
		$log_data1['receive_pincode'] = $receive_pincode = $this->input->post('receive_pincode');
		$log_data1['physical_weight_in_kg'] = $physical_weight = $this->input->post('physical_weight');
		$phy_weight = $physical_weight * 1;

		$total_shipping_price = get_shiping_price('1', NULL, $pincode, $receive_pincode, '0', '0', $phy_weight, $phy_weight, 0, 0, 18);
		$data['shippingprice'] = $total_shipping_price['data'];

		$flag = count($total_shipping_price['data']);
		foreach ($total_shipping_price['data'] as $val) {
			if ($val['subtotal'] == "Rulse Is Not Proper It's Infinite") {
				$flag--;
			}
		}

		if ($flag == 0) {
			$message = 'Pincode Not Available';
		} else {
			$table = $this->load->view("admin/order/shipping_table", $data, TRUE);
		}

		// dd($table);

		// $is_delhivery = $is_shadowfax = $is_xpressbees = $is_dtdc = $is_delhivery_express = $is_udaan_express = $price = $gst_charge = $total_charge = $dehlivery_price = 0;
		// $message = $table = $shadowfax_error = $dehlivery_error = $shadowfax_table_view = $dehlivery_table_view = $table_header_view = $table_footer_view = $xpressbees_error = $xpressbees_table_view = $dtdc_error = $dtdc_table_view = $dehlivery_express_error = $dehlivery_express_table_view = $udaan_express_error = $udaan_express_table_view = "";
		// $from_pincode = $pincode;

		// $result_delhivery = $this->order_model->getRow(array('pincode' => $pincode, 'pickup' => 1), 'id,pincode,city', "pincode_detail");
		// $result_delhivery_receive = $this->order_model->getRow(array('pincode' => $receive_pincode), 'id,pincode,pre_paid,cod,city', "pincode_detail");
		// $log_data1['result_pickup_pincode_for_delhivery'] = $result_delhivery;
		// $log_data1['result_delivery_pincode_for_delhivery'] = $result_delhivery_receive;

		// $result_delhivery_express = $this->order_model->getRow(array('pincode' => $pincode, 'pickup_availablity' => 1), 'id,pincode,city', "delhivery_express_pincode_detail");
		// $result_delhivery_express_receive = $this->order_model->getRow(array('pincode' => $receive_pincode, 'delivery_availablity' => 1), 'id,pincode,city', "delhivery_express_pincode_detail");
		// $log_data1['result_pickup_pincode_for_delhivery_express'] = $result_delhivery_express;
		// $log_data1['result_delivery_pincode_for_delhivery_express'] = $result_delhivery_express_receive;

		// $result_udaan_express = $this->Common_model->getRow(array('pincode' => $pincode, 'pickup_availablity' => 1), 'id,pincode', "udaan_express_pincode_detail");
		// $result_udaan_express_receive = $this->Common_model->getRow(array('pincode' => $receive_pincode, 'delivery_availablity' => 1), 'id,pincode', "udaan_express_pincode_detail");
		// $log_data['result_pickup_pincode_for_udaan_express'] = $result_udaan_express;
		// $log_data['result_delivery_pincode_for_udaan_express'] = $result_udaan_express_receive;

		// $result_shadowfax = $this->order_model->getRow(array('pincode' => $pincode, 'pickup_availablity' => 1), 'id,pincode,zonemapping,city', "shadowfex_pincode_detail");
		// $result_shadowfax_recieve = $this->order_model->getRow(array('pincode' => $receive_pincode, 'delivery_availablity' => 1), 'id,pincode,zonemapping,city', "shadowfex_pincode_detail");
		// $log_data1['result_pickup_pincode_for_shadowfax'] = $result_shadowfax;
		// $log_data1['result_delivery_pincode_for_shadowfax'] = $result_shadowfax_recieve;

		// $result_xpressbees = $this->order_model->getRow(array('pincode' => $pincode, 'pickup_service' => 1), 'id,pincode,hub_city', "xpressbees_pincode_detail");
		// $result_xpressbees_recieve = $this->order_model->getRow(array('pincode' => $receive_pincode), 'id,pincode,cod,prepaid,hub_city', "xpressbees_pincode_detail");
		// $log_data1['result_pickup_pincode_for_xpressbees'] = $result_xpressbees;
		// $log_data1['result_delivery_pincode_for_xpressbees'] = $result_xpressbees_recieve;
		// /*$result_dtdc = $this->order_model->getRow(array('pickup_pincode'=> $pincode, 'pickup_availablity'=> 1), 'id,pickup_pincode,pickup_state,pickup_city', "dtdc_pincode");
		// 			$result_dtdc_recieve = $this->order_model->getRow(array('pickup_pincode'=> $receive_pincode,'delivery_availablity'=>1), 'id,pickup_pincode,pickup_state,pickup_city', "dtdc_pincode");
		// 	    	$log_data1['result_pickup_pincode_for_dtdc'] = $result_dtdc;
		// */
		// if (!empty($result_udaan_express)) {
		// 	$city = @$result_udaan_express->city;
		// 	$is_udaan_express = 1;
		// }
		// if (!empty($result_shadowfax)) {
		// 	$city = @$result_shadowfax->city;
		// 	$is_shadowfax = 1;
		// }
		// if (!empty($result_xpressbees)) {
		// 	$city = @$result_xpressbees->hub_city;
		// 	$is_xpressbees = 1;
		// }
		// if (!empty($result_delhivery_express)) {
		// 	$city = @$result_delhivery_express->city;
		// 	$is_delhivery_express = 1;
		// }
		// /*if(!empty($result_dtdc)){
		// 	$city = $result_dtdc->pickup_city;
		// 	$is_dtdc = 1;
		// }*/
		// if (!empty($result_delhivery)) {
		// 	$city = @$result_delhivery->city;
		// 	$is_delhivery = 1;
		// }
		// /*if ($is_dtdc == 1 && !empty($result_dtdc_recieve)) {
		// 	$toaddress = $result_dtdc_recieve->pickup_city.", ".$receive_pincode.", India";
		// }*/
		// if ($is_udaan_express == 1 && !empty($result_udaan_express_receive)) {
		// 	$deliver_city = @$result_udaan_express_receive->city;
		// 	$toaddress = @$result_udaan_express_receive->city . ", " . $receive_pincode . ", India";
		// }
		// if ($is_xpressbees == 1 && !empty($result_xpressbees_recieve)) {
		// 	$deliver_city = @$result_xpressbees_recieve->hub_city;
		// 	$toaddress = $result_xpressbees_recieve->hub_city . ", " . $receive_pincode . ", India";
		// }
		// if ($is_shadowfax == 1 && !empty($result_shadowfax_recieve)) {
		// 	$deliver_city = @$result_shadowfax_recieve->city;
		// 	$toaddress = $result_shadowfax_recieve->city . ", " . $receive_pincode . ", India";
		// }
		// if ($is_delhivery_express == 1 && !empty($result_delhivery_express_receive)) {
		// 	$deliver_city = @$result_delhivery_express_receive->city;
		// 	$toaddress = @$result_delhivery_express_receive->city . ", " . $receive_pincode . ", India";
		// }
		// if ($is_delhivery == 1 && !empty($result_delhivery_receive) && (@$result_delhivery_receive->cod == 1 || @$result_delhivery_receive->pre_paid == 1)) {
		// 	$deliver_city = @$result_delhivery_receive->city;
		// 	$toaddress = @$result_delhivery_receive->city . ", " . $receive_pincode . ", India";
		// }
		// file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_get_price/' . date("d-m-Y") . '_log.txt', "\n" . print_r($log_data1, true), FILE_APPEND);
		// $fromaddress = @$city . ", " . $pincode . ", India";
		// $distance_response = $this->getDistance($fromaddress, $toaddress, @$city, @$deliver_city);
		// if (@$distance_response['Error'] != "") {
		// 	$message = $distance_response['Error'];
		// } else {
		// 	$distance = $distance_response['Distance'];
		// 	$table_header_view .= '<table class="table table-xs table-bordered table-price-box" id="rate_table_div" width="100%"><thead><tr><th><strong>Logistic</strong></th><th><strong>Price</strong></th><th><strong>GST(18%)</strong></th><th><strong>Total Price</strong></th></tr></thead><tbody id="table_data">';
		// 	/*if($is_dtdc == 1 && !empty($result_dtdc_recieve)){
		// 					if (strtoupper($result_dtdc->pickup_state) == 'GUJARAT') {
		// 						file_put_contents($this->config->item("FILE_PATH").'/upload/log_error/home_page_get_price/'.date("d-m-Y").'_log.txt', "----------START DETAILS WHEN GET PRICE FROM HOME PAGE FOR DTDC-------------\n" , FILE_APPEND);
		// 						$dtdc_price_response = $this->getDTDCPrice(@$result_dtdc_recieve->pickup_city,$city,$distance,$phy_weight,$receive_pincode,$pincode);
		// 						if (@$dtdc_price_response['Error']!="") {
		// 							$dtdc_error = $dtdc_price_response['Error'];
		// 						}else{
		// 							$dtdc_price = $dtdc_price_response['Price'];
		// 							$dtdc_table_view .='<tr>
		// 		                                  <td>
		// 		                                    <img src="'.base_url().'assets/images/dtdc.png" style="width:100px;">
		// 		                                  </td>
		// 		                                  <td style="text-align:right" id="dtdc_rate" class="shipp_rate">Rs. '.number_format($dtdc_price,2).'</td>
		// 		                                  <td style="text-align:right" id="xpressbees_rate" class="shipp_rate">Rs. '.(($dtdc_price *18)/100).'</td>
		// 		                                  <td style="text-align:right" id="xpressbees_rate" class="shipp_rate">Rs. '.number_format($dtdc_price + (($dtdc_price *18)/100),2).'</td>
		// 		                                </tr>';
		// 		                }
		// 						file_put_contents($this->config->item("FILE_PATH").'/upload/log_error/home_page_get_price/'.date("d-m-Y").'_log.txt', "----------END DETAILS WHEN GET PRICE FROM HOME PAGE FOR DTDC-------------\n" , FILE_APPEND);
		// 					}
		// 	*/
		// 	if ($is_xpressbees == 1 && !empty($result_xpressbees_recieve)) {
		// 		file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_get_price/' . date("d-m-Y") . '_log.txt', "----------START DISTANCE DETAILS WHEN GET PRICE FROM HOME PAGE FOR XPRESSBEES-------------\n", FILE_APPEND);
		// 		$xpressbees_price_response = $this->getXpressbeeslitePrice(@$result_xpressbees_recieve->hub_city, $city, $distance, $phy_weight, $receive_pincode, $pincode);
		// 		if (@$xpressbees_price_response['Error'] != "") {
		// 			$xpressbees_error = $xpressbees_price_response['Error'];
		// 		} else {
		// 			$xpressbees_price = $xpressbees_price_response['Price'];
		// 			$xpressbees_table_view .= '<tr>
		//                               <td>
		//                                 <img src="' . base_url() . 'assets/images/xpressbees.png" style="width:100px;">(LITE)
		//                               </td>
		//                               <td style="text-align:right" id="xpressbees_rate" class="shipp_rate">Rs. ' . number_format($xpressbees_price, 2) . '</td>
		//                               <td style="text-align:right" id="xpressbees_rate" class="shipp_rate">Rs. ' . (($xpressbees_price * 18) / 100) . '</td>
		//                               <td style="text-align:right" id="xpressbees_rate" class="shipp_rate">Rs. ' . number_format($xpressbees_price + (($xpressbees_price * 18) / 100), 2) . '</td>
		//                             </tr>';
		// 		}
		// 		$xpressbees_express_price_response = $this->getXpressbeesExpressPrice(@$result_xpressbees_recieve->hub_city, $city, $distance, $phy_weight, $receive_pincode, $pincode);
		// 		if (@$xpressbees_express_price_response['Error'] != "") {
		// 			$xpressbees_error = $xpressbees_express_price_response['Error'];
		// 		} else {
		// 			$xpressbees_express_price = $xpressbees_express_price_response['Price'];
		// 			$xpressbees_table_view .= '<tr>
		//                               <td>
		//                                 <img src="' . base_url() . 'assets/images/xpressbees.png" style="width:100px;">(EXPRESS)
		//                               </td>
		//                               <td style="text-align:right" id="xpressbees_rate" class="shipp_rate">Rs. ' . number_format($xpressbees_express_price, 2) . '</td>
		//                               <td style="text-align:right" id="xpressbees_rate" class="shipp_rate">Rs. ' . (($xpressbees_express_price * 18) / 100) . '</td>
		//                               <td style="text-align:right" id="xpressbees_rate" class="shipp_rate">Rs. ' . number_format($xpressbees_express_price + (($xpressbees_express_price * 18) / 100), 2) . '</td>
		//                             </tr>';
		// 		}
		// 		file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_get_price/' . date("d-m-Y") . '_log.txt', "----------END DISTANCE DETAILS WHEN GET PRICE FROM HOME PAGE FOR XPRESSBEES-------------\n", FILE_APPEND);
		// 	} else {
		// 		$xpressbees_error = "Pincode Not Available";
		// 	}
		// 	if ($is_shadowfax == 1 && !empty($result_shadowfax_recieve)) {
		// 		file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_get_price/' . date("d-m-Y") . '_log.txt', "----------START DISTANCE DETAILS WHEN GET PRICE FROM HOME PAGE FOR SHADOWFAX-------------\n", FILE_APPEND);
		// 		$shadowfax_price_response = $this->getShadowfaxPrice(@$result_shadowfax_recieve->city, $city, $distance, $phy_weight, $receive_pincode, $pincode);
		// 		if (@$shadowfax_price_response['Error'] != "") {
		// 			$shadowfax_error = $shadowfax_price_response['Error'];
		// 		} else {
		// 			$shadowfax_price = $shadowfax_price_response['Price'];
		// 			$shadowfax_table_view .= '<tr>
		//                               <td>
		//                                 <img src="' . base_url() . 'assets/images/shadowfax.png" style="width:100px;">
		//                               </td>
		//                               <td style="text-align:right" id="shadowfax_rate" class="shipp_rate">Rs. ' . number_format($shadowfax_price, 2) . '</td>
		//                               <td style="text-align:right" id="xpressbees_rate" class="shipp_rate">Rs. ' . (($shadowfax_price * 18) / 100) . '</td>
		//                               <td style="text-align:right" id="xpressbees_rate" class="shipp_rate">Rs. ' . number_format($shadowfax_price + (($shadowfax_price * 18) / 100), 2) . '</td>
		//                             </tr>';
		// 		}
		// 		file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_get_price/' . date("d-m-Y") . '_log.txt', "----------END DISTANCE DETAILS WHEN GET PRICE FROM HOME PAGE FOR SHADOWFAX-------------\n", FILE_APPEND);
		// 	} else {
		// 		$shadowfax_error = "Pincode Not Available";
		// 	}
		// 	if ($is_delhivery == 1 && !empty($result_delhivery_receive) && (@$result_delhivery_receive->cod == 1 || @$result_delhivery_receive->pre_paid == 1)) {
		// 		file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_get_price/' . date("d-m-Y") . '_log.txt', "----------START DISTANCE DETAILS WHEN GET PRICE FROM HOME PAGE FOR DELHIVERY-------------\n", FILE_APPEND);
		// 		if ($result_delhivery_receive->pre_paid == 1 || $result_delhivery_receive->cod == 1) {
		// 			$dehlivery_price_response = $this->getDehliveryPrice($result_delhivery_receive->city, $city, $distance, $phy_weight);
		// 			if (@$dehlivery_price_response['Error'] != "") {
		// 				$dehlivery_error = $dehlivery_price_response['Error'];
		// 			} else {
		// 				$dehlivery_price = $dehlivery_price_response['Price'];
		// 				$dehlivery_table_view .= '<tr>
		//                               <td>
		//                                 <img src="' . base_url() . 'assets/images/delhivery.png?v=1" style="width:100px;">
		//                               </td>
		//                               <td style="text-align:right" id="delhivery_rate" class="shipp_rate">Rs. ' . number_format($dehlivery_price, 2) . '</td>
		//                               <td style="text-align:right" id="xpressbees_rate" class="shipp_rate">Rs. ' . (($dehlivery_price * 18) / 100) . '</td>
		//                               <td style="text-align:right" id="xpressbees_rate" class="shipp_rate">Rs. ' . number_format($dehlivery_price + (($dehlivery_price * 18) / 100), 2) . '</td>
		//                             </tr>';
		// 			}
		// 		} else {
		// 			$dehlivery_error = "Delhivery Not Available";
		// 		}
		// 		// }
		// 		file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_get_price/' . date("d-m-Y") . '_log.txt', "----------END DISTANCE DETAILS WHEN GET PRICE FROM HOME PAGE FOR DELHIVERY-------------\n", FILE_APPEND);
		// 	} else {
		// 		$dehlivery_error = "Pincode Not Available";
		// 	}
		// 	if ($is_delhivery_express == 1 && !empty($result_delhivery_express_receive)) {
		// 		file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_get_price/' . date("d-m-Y") . '_log.txt', "--------------------START DISTANCE DETAILS WHEN GET PRICE FROM HOME PAGE FOR DELHIVERY EXPRESS-----------------------\n", FILE_APPEND);
		// 		$dehlivery_express_price_response = $this->getDehliveryExpressPrice($result_delhivery_express_receive->city, $city, $distance, $phy_weight);
		// 		if (@$dehlivery_express_price_response['Error'] != "") {
		// 			$dehlivery_express_error = $dehlivery_express_price_response['Error'];
		// 		} else {
		// 			$dehlivery_express_price = $dehlivery_express_price_response['Price'];
		// 			$dehlivery_express_table_view .= '<tr>
		//                           <td>
		//                             <img src="' . base_url() . 'assets/images/delhivery.png?v=1" style="width:100px;"> (EXPRESS)
		//                           </td>
		//                           <td style="text-align:right" id="delhivery_rate" class="shipp_rate">Rs. ' . number_format($dehlivery_express_price, 2) . '</td>
		//                           <td style="text-align:right" id="xpressbees_rate" class="shipp_rate">Rs. ' . (($dehlivery_express_price * 18) / 100) . '</td>
		//                           <td style="text-align:right" id="xpressbees_rate" class="shipp_rate">Rs. ' . number_format($dehlivery_express_price + (($dehlivery_express_price * 18) / 100), 2) . '</td>
		//                         </tr>';
		// 		}
		// 		file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_get_price/' . date("d-m-Y") . '_log.txt', "----------------------END DISTANCE DETAILS WHEN GET PRICE FROM HOME PAGE FOR DELHIVERY EXPRESS-------------------------\n", FILE_APPEND);
		// 	} else {
		// 		$dehlivery_express_error = "Pincode Not Available";
		// 	}
		// 	if ($is_udaan_express == 1 && !empty($result_udaan_express_receive)) {
		// 		file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_get_price/' . date("d-m-Y") . '_log.txt', "--------------------START DISTANCE DETAILS WHEN GET PRICE FROM HOME PAGE FOR UDAAN EXPRESS-----------------------\n", FILE_APPEND);
		// 		$udaan_express_price_response = $this->getUdaanExpressPrice($receive_pincode, $pincode, $distance, $phy_weight);
		// 		if (@$udaan_express_price_response['Error'] != "") {
		// 			$udaan_express_error = $udaan_express_price_response['Error'];
		// 		} else {
		// 			$udaan_express_price = $udaan_express_price_response['Price'];
		// 			$udaan_express_table_view .= '<tr>
		//                           <td>
		//                             <img src="' . base_url() . 'assets/images/udaanexpress.png?v=1" style="width:100px;">
		//                           </td>
		//                           <td style="text-align:right" id="udaan_rate" class="shipp_rate">Rs. ' . number_format($udaan_express_price, 2) . '</td>
		//                           <td style="text-align:right" id="xpressbees_rate" class="shipp_rate">Rs. ' . (($udaan_express_price * 18) / 100) . '</td>
		//                           <td style="text-align:right" id="xpressbees_rate" class="shipp_rate">Rs. ' . number_format($udaan_express_price + (($udaan_express_price * 18) / 100), 2) . '</td>
		//                         </tr>';
		// 		}
		// 		file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_get_price/' . date("d-m-Y") . '_log.txt', "----------------------END DISTANCE DETAILS WHEN GET PRICE FROM HOME PAGE FOR udaan EXPRESS-------------------------\n", FILE_APPEND);
		// 	} else {
		// 		$udaan_express_error = "Pincode Not Available";
		// 	}
		// 	$table_footer_view .= '</table>';
		// 	if (($dehlivery_error == "" && $shadowfax_error == "" && $xpressbees_error == "" && /*$dtdc_error=="" && */ $dehlivery_express_error == "" && $udaan_express_error == "") || ($dehlivery_error == "" || $shadowfax_error == "" || $xpressbees_error == "" || /*$dtdc_error=="" ||*/ $dehlivery_express_error == "" || $udaan_express_error == "")) {
		// 		$table = $table_header_view . "" . $dtdc_table_view . "" . $xpressbees_table_view . "" . $shadowfax_table_view . "" . $dehlivery_table_view . "" . $dehlivery_express_table_view . "" . $udaan_express_table_view . "" . $table_footer_view;
		// 	} else if ($dehlivery_error != "" && $shadowfax_error != "" && $xpressbees_error != "" && /*$dtdc_error!="" &&*/ $dehlivery_express_error != "" && $udaan_express_error != "") {
		// 		$message = "Pincode Not Available";
		// 	}
		// }
		file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_get_price/' . date("d-m-Y") . '_log.txt', "----------------------------------END HOME PAGE CALCULATION-------------------------------------\n\n", FILE_APPEND);
		$response = array('result' => $table, 'error' => $message);
		echo json_encode($response);
		exit();
	}

	function getDistance($fromaddress, $toaddress, $pickup_city, $deliver_city)
	{
		$distance_data_response = $this->getDistancefromDatabase($pickup_city, $deliver_city);
		$log_data1['distance_api_response_from_database'] = $distance_data_response;
		if (@$distance_data_response['error'] == 'Error') {
			$formadd = $fromaddress;
			$toadd = $toaddress;
			$log_data['distance_api_access_user'] = $this->userId;
			$log_data['distance_api_fromaddress'] = $fromaddress;
			$log_data['distance_api_toaddress'] = $toaddress;
			$fromaddress = urlencode($fromaddress);
			$toaddress = urlencode($toaddress);
			$data = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=$fromaddress&destinations=$toaddress&key=" . $this->config->item("DISTANCE_API"));
			$data = json_decode($data);
			$log_data['distance_api_response'] = $data;
			file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_get_price/' . date("d-m-Y") . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
			$time = 0;
			$distance = 0;
			if (!empty($data)) {
				if ($data->rows[0]->elements[0]->status != 'ZERO_RESULTS') {
					foreach ($data->rows[0]->elements as $road) {
						$time = $road->duration->value;
						$distance = $road->distance->value;
					}
					$get_pickup_city_info = $this->Common_model->getRowArray(array('city_name' => ucwords($pickup_city)), 'city_id', 'city_master');
					$get_deliver_city_info = $this->Common_model->getRowArray(array('city_name' => ucwords($deliver_city)), 'city_id', 'city_master');
					$distance_insert_data['pickup_city_id'] = $get_pickup_city_info['city_id'];
					$distance_insert_data['deliver_city_id'] = $get_deliver_city_info['city_id'];
					$distance_insert_data['distance'] = $distance / 1000;
					$this->Common_model->insert($distance_insert_data, 'distance_master');
					$distance_insert_data_reverse['pickup_city_id'] = $get_deliver_city_info['city_id'];
					$distance_insert_data_reverse['deliver_city_id'] = $get_pickup_city_info['city_id'];
					$distance_insert_data_reverse['distance'] = $distance / 1000;
					$this->Common_model->insert($distance_insert_data_reverse, 'distance_master');
					// $res['Distance'] = $distance / 1000;
					$result_distance = $distance / 1000;
					if ($result_distance == 0) {
						$res['Error'] = 'Distance Not Found.';
					} else {
						$res['Distance'] = $distance / 1000;
					}
				} else {
					$res['Error'] = 'Distance Not Found.';
				}
			} else {
				$res['Error'] = 'Distance Not Found.';
			}
			// return @$res;
		} else {
			// $res['Distance'] = $distance_data_response['distance'];
			if ($distance_data_response['distance'] != 0) {
				$res['Distance'] = $distance_data_response['distance'];
			} else {
				$res['Error'] = 'Distance Not Found.';
			}
		}
		$log_data1['distance_function_response_res'] = $res;
		file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_get_price/' . date("d-m-Y") . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		return $res;
	}
	function getDistancefromDatabase($pickup_city, $deliver_city)
	{
		if ($pickup_city != "" && $deliver_city != "") {
			$get_pickup_city_info = $this->Common_model->getRowArray(array('city_name' => ucwords(strtolower($pickup_city))), 'city_id', 'city_master');
			$get_deliver_city_info = $this->Common_model->getRowArray(array('city_name' => ucwords(strtolower($deliver_city))), 'city_id', 'city_master');
			$log_data['get_pickup_city_name'] = ucwords(strtolower($pickup_city));
			$log_data['get_pickup_city_info'] = $get_pickup_city_info;
			$log_data['get_deliver_city_name'] = ucwords(strtolower($deliver_city));
			$log_data['get_deliver_city_info'] = $get_deliver_city_info;
			if (!empty($get_pickup_city_info) && !empty($get_deliver_city_info)) {
				$get_distance_info = $this->Common_model->getRowArray(array('pickup_city_id' => $get_pickup_city_info['city_id'], 'deliver_city_id' => $get_deliver_city_info['city_id']), 'distance', 'distance_master');
				$log_data['get_distance_info'] = $get_distance_info;
				if (!empty($get_distance_info)) {
					$res['distance'] = $get_distance_info['distance'];
				} else {
					$res['error'] = 'Error';
				}
			} else {
				if (empty($get_pickup_city_info)) {
					$city_insert_data['city_name'] = ucwords(strtolower(trim($pickup_city)));
					$this->Common_model->insert($city_insert_data, 'city_master');
				}
				if (empty($get_deliver_city_info)) {
					$city_insert_data['city_name'] = ucwords(strtolower(trim($deliver_city)));
					$this->Common_model->insert($city_insert_data, 'city_master');
				}
				$res['error'] = 'Error';
			}
		} else {
			$res['error'] = 'Error';
		}
		$log_data['final_response_from_database_distance'] = $res;
		file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_get_price/' . date("d-m-Y") . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		return $res;
	}
	function getDehliveryPrice($city, $fromcity, $distance, $phy_weight)
	{
		$price = 0;
		$type_of_shipment = '0';
		$to_mertocity = $this->order_model->getRow(array('metrocity_name' => $city), '*', 'metrocity_list');
		$from_mertocity = $this->order_model->getRow(array('metrocity_name' => $fromcity), '*', 'metrocity_list');
		$log_data['delhivery_check_metrocity_availablity_for_deliver_city'] = $to_mertocity;
		$log_data['delhivery_check_metrocity_availablity_for_pickup_city'] = $from_mertocity;
		if (strtolower($fromcity) == strtolower($city)) {
			$zone = "within_city";
		} else {
			if ('500' >= $distance) {
				$zone = "within_zone";
			} else if ('2500' <= $distance) {
				$zone = "special_zone";
			} else {
				if (!empty($from_mertocity) && !empty($to_mertocity) && '500' <= $distance && '2500' >= $distance) {
					if ('500' <= $distance && '1400' >= $distance) {
						$zone = "metro";
					} else if ('1400' <= $distance && '2500' >= $distance) {
						$zone = "metro_2";
					}
				} else {
					if ('500' <= $distance && '1400' >= $distance) {
						$zone = "rest_of_india";
					} else if ('1400' <= $distance && '2500' >= $distance) {
						$zone = "rest_of_india_2";
					}
				}
			}
		}
		$log_data['delhivery_distance'] = $distance;
		$log_data['delhivery_zone'] = $zone;
		$log_data['delhivery_weight'] = $phy_weight;
		$single_logistic_info = $this->order_model->getRow(array('logistic' => 'Delhivery'), '*', 'logistic');
		$log_data['delhivery_logistic_detail'] = $single_logistic_info;
		if ($zone != '') {
			if ($phy_weight > 500) {
				$result_first_500gram = $this->Common_model->getRow(array('shipment_type' => $type_of_shipment, 'logistic_id' => $single_logistic_info->id, 'rule_id' => 1), $zone, 'manage_price_new');
				$price += $result_first_500gram->$zone;
				$log_data['delhivery_price_for_first_500_if_morethan_500'] = $result_first_500gram->$zone;
				if ($phy_weight > 3000) {
					$temp1 = ceil(2500 / 500);
					$result_additional_500gm = $this->Common_model->getRow(array('shipment_type' => $type_of_shipment, 'logistic_id' => $single_logistic_info->id, 'rule_id' => 6), $zone, 'manage_price_new');
					$price += $temp1 * $result_additional_500gm->$zone;
					$log_data['delhivery_price_for_every_500gram_upto_3kg_if_morethan_3kg'] = $result_additional_500gm->$zone;
					$temp = $phy_weight - 3000;
					$temp1 = ceil($temp / 1000);
					$result_additional_1kg = $this->Common_model->getRow(array('shipment_type' => $type_of_shipment, 'logistic_id' => $single_logistic_info->id, 'rule_id' => 7), $zone, 'manage_price_new');
					$price += $temp1 * $result_additional_1kg->$zone;
					$log_data['delhivery_price_for_every_1kg_if_morethan_3kg'] = $result_additional_1kg->$zone;
				} else {
					$temp = $phy_weight - 500;
					$temp1 = ceil($temp / 500);
					$result_additional_500gm = $this->Common_model->getRow(array('shipment_type' => $type_of_shipment, 'logistic_id' => $single_logistic_info->id, 'rule_id' => 6), $zone, 'manage_price_new');
					$price += $temp1 * $result_additional_500gm->$zone;
					$log_data['delhivery_price_for_every_500gram_if_upto_3kg'] = $result_additional_500gm->$zone;
				}
			} else {
				$result_500gram = $this->Common_model->getRow(array('shipment_type' => $type_of_shipment, 'logistic_id' => $single_logistic_info->id, 'rule_id' => 1), $zone, 'manage_price_new');
				$price += $result_500gram->$zone;
				$log_data['delhivery_price_for_first_500gram_if_upto_500gram'] = $result_500gram->$zone;
			}
		} else {
			$res['Error'] = 'error';
		}
		$res['Price'] = $price;
		$log_data['delhivery_total_price'] = $price;
		file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_get_price/' . date("d-m-Y") . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		return $res;
	}
	function getDehliveryExpressPrice($city, $fromcity, $distance, $phy_weight)
	{
		$price = 0;
		$type_of_shipment = '0';
		$to_mertocity = $this->order_model->getRow(array('metrocity_name' => $city), '*', 'metrocity_list');
		$from_mertocity = $this->order_model->getRow(array('metrocity_name' => $fromcity), '*', 'metrocity_list');
		$log_data['delhivery_express_check_metrocity_availablity_for_deliver_city'] = $to_mertocity;
		$log_data['delhivery_express_check_metrocity_availablity_for_pickup_city'] = $from_mertocity;
		if (strtolower($fromcity) == strtolower($city)) {
			$zone = "within_city";
		} else {
			if ('500' >= $distance) {
				$zone = "within_zone";
			} else if ('2500' <= $distance) {
				$zone = "special_zone";
			} else {
				if (!empty($from_mertocity) && !empty($to_mertocity) && '500' <= $distance && '2500' >= $distance) {
					if ('500' <= $distance && '1400' >= $distance) {
						$zone = "metro";
					} else if ('1400' <= $distance && '2500' >= $distance) {
						$zone = "metro_2";
					}
				} else {
					if ('500' <= $distance && '1400' >= $distance) {
						$zone = "rest_of_india";
					} else if ('1400' <= $distance && '2500' >= $distance) {
						$zone = "rest_of_india_2";
					}
				}
			}
		}
		$log_data['delhivery_express_distance'] = $distance;
		$log_data['delhivery_express_zone'] = $zone;
		$log_data['delhivery_express_weight'] = $phy_weight;
		$single_logistic_info = $this->order_model->getRow(array('logistic' => 'Delhivery Express'), '*', 'logistic');
		$log_data['delhivery_express_logistic_detail'] = $single_logistic_info;
		if ($zone != '') {
			if ($phy_weight > 5000) {
				$result_first_5kg = $this->Common_model->getRow(array('shipment_type' => $type_of_shipment, 'logistic_id' => $single_logistic_info->id, 'rule_id' => 10), $zone, 'manage_price_new');
				$price += $result_first_5kg->$zone;
				$log_data['delhivery_express_price_for_first_500_if_morethan_500'] = $result_first_5kg->$zone;
				if ($phy_weight > 10000) {
					$temp1 = ceil(5000 / 5000);
					$result_additional_5kg = $this->Common_model->getRow(array('shipment_type' => $type_of_shipment, 'logistic_id' => $single_logistic_info->id, 'rule_id' => 11), $zone, 'manage_price_new');
					$price += $temp1 * $result_additional_5kg->$zone;
					$log_data['delhivery_express_price_for_every_5kg_upto_10kg_if_morethan_10kg'] = $result_additional_5kg->$zone;
					$temp = $phy_weight - 10000;
					$temp1 = ceil($temp / 1000);
					$result_additional_1kg = $this->Common_model->getRow(array('shipment_type' => $type_of_shipment, 'logistic_id' => $single_logistic_info->id, 'rule_id' => 12), $zone, 'manage_price_new');
					$price += $temp1 * $result_additional_1kg->$zone;
					$log_data['delhivery_express_price_for_every_5kg_if_morethan_10kg'] = $result_additional_1kg->$zone;
				} else {
					$temp = $phy_weight - 5000;
					$temp1 = ceil($temp / 5000);
					$result_additional_5kg = $this->Common_model->getRow(array('shipment_type' => $type_of_shipment, 'logistic_id' => $single_logistic_info->id, 'rule_id' => 11), $zone, 'manage_price_new');
					$price += $temp1 * $result_additional_5kg->$zone;
					$log_data['delhivery_express_price_for_every_5kg_if_upto_10kg'] = $result_additional_5kg->$zone;
				}
			} else {
				$result_5kg = $this->Common_model->getRow(array('shipment_type' => $type_of_shipment, 'logistic_id' => $single_logistic_info->id, 'rule_id' => 10), $zone, 'manage_price_new');
				$price += $result_5kg->$zone;
				$log_data['delhivery_express_price_for_first_5kg_if_upto_5kg'] = $result_5kg->$zone;
			}
		} else {
			$res['Error'] = 'error';
		}
		$res['Price'] = $price;
		$log_data['delhivery_express_total_price'] = $price;
		file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_get_price/' . date("d-m-Y") . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		return $res;
	}
	function getShadowfaxPrice($city, $fromcity, $distance, $phy_weight, $pincode, $from_pincode)
	{
		$price = 0;
		$type_of_shipment = '0';
		if (strtolower($fromcity) == strtolower($city)) {
			$zone1 = 'within city';
		} else {
			if ($distance < 500) {
				$result_shadowfax = $this->Common_model->getRow(array('pincode' => $from_pincode), 'zonemapping', "shadowfex_pincode_detail");
			} else {
				$result_shadowfax = $this->Common_model->getRow(array('pincode' => $pincode), 'zonemapping', "shadowfex_pincode_detail");
			}
			$log_data['shadowfax_data_result'] = $result_shadowfax;
			$zone1 = $result_shadowfax->zonemapping;
		}
		$zone = str_replace(array('within city', 'within zone', 'metro', 'roi', 'special zone'), array('within_city', 'within_zone', 'metro', 'rest_of_india', 'special_zone'), strtolower($zone1));
		$log_data['shadowfax_distance'] = $distance;
		$log_data['shadowfax_zone'] = $zone;
		$log_data['shadowfax_weight'] = $phy_weight;
		$single_logistic_info = $this->order_model->getRow(array('logistic' => 'Shadowfax'), '*', 'logistic');
		if ($zone != '') {
			if ($phy_weight > 500) {
				$resultdata1 = $this->Common_model->getRow(array('shipment_type' => $type_of_shipment, 'logistic_id' => $single_logistic_info->id, 'rule_id' => 1), $zone, 'manage_price_new');
				$price += $resultdata1->$zone;
				$log_data['shadowfax_price_for_first_500'] = $resultdata1->$zone;
				$temp = $phy_weight - 500;
				$temp1 = ceil($temp / 500);
				$resultdata3 = $this->Common_model->getRow(array('shipment_type' => $type_of_shipment, 'logistic_id' => $single_logistic_info->id, 'rule_id' => 2), $zone, 'manage_price_new');
				$price += $temp1 * $resultdata3->$zone;
				$log_data['shadowfax_price_for_weight'] = $resultdata3->$zone;
			} else {
				$resultdata4 = $this->Common_model->getRow(array('shipment_type' => $type_of_shipment, 'logistic_id' => $single_logistic_info->id, 'rule_id' => 1), $zone, 'manage_price_new');
				$price += $resultdata4->$zone;
				$log_data['shadowfax_price_for_first_500'] = $resultdata4->$zone;
			}
		} else {
			$res['Error'] = 'error';
		}
		$log_data['shadowfax_total_price'] = $price;
		$res['Price'] = $price;
		file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_get_price/' . date("d-m-Y") . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		return $res;
	}
	function getXpressbeeslitePrice($city, $fromcity, $distance, $phy_weight, $pincode, $from_pincode)
	{
		$price = 0;
		$type_of_shipment = '0';
		$deliver_zone_type = $this->order_model->getRow(array('pincode' => $pincode), 'id,pincode,hub_zone_name,hub_state,area_code', 'xpressbees_pincode_detail');
		$pickup_zone_type = $this->order_model->getRow(array('pincode' => $from_pincode), 'id,pincode,hub_zone_name,hub_state,area_code', 'xpressbees_pincode_detail');
		$log_data['xpressbees_lite_fetch_deliver_zone_type'] = $deliver_zone_type;
		$log_data['xpressbees_lite_fetch_pickup_zone_type'] = $pickup_zone_type;
		if ($deliver_zone_type->hub_zone_name == "North East" || $pickup_zone_type->hub_zone_name == "North East" || $deliver_zone_type->hub_state == 'KERALA' || $deliver_zone_type->hub_state == 'JAMMU AND KASHMIR' || $pickup_zone_type->hub_state == 'KERALA' || $pickup_zone_type->hub_state == 'JAMMU AND KASHMIR') {
			// $zone = "J&K / North East / Kerala";
			$zone = "special_zone";
		} else if (strtolower($fromcity) == strtolower($city)) {
			// $zone = 'Within City';
			$zone = 'within_city';
		} else if ($deliver_zone_type->hub_zone_name == $pickup_zone_type->hub_zone_name) {
			// $zone = 'Within Zone';
			$zone = 'within_zone';
		} else if (strrpos($deliver_zone_type->area_code, 'BOM/') !== false || strrpos($deliver_zone_type->area_code, 'DEL/') !== false || strrpos($deliver_zone_type->area_code, 'HYD/') !== false || strrpos($deliver_zone_type->area_code, 'BLR/') !== false || strrpos($deliver_zone_type->area_code, 'MAA/') !== false || strrpos($deliver_zone_type->area_code, 'CCU/') !== false || strrpos($pickup_zone_type->area_code, 'BOM/') !== false || strrpos($pickup_zone_type->area_code, 'DEL/') !== false || strrpos($pickup_zone_type->area_code, 'HYD/') !== false || strrpos($pickup_zone_type->area_code, 'BLR/') !== false || strrpos($pickup_zone_type->area_code, 'MAA/') !== false || strrpos($pickup_zone_type->area_code, 'CCU/') !== false) {
			// $zone = 'Metros';
			$zone = 'metro';
		} else {
			// $zone = 'Rest of India';
			$zone = 'rest_of_india';
		}
		$log_data['xpressbees_lite_distance'] = $distance;
		$log_data['xpressbees_lite_zone'] = $zone;
		$log_data['xpressbees_lite_weight'] = $phy_weight;
		$single_logistic_info = $this->order_model->getRow(array('logistic' => 'Xpressbees lite'), '*', 'logistic');
		if ($zone != '') {
			if ($phy_weight <= 500) {
				$result_500gm = $this->Common_model->getRow(array('shipment_type' => $type_of_shipment, 'logistic_id' => $single_logistic_info->id, 'rule_id' => 1), $zone, 'manage_price_new');
				$price += $result_500gm->$zone;
				$log_data['xpressbees_lite_price_for_first_500'] = $result_500gm->$zone;
			} else {
				$result_500gm = $this->Common_model->getRow(array('shipment_type' => $type_of_shipment, 'logistic_id' => $single_logistic_info->id, 'rule_id' => 1), $zone, 'manage_price_new');
				$price += $result_500gm->$zone;
				$log_data['xpressbees_lite_price_for_first_500'] = $result_500gm->$zone;
				$temp = $phy_weight - 500;
				$temp1 = ceil($temp / 500);
				$additional_500gm = $this->Common_model->getRow(array('shipment_type' => $type_of_shipment, 'logistic_id' => $single_logistic_info->id, 'rule_id' => 2), $zone, 'manage_price_new');
				$price += $temp1 * $additional_500gm->$zone;
				$log_data['xpressbees_lite_price_for_additional_500gm'] = $additional_500gm->$zone;
			}
		} else {
			$res['Error'] = 'error';
		}
		$log_data['xpressbees_lite_total_price'] = $price;
		$res['Price'] = $price;
		file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_get_price/' . date("d-m-Y") . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		return $res;
	}
	function getXpressbeesExpressPrice($city, $fromcity, $distance, $phy_weight, $pincode, $from_pincode)
	{
		$price = 0;
		$type_of_shipment = '0';
		$deliver_zone_type = $this->order_model->getRow(array('pincode' => $pincode), 'id,pincode,hub_zone_name,hub_state,area_code', 'xpressbees_pincode_detail');
		$pickup_zone_type = $this->order_model->getRow(array('pincode' => $from_pincode), 'id,pincode,hub_zone_name,hub_state,area_code', 'xpressbees_pincode_detail');
		$log_data['xpressbees_express_fetch_deliver_zone_type'] = $deliver_zone_type;
		$log_data['xpressbees_express_fetch_pickup_zone_type'] = $pickup_zone_type;
		if ($deliver_zone_type->hub_zone_name == "North East" || $pickup_zone_type->hub_zone_name == "North East" || $deliver_zone_type->hub_state == 'KERALA' || $deliver_zone_type->hub_state == 'JAMMU AND KASHMIR' || $pickup_zone_type->hub_state == 'KERALA' || $pickup_zone_type->hub_state == 'JAMMU AND KASHMIR') {
			// $zone = "J&K / North East / Kerala";
			$zone = "special_zone";
		} else if (strtolower($fromcity) == strtolower($city)) {
			// $zone = 'Within City';
			$zone = 'within_city';
		} else if ($deliver_zone_type->hub_zone_name == $pickup_zone_type->hub_zone_name) {
			// $zone = 'Within Zone';
			$zone = 'within_zone';
		} else if (strrpos($deliver_zone_type->area_code, 'BOM/') !== false || strrpos($deliver_zone_type->area_code, 'DEL/') !== false || strrpos($deliver_zone_type->area_code, 'HYD/') !== false || strrpos($deliver_zone_type->area_code, 'BLR/') !== false || strrpos($deliver_zone_type->area_code, 'MAA/') !== false || strrpos($deliver_zone_type->area_code, 'CCU/') !== false || strrpos($pickup_zone_type->area_code, 'BOM/') !== false || strrpos($pickup_zone_type->area_code, 'DEL/') !== false || strrpos($pickup_zone_type->area_code, 'HYD/') !== false || strrpos($pickup_zone_type->area_code, 'BLR/') !== false || strrpos($pickup_zone_type->area_code, 'MAA/') !== false || strrpos($pickup_zone_type->area_code, 'CCU/') !== false) {
			// $zone = 'Metros';
			$zone = 'metro';
		} else {
			// $zone = 'Rest of India';
			$zone = 'rest_of_india';
		}
		$log_data['xpressbees_express_distance'] = $distance;
		$log_data['xpressbees_express_zone'] = $zone;
		$log_data['xpressbees_express_weight'] = $phy_weight;
		$single_logistic_info = $this->order_model->getRow(array('logistic' => 'Xpressbees express'), '*', 'logistic');

		if ($zone != '') {
			if ($phy_weight <= 1000) {
				$result_1kg = $this->Common_model->getRow(array('logistic_id' => $single_logistic_info->id, 'shipment_type' => $type_of_shipment, 'rule_id' => 3), $zone, 'manage_price_new');
				$price += $result_1kg->$zone;
				$log_data['xpressbees_lite_price_for_first_1kg'] = $result_1kg->$zone;
			} else {
				$result_1kg = $this->Common_model->getRow(array('logistic_id' => $single_logistic_info->id, 'shipment_type' => $type_of_shipment, 'rule_id' => 3), $zone, 'manage_price_new');
				$price += $result_1kg->$zone;
				$log_data['xpressbees_lite_price_for_first_1kg'] = $result_1kg->$zone;
				$temp = $phy_weight - 1000;
				$temp1 = ceil($temp / 1000);
				$additional_1kg = $this->Common_model->getRow(array('logistic_id' => $single_logistic_info->id, 'shipment_type' => $type_of_shipment, 'rule_id' => 4), $zone, 'manage_price_new');
				$price += $temp1 * $additional_1kg->$zone;
				$log_data['xpressbees_lite_price_for_additional_1kg'] = $additional_1kg->$zone;
			}
		} else {
			$res['Error'] = 'error';
		}
		$log_data['xpressbees_express_total_price'] = $price;
		$res['Price'] = $price;
		file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_get_price/' . date("d-m-Y") . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		return $res;
	}
	function getDTDCPrice($city, $fromcity, $distance, $phy_weight, $pincode, $from_pincode)
	{
		$price = 0;
		$type_of_shipment = '0';
		$match = array('ANDAMAN & NICOBAR', 'HIMACHAL PRADESH', 'JAMMU AND KASHMIR', 'KERALA', 'NORTH EAST');
		$to_mertocity = $this->order_model->getRow(array('metrocity_name' => $city), '*', 'metrocity_list');
		$from_mertocity = $this->order_model->getRow(array('metrocity_name' => $fromcity), '*', 'metrocity_list');
		$log_data['DTDC_check_metrocity_availablity_for_deliver_city'] = $to_mertocity;
		$log_data['DTDC_check_metrocity_availablity_for_pickup_city'] = $from_mertocity;
		$to_pincode_detail = $this->order_model->getRow(array('pickup_pincode' => $pincode), 'id,pickup_pincode,pickup_state', 'dtdc_pincode');
		$from_pincode_detail = $this->order_model->getRow(array('pickup_pincode' => $from_pincode), 'id,pickup_pincode,pickup_state', 'dtdc_pincode');
		$log_data['DTDC_pincode_info_for_deliver_city'] = $to_pincode_detail;
		$log_data['DTDC_pincode_info_for_pickup_city'] = $from_pincode_detail;
		if (in_array(strtoupper($to_pincode_detail->pickup_state), $match) || in_array(strtoupper($from_pincode_detail->pickup_state), $match)) {
			$zone = "special_zone";
		} else if (strtolower($fromcity) == strtolower($city)) {
			$zone = "within_city";
		} else if (strtolower($to_pincode_detail->pickup_state) == strtolower($from_pincode_detail->pickup_state)) {
			$zone = "within_state";
		} else if (!empty($from_mertocity) && !empty($to_mertocity)) {
			$zone = "metro";
		} else {
			if ($distance < 500) {
				$zone = "within_zone";
			} else {
				$zone = "rest_of_india";
			}
		}
		$log_data['DTDC_distance'] = $distance;
		$log_data['DTDC_zone'] = $zone;
		$log_data['DTDC_weight'] = $phy_weight;
		$single_logistic_info = $this->order_model->getRow(array('logistic' => 'DTDC'), '*', 'logistic');

		if ($zone != '') {
			if ($phy_weight > 500) {
				$resultdata1 = $this->Common_model->getRow(array('shipment_type' => $type_of_shipment, 'logistic_id' => $single_logistic_info->id, 'rule_id' => 1), $zone, 'manage_price_new');
				$price += $resultdata1->$zone;
				$log_data['DTDC_price_for_first_500'] = $resultdata1->$zone;
				if ($phy_weight > 5000) {
					$temp1 = ceil(4500 / 500);
					$rule_id = 2;
					$resultdata3 = $this->Common_model->getRow(array('shipment_type' => $type_of_shipment, 'logistic_id' => $single_logistic_info->id, 'rule_id' => 2), $zone, 'manage_price_new');
					$price += $temp1 * $resultdata3->$zone;
					$log_data['DTDC_price_for_every_500_upto_5kg_if_morethan_5kg'] = $resultdata3->$zone;
					$temp = $phy_weight - 5000;
					$temp2 = ceil($temp / 1000);
					$rule_id = 3;
					$resultdata2 = $this->Common_model->getRow(array('shipment_type' => $type_of_shipment, 'logistic_id' => $single_logistic_info->id, 'rule_id' => 8), $zone, 'manage_price_new');
					$price += $temp2 * $resultdata2->$zone;
					$log_data['DTDC_price_for_every_1kg_if_morethan_5kg'] = $resultdata2->$zone;
				} else {
					$temp = $phy_weight - 500;
					$temp1 = ceil($temp / 500);
					$rule_id = 2;
					$resultdata3 = $this->Common_model->getRow(array('shipment_type' => $type_of_shipment, 'logistic_id' => $single_logistic_info->id, 'rule_id' => 2), $zone, 'manage_price_new');
					$price += $temp1 * $resultdata3->$zone;
					$log_data['DTDC_price_for_every_500_if_upto_5kg'] = $resultdata3->$zone;
				}
			} else {
				$resultdata4 = $this->Common_model->getRow(array('shipment_type' => $type_of_shipment, 'logistic_id' => $single_logistic_info->id, 'rule_id' => 1), $zone, 'manage_price_new');
				$price += $resultdata4->$zone;
				$log_data['DTDC_price_for_first_500'] = $resultdata4->$zone;
			}
		} else {
			$res['Error'] = 'error';
		}
		$log_data['DTDC_total_price'] = $price;
		$res['Price'] = $price;
		file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_get_price/' . date("d-m-Y") . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		return $res;
	}
	function getUdaanExpressPrice($pincode, $from_pincode, $distance, $phy_weight)
	{
		$price = 0;
		$type_of_shipment = '0';
		$match = array('ANDAMAN & NICOBAR', 'HIMACHAL PRADESH', 'JAMMU AND KASHMIR', 'KERALA', 'NORTH EAST');
		$to_pincode_detail = $this->Common_model->getRow(array('pincode' => $pincode), 'id,state', 'udaan_express_pincode_detail');
		$from_pincode_detail = $this->Common_model->getRow(array('pincode' => $from_pincode), 'id,state', 'udaan_express_pincode_detail');
		if (in_array(strtoupper($to_pincode_detail->state), $match) || in_array(strtoupper($from_pincode_detail->state), $match)) {
			$zone = "special_zone"; //North East as per price chart
		} else if ($distance <= 125 && $distance > 0) {
			$zone = "within_city"; //local as per price chart
		} else if ($distance > 125 && $distance <= 300) {
			$zone = "within_zone"; //Zonal 1 as per price chart
		} else if ($distance > 300 && $distance <= 500) {
			$zone = "metro"; //Zonal 2 as per price chart
		} else if ($distance > 500 && $distance <= 750) {
			$zone = "metro_2"; //National 1 as per price chart
		} else if ($distance > 750 && $distance <= 1000) {
			$zone = "rest_of_india"; //National 2 as per price chart
		} else if ($distance > 1000) {
			$zone = "rest_of_india_2"; //National 3 as per price chart
		}
		$log_data['udaan_express_distance'] = $distance;
		$log_data['udaan_express_zone'] = $zone;
		$log_data['udaan_express_weight'] = $phy_weight;
		$single_logistic_info = $this->Common_model->getRow(array('logistic' => 'Udaan Express'), '*', 'logistic');
		$log_data['udaan_express_logistic_detail'] = $single_logistic_info;

		if ($zone != '') {
			if ($phy_weight <= 500) {
				$result_500gm = $this->Common_model->getRow(array('logistic_id' => $single_logistic_info->id, 'shipment_type' => $type_of_shipment, 'rule_id' => 1), $zone, 'manage_price_new');
				$price += $result_500gm->$zone;
				$log_data['udaan_express_price_for_first_500'] = $result_500gm->$zone;
			} else if ($phy_weight > 500 && $phy_weight <= 1000) {
				$result_1kg = $this->Common_model->getRow(array('logistic_id' => $single_logistic_info->id, 'shipment_type' => $type_of_shipment, 'rule_id' => 3), $zone, 'manage_price_new');
				$price += $result_1kg->$zone;
				$log_data['udaan_express_price_for_first_1kg'] = $result_1kg->$zone;
			} else if ($phy_weight > 1000 && $phy_weight <= 1500) {
				$result_1_5kg = $this->Common_model->getRow(array('logistic_id' => $single_logistic_info->id, 'shipment_type' => $type_of_shipment, 'rule_id' => 13), $zone, 'manage_price_new');
				$price += $result_1_5kg->$zone;
				$log_data['udaan_express_price_for_first_1_5kg'] = $result_1_5kg->$zone;
			} else if ($phy_weight > 1500 && $phy_weight <= 2000) {
				$result_2kg = $this->Common_model->getRow(array('logistic_id' => $single_logistic_info->id, 'shipment_type' => $type_of_shipment, 'rule_id' => 14), $zone, 'manage_price_new');
				$price += $result_2kg->$zone;
				$log_data['udaan_express_price_for_first_2kg'] = $result_2kg->$zone;
			} else if ($phy_weight > 2000 && $phy_weight <= 2500) {
				$result_2_5kg = $this->Common_model->getRow(array('logistic_id' => $single_logistic_info->id, 'shipment_type' => $type_of_shipment, 'rule_id' => 15), $zone, 'manage_price_new');
				$price += $result_2_5kg->$zone;
				$log_data['udaan_express_price_for_first_2_5kg'] = $result_2_5kg->$zone;
			} else if ($phy_weight > 2500 && $phy_weight <= 3000) {
				$result_3kg = $this->Common_model->getRow(array('logistic_id' => $single_logistic_info->id, 'shipment_type' => $type_of_shipment, 'rule_id' => 16), $zone, 'manage_price_new');
				$price += $result_3kg->$zone;
				$log_data['udaan_express_price_for_first_3kg'] = $result_3kg->$zone;
			} else {
				$result_3kg = $this->Common_model->getRow(array('logistic_id' => $single_logistic_info->id, 'shipment_type' => $type_of_shipment, 'rule_id' => 16), $zone, 'manage_price_new');
				$price += $result_3kg->$zone;
				$log_data['udaan_express_price_for_first_5kg'] = $result_3kg->$zone;
				$temp = $phy_weight - 3000;
				$temp1 = ceil($temp / 1000);
				$additional_500gm = $this->Common_model->getRow(array('shipment_type' => $type_of_shipment, 'logistic_id' => $single_logistic_info->id, 'rule_id' => 4), $zone, 'manage_price_new');
				$price += $temp1 * $additional_500gm->$zone;
				$log_data['udaan_express_price_for_additional_500gm'] = $additional_500gm->$zone;
			}
		} else {
			$res['Error'] = 'error';
		}
		$log_data['udaan_express_total_price'] = $price;
		$res['Price'] = $price;
		file_put_contents($this->config->item("FILE_PATH") . '/upload/log_error/home_page_get_price/' . date("d-m-Y") . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		return $res;
	}
}
