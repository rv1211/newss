<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Invoice_model extends CI_Model
{

	public function get_order_data1($today, $fromday, $status_id, $userId, $userType)
	{

		$this->db->select('sum(fom.total_shipping_amount) as Total');
		$where = ("(DATE_FORMAT(fom.created_date,'%Y-%m-%d') BETWEEN '" . $fromday . "' AND '" . $today . "')");
		$this->db->from('forward_order_master as fom');
		if ($today != '' || $fromday != '') {
			$this->db->where($where);
		}
		if ($userType == 4) {
			$this->db->where('fom.sender_id', $userId);
		}
		$this->db->where('fom.is_delete', '0');
		$query  = $this->db->get();
		$data  = $query->row_array();


		$where = ("(DATE_FORMAT(fom.created_date,'%Y-%m-%d') BETWEEN '" . $fromday . "' AND '" . $today . "')");
		$this->db->from('forward_order_master as fom');
		if ($today != '' || $fromday != '') {
			$this->db->where($where);
		}
		if ($userType == 4) {
			$this->db->where('fom.sender_id', $userId);
		}
		$this->db->where('fom.is_delete', '0');
		$data['order_count'] = $this->db->count_all_results();

		$this->db->select('*');
		$this->db->from('wallet_transaction');
		$this->db->where('sender_id', $userId);
		$where = ("(DATE_FORMAT(created_date,'%Y-%m-%d') BETWEEN '" . $fromday . "' AND '" . $today . "')");
		$this->db->where($where);
		$this->db->order_by('id', 'desc');

		$query = $this->db->get();
		$data['wallet_data'] =  $query->result_array();
		// lq();

		//sender Information
		$this->db->select('sm.name,sm.email,sam.warehouse_name,sam.address_line_1,sam.address_line_2,sam.pincode,sam.state,sam.city');
		$this->db->from('sender_master as sm');
		$this->db->join('sender_address_master as sam', 'sam.sender_id = sm.id');
		$this->db->where('sm.id', $userId);
		$query = $this->db->get();
		$data['sender_data'] = $query->row_array();


		return $data;
	}



	public function get_order_data($id)
	{
		$this->db->select('fom.sender_id,fom.pickup_address_id,fom.created_date,fom.total_shipping_amount,opd.product_name,opd.product_quantity');
		$this->db->from('forward_order_master as fom');
		$this->db->join('order_product_detail as opd', 'fom.order_product_detail_id = opd.id');
		$this->db->where('fom.id', $id);
		$query = $this->db->get();

		$data['orderdata'] = $query->row_array();

		$this->db->select('name');
		$this->db->from('sender_master');
		$this->db->where('id', $data['orderdata']['sender_id']);
		$query = $this->db->get();

		$data['userdata'] = $query->row_array();


		$this->db->select('kvm.gst_no,ba.state');
		$this->db->from('kyc_verification_master as kvm');
		$this->db->join('billing_address as ba', 'kvm.billing_address_id = ba.id');
		$this->db->where('kvm.sender_id', $data['orderdata']['sender_id']);
		$query = $this->db->get();

		$data['kycdata'] = $query->row_array();

		$this->db->select('sam.address_line_1,sam.address_line_2,sam.state,sam.pincode,sam.city');
		$this->db->from('sender_address_master as sam');
		$this->db->where('sam.id', $data['orderdata']['pickup_address_id']);
		$query =  $this->db->get();

		$data['pickupaddress'] = $query->row_array();

		return $data;
	}
}

/* End of file ModelName.php */
