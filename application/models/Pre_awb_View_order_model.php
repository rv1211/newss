<?php
class Pre_awb_View_order_model extends CI_Model
{

    public function get_count($status)
    {

        if ($this->session->userdata['userType'] == '1') {
            $count_admin_query = $this->db->select('*');
            $this->db->from('forward_order_master');
            $this->db->join('order_airwaybill_detail', 'order_airwaybill_detail.order_id = forward_order_master.id', 'left');
            $this->db->where('forward_order_master.is_reverse', '0');
            $this->db->where('forward_order_master.is_cancelled', '0');
            $this->db->where('forward_order_master.is_pre_awb', '1');
            $this->db->where('forward_order_master.is_delete', '0');

            if ($status != "") {
                $this->db->where('order_airwaybill_detail.order_status_id', $status);
            }
            // $query = $this->db->get();
            return $this->db->count_all_results();
        } else {
            $customer_id =  $this->session->userdata['userId'];
            $count_cus_query =  $this->db->select('*');
            $this->db->from('forward_order_master');
            $this->db->join('order_airwaybill_detail', 'order_airwaybill_detail.order_id = forward_order_master.id', 'left');
            $this->db->where('forward_order_master.is_reverse', '0');
            $this->db->where('forward_order_master.is_cancelled', '0');
            $this->db->where('forward_order_master.is_pre_awb', '1');
            $this->db->where('forward_order_master.is_delete', '0');

            if ($status != "") {
                $this->db->where('order_airwaybill_detail.order_status_id', $status);
            }
            $this->db->where('created_by', $customer_id);
            // $query = $this->db->get();lq();
            return $this->db->count_all_results();
        }
    }


    public function get_onprocess_data($userId, $userType)
    {
        if ($userType != '1') {
            $this->db->where('sender_id', $userId);
        }
        $this->db->select('*');
        $this->db->from('temp_forward_order_master');
        $this->db->where('is_created', '1');
        $this->db->where('is_pre_awb', '1');
        return $this->db->count_all_results();
    }

    public function get_error_data($userId, $userType)
    {

        $this->db->select('id');
        $this->db->from('error_order_master');
        // $this->db->where('is_created','1');
        if ($userType != '1') {
            $this->db->where('sender_id', $userId);
        }
        $this->db->where('is_delete', '0');
        $this->db->where('is_pre_awb', '1');
        return $this->db->count_all_results();
    }

    public function get_intransit_order_count($status)
    {

        $status_all = explode(",", $status);

        if ($this->session->userdata['userType'] == '1') {
            $count_admin_query = $this->db->select('*');
            $this->db->from('forward_order_master');
            $this->db->join('order_airwaybill_detail', 'order_airwaybill_detail.order_id = forward_order_master.id', 'left');
            $this->db->where('forward_order_master.is_reverse', '0');
            $this->db->where('forward_order_master.is_cancelled', '0');
            $this->db->where('forward_order_master.is_pre_awb', '1');
            $this->db->where('forward_order_master.is_delete', '0');

            if ($status != "") {
                $this->db->where_in('order_airwaybill_detail.order_status_id', $status_all);
            }
            return $this->db->count_all_results();
        } else {
            $customer_id =  $this->session->userdata['userId'];
            $count_cus_query =  $this->db->select('*');
            $this->db->from('forward_order_master');
            $this->db->join('order_airwaybill_detail', 'order_airwaybill_detail.order_id = forward_order_master.id', 'left');
            $this->db->where('forward_order_master.is_reverse', '0');
            $this->db->where('forward_order_master.is_cancelled', '0');
            $this->db->where('forward_order_master.is_pre_awb', '1');
            $this->db->where('forward_order_master.is_delete', '0');

            if ($status != "") {
                $this->db->where_in('order_airwaybill_detail.order_status_id', $status_all);
            }
            // $this->db->where('created_by',$customer_id);
            // $query = $this->db->get();

            return $this->db->count_all_results();
        }
    }

    public function get_waiting_order_data($userId, $userType)
    {

        $this->db->select('id');
        $this->db->from('temp_order_master');
        // $this->db->where('is_created','1');
        if ($userType != '1') {
            $this->db->where('sender_id', $userId);
        }
        $this->db->where('is_flag', '1');
        $this->db->where('is_pre_awb', '1');
        return $this->db->count_all_results();
    }
}
