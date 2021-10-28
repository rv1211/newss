<?php
class Bulk_order_model extends CI_Model
{

    public function insert($data, $table)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function chek_exist_pincode($pincodes)
    {
        $this->db->select('*');
        $this->db->from('pincode_master');
        $this->db->where('pincode_master.pincode', $pincodes);
        $query = $this->db->get();
        if (empty($query->result_array())) {
            return false;
        } else {
            return true;
        }
    }

    public function get_data_by_pincode($is_valid_pincode)
    {
        $this->db->select('*');
        $this->db->from('pincode_detail');
        $this->db->where('pincode_id', $is_valid_pincode);
        $this->db->where('is_pickup', '1');
        $query = $this->db->get();
        return $query->row();
    }

    public function get_id_from_pincode($pickup_id)
    {
        $this->db->select('pincode');
        $this->db->from('sender_address_master');
        $this->db->where('sender_address_master.id', $pickup_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_user_wallet($sender_id)
    {
        $this->db->select('id,email,wallet_balance,allow_credit,allow_credit_limit');
        $this->db->from('sender_master');
        $this->db->where('id', $sender_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_order_cost($order_ids)
    {
        $this->db->select_sum('total_shipping_amount');
        $this->db->from('temp_order_master');
        $this->db->where_in('id', $order_ids);
        $query = $this->db->get();
        return $query->row();
    }

    public function delete_bulk_order($order_id)
    {

        $this->db->where_in('id', $order_id);
        $this->db->delete('temp_order_master');
        return  $this->db->affected_rows();
    }

    public function delete_bulk_error_order($sender_id)
    {
        $this->db->where('sender_id', $sender_id);
        $this->db->where('is_process', '1');
        $this->db->where('is_flag', '0');
        $this->db->delete('temp_order_master');
        return $this->db->affected_rows();
    }
}
