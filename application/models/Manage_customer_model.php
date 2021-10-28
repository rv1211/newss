<?php
class Manage_customer_model extends CI_Model
{

	// get all pending request 
	public function get_all_pending_customer()
	{
		// $this->db->select('kyc_master.*,kyc_master.created_date,sm.name,sm.website,sm.mobile_no,ba.address_1,ba.city,ba.pincode,sm.email,sm.is_active,sm.status');
		$this->db->select('billing_address.*,kyc_master.*,kyc_master.created_date,sm.name,sm.website,sm.mobile_no,sm.email,sm.is_active,sm.status');

		$this->db->from('kyc_verification_master as kyc_master');
		$this->db->join('sender_master as sm', 'kyc_master.sender_id = sm.id');
		$this->db->join('billing_address as billing_address', 'billing_address.sender_id = kyc_master.sender_id ', 'left outer');
		$this->db->group_by('kyc_master.sender_id');
		$this->db->where('sm.status', '0');
		$query = $this->db->get();
		return $query->result_array();
	}


	// get customer which alllow logistics
	public function get_customer_allow_logistics($id)
	{
		$this->db->select('logistic_id');
		$this->db->from('assign_logistic_sender');
		$this->db->where('sender_id', $id);
		$this->db->group_by('logistic_id');
		$query = $this->db->get();
		return $query->result_array();
	}

	//already inserted logistics
	public function already_inserted_logistics($sender_id)
	{
		$this->db->select('m.logistic_id');
		$this->db->from('assign_logistic_sender as m');
		$this->db->group_by('m.logistic_id');
		$this->db->where('m.sender_id', $sender_id);
		$query = $this->db->get();
		// lq();
		return $query->result_array();
	}

	public function get_particular_pending_customer($id)
	{
		// $this->db->select('kyc_dom.*,kyc.profile_type,kyc.company_type,kyc.company_name,kyc.pan_no,kyc.gst_no,sam.address_1,sam.address_2,sam.pincode,sam.state,sam.city,smaster.status,kyc.created_by');		
		$this->db->select('kyc.*,sam.address_1,sam.address_2,sam.pincode,sam.state,sam.city,smaster.status,smaster.password,smaster.email as semail');
		$this->db->from('kyc_verification_master as kyc');
		$this->db->join('billing_address as sam', 'sam.sender_id = kyc.sender_id', 'right');
		$this->db->join('sender_master as smaster', 'smaster.id =kyc.sender_id', 'right');
		// $this->db->join('kyc_document_master as kyc_dom','kyc_dom.kyc_id = kyc.id','right');		
		$this->db->group_by('kyc.id');
		// $this->db->where('smaster.status','0');
		$this->db->where('smaster.id', $id);
		$query = $this->db->get();
		// lq();
		return  $query->row_array();
	}

	public function get_particular_pending_customer_doc($id)
	{
		// $this->db->select('kyc_dom.*,kyc.profile_type,kyc.company_type,kyc.company_name,kyc.pan_no,kyc.gst_no,sam.address_1,sam.address_2,sam.pincode,sam.state,sam.city,smaster.status,kyc.created_by');		
		$this->db->select('kdm.*, dm.doc_type');
		$this->db->from('kyc_document_master as kdm');
		$this->db->join('document_master as dm', 'dm.id = kdm.doc_id');
		// $this->db->join('sender_master as smaster','smaster.id =kyc.sender_id','right');
		// $this->db->join('kyc_document_master as kyc_dom','kyc_dom.kyc_id = kyc.id','right');		
		// $this->db->group_by('kyc.id');
		// $this->db->where('smaster.status',0);
		$this->db->where('kdm.kyc_id', $id);
		$query = $this->db->get();

		// lq();
		return  $query->result_array();
	}

	public function check_inserted($sender_id, $single_post_logistic_id)
	{
		return $this->db->select('id')->from('assign_logistic_sender')->where('sender_id', $sender_id)->where('logistic_id', $single_post_logistic_id)->get()->result_array();
	}
}
