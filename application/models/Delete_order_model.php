<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Delete_order_model extends CI_Model
{

	public function get_order_details()
	{
		$sql = "(SELECT '0' as type,fom.id,fom.is_refund,fom.order_no,fom.awb_number,fom.order_type,fom.updated_date,fom.paid_amount,sm.name As user,sm.email As email,lm.api_name as apiname,ra.name,ra.mobile_no FROM `forward_order_master` AS fom JOIN sender_master AS sm ON sm.id=fom.sender_id JOIN receiver_address As ra ON ra.sender_id=fom.sender_id JOIN logistic_master AS lm ON fom.logistic_id=lm.id WHERE (fom.is_delete = '1' AND fom.is_pre_awb = '0' ) GROUP By fom.order_no) UNION ALL (SELECT '1' as type,'1' as na,eom.id,eom.order_no,eom.awb_number,eom.order_type,eom.updated_date,eom.paid_amount,sm.name As user,sm.email As email,lm.api_name as apiname,ra.name,ra.mobile_no FROM `error_order_master` AS eom JOIN sender_master AS sm ON sm.id=eom.sender_id JOIN receiver_address As ra ON ra.sender_id=eom.sender_id JOIN logistic_master AS lm ON eom.logistic_id=lm.id WHERE (eom.is_delete = '1' AND eom.is_pre_awb = '0') GROUP By eom.order_no)";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	public function get_excel_data($ids)
	{
		$order_no = '"' . implode('", "', $ids) . '"';
		$sql = "(SELECT fom.order_no,fom.awb_number,lm.api_name as apiname,ra.name,sm.email As email,ra.mobile_no,(CASE WHEN fom.order_type = '0' THEN 'Prepaid' ELSE 'COD' END) as order_type,fom.updated_date,fom.paid_amount,sm.name As user FROM `forward_order_master` AS fom JOIN sender_master AS sm ON sm.id=fom.sender_id JOIN receiver_address As ra ON ra.sender_id=fom.sender_id JOIN logistic_master AS lm ON fom.logistic_id=lm.id WHERE( fom.order_no IN (" . $order_no . ") AND fom.is_delete = '1' AND fom.is_pre_awb = '0' ) GROUP By fom.order_no) UNION ALL (SELECT eom.order_no,eom.awb_number,lm.api_name as apiname,ra.name,sm.email As email,ra.mobile_no,(CASE WHEN eom.order_type = '0' THEN 'Prepaid' ELSE 'COD' END) as order_type,eom.updated_date,eom.paid_amount,sm.name As user FROM `error_order_master` AS eom JOIN sender_master AS sm ON sm.id=eom.sender_id JOIN receiver_address As ra ON ra.sender_id=eom.sender_id JOIN logistic_master AS lm ON eom.logistic_id=lm.id WHERE (eom.order_no IN (" . $order_no . ") AND eom.is_delete = '1' AND eom.is_pre_awb = '0') GROUP By eom.order_no)";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function delete_checked_forward($forward_array)
	{
		$this->db->where_in('order_no', $forward_array);
		$this->db->where('is_pre_awb', '0');
		return $this->db->delete('forward_order_master');
	}
	public function delete_checked_error($error_array)
	{
		$this->db->where_in('order_no', $error_array);
		$this->db->where('is_pre_awb', '0');
		return $this->db->delete('error_order_master');
	}
}

/* End of file Delete_order_model.php */