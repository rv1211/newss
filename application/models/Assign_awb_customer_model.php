<?php

class Assign_awb_customer_model extends CI_Model
{
    public function get_customers()
    {
        $this->db->select('id,email,name');
        $this->db->from('sender_master');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_logistic($id)
    {
        $this->db->select('logistic_master.id');
        $this->db->select('logistic_master.logistic_name');
        $this->db->from('logistic_master');
        $this->db->join('assign_logistic_sender', 'assign_logistic_sender.logistic_id=logistic_master.id');
        $this->db->where('assign_logistic_sender.sender_id', $id);
        $this->db->where('logistic_master.is_active', '1');
        // $this->db->group_by('logistic_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_logistic_name($logistic_id)
    {
        $this->db->select('logistic_name,id,api_name');
        $this->db->from('logistic_master');
        $this->db->where('id', $logistic_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_airwaybill($table)
    {
        $this->db->select('id,awb_number');
        $this->db->from($table . '_airwaybill');
        $this->db->where('is_used', '1');
        if ($table != 'udaan_direct') {
            $this->db->where('type', '2');
        }
        $this->db->where('for_what', '2');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_excel_data($ids, $logistic_id)
    {

        if ($logistic_id != "") {
            $this->db->select('id,logistic_name,api_name')->from('logistic_master')->where('id', $logistic_id);
            $query = $this->db->get();
            $logistic =  $query->row_array();
            $table = str_replace(' ', '_', $logistic['api_name']);
        }
        $this->db->select('awb_number');
        $this->db->from(strtolower($table . "_airwaybill"));
        $this->db->where_in('id', $ids);
        $query_data = $this->db->get();
        return $query_data->result_array();
    }

    public function updateawb($id_array, $logistic_name)
    {
        $table = str_replace(' ', '_', strtolower($logistic_name['api_name']));
        $data = [
            'for_what' => '1',
        ];
        $this->db->where_in('id', $id_array);
        return $this->db->update($table . "_airwaybill", $data);
    }
}
