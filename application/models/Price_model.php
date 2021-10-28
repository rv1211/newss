<?php

class Price_model extends CI_Model{

    public function get_sender_price_data($logistic_id,$customer_id){
       // dd($logistic_id);
        $this->db->select('sender_manage_price.*,logistic_master.logistic_name,rule_master.name,rule_master.id as rule_name');
        $this->db->from('sender_manage_price');
        $this->db->join('logistic_master','logistic_master.id=sender_manage_price.logistic_id', 'INNER');
        $this->db->join('rule_master','rule_master.id=sender_manage_price.rule', 'INNER');
        $this->db->where('sender_manage_price.sender_id', $customer_id);       
        $this->db->where_in('sender_manage_price.logistic_id', $logistic_id); 
        $query = $this->db->get(); 
        return $query->result_array();
    }

    public function get_ship_price_data($logistic_id,$manage_price_data){
        $this->db->select('manage_price.*,logistic_master.logistic_name,rule_master.name,rule_master.id as rule_name');
        $this->db->from('manage_price');
        $this->db->join('logistic_master','logistic_master.id=manage_price.logistic_id', 'INNER');
        $this->db->join('rule_master','rule_master.id=manage_price.rule', 'INNER');
        $this->db->where_in('manage_price.logistic_id',$logistic_id);
        if(empty($manage_price_data)){
            $this->db->where_not_in('manage_price.id','');
        }else{
            $this->db->where_not_in('manage_price.id',$manage_price_data);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_wallet_transaction_by_id($id) {
		$this->db->select('*');
		$this->db->from('wallet_transaction');
		$this->db->where('user_id', $id);
		$this->db->order_by('id', 'desc');
		$info = $this->db->get();
		return $info->result();
	}

    public function get_logistic($user_id)
    {
        $this->db->select('logistic_id');
        $this->db->from('assign_logistic_sender');
        $this->db->where('sender_id',$user_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_logistic_details($where)
    {
        $this->db->select("*");
        $this->db->from('logistic_master');
        $this->db->where_in('id',$where);
        $this->db->where('is_active','1');
        $query = $this->db->get();
        return $query->result();
        // lq();
    }  
    

    public function get_ship_price_data1($logistic_id,$manage_price_data){
            $this->db->select('*');
            $this->db->from('manage_price');
            $this->db->where('logistic_id', $logistic_id);
            $this->db->where_not_in('id',$manage_price_data);
            $query = $this->db->get();
            return $query->result_array();
    }

    public function get_all_price_data($user_id,$logistic_id){
       
        $this->db->select('manage_price_id');
        $this->db->from('sender_manage_price');
        $this->db->where('sender_id',$user_id);
        $this->db->where('logistic_id',$logistic_id);
        $query = $this->db->get(); 
        $data= $query->result_array();
        if($data){
            return $data;
        }else{
            $data = "";
            return $data;
        }

    }

    public function get_assing_logistic($customer_id){
        $this->db->select('logistic_id');
        $this->db->from('assign_logistic_sender');
        $this->db->where('sender_id',$customer_id);
        $query = $this->db->get();
        return $query->result_array();
    }
}