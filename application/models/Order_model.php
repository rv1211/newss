<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Order_model extends CI_Model
{

	public function get_multiple_order_list_for_slip($order_id)
	{

		$this->db->select("ot.order_no,ot.customer_order_no, ot.order_type, ot.awb_number, oad.airwaybill_barcode_img, ot.created_date, ot.id ,ot.total_shipping_amount,ot.sgst_amount as sgst,ot.cgst_amount as cgst,ot.igst_amount as igst,ot.packing_slip_warehouse_name, ram.name as deliver_name, ram.address_1 as deliver_address_1, ram.address_2 as deliver_address_2, ram.city as deliver_city, ram.state as deliver_state, ram.pincode as deliver_pincode, ram.mobile_no as deliver_mobile_no, opd.product_name, opd.product_quantity, opd.product_value, opd.product_quantity,opd.length,opd.width,opd.height, opd.physical_weight, opd.cod_amount,opd.product_sku, lm.logistic_name,lm.api_name, sam.contact_email as pickup_email, sam.contact_no as pickup_contact_no, sam.website as pickup_website,sam.address_line_1 as pickup_address_1,sam.address_line_2 as pickup_address_2 ,sam.city as pickup_city,sam.state as pickup_state,sam.pincode as pickup_pincode,sam.contact_person_name as pickup_name,kvm.gst_no,sm.name as sender_name
		");
		$this->db->from("forward_order_master AS ot");

		$this->db->join('order_airwaybill_detail as oad', 'oad.order_id=ot.id', 'left');
		$this->db->join('receiver_address as ram', 'ram.id=ot.deliver_address_id', 'inner');
		$this->db->join('order_product_detail as opd', 'opd.id=ot.order_product_detail_id', 'inner');
		$this->db->join('sender_address_master AS sam ', 'sam.id=ot.pickup_address_id', 'inner');
		$this->db->join('logistic_master AS lm ', 'lm.id=ot.logistic_id', 'inner');
		$this->db->join('sender_master as sm', 'ot.sender_id = sm.id');
		$this->db->join('kyc_verification_master AS kvm ', 'kvm.sender_id=ot.sender_id', 'inner');
		$this->db->where_in('ot.id', $order_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_manifest_data($order_id)
	{
		$this->db->select("ot.order_no,ot.logistic_id as logistic_id, ot.sender_id, ot.order_type, ot.awb_number, oad.airwaybill_barcode_img, ot.created_date, ot.id ,ot.total_shipping_amount,ot.sgst_amount as sgst,ot.cgst_amount as cgst,ot.igst_amount as igst, ram.name as deliver_name, ram.address_1 as deliver_address_1, ram.address_2 as deliver_address_2, ram.city as deliver_city, ram.state as deliver_state, ram.pincode as deliver_pincode, ram.mobile_no as deliver_mobile_no, opd.product_name, opd.product_quantity, opd.product_value, opd.product_quantity,opd.length,opd.width,opd.height, opd.physical_weight, opd.cod_amount,opd.product_sku, lm.logistic_name,lm.api_name, sam.contact_email as pickup_email, sam.contact_no as pickup_contact_no, sam.website as pickup_website,sam.address_line_1 as pickup_address_1,sam.address_line_2 as pickup_address_2 ,sam.city as pickup_city,sam.state as pickup_state,sam.pincode as pickup_pincode,sam.contact_person_name as pickup_name,kvm.gst_no,sm.name as sender_name
		");
		$this->db->from("forward_order_master AS ot");

		$this->db->join('order_airwaybill_detail as oad', 'oad.order_id=ot.id', 'left');
		$this->db->join('receiver_address as ram', 'ram.id=ot.deliver_address_id', 'inner');
		$this->db->join('order_product_detail as opd', 'opd.id=ot.order_product_detail_id', 'inner');
		$this->db->join('sender_address_master AS sam ', 'sam.id=ot.pickup_address_id', 'inner');
		$this->db->join('logistic_master AS lm ', 'lm.id=ot.logistic_id', 'inner');
		$this->db->join('kyc_verification_master AS kvm ', 'kvm.sender_id=ot.sender_id', 'inner');
		$this->db->join('sender_master as sm', 'ot.sender_id = sm.id');
		$this->db->where_in('ot.id', $order_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function update_record_webhook($data, $id)
	{
		$define = $id[0];
		if ($define == "B") {
			$this->db->where('order_no', substr($id, 1));
			$this->db->update('temp_order_master', $data);
		} else {
			$this->db->where('order_no', substr($id, 1));
			$this->db->update('temp_forward_order_master', $data);
		}
	}

	public function update_order_data($data, $id, $table_name)
	{
		$define = $id[0];
		if ($define == "B") {
			$this->db->where('order_no', substr($id, 1));
			$this->db->update('temp_order_master', $data);
		} else {
			$this->db->where('order_no', substr($id, 1));
			$this->db->update('temp_forward_order_master', $data);
		}
	}

	public function get_wallet_info($id)
	{
		$define = $id[0];
		if ($define == "B") {
			$this->db->select('sm.id as sender_id,sm.email,sm.wallet_balance,sm.allow_credit,sm.allow_credit_limit,tm.total_shipping_amount,tm.igst_amount,tm.cgst_amount,tm.sgst_amount,tm.id as order_id,tm.order_no as order_no,tm.awb_number,tm.order_type,lm.logistic_name as logistic_name,lm.api_name as api_name');
			$this->db->from('temp_order_master as tm');
			$this->db->join('sender_master  as sm', 'tm.sender_id = sm.id');
			$this->db->join('logistic_master as lm', 'tm.logistic_id = lm.id');
			$this->db->where('tm.order_no', substr($id, 1));
			$query = $this->db->get();
			return $query->row_array();
		} else {
			$this->db->select('sm.id as sender_id,sm.email,sm.wallet_balance,sm.allow_credit,sm.allow_credit_limit,tm.total_shipping_amount,tm.igst_amount,tm.cgst_amount,tm.sgst_amount,tm.id as order_id,tm.order_no as order_no,tm.awb_number,tm.order_type,lm.logistic_name as logistic_name,lm.api_name as api_name');
			$this->db->from('temp_forward_order_master as tm');
			$this->db->join('sender_master  as sm', 'tm.sender_id = sm.id');
			$this->db->join('logistic_master as lm', 'tm.logistic_id = lm.id');
			$this->db->where('tm.order_no', substr($id, 1));
			$query = $this->db->get();
			return $query->row_array();
		}
	}

	public function get_user_assign_label($user_id)
	{
		$this->db->select('*');
		$this->db->from('assign_label_user');
		$this->db->where('sender_id', $user_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function check_bulk_order($sender_id)
	{
		$this->db->select('id');
		$this->db->from('temp_order_master');
		$this->db->where('sender_id', $sender_id);
		$this->db->where('is_flag', '1');
		return $this->db->count_all_results();
	}

	public function get_uddan_id($order_id)
	{
		$this->db->select('udaan_shipment_id');
		$this->db->from('order_udaan_shipment_id_detail');
		$this->db->where('order_id', $order_id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function check_priority($sender_id)
	{
		$this->db->select('id');
		$this->db->from('logistic_priority');
		$this->db->where('sender_id', $sender_id);
		$query = $this->db->get();
		return $query->row_array();
	}
}

/* End of file Order_model.php */
