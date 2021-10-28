<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home_model extends CI_Model
{

	public function insert_user($data)
	{
		return $this->db->insert('registration', $data);
	}

	public function insert_enquiry($data)
	{
		return $this->db->insert('enquiry', $data);
	}

	public function login_check($email, $password)
	{
		$this->db->select('*');
		$this->db->from('registration');
		$this->db->where('email', $email);
		$this->db->where('password', $password);
		$this->db->where('customer_status !=', 'Rejected');
		$info = $this->db->get();
		return $info->row();
	}

	public function check_availablity_user_in_kyc($id)
	{
		$this->db->select('*');
		$this->db->from('kyc_varification');
		$this->db->where('user_id', $id);
		$info = $this->db->get();
		return $info->result();
	}

	public function check_availablity_user_in_address($id)
	{
		$this->db->select('*');
		$this->db->from('pickup_address');
		$this->db->where('user_id', $id);
		$info = $this->db->get();
		return $info->result();
	}
	public function fetch_order_type_from_pincode($pincode)
	{
		$this->db->select('*');
		$this->db->from('pincode_detail');
		$this->db->where('pincode', $pincode);
		$this->db->where('pickup', 1);
		$info = $this->db->get();
		return $info->row();
	}
	public function check_cityin_mertocity($city)
	{
		$this->db->select('*');
		$this->db->from('metrocity_list');
		$this->db->where('metrocity_name', $city);
		$info = $this->db->get();
		return $info->row();
	}
	public function get_zone_by_within_city($distance)
	{
		$sql = "SELECT zone_id
		  FROM zone WHERE zone_within_city = 1  
		  AND zone_end_distance >= '" . $distance . "'
		  AND zone_start_distance <= '" . $distance . "'";
		$query = $this->db->query($sql);
		return $query->row();
	}
	public function get_zone_by_both_metrocity($distance)
	{
		$sql = "SELECT zone_id
		  FROM zone WHERE zone_for = 1  
		  AND zone_end_distance >= '" . $distance . "'
		  AND zone_start_distance <= '" . $distance . "'";
		$query = $this->db->query($sql);
		return $query->row();
	}
	public function get_zone_by_metro_to_other($distance)
	{
		$sql = "SELECT zone_id
		  FROM zone WHERE zone_for = 2  
		  AND zone_end_distance >= '" . $distance . "'
		  AND zone_start_distance <= '" . $distance . "'";
		$query = $this->db->query($sql);
		return $query->row();
	}
	public function get_zone_by_other($distance)
	{
		$sql = "SELECT zone_id
		  FROM zone WHERE zone_within_city = 0  
		  AND zone_end_distance >= '" . $distance . "'
		  AND zone_start_distance <= '" . $distance . "'";
		$query = $this->db->query($sql);
		return $query->row();
	}

	public function getDatabyId($id, $zone_id, $id_name)
	{
		$sql = "SELECT value FROM manage_shipping_price WHERE zone_id=" . $zone_id . " AND $id_name = " . $id;
		$query = $this->db->query($sql);
		if ($query->num_rows($query) > 0) {
			return $query->row();
		}
	}

	public function checkDuplicateEmail($email, $id)
	{
		if (isset($id) && $id > 0)
			$sql = 'SELECT id FROM sender_master WHERE email="' . $email . '" AND id != "' . $id . '"';
		else
			$sql = 'SELECT id FROM sender_master WHERE esmail="' . $email . '"';
		$query = $this->db->query($sql);
		if ($query->num_rows($query) > 0) {
			return 'false';
		} else {
			return 'true';
		}
	}

	public function get_info($awb_number)
	{
		$this->db->select("oad.order_id,oad.order_status_id,oad.updateDate
		,os.status_name,ra.*,lm.api_name");
		$this->db->from('order_airwaybill_detail as oad');
		$this->db->join('order_status as os', 'os.order_status_id = oad.order_status_id');
		$this->db->join('forward_order_master as fom', 'fom.id = oad.order_id');
		$this->db->join('receiver_address as ra', 'ra.id = fom.deliver_address_id');
		$this->db->join('logistic_master as lm', 'lm.id = fom.logistic_id');
		$this->db->like('oad.airwaybill_no', $awb_number);
		$query = $this->db->get();
		// lq();
		return $query->row();
	}
}
