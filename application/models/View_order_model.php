<?php
class View_order_model extends CI_Model
{

	public function get_count($status)
	{
		$customer_id =  $this->session->userdata['userId'];
		$count_admin_query = $this->db->select('COUNT(*) AS `numrows`, order_airwaybill_detail.order_status_id');
		$this->db->from('forward_order_master');
		$this->db->join('order_airwaybill_detail', 'order_airwaybill_detail.order_id = forward_order_master.id', 'left');
		$this->db->where('forward_order_master.is_reverse', '0');
		$this->db->where('forward_order_master.is_cancelled', '0');
		$this->db->where('forward_order_master.is_delete', '0');
		$this->db->where('forward_order_master.is_pre_awb', '0');
		if ($this->session->userdata['userType'] != '1') {
			$this->db->where('forward_order_master.sender_id', $customer_id);
		}
		if ($status != "") {
			$this->db->where_in('order_airwaybill_detail.order_status_id', $status);
			$this->db->group_by('order_airwaybill_detail.order_status_id');
			$query = $this->db->get();
			return $query->result_array();
		} else {
			return $this->db->count_all_results();
		}
	}

	public function get_count_data($status)
	{
		// dd($_SESSION);
		if ($this->session->userdata['userType'] == '1') {
			$count_admin_query = $this->db->select('*');
			$this->db->from('forward_order_master');
			$this->db->join('order_airwaybill_detail', 'order_airwaybill_detail.order_id = forward_order_master.id', 'left');
			$this->db->where('forward_order_master.is_reverse', '0');
			$this->db->where('forward_order_master.is_cancelled', '0');
			$this->db->where('forward_order_master.is_pre_awb', '0');
			if ($status != "") {
				$this->db->where('order_airwaybill_detail.order_status_id', $status);
			}
			return $this->db->count_all_results();
		} else {
			$customer_id =  $this->session->userdata['userId'];
			$count_cus_query =  $this->db->select('*');
			$this->db->from('forward_order_master');
			$this->db->join('order_airwaybill_detail', 'order_airwaybill_detail.order_id = forward_order_master.id', 'left');
			$this->db->where('forward_order_master.is_reverse', '0');
			$this->db->where('forward_order_master.is_cancelled', '0');
			$this->db->where('forward_order_master.is_pre_awb', '0');
			if ($status != "") {
				$this->db->where('order_airwaybill_detail.order_status_id', $status);
			}
			// $this->db->where('created_by',$customer_id);
			// $query = $this->db->get();lq();
			return $this->db->count_all_results();
		}
	}

	public function getOrder_details($order_id)
	{
		$this->db->select('order_product_detail.product_quantity,order_product_detail.product_name,receiver_address.*,sender_master.name as sendername,sender_master.mobile_no as sendermobile,forward_order_master.order_no,forward_order_master.order_type,forward_order_master.awb_number,forward_order_master.customer_order_no,forward_order_master.total_shipping_amount,order_product_detail.cod_amount');
		$this->db->from('forward_order_master');
		$this->db->join('receiver_address', 'forward_order_master.deliver_address_id=receiver_address.id');
		$this->db->join('sender_master', 'sender_master.id=forward_order_master.sender_id');
		$this->db->join('order_product_detail', 'order_product_detail.id=forward_order_master.order_product_detail_id');
		$this->db->where('forward_order_master.id', $order_id);

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_onprocess_data($userId, $userType)
	{
		if ($userType != '1') {
			$this->db->where('sender_id', $userId);
		}
		$this->db->select('*');
		$this->db->from('temp_forward_order_master');
		$this->db->where('is_created', '1');
		$this->db->where('is_pre_awb', '0');

		return $this->db->count_all_results();
	}

	public function get_error_data($userId, $userType)
	{

		$this->db->select('id');
		$this->db->from('error_order_master');
		// $this->db->where('is_created','1');
		if ($userType != '1') {
			$this->db->where('sender_id', $userId);
		}
		$this->db->where('is_delete', '0');
		$this->db->where('is_pre_awb', '0');
		return $this->db->count_all_results();
	}

	public function get_intransit_order_count($status)
	{

		$status_all = explode(",", $status);

		if ($this->session->userdata['userType'] == '1') {
			$count_admin_query = $this->db->select('*');
			$this->db->from('forward_order_master');
			$this->db->join('order_airwaybill_detail', 'order_airwaybill_detail.order_id = forward_order_master.id', 'left');
			$this->db->where('forward_order_master.is_reverse', '0');
			$this->db->where('forward_order_master.is_cancelled', '0');
			$this->db->where('forward_order_master.is_pre_awb', '0');
			$this->db->where('forward_order_master.is_delete', '0');

			if ($status != "") {
				$this->db->where_in('order_airwaybill_detail.order_status_id', $status_all);
			}
			return $this->db->count_all_results();
		} else {
			$customer_id =  $this->session->userdata['userId'];
			$count_cus_query =  $this->db->select('*');
			$this->db->from('forward_order_master');
			$this->db->join('order_airwaybill_detail', 'order_airwaybill_detail.order_id = forward_order_master.id', 'left');
			$this->db->where('forward_order_master.is_reverse', '0');
			$this->db->where('forward_order_master.is_cancelled', '0');
			$this->db->where('forward_order_master.is_pre_awb', '0');
			$this->db->where('forward_order_master.is_delete', '0');

			$this->db->where('forward_order_master.sender_id', $customer_id);
			if ($status != "") {
				$this->db->where_in('order_airwaybill_detail.order_status_id', $status_all);
			}
			return $this->db->count_all_results();
		}
	}

	public function get_waiting_order_data($userId, $userType)
	{

		$this->db->select('id');
		$this->db->from('temp_order_master');
		// $this->db->where('is_created','1');
		if ($userType != '1') {
			$this->db->where('sender_id', $userId);
		}
		$this->db->where('is_flag', '1');
		$this->db->where('is_pre_awb', '0');
		return $this->db->count_all_results();
	}

	public function getTracking_details($order_id)
	{
		$this->db->select('fom.id, otd.*');
		$this->db->from('order_tracking_detail as otd');
		$this->db->join('forward_order_master as fom', 'fom.id = otd.order_id');
		$this->db->where('fom.id', $order_id);
		$sql = $this->db->get();
		return $sql->result_array();
	}

	public function get_ndr_data($order_id)
	{
		$this->db->select('ndr.*,sm.name as sender_name,us.name as user_name');
		$this->db->from('ndr_comment_detail as ndr');
		$this->db->join('user_master as us', 'us.id = ndr.created_by_user', 'left');
		$this->db->join('sender_master as sm', 'sm.id = ndr.created_by_sender', 'left');
		$this->db->where('ndr.order_id', $order_id);
		$sql = $this->db->get();
		return $sql->result_array();
	}

	public function delete_bulk_order($order_id)
	{

		$this->db->where_in('id', $order_id);
		$this->db->delete('error_order_master');
		return  $this->db->affected_rows();
	}
}
