<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pincode_serviceability_model extends CI_Model
{
	/**
    * pincode details
    *
    * @return  result_array pincode_details 
	* controller: Pincode_serviceability
	* view : pincode_serviceability 
    */
	public function get_pincode_details($your_pincode,$check_pincode,$userId, $userType)
	{
		$where =  "(pm.pincode = '".$your_pincode."' OR pm.pincode = '".$check_pincode."')";
		if($userType == '4'){
			$this->db->select('pm.pincode,pd.is_cod,pd.is_prepaid,pd.is_pickup,pd.is_reverse_pickup,lm.id as logistic_id_master,lm.logistic_name,lm.api_name,als.logistic_id as logistic_id_assign,als.sender_id');
			$this->db->from('pincode_detail AS pd');
			$this->db->join('pincode_master AS pm', 'pd.pincode_id=pm.id');
			$this->db->join('assign_logistic_sender AS als', 'pd.logistic_id=als.logistic_id');
			$this->db->join('logistic_master AS lm', 'lm.id = als.logistic_id');
			$this->db->WHERE($where);
			$this->db->WHERE('als.sender_id',$userId);
		}else{
			$this->db->select('pm.pincode,pd.is_cod,pd.is_prepaid,pd.is_pickup,pd.is_reverse_pickup,lm.id as logistic_id_master,lm.logistic_name,lm.api_name');
			$this->db->from('pincode_detail AS pd');
			$this->db->join('pincode_master AS pm', 'pd.pincode_id=pm.id');
			$this->db->join('logistic_master AS lm', 'lm.id = pd.logistic_id');
			$this->db->WHERE($where);
		}
		$this->db->WHERE('lm.is_active','1');
			$query = $this->db->get();
			return $query->result_array();
    }  
}

/* End of file Pincode_serviceability_model.php */