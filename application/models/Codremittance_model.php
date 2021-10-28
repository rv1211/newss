<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Codremittance_model extends CI_Model {
	public function get_credit_limit_sum($customer_id, $to_date, $from_date) {
		$sql = "SELECT SUM(remain_amount) AS total_remain_balance FROM order_master WHERE payment_status=0 AND payment_method='Wallet' AND is_delete='0' AND customer_id='" . $customer_id . "' AND (created_date BETWEEN '" . $from_date . "' AND '" . $to_date . "')";
		$query = $this->db->query($sql);
		return $query->row();
	}
	public function get_cod_amount_sum($customer_id, $to_date, $from_date) {
		$sql = "SELECT SUM(opd.cod_amount) AS total_cod_amount
					FROM order_master AS ot
					LEFT JOIN order_product_detail AS opd ON opd.order_product_detail_id=ot.order_product_detail_id  WHERE ot.is_cod_available='1' AND ot.is_delete='0' AND ot.order_type='1' AND ot.customer_id='" . $customer_id . "' AND (ot.is_cod_available_date BETWEEN '" . $from_date . "' AND '" . $to_date . "')";
		$query = $this->db->query($sql);
		return $query->row();
	}
	public function get_cod_remittance_data($cod_remittance_detail_id) {
		$sql = "SELECT ot.airwaybill_number,ot.delivered_date,opd.cod_amount
					FROM order_master AS ot
					LEFT JOIN order_product_detail AS opd ON opd.order_product_detail_id=ot.order_product_detail_id  WHERE ot.cod_remittance_detail_id='" . $cod_remittance_detail_id . "'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_cod_remittance_order_data($cod_remittance_detail_id){
		$this->db->select('fom.awb_number,opd.cod_amount,fom.is_cod_remittance_close_datetime,oad.delivery_date');
		$this->db->from('forward_order_master as fom');
		$this->db->join('order_product_detail as opd','opd.id = fom.order_product_detail_id','left');
		$this->db->join('order_airwaybill_detail as oad','oad.order_id = fom.id','left');
		$this->db->where('fom.cod_remittance_detail_id',$cod_remittance_detail_id);
		$sql = $this->db->get();
        return $sql->result_array();
	}
	public function delete_in_cod($sender_ids)
	{
		$this->db->where_in('sender_id',$sender_ids);
		return $this->db->delete('next_cod_remittance_list');
	}

	public function get_cod_remittance_total($userId){
		$this->db->select('SUM(opd.cod_amount) as Totalcod');
		$this->db->from('forward_order_master as fom');
		$this->db->join('order_product_detail as opd','opd.id = fom.order_product_detail_id','left');
		$this->db->join('order_airwaybill_detail as oad','oad.order_id = fom.id','left');
		$this->db->join('order_status as os','oad.order_status_id = os.order_status_id','left');
		$this->db->where('os.status_name','Delivered');
		$this->db->where('fom.order_type','1');
		if($userId != '0'){
			$this->db->where('fom.sender_id',$userId);
		}
		$sql = $this->db->get();
        return $sql->row_array();
	}
	public function get_next_cod_remittanace_data($fromday,$today,$userId,$userType)
    {
        $where = ("(DATE_FORMAT(oad.delivery_date,'%Y-%m-%d') BETWEEN '".$fromday."' AND '".$today."')");
		$this->db->select('sm.id,sm.name,sm.email,COUNT(fom.id) As order_count,sum(opd.cod_amount) As cod_amount');
        $this->db->from('forward_order_master as fom');
        $this->db->join('order_airwaybill_detail as oad', 'fom.id = oad.order_id');
        $this->db->join('order_product_detail as opd', 'fom.order_product_detail_id = opd.id');
        $this->db->join('sender_master as sm', 'fom.sender_id = sm.id');
        if ($today != '' || $fromday != '') {
            $this->db->where($where);
        }
        $this->db->where('fom.order_type', '1');
		$this->db->where('fom.is_pre_awb', '0');
		$this->db->where('fom.is_delete', '0');
		$this->db->where('oad.order_status_id', '6');
		$this->db->where('fom.is_cod_remittance','0');
		$this->db->group_by('fom.sender_id');
        $query = $this->db->get(); 
        return $query->result_array();
    }
	public function get_next_cod_remittanace_all_data()
    {
		$this->db->select('sm.id,sm.name,sm.email,ncod.order_count,ncod.cod_remittance_amount');
        $this->db->from('next_cod_remittance_list as ncod');
        $this->db->join('sender_master as sm', 'ncod.sender_id = sm.id');
        $query = $this->db->get(); 
        return $query->result_array();
    }
	public function get_cod_remittanace_count($get_shipping_amount,$userId,$userType)
    {
        $this->db->select('sum(opd.cod_amount) As cod_amount,fom.is_cod_remittance ,oad.updateDate');
        $this->db->from('forward_order_master as fom');
        $this->db->join('order_airwaybill_detail as oad', 'fom.id = oad.order_id');
        $this->db->join('order_product_detail as opd', 'fom.order_product_detail_id = opd.id');
        $this->db->where('fom.order_type', '1');
        if($get_shipping_amount == '3'){
            $this->db->where('fom.is_pre_awb', '0');
            $this->db->where('fom.is_delete', '0');
            $this->db->where('oad.order_status_id', '6');
            $this->db->where('fom.is_cod_remittance','0');
            
        }
        if($get_shipping_amount == '2'){
            $this->db->where('fom.is_cod_remittance','1');
        }
		if ($userType == 4) {
            $this->db->where('fom.sender_id', $userId);
        }
        $query = $this->db->get(); 
        return $query->row_array();
    }

	public function get_excel_data($crf_id){
		
		$this->db->select('fom.awb_number,fom.order_no,sm.name,lm.logistic_name,opd.cod_amount as price,oad.delivery_date');
		$this->db->from('cod_remittance_order_detail as crod');
		$this->db->join('cod_remittance as cr', 'cr.id = crod.cod_remittance_id');
        $this->db->join('forward_order_master as fom', 'crod.order_id = fom.id');
		$this->db->join('order_product_detail as opd', 'opd.id = fom.order_product_detail_id');
		$this->db->join('order_airwaybill_detail as oad', 'fom.id = oad.order_id');
		$this->db->join('logistic_master as lm', 'lm.id = fom.logistic_id');
		$this->db->join('sender_master as sm', 'sm.id = crod.sender_id');
        $this->db->where('cr.crf_id', $crf_id);
        $this->db->where('fom.is_pre_awb', '0');
        $this->db->where('fom.is_delete', '0');
        $this->db->where('oad.order_status_id', '6');
		$query_data = $this->db->get();
        return $query_data->result_array();
	}
}
?>