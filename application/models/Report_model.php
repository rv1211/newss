<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Report_model extends CI_Model
{

	public function get_daily_shipment_count($status_id, $today, $fromday, $userType = "", $userId = "", $is_cod = "", $is_all = "")
	{
		if ($status_id == 1 || $is_all == 1) {
			$data = "fom.order_no,fom.customer_order_no,fom.awb_number as awb_number,'Forward' AS shipment_type,ra.name as customer_name,ra.mobile_no as customer_mobile_no,concat(ra.address_1,ra.address_2) as reciver_address,ra.city as city,ra.pincode as pincode,ra.state as state,(CASE WHEN fom.order_type = '0' THEN 'Prepaid' ELSE 'COD' END) as order_type,(opd.product_value * opd.product_quantity) as cod_amount,lm.logistic_name as logistic_name,os.status_name as order_status, opd.product_name as product_name,opd.product_value as product_value,opd.product_quantity as product_quantity,opd.physical_weight,fom.total_shipping_amount as total_shipping_amount,fom.created_date as created_date,oad.updateDate as last_status_date,sm.name as sender_name,sm.email as sender_email,sam.contact_person_name as pickup_username,sam.contact_no as pickup_contact,concat(sam.address_line_1,address_line_2) as pickup_address,sam.pincode as pickup_pincode,sam.city as pickup_city, sam.state as pickup_state,sam.warehouse_name as warehouse";

			$where = ("(DATE_FORMAT(fom.created_date,'%m/%d/%Y') BETWEEN '" . $fromday . "' AND '" . $today . "')");
			// $group_by = ("DATE_FORMAT(oad.createDate,'%Y-%m-%d'),status_id");
		} else {
			$data = "fom.order_no,fom.customer_order_no,fom.awb_number as awb_number,'Forward' AS shipment_type,ra.name as customer_name,ra.mobile_no as customer_mobile_no,concat(ra.address_1,ra.address_2) as reciver_address,ra.city as city,ra.pincode as pincode,ra.state as state,,(CASE WHEN fom.order_type = '0' THEN 'Prepaid' ELSE 'COD' END) as order_type,(opd.product_value * opd.product_quantity) as cod_amount,lm.logistic_name as logistic_name,os.status_name as order_status, opd.product_name as product_name,opd.product_value as product_value,opd.product_quantity as product_quantity,opd.physical_weight,fom.total_shipping_amount as total_shipping_amount,fom.created_date as created_date,oad.updateDate as last_status_date,sm.name as sender_name,sm.email as sender_email";

			$where = ("(DATE_FORMAT(oad.updateDate,'%m/%d/%Y') BETWEEN '" . $fromday . "' AND '" . $today . "')");
			// $group_by = ("DATE_FORMAT(oad.updateDate,'%Y-%m-%d'),status_id");
		}
		$this->db->select($data);
		$this->db->from('forward_order_master as fom');
		$this->db->join('order_airwaybill_detail as oad', 'fom.id = oad.order_id');
		$this->db->join('sender_master as sm', 'fom.sender_id = sm.id');
		$this->db->join('sender_address_master as sam', 'fom.pickup_address_id = sam.id');
		$this->db->join('receiver_address as ra', 'fom.deliver_address_id = ra.id');
		$this->db->join('order_product_detail as opd', 'fom.order_product_detail_id = opd.id');
		$this->db->join('logistic_master as lm', 'fom.logistic_id = lm.id');
		$this->db->join('order_status as os', 'os.order_status_id = oad.order_status_id');
		$this->db->where_in('oad.order_status_id', $status_id);
		if ($today != '' || $fromday != '') {
			$this->db->where($where);
		}
		if ($userType == 4) {
			$this->db->where('fom.sender_id', $userId);
		}
		if ($is_cod != "" && $is_cod == "1") {
			$this->db->where('fom.order_type', '1');
		}
		// $this->db->where('fom.is_pre_awb', '0');
		$this->db->where('fom.is_delete', '0');
		// $this->db->group_by($group_by);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_all_ndr_comment_details($from_date, $to_date, $usertype, $customer_id = "")
	{
		$where = "";
		if ($usertype != 1) {
			$where .= " AND fom.sender_id = '" . $customer_id . "'";
		}
		$sql = "SELECT fom.order_no,fom.customer_order_no, fom.awb_number, ra.name, ra.mobile_no,(opd.product_quantity * opd.product_value), lm.logistic_name, ncd.created_date, ncd.admin_comment, ncd.admin_update_datetime, ncd.client_comment, ncd.client_update_datetime , sm.email
		FROM ndr_comment_detail AS ncd
		LEFT JOIN forward_order_master AS fom ON fom.id=ncd.order_id
		LEFT JOIN receiver_address AS ra ON ra.id =fom.deliver_address_id
		LEFT JOIN order_product_detail AS opd ON opd.id=fom.order_product_detail_id
        LEFT JOIN logistic_master  AS lm ON lm.id =  fom.logistic_id
        LEFT JOIN sender_master AS sm ON sm.id = fom.sender_id
		WHERE (ncd.client_comment != '' ||  ncd.admin_comment != '') AND (ncd.created_date BETWEEN '" . $from_date . "' AND '" . $to_date . "')" . $where;
		$query = $this->db->query($sql);
		return $query->result();
	}
}

/* End of file ModelName.php */
