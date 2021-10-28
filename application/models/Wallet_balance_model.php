<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Wallet_balance_model extends CI_Model
{
	public function get_users($usertype, $userid)
	{
		$this->db->select('sm.id,sm.name,sm.email');
		$this->db->from('sender_master as sm');
		$this->db->where('is_active', '1');
		$this->db->where('status', '1');
		if ($usertype != '1') {
			$this->db->join('kyc_verification_master as kym', 'kym.sender_id = sm.id');
			$this->db->where('kym.created_by', $userid);
		}
		$query = $this->db->get();
		return $query->result();
	}
}

/* End of file Wallet_balance_model.php */
