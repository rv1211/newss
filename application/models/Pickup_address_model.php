<?php

class Pickup_address_model extends CI_Model
{
    public function get_excel_data($ids)
    {
        $this->db->select('warehouse_name,contact_person_name,contact_no,contact_email,website,address_line_1,address_line_2,pincode,state,city');
        $this->db->from('sender_address_master');
        $this->db->where_in('id', $ids);
        $query_data = $this->db->get();
        return $query_data->result_array();
    }

    public function updateawb($id_array)
    {
        $table = str_replace(' ', '_', $logistic_name['api_name']);
        $data = [
            'for_what' => '1',
        ];
        $this->db->where_in('id', $id_array);
        return $this->db->update($table . "_airwaybill", $data);
    }
}