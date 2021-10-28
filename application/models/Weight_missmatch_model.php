<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Weight_missmatch_model extends CI_Model
{
	public function get_order_data($awbnumbers)
	{
		$this->db->select('fom.id,fom.sender_id,fom.customer_order_no,fom.logistic_id,fom.order_no,,fom.order_type,fom.order_type,fom.awb_number,fom.created_date,fom.total_shipping_amount,lm.logistic_name,opd.physical_weight,opd.volumetric_weight,opd.cod_amount,sam.pincode as pickup_pincode,ra.pincode as receiver_pincode,oad.order_status_id');
		$this->db->from('forward_order_master as fom');
		$this->db->join('logistic_master as lm', 'lm.id = fom.logistic_id');
		$this->db->join('order_product_detail as opd', 'opd.id = fom.order_product_detail_id');
		$this->db->join('sender_address_master as sam', 'sam.id = fom.pickup_address_id');
		$this->db->join('receiver_address as ra', 'ra.id = fom.deliver_address_id');
		$this->db->join('order_airwaybill_detail as oad', 'oad.order_id = fom.id');

		$this->db->where_in('fom.awb_number', $awbnumbers);

		$query = $this->db->get();
		return $query->result_array();
	}

	public function insert_history_index($id, $logistic_id)
	{
		$data = [
			'date' => date('Y-m-d'),
			'created_by' => $id,
			'logistic_id' => $logistic_id
		];
		$this->db->insert('weight_missmatch_master', $data);
		return $this->db->insert_id();
	}


	public function insert_missmatch_record($data)
	{
		return $this->db->insert_batch('weight_missmatch_detail', $data);
	}

	public function get_history($userid, $usertype)
	{
		$this->db->select('weight_missmatch_master.*,lm.logistic_name');
		$this->db->from('weight_missmatch_master');
		$this->db->join('logistic_master as lm', 'weight_missmatch_master.logistic_id = lm.id');
		if ($usertype == '4') {
			$this->db->join('weight_missmatch_detail', 'weight_missmatch_detail.missmatch_id = weight_missmatch_master.id');
			$this->db->where('weight_missmatch_detail.sender_id', $userid);
		}
		$query = $this->db->get();

		return $query->result_array();
	}


	public function get_missmatch_data($id)
	{
		$this->db->select('fom.id,fom.sender_id,fom.customer_order_no,fom.logistic_id,fom.order_no,,fom.order_type,fom.order_type,fom.awb_number,fom.created_date,fom.total_shipping_amount,lm.logistic_name,opd.physical_weight,opd.volumetric_weight,opd.cod_amount,sam.pincode as pickup_pincode,ra.pincode as receiver_pincode,oad.order_status_id,wmd.actual_weight,wmd.actual_amount as subtotal');
		$this->db->from('weight_missmatch_detail as wmd');
		$this->db->join('forward_order_master as fom', 'fom.id = wmd.order_id');
		$this->db->join('logistic_master as lm', 'lm.id = fom.logistic_id');
		$this->db->join('order_product_detail as opd', 'opd.id = fom.order_product_detail_id');
		$this->db->join('sender_address_master as sam', 'sam.id = fom.pickup_address_id');
		$this->db->join('receiver_address as ra', 'ra.id = fom.deliver_address_id');
		$this->db->join('order_airwaybill_detail as oad', 'oad.order_id = fom.id');

		$query = $this->db->get();
		return $query->result_array();
	}
}

/* End of file Weight_missmatch.php */
