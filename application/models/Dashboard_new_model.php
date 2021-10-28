<?php
class Dashboard_new_model extends CI_Model
{
    public function get_all_logistics($userId, $userType)
    {
        $this->db->select('lm.id,lm.logistic_name');
        $this->db->from('logistic_master as lm');
        if ($userType == 4) {
            $this->db->join('assign_logistic_sender as als', 'lm.id = als.logistic_id');
            $this->db->where('als.sender_id', $userId);
        }
        $this->db->where('lm.is_active', '1');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_today_order_count($today, $fromday, $status_id, $userId, $userType)
    {
        if (in_array('1', $status_id)) {
            $where = ("(DATE_FORMAT(oad.createDate,'%Y-%m-%d') BETWEEN '" . $fromday . "' AND '" . $today . "')");
        } else {
            $where = ("(DATE_FORMAT(oad.updateDate,'%Y-%m-%d') BETWEEN '" . $fromday . "' AND '" . $today . "')");
        }
        $this->db->select('count(fom.id) as totalCount, oad.order_status_id');
        $this->db->from('forward_order_master as fom');
        $this->db->join('order_airwaybill_detail as oad', 'fom.id = oad.order_id');
        $this->db->join('order_status as os', 'os.order_status_id = oad.order_status_id');
        if ($today != '' || $fromday != '') {
            $this->db->where($where);
        }
        if ($userType == 4) {
            $this->db->where('fom.sender_id', $userId);
        }
        $this->db->where('fom.is_pre_awb', '0');
        $this->db->where('fom.is_delete', '0');
        if (!empty($status_id)) {
            $this->db->where_in('oad.order_status_id', $status_id);
            $this->db->group_by('oad.order_status_id');
            $query = $this->db->get();
            return $query->result_array();
        } else {
            $this->db->where_in('oad.order_status_id', array('3', '5', '6', '9', '10', '11', '12', '13', '14'));
            return $this->db->count_all_results();
        }
    }

    public function get_daily_shipment_count($status_id, $today, $fromday, $userType, $userId, $logistic)
    {
        if ($status_id == 1) {
            $data = "DATE_FORMAT(oad.createDate, '%Y-%m-%d') As createdate, count(oad.createDate) As status_count,oad.order_status_id As status_id";
            $where = ("(DATE_FORMAT(oad.createDate,'%Y-%m-%d') BETWEEN '" . $fromday . "' AND '" . $today . "')");
            $group_by = ("DATE_FORMAT(oad.createDate,'%Y-%m-%d'),status_id");
        } else {
            $data = "DATE_FORMAT(oad.updateDate, '%Y-%m-%d') As updatedate ,count(oad.updateDate) As status_count,oad.order_status_id As status_id";
            $where = ("(DATE_FORMAT(oad.updateDate,'%Y-%m-%d') BETWEEN '" . $fromday . "' AND '" . $today . "')");
            $group_by = ("DATE_FORMAT(oad.updateDate,'%Y-%m-%d'),status_id");
        }
        $this->db->select($data);
        $this->db->from('forward_order_master as fom');
        $this->db->join('order_airwaybill_detail as oad', 'fom.id = oad.order_id');
        $this->db->join('order_status as os', 'os.order_status_id = oad.order_status_id');
        $this->db->where_in('oad.order_status_id', $status_id);
        if ($today != '' || $fromday != '') {
            $this->db->where($where);
        }
        if ($userType == 4) {
            $this->db->where('fom.sender_id', $userId);
        }
        if ($logistic != '0') {
            $this->db->where('fom.logistic_id', $logistic);
        }
        $this->db->where('fom.is_pre_awb', '0');
        $this->db->where('fom.is_delete', '0');
        $this->db->group_by($group_by);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_carrier_performance_count($status_id, $today, $fromday, $userType, $userId)
    {
        if (!empty($status_id)) {
            $data = "count(oad.updateDate) As status_count,oad.order_status_id As status_id,lm.logistic_name,lm.api_name";
        } else {
            $data = "count(*) As status_count,lm.logistic_name,lm.api_name";
        }
        $where = ("(DATE_FORMAT(oad.updateDate,'%Y-%m-%d') BETWEEN '" . $fromday . "' AND '" . $today . "')");

        $this->db->select($data);
        $this->db->from('forward_order_master as fom');
        $this->db->join('logistic_master as lm', 'lm.id = fom.logistic_id');
        $this->db->join('order_airwaybill_detail as oad', 'fom.id = oad.order_id');
        $this->db->join('order_status as os', 'os.order_status_id = oad.order_status_id');
        if (!empty($status_id)) {
            $this->db->where_in('oad.order_status_id', $status_id);
        } else {
            $this->db->where_in('oad.order_status_id', array('3', '5', '6', '9', '10', '11', '12', '13', '14'));
        }
        if ($today != '' || $fromday != '') {
            $this->db->where($where);
        }
        if ($userType == 4) {
            $this->db->where('fom.sender_id', $userId);
        }
        $this->db->where('lm.is_active', '1');
        $this->db->where('fom.is_pre_awb', '0');
        $this->db->where('fom.is_delete', '0');
        if (!empty($status_id)) {
            $this->db->group_by('status_id,lm.logistic_name');
        } else {
            $this->db->group_by('lm.logistic_name');
        }
        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_chart_count($today, $fromday, $status_id, $userType, $userId)
    {
        if ($status_id == '1') {
            $where = ("(DATE_FORMAT(oad.createDate,'%Y-%m-%d') BETWEEN '" . $fromday . "' AND '" . $today . "')");
        } else {
            $where = ("(DATE_FORMAT(oad.updateDate,'%Y-%m-%d') BETWEEN '" . $fromday . "' AND '" . $today . "')");
        }
        $this->db->from('forward_order_master as fom');
        $this->db->join('order_airwaybill_detail as oad', 'fom.id = oad.order_id');
        $this->db->join('order_status as os', 'os.order_status_id = oad.order_status_id');
        if (!empty($status_id)) {
            $this->db->where_in('oad.order_status_id', $status_id);
        }
        if ($today != '' || $fromday != '') {
            $this->db->where($where);
        }
        if ($userType == 4) {
            $this->db->where('fom.sender_id', $userId);
        }
        $this->db->where('fom.is_pre_awb', '0');
        $this->db->where('fom.is_delete', '0');
        return $this->db->count_all_results();
    }

    public function get_cod_remittanace_count($get_shipping_amount, $today, $fromday, $userId, $userType)
    {
        $where = ("(DATE_FORMAT(oad.updateDate,'%Y-%m-%d') BETWEEN '" . $fromday . "' AND '" . $today . "')");
        if ($get_shipping_amount == '1') {
            $this->db->select('AVG(`fom`.`total_shipping_amount`) As shipping_amount');
        } else {
            $this->db->select('sum(opd.cod_amount) As cod_amount,fom.is_cod_remittance ,oad.updateDate');
        }
        $this->db->from('forward_order_master as fom');
        $this->db->join('order_airwaybill_detail as oad', 'fom.id = oad.order_id');
        $this->db->join('order_product_detail as opd', 'fom.order_product_detail_id = opd.id');
        if ($today != '' || $fromday != '') {
            $this->db->where($where);
        }
        if ($userType == 4) {
            $this->db->where('fom.sender_id', $userId);
        }
        $this->db->where('fom.order_type', '1');
        if ($get_shipping_amount == '3') {
            $this->db->where('fom.is_pre_awb', '0');
            $this->db->where('fom.is_delete', '0');
            $this->db->where('oad.order_status_id', '6');
            $this->db->where('fom.is_cod_remittance', '0');
        }
        if ($get_shipping_amount == '2') {
            $this->db->where('fom.is_cod_remittance', '1');
        }
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_cod_year_chart_count($userType, $userId)
    {

        $this->db->select('MONTHNAME(oad.updateDate) AS month_name,sum(opd.cod_amount) as cod_amount');
        $this->db->from('forward_order_master as fom');
        $this->db->join('order_product_detail as opd', 'opd.id = fom.order_product_detail_id');
        $this->db->join('order_airwaybill_detail as oad', 'fom.id = oad.order_id');
        $this->db->where('fom.is_cancelled', '0');
        $this->db->where('oad.order_status_id', '6');
        $this->db->where('fom.is_delete', '0');
        $this->db->where('fom.order_type', '1');
        $this->db->where('fom.is_pre_awb', '0');

        if ($userType == 4) {

            $this->db->where('fom.sender_id', $userId);
        }
        $this->db->where('YEAR(oad.updateDate)', 'YEAR(CURDATE())', false);
        $this->db->GROUP_BY('MONTH(oad.updateDate)', 'asc');


        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_today_order_count_preawb($today, $fromday, $status_id, $userId, $userType)
    {
        if (in_array('1', $status_id)) {
            $where = ("(DATE_FORMAT(oad.createDate,'%Y-%m-%d') BETWEEN '" . $fromday . "' AND '" . $today . "')");
        } else {
            $where = ("(DATE_FORMAT(oad.updateDate,'%Y-%m-%d') BETWEEN '" . $fromday . "' AND '" . $today . "')");
        }
        $this->db->select('count(fom.id) as totalCount, oad.order_status_id');
        $this->db->from('forward_order_master as fom');
        $this->db->join('order_airwaybill_detail as oad', 'fom.id = oad.order_id');
        $this->db->join('order_status as os', 'os.order_status_id = oad.order_status_id');
        if ($today != '' || $fromday != '') {
            $this->db->where($where);
        }
        if ($userType == 4) {
            $this->db->where('fom.sender_id', $userId);
        }
        $this->db->where('fom.is_pre_awb', '1');
        $this->db->where('fom.is_delete', '0');
        if (!empty($status_id)) {
            $this->db->where_in('oad.order_status_id', $status_id);
            $this->db->group_by('oad.order_status_id');
            $query = $this->db->get();
            return $query->result_array();
        } else {
            $this->db->where_in('oad.order_status_id', array('3', '5', '6', '9', '10', '11', '12', '13', '14'));
            return $this->db->count_all_results();
        }
    }
}
