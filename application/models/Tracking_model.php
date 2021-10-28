<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Tracking_model extends CI_Model
{

	public function get_order()
	{
		$this->db->select('fom.awb_number,fom.tracking_id,oad.order_status_id');
		$this->db->from('forward_order_master as fom');
		$this->db->join('order_airwaybill_detail as oad', 'fom.awb_number = oad.airwaybill_no');
		$this->db->join('logistic_master as lm', 'fom.logistic_id =lm.id');
		$this->db->where('fom.is_cancelled', '0');
		$this->db->where('fom.is_delete', '0');
		$this->db->where('lm.api_name', 'Shadowfax_Direct');
		$this->db->where_not_in('oad.order_status_id', ['6', '13', '14']);

		$query = $this->db->get();
		return $query->result_array();
	}
}

/* End of file Tracking_model.php */
