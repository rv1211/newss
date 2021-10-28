<?php

use Ratchet\Server\EchoServer;

class Create_singleorder_awb extends CI_Model
{
    //get logistic which assign to customer
    public function get_logistic($id)
    {
        if ($this->session->userdata('userType') == '1') {
            $this->db->select('id,logistic_name');
            $this->db->from('logistic_master');
            $this->db->where('is_active', '1');
        } else {
            $this->db->select('logistic_master.id');
            $this->db->select('logistic_master.logistic_name');
            $this->db->from('logistic_master');
            $this->db->join('logistic_priority', 'logistic_priority.logistic_id=logistic_master.id');
            $this->db->where('logistic_priority.sender_id', $id);
            $this->db->where('logistic_master.is_active', '1');
            $this->db->group_by('id');
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    //get pickup address of customer
    public function get_pickup_address($id)
    {
        $this->db->select('id,warehouse_name');
        $this->db->from('sender_address_master');
        $this->db->where('sender_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function chek_exist_pincode($pincodes)
    {
        $this->db->select('id');
        $this->db->from('pincode_master');
        $this->db->where('pincode', $pincodes);
        $query = $this->db->get();
        return  $query->row();
    }

    public function insert($data, $table)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function get_name_from_id($logistic_name)
    {
        $this->db->select('id');
        $this->db->from('logistic_master');
        $this->db->where('logistic_master.logistic_name', $logistic_name);
        $this->db->where('logistic_master.is_active', '1');
        $query = $this->db->get();
        return  $query->row();
    }

    public function get_user_aviliblity($logistic_id_of_user, $userId)
    {
        $this->db->select('sender_id,logistic_id');
        $this->db->from('sender_manage_price');
        $this->db->where('sender_manage_price.logistic_id', $logistic_id_of_user);
        $this->db->where('sender_manage_price.sender_id', $userId);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_awb($awb_number, $logistic_id, $awb_type)
    {

        $logistic_name = $this->Common_model->getSingle_data('logistic_name,id,api_name', 'logistic_master', array('id' => $logistic_id));
        // lq();
        $logisticName = str_replace(' ', '_', strtolower(trim($logistic_name['api_name'])));
        $this->db->select('awb_number,is_used,type');
        $this->db->from($logisticName . "_airwaybill");
        $this->db->like('awb_number', $awb_number);
        $this->db->where('is_used', '1');
        $this->db->where('type', $awb_type);
        $query = $this->db->get();
        return $query->row();
    }


    public function get_logistic_by_pincode($logistic_id_of_user, $is_valid_pincode)
    {
        $this->db->select('*');
        $this->db->from('pincode_detail');
        $this->db->where('logistic_id', $logistic_id_of_user);
        $this->db->where('pincode_id', $is_valid_pincode);
        $query = $this->db->get();
        return $query->row();
    }

    public function getall_data_by_process()
    {
        $this->db->select('tom.*');
        $this->db->from('temp_order_master as tom');
        $this->db->where('is_pre_awb', '1');
        $this->db->where('is_process', '0');
        $this->db->where('is_flag', '0');
        $query = $this->db->get();
        return $query;
    }

    public function get_zship_id($id)
    {

        $this->db->select('zship_sender_id');
        $this->db->from('sender_address_master');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function check_awb($awb_no, $ordertype, $userId)
    {

        if ($ordertype == 1 || $ordertype == '1' || $ordertype == 'cod') {
            $type = '1';
        } else {
            $type = '2';
        }
        $this->db->select('logistic_master.id,logistic_master.api_name,logistic_master.logistic_name');
        $this->db->from('logistic_master');
        $this->db->join('assign_logistic_sender', 'assign_logistic_sender.logistic_id=logistic_master.id');
        $this->db->where('assign_logistic_sender.sender_id', $userId);
        $this->db->where('logistic_master.is_active', '1');
        $this->db->group_by('id');
        $query = $this->db->get();
        $logistic_array = $query->result_array();

        if (!empty($logistic_array)) {
            foreach ($logistic_array as $logisticvalue) {
                $logistic_id = $logisticvalue['id'];
                $logisticName = str_replace(' ', '_', strtolower(trim($logisticvalue['api_name'])));
                // dd($logisticName);
                if ($logisticName) {
                    $table = $logisticName . "_airwaybill";
                    if ($this->db->table_exists($table)) {
                        $this->db->select('awb_number,is_used');
                        $this->db->from($logisticName . '_airwaybill');
                        $this->db->like('awb_number', $awb_no);
                        if ($logisticName != 'udaan_direct') {
                            $this->db->where('type', $type);
                        }
                        $this->db->where('is_used', '1');
                        $this->db->where('for_what', '1');
                        $query_logistic = $this->db->get();
                        // lq();
                        if ($query_logistic->num_rows($query_logistic) > 0) {
                            return $logisticvalue;
                        }
                    }
                }
            }
        }
    }
    public function get_multiple_order_list($order_id)
    {

        $this->db->select('ot.*, ra.name, ra.email, ra.mobile_no, ra.address_1, ra.address_2, ra.city, ra.state, ra.pincode, opd.id as productId, opd.physical_weight, opd.cod_amount, opd.product_name, opd.product_quantity, opd.product_value,opd.volumetric_weight,opd.length,opd.width,opd.height, opd.package_count, opd.product_sku, sam.sender_id,sam.zship_sender_id,sam.id as pickup_id,sam.contact_no as pickup_contactNo,sam.warehouse_name as pickup_warehouseName,sam.contact_person_name as pickup_contactName,sam.address_line_1 as pickup_address_1,sam.address_line_2 as pickup_address_2,sam.pincode as pickup_pincode,sam.state as pickup_state,sam.city as pickup_city,lm.logistic_name,lm.api_name, sam.udaan_sender_orgid');
        $this->db->from('temp_forward_order_master AS ot');
        $this->db->join('receiver_address  AS ra ', 'ra.id=ot.deliver_address_id', 'INNER');
        $this->db->join('order_product_detail  AS opd ', 'opd.id=ot.order_product_detail_id', 'INNER');
        $this->db->join('logistic_master as lm', 'ot.logistic_id=lm.id');
        $this->db->join('sender_address_master  AS sam ', 'sam.id=ot.pickup_address_id', 'INNER');
        $this->db->where_in('ot.id', $order_id);

        $query = $this->db->get();
        return $query->row_array();
    }
    public function get_multiple_order_list_bulk($order_id)
    {
        $this->db->select('ot.*, ra.name, ra.email, ra.mobile_no, ra.address_1, ra.address_2, ra.city, ra.state, ra.pincode, opd.id as productId, opd.physical_weight, opd.cod_amount, opd.product_name, opd.product_quantity, opd.product_value,opd.volumetric_weight,opd.length,opd.width,opd.height, opd.package_count, opd.product_sku, sam.sender_id,sam.zship_sender_id,sam.id as pickup_id,sam.contact_no as pickup_contactNo,sam.warehouse_name as pickup_warehouseName,sam.contact_person_name as pickup_contactName,sam.address_line_1 as pickup_address_1,sam.address_line_2 as pickup_address_2,sam.pincode as pickup_pincode,sam.state as pickup_state,sam.city as pickup_city,lm.logistic_name,lm.api_name, sam.udaan_sender_orgid');
        $this->db->from('temp_order_master AS ot');
        $this->db->join('receiver_address  AS ra ', 'ra.id=ot.deliver_address_id', 'INNER');
        $this->db->join('order_product_detail  AS opd ', 'opd.id=ot.order_product_detail_id', 'INNER');
        $this->db->join('logistic_master as lm', 'ot.logistic_id=lm.id');
        $this->db->join('sender_address_master  AS sam ', 'sam.id=ot.pickup_address_id', 'INNER');
        $this->db->where_in('ot.id', $order_id);

        $query = $this->db->get();
        return $query->row_array();
    }
    public function get_order_data($order_id, $table_name)
    {
        $this->db->select('ot.*, ra.name, ra.email, ra.mobile_no, ra.address_1, ra.address_2, ra.city, ra.state, ra.pincode, opd.id as productId, opd.physical_weight, opd.cod_amount, opd.product_name, opd.product_quantity, opd.product_value,opd.volumetric_weight,opd.length,opd.width,opd.height, opd.package_count, opd.product_sku, sam.sender_id,sam.zship_sender_id,sam.id as pickup_id,sam.contact_no as pickup_contactNo,sam.warehouse_name as pickup_warehouseName,sam.contact_person_name as pickup_contactName,sam.address_line_1 as pickup_address_1,sam.address_line_2 as pickup_address_2,sam.pincode as pickup_pincode,sam.state as pickup_state,sam.city as pickup_city,lm.logistic_name,lm.api_name, sam.udaan_sender_orgid');
        $this->db->from($table_name . ' AS ot');
        $this->db->join('receiver_address  AS ra ', 'ra.id=ot.deliver_address_id', 'INNER');
        $this->db->join('order_product_detail  AS opd ', 'opd.id=ot.order_product_detail_id', 'INNER');
        $this->db->join('logistic_master as lm', 'ot.logistic_id=lm.id');
        $this->db->join('sender_address_master  AS sam ', 'sam.id=ot.pickup_address_id', 'INNER');
        $this->db->where_in('ot.id', $order_id);

        $query = $this->db->get();
        return $query->row_array();
    }

    public function user_by_get_logistic($userId)
    {
        $this->db->select('lm.id,lm.logistic_name');
        $this->db->from('logistic_master as lm');
        $this->db->join('assign_logistic_sender as sam', 'lm.id = sam.logistic_id');
        $this->db->group_by('lm.logistic_name');
        $this->db->where('sender_id', $userId);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_type_exist($check_with_log_id_type, $awb_types_in, $awb_type)
    {
        $this->db->select('*');
        $this->db->from('pincode_detail');
        $this->db->where('pincode_id', $check_with_log_id_type);
        $this->db->where($awb_type, $awb_types_in);
        $query = $this->db->get();
        return $query->row();
    }

    public function check_logistic_exist($logistic_id, $awb_no)
    {
        $logistic_name = $this->Common_model->getSingle_data('logistic_name,id,api_name', 'logistic_master', array('id' => $logistic_id));
        $logisticName = str_replace(' ', '_', strtolower(trim($logistic_name['api_name'])));
        if (isset($logisticName) && $logisticName != "") {
            $this->db->select('awb_number,is_used');
            $this->db->from($logisticName . '_airwaybill');
            $this->db->where('awb_number', $awb_no);
            $this->db->where('is_used', '1');
            $query = $this->db->get();
            return $query->row_array();
        }
    }


    public function check_in_temp_awb($awb, $logistic_id)
    {
        $this->db->select('*');
        $this->db->from('temp_order_master');
        $this->db->where('awb_number', $awb);
        $this->db->where('logistic_id', $logistic_id);
        $query = $this->db->get();
        return $query->row();
    }


    public function is_pincode_for_pickup($check_with_log_id_type)
    {
        $this->db->select('*');
        $this->db->from('pincode_detail');
        $this->db->where('pincode_id', $check_with_log_id_type);
        $this->db->where('is_pickup', '1');
        $query = $this->db->get();
        return $query->row();
    }


    public function get_all_data_by_id($userId)
    {
        $this->db->select('sam.id,sam.sender_id,sam.warehouse_name,sam.contact_person_name,sam.contact_no,sam.contact_email as email,sam.website,sam.address_line_1,sam.address_line_2,sam.pincode,sam.state,sam.city');
        $this->db->from('sender_address_master as sam');
        $this->db->where('sam.sender_id', $userId);
        $query = $this->db->get();
        return $query->result_array();
    }

    // check logistic_id by user
    public function check_logistic_id_by_user($logistic_id, $userId)
    {
        $this->db->select('als.id');
        $this->db->from('assign_logistic_sender as als');
        $this->db->where('sender_id', $userId);
        $this->db->where('logistic_id', $logistic_id);
        $query = $this->db->get();
        return $query->row();
    }

    // validation
    public function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
    public function required($str)
    {
        return is_array($str)
            ? (empty($str) === FALSE)
            : (trim($str) !== '');
    }
    public function min_length($str, $val)
    {
        if (!is_numeric($val)) {
            return FALSE;
        }
        return ($val <= mb_strlen($str));
    }
    public function max_length($str, $val)
    {
        if (!is_numeric($val)) {
            return FALSE;
        }

        return ($val >= mb_strlen($str));
    }
    public function exact_length($str, $val)
    {
        if (!is_numeric($val)) {
            return FALSE;
        }

        return (mb_strlen($str) === (int) $val);
    }
    public function valid_url($str)
    {
        if (empty($str)) {
            return FALSE;
        } elseif (preg_match('/^(?:([^:]*)\:)?\/\/(.+)$/', $str, $matches)) {
            if (empty($matches[2])) {
                return FALSE;
            } elseif (!in_array(strtolower($matches[1]), array('http', 'https'), TRUE)) {
                return FALSE;
            }

            $str = $matches[2];
        }

        // Apparently, FILTER_VALIDATE_URL doesn't reject digit-only names for some reason ...
        // See https://github.com/bcit-ci/CodeIgniter/issues/5755
        if (ctype_digit($str)) {
            return FALSE;
        }

        // PHP 7 accepts IPv6 addresses within square brackets as hostnames,
        // but it appears that the PR that came in with https://bugs.php.net/bug.php?id=68039
        // was never merged into a PHP 5 branch ... https://3v4l.org/8PsSN
        if (preg_match('/^\[([^\]]+)\]/', $str, $matches) && !is_php('7') && filter_var($matches[1], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== FALSE) {
            $str = 'ipv6.host' . substr($str, strlen($matches[1]) + 2);
        }

        return (filter_var('http://' . $str, FILTER_VALIDATE_URL) !== FALSE);
    }
    public function valid_email($str)
    {
        if (function_exists('idn_to_ascii') && preg_match('#\A([^@]+)@(.+)\z#', $str, $matches)) {
            $domain = defined('INTL_IDNA_VARIANT_UTS46')
                ? idn_to_ascii($matches[2], 0, INTL_IDNA_VARIANT_UTS46)
                : idn_to_ascii($matches[2]);

            if ($domain !== FALSE) {
                $str = $matches[1] . '@' . $domain;
            }
        }

        return (bool) filter_var($str, FILTER_VALIDATE_EMAIL);
    }
    public function valid_emails($str)
    {
        if (strpos($str, ',') === FALSE) {
            return $this->valid_email(trim($str));
        }

        foreach (explode(',', $str) as $email) {
            if (trim($email) !== '' && $this->valid_email(trim($email)) === FALSE) {
                return FALSE;
            }
        }

        return TRUE;
    }
    public function alpha($str)
    {
        return ctype_alpha($str);
    }
    public function alpha_numeric($str)
    {
        return ctype_alnum((string) $str);
    }
    public function alpha_numeric_spaces($str)
    {
        return (bool) preg_match('/^[A-Z0-9 ]+$/i', $str);
    }
    public function alpha_dash($str)
    {
        return (bool) preg_match('/^[a-z0-9_-]+$/i', $str);
    }
    public function numeric($str)
    {
        return (bool) preg_match('/^[\-+]?[0-9]*\.?[0-9]+$/', $str);
    }
    public function integer($str)
    {
        return (bool) preg_match('/^[\-+]?[0-9]+$/', $str);
    }
    public function decimal($str)
    {
        return (bool) preg_match('/^[\-+]?[0-9]+\.[0-9]+$/', $str);
    }
    public function greater_than($str, $min)
    {
        return is_numeric($str) ? ($str > $min) : FALSE;
    }
    public function greater_than_equal_to($str, $min)
    {
        return is_numeric($str) ? ($str >= $min) : FALSE;
    }
    public function less_than($str, $max)
    {
        return is_numeric($str) ? ($str < $max) : FALSE;
    }
    public function less_than_equal_to($str, $max)
    {
        return is_numeric($str) ? ($str <= $max) : FALSE;
    }

    public function debit_wallet($amount_wallet, $amount_credit, $sender_id)
    {
        $data = [
            'wallet_balance' => $amount_wallet,
            'allow_credit_limit' => $amount_credit
        ];
        $this->db->where('id', $sender_id);
        $this->db->update('sender_master', $data);
        return true;
    }

    public function delete_direct_amount($amount, $sender_id)
    {
        $data = [
            "wallet_balance" => $amount,
        ];
        $this->db->where('id', $sender_id);
        $this->db->update('sender_master', $data);
        return true;
    }

    public function delete_awb($awb_no, $awb_table)
    {
        // dd(trim($awb_table));
        $this->db->where('awb_number', $awb_no);
        $this->db->delete(trim($awb_table) . "_airwaybill");
        // lq();
        return true;
    }

    public function get_all_order_data($order_id, $bulk)
    {

        $this->db->select('*');
        if ($bulk == 1) {
            $this->db->from('temp_order_master');
        } else {
            $this->db->from('temp_forward_order_master');
        }
        $this->db->where('id', $order_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_amount($order_charage, $order_id, $bulk)
    {
        $data = [
            'paid_amount' => $order_charage,
            'remain_amount' => 00
        ];
        $this->db->where('id', $order_id);
        if ($bulk == 1) {
            $this->db->update('temp_order_master', $data);
        } else {
            $this->db->update('temp_forward_order_master', $data);
        }

        // $this->db->update('temp_forward_order_master', $data);

        return true;
    }

    public function move_order($order_id, $order_data, $status, $bulk = 0, $order_number = '', $error_log = '')
    {

        $this->db->where('id', $order_id);
        if ($bulk == 1) {
            $this->db->delete('temp_order_master');
        } else {
            $this->db->delete('temp_forward_order_master');
        }
        unset($order_data[0]['id']);
        unset($order_data[0]['updated_date']);
        unset($order_data[0]['created_date']);
        unset($order_data[0]['is_process']);
        unset($order_data[0]['is_flag']);
        // unset($order_data[0]['is_pre_awb']);
        unset($order_data[0]['error_message']);
        unset($order_data[0]['is_created']);
        if (empty($order_data[0]['customer_order_no'])) {
            $order_data[0]['customer_order_no'] = $order_number;
        }
        if ($status == 1) {
            $query = $this->db->insert('forward_order_master', $order_data[0]);
        } else {
            $query = $this->db->insert('error_order_master', $order_data[0]);
            $error_order_id = $this->db->insert_id();
            $logarr = array(
                'order_Error_id' => $error_order_id,
                'error' => $error_log
            );
            $log_query = $this->db->insert('order_error_log', $logarr);
        }
        return $query;
    }

    public function insert_barcode($object)
    {
        $this->db->insert('order_airwaybill_detail', $object);
    }

    public function get_awbno($awb_table, $type)
    {
        $logistic_name = $awb_table . "_airwaybill";
        $this->db->select('awb_number');
        $this->db->from($logistic_name);
        $this->db->where('is_used', '1');
        $this->db->where('type', $type);
        $this->db->where('for_what', '2');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    public function update_awb($order_id, $awno)
    {
        $object = ['awb_number' => $awno];
        $this->db->where('id', $order_id);
        $this->db->update('temp_forward_order_master', $object);
        return true;
    }

    public function update_order_status($order_id, $bulk)
    {
        if ($bulk) {
            $data =  [
                'is_created' => '1'
            ];
            $this->db->where('id', $order_id);
            $this->db->update('temp_order_master', $data);
        } else {
            $data =  [
                'is_created' => '1'
            ];
            $this->db->where('id', $order_id);
            $this->db->update('temp_forward_order_master', $data);
        }
    }

    public function get_wallet_info($id, $bulk)
    {
        if ($bulk == 0) {
            $this->db->select('sm.id as sender_id,sm.email,sm.wallet_balance,sm.allow_credit,sm.allow_credit_limit,tm.total_shipping_amount,tm.igst_amount,tm.cgst_amount,tm.sgst_amount,tm.id as order_id,tm.order_no as order_no,tm.awb_number,tm.order_type,lm.logistic_name as logistic_name,lm.api_name as api_name');
            $this->db->from('temp_forward_order_master as tm');
            $this->db->join('sender_master  as sm', 'tm.sender_id = sm.id');
            $this->db->join('logistic_master as lm', 'tm.logistic_id = lm.id');
            $this->db->where('tm.id', $id);
            $query = $this->db->get();
            return $query->row_array();
        } else {
            $this->db->select('sm.id as sender_id,sm.email,sm.wallet_balance,sm.allow_credit,sm.allow_credit_limit,tm.total_shipping_amount,tm.igst_amount,tm.cgst_amount,tm.sgst_amount,tm.id as order_id,tm.order_no as order_no,tm.awb_number,tm.order_type,lm.logistic_name as logistic_name,lm.api_name as api_name');
            $this->db->from('temp_order_master as tm');
            $this->db->join('sender_master  as sm', 'tm.sender_id = sm.id');
            $this->db->join('logistic_master as lm', 'tm.logistic_id = lm.id');
            $this->db->where('tm.id', $id);
            $query = $this->db->get();
            return $query->row_array();
        }
    }

    public function update_tranction($data)
    {
        $this->db->insert('wallet_transaction', $data);
        return true;
    }
    // end 
}
