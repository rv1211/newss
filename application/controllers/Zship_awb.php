<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Zship_awb extends Auth_Controller
{
    public $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->customer_id = $this->session->userdata('userId');
        $this->load->model('Common_model');
    }

    public function index()
    {
        $this->data['logisticDetail'] = $this->Common_model->getall_data('api_name, logistic_name', 'logistic_master', array('is_zship' => '0', 'is_active' => '1'));
        if ($this->input->post()) {
            $validation = [
                ['field' => 'zship_logistic', 'label' => 'Logisticname', 'rules' => 'trim|required'],
                ['field' => 'order_type', 'label' => 'Codprice', 'rules' => 'trim|required'],
            ];
            $this->form_validation->set_rules($validation);

            if ($this->form_validation->run() == FALSE) {
                $this->data['errors'] = $this->form_validation->error_array();
                load_admin_view('zship_awb', 'add_awb', $this->data);
            } else {
                $zship_logistic = $this->input->post('zship_logistic');
                if ($zship_logistic == 'Delhivery_Surface') {
                    $zshipProvider = 'delhivery';
                } else if ($zship_logistic == 'Xpressbees_Surface') {
                    $zshipProvider = 'xpressbees';
                } else if ($zship_logistic == 'Ekart_Surface') {
                    $zshipProvider = 'ekart';
                } else {
                    $zshipProvider = '';
                }
                $result = $this->generate_awb($zshipProvider, $this->input->post('order_type'));
                if ($result['message'] != '') {
                    $this->session->set_flashdata('message', $result['message']);
                } else {
                    $this->session->set_flashdata('error', $result['error']);
                }
                redirect('generate-awb', 'refresh');
            }
        } else {
            load_admin_view('zship_awb', 'add_awb', $this->data);
        }
    }

    public function generate_awb($zship_logistic, $order_type)
    {
        $awb_log['message'] = $awb_log['error'] = '';
        $request_body = 'provider=' . urlencode($zship_logistic) . '&delivery_type=' . urlencode($order_type) . '&count=' . urlencode('5000');
        $response['api-request-body'] = $request_body;
        switch ($order_type) {
            case 'COD':
                $type = '1';
                break;

            case 'PREPAID':
                $type = '2';
                break;

            default:
                $type = '3';
                break;
        }
        $awb_log['curl_body'] = $request_body;
        $token_detail = $this->Common_model->getSingle_data('*', 'zship_token_master', '');
        $curl_response = CUSTOM::curl_request('application/x-www-form-urlencoded', $token_detail['token'], $this->config->item('ZSHIP_API_AWB_GENERATION_URL'), $request_body, "POST");
        $awb_log['curl_response'] = $curl_response;
        if (!empty($curl_response)) {
            if (!empty($curl_response['success_response'])) {
                $awbResult = $curl_response['success_response'];
                if ($awbResult['status'] == '200') {
                    $awbList = $awbResult['message'];
                    if (!empty($awbList)) {
                        foreach ($awbList as $awbVal) {
                            $awbdata[] = array(
                                'awb_number' => $awbVal,
                                'is_used' => '1',
                                'type' => $type,
                                'for_what' => '2'
                            );
                        }
                        $awb_log['insert_body'] = $awbdata;

                        if ($zship_logistic == 'delhivery') {
                            $result = $this->db->insert_batch('delhivery_surface_airwaybill', $awbdata);
                            $awb_log['insert_result'] = $result;
                            if (!empty($result)) {
                                $awb_log['message'] = "AWB Generated Successfully.";
                            } else {
                                $awb_log['error'] = "AWB Generate Failed!!";
                            }
                        } else if ($zship_logistic == 'xpressbees') {
                            $result = $this->db->insert_batch('xpressbees_surface_airwaybill', $awbdata);
                            $awb_log['insert_result'] = $result;
                            if (!empty($result)) {
                                $awb_log['message'] = "AWB Generated Successfully.";
                            } else {
                                $awb_log['error'] = "AWB Generate Failed!!";
                            }
                        } else if ($zship_logistic == 'ekart') {
                            $result = $this->db->insert_batch('ekart_surface_airwaybill', $awbdata);
                            $awb_log['insert_result'] = $result;
                            if (!empty($result)) {
                                $awb_log['message'] = "AWB Generated Successfully.";
                            } else {
                                $awb_log['error'] = "AWB Generate Failed!!";
                            }
                        }
                        $awb_log['insert_response'] = $result;
                    }
                } else {
                    $awb_log['error'] = $awbResult['message'];
                }
            } else {
                $awb_log['error'] = $curl_response['error_response'];
            }
        } else {
            $awb_log['error'] = 'Something Went Wrong!!!';
        }
        file_put_contents(APPPATH . 'logs/zship_awb/' . date("d-m-Y") . '_zship_awb.txt', print_r($awb_log, true) . "\n------------------- Get AWB End ---------------\n", FILE_APPEND);
        return $awb_log;
    }

    public function get_total_awb()
    {
        $zship_logistic = $this->input->post('zship_logistic');
        $order_type = $this->input->post('order_type');
        switch ($order_type) {
            case 'COD':
                $type = '1';
                break;

            case 'PREPAID':
                $type = '2';
                break;

            default:
                $type = '3';
                break;
        }
        if ($zship_logistic == 'Delhivery_Surface') {
            $awbCount = $this->Common_model->getSingle_data('COUNT(id) as totalCount', 'delhivery_surface_airwaybill', array('type' => $type, 'is_used' => '1'));
            if (!empty($awbCount)) {
                echo $awbCount['totalCount'];
            } else {
                echo "00";
            }
        } else if ($zship_logistic == 'Xpressbees_Surface') {
            $awbCount = $this->Common_model->getSingle_data('COUNT(id) as totalCount', 'xpressbees_surface_airwaybill', array('type' => $type, 'is_used' => '1'));
            if (!empty($awbCount)) {
                echo $awbCount['totalCount'];
            } else {
                echo "00";
            }
        } else if ($zship_logistic == 'Ekart_Surface') {
            $awbCount = $this->Common_model->getSingle_data('COUNT(id) as totalCount', 'ekart_surface_airwaybill', array('type' => $type, 'is_used' => '1'));
            if (!empty($awbCount)) {
                echo $awbCount['totalCount'];
            } else {
                echo "00";
            }
        } else {
            echo '00';
        }
        exit;
    }
}
