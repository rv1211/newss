<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kyc_verification extends Auth_Controller
{
	public $data;

	public function __construct()
	{
		parent::__construct();
		$this->customer_id = $this->session->userdata('userId');
		$this->load->model('Common_model');
	}
	//kyc verification form
	public function kyc_verification_index()
	{
		// dd($this->input->post());
		$flag = 1;
		$allow_url = '0';
		if ($this->session->userdata('userType') == '4') {
			$kyc_status = $this->Common_model->getSingle_data('status', 'sender_master', array('id' => $this->customer_id));
			if ($kyc_status['status'] == '0') {
				$kyc_data = $this->Common_model->getSingle_data('id', 'kyc_verification_master', array('sender_id' => $this->customer_id));
				if (empty($kyc_data)) {
					$allow_url = '1';
				}
			}
		}
		if ($allow_url == '1') {
			$this->data['document_list'] = $this->Common_model->getResultArray(array('is_active' => '1'), '*', 'document_master');

			if ($this->input->post()) {
				//print_r($_POST);
				$validation = [
					['field' => 'profile_type', 'label' => 'Profile Type', 'rules' => 'required'],
					['field' => 'address_1', 'label' => 'Address 1', 'rules' => 'required'],
					['field' => 'pincode', 'label' => 'Pincode', 'rules' => 'required|exact_length[6]'],
					['field' => 'city', 'label' => 'City', 'rules' => 'required'],
					['field' => 'pan_no', 'label' => 'Pan No', 'rules' => 'required|exact_length[10]|regex_match[/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}$/]'],
					['field' => 'state', 'label' => 'State', 'rules' => 'required'],
					['field' => 'doc1_id', 'label' => 'Document', 'rules' => 'required'],
					['field' => 'doc2_id', 'label' => 'Document', 'rules' => 'required'],
					['field' => 'bankname', 'label' => 'Bank Name', 'rules' => 'required'],
					['field' => 'benificiary', 'label' => 'Benificiary Name', 'rules' => 'required'],
					['field' => 'acno', 'label' => 'Account Number', 'rules' => 'required'],
					['field' => 'ifsc', 'label' => 'IFSC Code', 'rules' => 'required'],
				];
				switch ($this->input->post('profile_type')) {
					case 1:
						$validation[] = ['field' => 'gst_no', 'label' => 'GST No', 'rules' => 'required|exact_length[15]|regex_match[/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/]'];
						$validation[] = ['field' => 'company_type', 'label' => 'Company Type', 'rules' => 'required'];
						$validation[] =	['feild' => 'company_name', 'lable' => 'Company Name', 'rules' => 'required'];
						break;

					case 2:
						$validation[] = ['field' => 'gst_no', 'label' => 'GST No', 'rules' => 'exact_length[15]|regex_match[/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/]'];
						break;

					default:
						break;
				}

				if (empty($_FILES['doc1_1_img']['name'])) {
					$validation[] = ['field' => 'doc1_1_img', 'label' => 'Document Image', 'rules' => 'required'];
				}
				if (empty($_FILES['doc1_2_img']['name'])) {
					$validation[] = ['field' => 'doc1_2_img', 'label' => 'Document Image', 'rules' => 'required'];
				}
				if (empty($_FILES['doc2_image1']['name'])) {
					$validation[] = ['field' => 'doc2_image1', 'label' => 'Document Image', 'rules' => 'required'];
				}
				// if(empty($_FILES['doc2_image2']['name'])){
				// 	$validation[] = ['field' => 'doc2_image2', 'label' => 'Document Image', 'rules' => 'required'];
				// }
				// if (empty($_FILES['pick_up_img']['name'])) {
				// 	$validation[] = ['field' => 'pick_up_img', 'label' => 'Pickup Image', 'rules' => 'required'];
				// }


				if (empty($_FILES['cancelled_cheque_image']['name'])) {
					$validation[] = ['field' => 'cancelled_cheque_image', 'label' => 'Cancelled Cheque Image', 'rules' => 'required'];
				}

				$this->form_validation->set_rules($validation);
				if ($this->form_validation->run() == FALSE) {
					$this->data['errors'] = $this->form_validation->error_array();
					$this->load->view('admin/template/header');
					$this->load->view('admin/kyc_form/kyc_form', $this->data);
					$this->load->view('admin/template/footer');
				} else {
					$kycbilladdressdata = array(
						"sender_id" => $this->customer_id,
						"address_1" => $this->input->post('address_1'),
						"address_2" => $this->input->post('address_2'),
						"city" => $this->input->post('city'),
						"state" => $this->input->post('state'),
						"pincode" => $this->input->post('pincode'),
					);
					$resultkycbilladdress = $this->Common_model->insert($kycbilladdressdata, "billing_address");

					if ($resultkycbilladdress) {
						$billing_address_id = $this->db->insert_id();
						$kycdata = array(
							"sender_id" => $this->customer_id,
							"billing_address_id" => $billing_address_id,
							"profile_type" => $this->input->post('profile_type'),
							"company_type" => @$this->input->post('company_type'),
							"company_name" => @$this->input->post('company_name'),
							"pan_no" => $this->input->post('pan_no'),
							"gst_no" => $this->input->post('gst_no'),
							"bankname" => $this->input->post('bankname'),
							"benificiary" => $this->input->post('benificiary'),
							"account_no" => $this->input->post('acno'),
							"ifsc_code" => $this->input->post('ifsc')
						);

						$result = $this->Common_model->insert($kycdata, "kyc_verification_master");
						$kyc_id = $this->db->insert_id();

						if (!empty($_FILES['doc1_1_img']['name'])) {
							$config['upload_path'] = './uploads/kyc_verification_document/doc1_image/';
							$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
							$config['max_size'] = 7096;
							$doc1_1_img_name = strtotime('now');
							$config['file_name'] = $doc1_1_img_name;
							$this->upload->initialize($config);
							if (!$this->upload->do_upload('doc1_1_img')) {
								$flag = 0;
								$error = $this->upload->display_errors();
								if (strpos($error, "The file you are attempting to upload is larger than the permitted size")) {
									$this->session->set_flashdata('error', "File size larger than 7MB.");
								} else {
									$this->session->set_flashdata('error', $error);
								}
								$billAddress = $this->Common_model->delete('billing_address', array('sender_id' => $this->customer_id));
								$kycVerification = $this->Common_model->delete('kyc_verification_master', array('sender_id' => $this->customer_id));
								$kycDoc = $this->Common_model->delete('kyc_document_master', array('kyc_id' => $kyc_id));
								redirect('kyc-verification');
							} else {
								$post_image = $this->upload->data();
								$doc1_1_img = $post_image['file_name'];
								$adhar_card_1 = array(
									"kyc_id" => $kyc_id,
									"doc_id" => $this->input->post('doc1_id'),
									"image" => $doc1_1_img,
								);
								$adhar_insert_1 = $this->Common_model->insert($adhar_card_1, "kyc_document_master");
							}
						}

						if (!empty($_FILES['doc1_2_img']['name'])) {
							$config['upload_path'] = './uploads/kyc_verification_document/doc1_image/';
							$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
							$config['max_size'] = 7096;
							$doc1_2_img_name =  strtotime('now');
							$config['file_name'] = $doc1_2_img_name;
							$this->upload->initialize($config);
							if (!$this->upload->do_upload('doc1_2_img')) {
								$flag = 0;
								$error = $this->upload->display_errors();
								if (strpos($error, "The file you are attempting to upload is larger than the permitted size")) {
									$this->session->set_flashdata('error', "File size larger than 7MB.");
								} else {
									$this->session->set_flashdata('error', $error);
								}
								$billAddress = $this->Common_model->delete('billing_address', array('sender_id' => $this->customer_id));
								$kycVerification = $this->Common_model->delete('kyc_verification_master', array('sender_id' => $this->customer_id));
								$kycDoc = $this->Common_model->delete('kyc_document_master', array('kyc_id' => $kyc_id));
								redirect('kyc-verification');
							} else {
								$post_image = $this->upload->data();
								$doc1_2_img = $post_image['file_name'];

								$adhar_card_2 = array(
									"kyc_id" => $kyc_id,
									"doc_id" => $this->input->post('doc1_id'),
									"image" => $doc1_2_img,
								);
								$adhar_insert_2 = $this->Common_model->insert($adhar_card_2, "kyc_document_master");
							}
						}

						if (!empty($_FILES['doc2_image1']['name'])) {
							$config['upload_path'] = './uploads/kyc_verification_document/doc2_image/';
							$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
							$config['max_size'] = 7096;
							$doc2_image1_name = strtotime('now');
							$config['file_name'] = $doc2_image1_name;
							$this->upload->initialize($config);
							if (!$this->upload->do_upload('doc2_image1')) {
								$flag = 0;
								$error = $this->upload->display_errors();
								if (strpos($error, "The file you are attempting to upload is larger than the permitted size")) {
									$this->session->set_flashdata('error', "File size larger than 7MB.");
								} else {
									$this->session->set_flashdata('error', $error);
								}
								$billAddress = $this->Common_model->delete('billing_address', array('sender_id' => $this->customer_id));
								$kycVerification = $this->Common_model->delete('kyc_verification_master', array('sender_id' => $this->customer_id));
								$kycDoc = $this->Common_model->delete('kyc_document_master', array('kyc_id' => $kyc_id));
								redirect('kyc-verification');
							} else {
								$post_image = $this->upload->data();
								$doc2_image1 = $post_image['file_name'];
								$pan_card_1 = array(
									"kyc_id" => $kyc_id,
									"doc_id" => $this->input->post('doc2_id'),
									"image" => $doc2_image1,
								);
								$pan_insert_1 = $this->Common_model->insert($pan_card_1, "kyc_document_master");
							}
						}

						if (!empty($_FILES['doc2_image2']['name'])) {
							$config['upload_path'] = './uploads/kyc_verification_document/doc2_image/';
							$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
							$config['max_size'] = 7096;
							$doc2_image2_name = strtotime('now');
							$config['file_name'] = $doc2_image2_name;
							$this->upload->initialize($config);
							if (!$this->upload->do_upload('doc2_image2')) {
								$flag = 0;
								$error = $this->upload->display_errors();
								if (strpos($error, "The file you are attempting to upload is larger than the permitted size")) {
									$this->session->set_flashdata('error', "File size larger than 7MB.");
								} else {
									$this->session->set_flashdata('error', $error);
								}
								$billAddress = $this->Common_model->delete('billing_address', array('sender_id' => $this->customer_id));
								$kycVerification = $this->Common_model->delete('kyc_verification_master', array('sender_id' => $this->customer_id));
								$kycDoc = $this->Common_model->delete('kyc_document_master', array('kyc_id' => $kyc_id));
								redirect('kyc-verification');
							} else {
								$post_image = $this->upload->data();
								$doc2_image2 = $post_image['file_name'];
								$pan_card_2 = array(
									"kyc_id" => $kyc_id,
									"doc_id" => $this->input->post('doc2_id'),
									"image" => $doc2_image2,
								);
								$pan_insert_2 = $this->Common_model->insert($pan_card_2, "kyc_document_master");
							}
						}

						if (!empty($_FILES['pick_up_img']['name'])) {
							$config['upload_path'] = './uploads/kyc_verification_document/pickup_image/';
							$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
							$config['max_size'] = 7096;
							$pick_up_img_name = strtotime('now');
							$config['file_name'] = $pick_up_img_name;
							$this->upload->initialize($config);
							if (!$this->upload->do_upload('pick_up_img')) {
								$flag = 0;
								$error = $this->upload->display_errors();
								if (strpos($error, "The file you are attempting to upload is larger than the permitted size")) {
									$this->session->set_flashdata('error', "File size larger than 7MB.");
								} else {
									$this->session->set_flashdata('error', $error);
								}
								$billAddress = $this->Common_model->delete('billing_address', array('sender_id' => $this->customer_id));
								$kycVerification = $this->Common_model->delete('kyc_verification_master', array('sender_id' => $this->customer_id));
								$kycDoc = $this->Common_model->delete('kyc_document_master', array('kyc_id' => $kyc_id));
								redirect('kyc-verification');
							} else {
								echo "insert";
								$post_image = $this->upload->data();
								$pick_up_img = $post_image['file_name'];
								$pickup_adds = array(
									"kyc_id" => $kyc_id,
									"doc_id" => $this->input->post('pickup_id'),
									"image" => $pick_up_img,
								);
								$pan_insert_2 = $this->Common_model->insert($pickup_adds, "kyc_document_master");
							}
						}

						if (!empty($_FILES['cancelled_cheque_image']['name'])) {
							$config['upload_path'] = './uploads/kyc_verification_document/cancelled_cheque_image/';
							$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
							$config['max_size'] = 7096;
							$cancelled_cheque_image_name = strtotime('now');
							$config['file_name'] = $cancelled_cheque_image_name;
							$this->upload->initialize($config);
							if (!$this->upload->do_upload('cancelled_cheque_image')) {
								$flag = 0;
								$error = $this->upload->display_errors();
								if (strpos($error, "The file you are attempting to upload is larger than the permitted size")) {
									$this->session->set_flashdata('error', "File size larger than 7MB.");
								} else {
									$this->session->set_flashdata('error', $error);
								}
								$billAddress = $this->Common_model->delete('billing_address', array('sender_id' => $this->customer_id));
								$kycVerification = $this->Common_model->delete('kyc_verification_master', array('sender_id' => $this->customer_id));
								$kycDoc = $this->Common_model->delete('kyc_document_master', array('kyc_id' => $kyc_id));
								redirect('kyc-verification');
							} else {
								$post_image = $this->upload->data();
								$cancelled_cheque_image = $post_image['file_name'];
								$cancel_check = array(
									"kyc_id" => $kyc_id,
									"doc_id" => $this->input->post('cancelled_cheque_id'),
									"image" => $cancelled_cheque_image,
								);
								$cancel_check_insert = $this->Common_model->insert($cancel_check, "kyc_document_master");
							}
						}

						$error_conter = 0;
						if (!empty($_FILES['other_document']['name'])) {
							for ($i = 0; $i < count($_FILES['other_document']['name']); $i++) {
								if ($_FILES['other_document']['name'][$i] != '') {
									$_FILES['file']['name'] = $_FILES['other_document']['name'][$i];
									$_FILES['file']['type'] = $_FILES['other_document']['type'][$i];
									$_FILES['file']['tmp_name'] = $_FILES['other_document']['tmp_name'][$i];
									$_FILES['file']['error'] = $_FILES['other_document']['error'][$i];
									$_FILES['file']['size'] = $_FILES['other_document']['size'][$i];
									$config['upload_path'] = './uploads/kyc_verification_document/other_document/';
									$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
									$config['max_size'] = 7096;

									$this->upload->initialize($config);
									if (!$this->upload->do_upload('file')) {
										$flag = 0;
										$error = $this->upload->display_errors();
										if (strpos($error, "The file you are attempting to upload is larger than the permitted size")) {
											$this->session->set_flashdata('error', "File size larger than 7MB.");
										} else {
											$this->session->set_flashdata('error', $error);
										}
										$billAddress = $this->Common_model->delete('billing_address', array('sender_id' => $this->customer_id));
										$kycVerification = $this->Common_model->delete('kyc_verification_master', array('sender_id' => $this->customer_id));
										$kycDoc = $this->Common_model->delete('kyc_document_master', array('kyc_id' => $kyc_id));
										redirect('kyc-verification');
									} else {
										$post_image = $this->upload->data();
										$other_document = $post_image['file_name'];
									}
									$other_doc = array(
										"kyc_id" => $kyc_id,
										"doc_id" => $this->input->post('other_doc_id'),
										"image" => $other_document,
									);
									$cancel_check_insert = $this->Common_model->insert($other_doc, "kyc_document_master");
								}
							}
						}

						if ($flag == 1) {
							$to = 'shipsecurelogistics1@gmail.com';
							$subject = "New Kyc Request Arrived !!";
							$messageBody = '<!DOCTYPE html>
                                            <html lang="en">
                                            <head>
                                                <meta charset="UTF-8">
                                                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                                <style>
                                                    * {
                                                        margin: 0;
                                                        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
                                                        box-sizing: border-box;
                                                        font-size: 14px;
                                                    }
                                            
                                                    body {
                                                        -webkit-font-smoothing: antialiased;
                                                        -webkit-text-size-adjust: none;
                                                        width: 100% !important;
                                                        height: 100%;
                                                        line-height: 1.6em;
                                                    }
                                            
                                                    body {
                                                        background-color: #f6f6f6;
                                                    }
                                            
                                                    .body-wrap {
                                                        background-color: #f6f6f6;
                                                        width: 100%;
                                                    }
                                            
                                                    .container {
                                                        display: block !important;
                                                        max-width: 600px !important;
                                                        margin: 0 auto !important;
                                                        clear: both !important;
                                                    }
                                            
                                                    a {
                                                        color: #348eda;
                                                        text-decoration: underline;
                                                    }
                                            
                                                    .btn-primary {
                                                        text-decoration: none;
                                                        color: #FFF;
                                                        background-color: #348eda;
                                                        border: solid #348eda;
                                                        border-width: 10px 20px;
                                                        line-height: 2em;
                                                        font-weight: bold;
                                                        text-align: center;
                                                        cursor: pointer;
                                                        display: inline-block;
                                                        border-radius: 5px;
                                                        text-transform: capitalize;
                                                    }
                                                </style>
                                            </head>
                                            
                                            <body>
                                                <img src="https://shipsecurelogistics.com/uploads/logo.png" height="150px" width="250px">
                                                <br>
                                                <h1>We have Recived New Kyc Request</h1>
                                                <h3>Click here :- <a href="https://shipsecurelogisticscom/kyc-pending-customer" class="btn-primary">Review Kyc</a>
                                                </h3>
                                        </body>

                                    </html>';
							$this->load->helper('mailhelper');
							$mail = simpleMail($to, $subject, $messageBody);
							$mailLog['toMail'] = $to;
							$mailLog['MailBody'] = $messageBody;
							$mailLog['MailResponse'] = $mail;
							file_put_contents(APPPATH . 'logs/mailLog/' . date("d-m-Y") . '_maillog.txt', "\n\n---------- KYC Request -------------\n" . print_r($mailLog, true), FILE_APPEND);

							$this->session->set_flashdata('message', 'Your KYC Document add Successfully.');
							redirect('approve-pending');
						} else {
							$this->session->set_flashdata('error', 'Not send.');
							$this->load->view('admin/template/header');
							$this->load->view('admin/kyc_form/kyc_form', $this->data);
							$this->load->view('admin/template/footer');
						}
					}
				}
			} else {
				$this->load->view('admin/template/header');
				$this->load->view('admin/kyc_form/kyc_form', $this->data);
				$this->load->view('admin/template/footer');
			}
		} else {
			redirect('dashboard', 'refresh');
		}
	}

	/*
     * Approve Pending
     * @return Layout
     */
	public function approve_pending()
	{ ?>
		<SCRIPT type="text/javascript">
			window.history.forward();
		</SCRIPT>
<?php
		$this->load->view('admin/template/header');
		$this->load->view('admin/kyc_form/approve_pending');
		$this->load->view('admin/template/footer');
	}

	public function get_city_state()
	{
		$result = $this->Common_model->getRowArray(array('pincode' => $this->input->post('pincode')), 'city,state', 'pincode_master');
		echo json_encode(array('city' => $result[0]['city'], 'state' => $result[0]['state']));
	}
}
