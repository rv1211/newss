<?php
class Tracking_webhook extends CI_Controller
{
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
                    if (empty($status)) {
                        $result = wallet_direct::refund_wallet(trim($array['AWBNO']), '0', '2');
                        $log_data['walelt_data'] = $status;
                        $log_data['wallet_debit_responce'] = $result;
                    }
                }

                if ($order_update_data['order_status_id'] == '14') {
                    $status = $this->db->select('order_id')->from('order_airwaybill_detail')->where('airwaybill_no', $array['AWBNO'])->where('order_status_id', '14')->get()->result_array();
                    if (empty($status)) {
                        $result = wallet_direct::refund_wallet(trim($array['AWBNO']), '1', '2');
                        $log_data['walelt_data'] = $status;
                        $log_data['wallet_credit_responce'] = $result;
                    }
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
            case 'data received':
                $order_update_data['order_status_id'] = '1';
                break;
            case 'new':
                $order_update_data['order_status_id'] = '1';
                break;
            case 'booked':
                $order_update_data['order_status_id'] = '1';
                break;
            case 'in transit':
                $order_update_data['order_status_id'] = '3';
                
                break;
            case 'drs prepared':
                $order_update_data['order_status_id'] = '3';
                break;
            case 'pickup created':
                $order_update_data['order_status_id'] = '1';
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
                $order_update_data['order_status_id'] = '1';
                break;
            case 'out for pickup':
                $order_update_data['order_status_id'] = '1'; //change
                break;
            case 'pickup not done':
                $order_update_data['order_status_id'] = '1';
                break;
            case 'on hold':
                $order_update_data['order_status_id'] = '3';
                break;
            case 'pending':
                $order_update_data['order_status_id'] = '3';
                break;
            case 'sent to forward':
                $order_update_data['order_status_id'] = '3';
                break;
            case 'received at forward hub':
                $order_update_data['order_status_id'] = '3';
                break;
            case 'received at dc':
                $order_update_data['order_status_id'] = '3';
                break;
            case 'reached at destination':
                $order_update_data['order_status_id'] = '3';
                break;
            case 'reached at destination':
                $order_update_data['order_status_id'] = '3';
                break;
            case 'oda (out of delivery area)':
                $order_update_data['status'] = '18'; //change
                break;
            case 'assigned for customer delivery':
                $order_update_data['order_status_id'] = '5';
                break;
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
            case 'cancelled by seller':
                $order_update_data['order_status_id'] = '9'; //change
                break;
            case 'cancelled':
                $order_update_data['order_status_id'] = '9'; //change
                break;
            case 'not delivered':
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
            case 'rto manifested':
                $order_update_data['order_status_id'] = '9';
                break;
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
            case 'lost':
                $order_update_data['order_status_id'] = '10';
                break;
            default:
                $order_update_data['order_status_id'] = '18';
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
        $post_data = file_get_contents('php://input');
        $log_data['post_response'] = $post_data;
        $data = json_decode($post_data, true);
        $log_data['post_data'] = $data;
        $postData = $_POST;
        $log_data['postData'] = $postData;

        file_put_contents(APPPATH . 'logs/ecom_order/' . date("d-m-Y") . '_tracking_webhook_responce.txt', "\n------- Start Log ------\n" . print_r($log_data, true) . "\n\n", FILE_APPEND);
        file_put_contents(APPPATH . 'logs/ecom_order/' . date("d-m-Y") . '_tracking_webhook_responce.txt', "\n------- END Log ------\n\n", FILE_APPEND);
    }

    public function udaan_tracking_webhook()
    {
        $path = APPPATH . 'logs/udaan_tracking/';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $post_data = file_get_contents('php://input');
        $log_data['post_response'] = $post_data;
        $data = json_decode($post_data, true);
        $log_data['post_data'] = $data;
        $postData = $_POST;
        $log_data['postData'] = $postData;

        file_put_contents(APPPATH . 'logs/udaan_tracking/' . date("d-m-Y") . '_tracking_webhook_responce.txt', "\n------- Start Log ------\n" . print_r($log_data, true) . "\n\n", FILE_APPEND);
        file_put_contents(APPPATH . 'logs/udaan_tracking/' . date("d-m-Y") . '_tracking_webhook_responce.txt', "\n------- END Log ------\n\n", FILE_APPEND);
    }
    
    public function ekart_tracking_webhook(){
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
}
