<?php

class Zship_cron_model extends CI_Model
{
    //get Order Data
    public function get_order_data($order_no)
    {
        $this->db->select('forward_order_master.id,forward_order_master.order_no,order_status.status_name,forward_order_master.order_type,forward_order_master.sender_id,forward_order_master.total_shipping_amount,forward_order_master.awb_number');
        $this->db->from('forward_order_master');
        $this->db->join('order_airwaybill_detail', 'order_airwaybill_detail.order_id=forward_order_master.id');
        $this->db->join('order_status', 'order_status.order_status_id=order_airwaybill_detail.order_status_id');
        $this->db->where('order_airwaybill_detail.airwaybill_no', $order_no);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function  get_order($order_id)
    {
        $this->db->select('fom.sender_id,fom.logistic_id,fom.awb_number,fom.order_product_detail_id,fom.order_no,fom.order_type,sm.pincode as pickup_pincode,rm.pincode as receiver_pincode,opd.volumetric_weight,opd.physical_weight,opd.cod_amount');
        $this->db->from('temp_order_master as fom');
        $this->db->join('sender_address_master as sm', 'fom.pickup_address_id = sm.id');
        $this->db->join('receiver_address as rm', 'fom.deliver_address_id = rm.id');
        $this->db->join('order_product_detail as opd', 'fom.order_product_detail_id = opd.id');
        $this->db->where('fom.id', $order_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update_order($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('temp_order_master', $data);
        return $this->db->affected_rows();
    }

    public function update_order_detail($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('order_product_detail', $data);
        return $this->db->affected_rows();
    }
}
