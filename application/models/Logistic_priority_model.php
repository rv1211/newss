<?php 
class Logistic_priority_model extends CI_Model{

    //get logistic from db which assign to particular customer

    public function get_logistic($id){
        $this->db->select('logistic_master.id');
        $this->db->select('logistic_master.logistic_name');
        $this->db->from('logistic_master');
        $this->db->join('assign_logistic_sender','assign_logistic_sender.logistic_id=logistic_master.id');
        $this->db->where('assign_logistic_sender.sender_id',$id);
        $this->db->where('logistic_master.is_active','1');
        // $this->db->group_by('logistic_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    // check order exist or not 
    // of particular logitic

    public function check_order($id){

        $this->db->select('id as fom_id');
        $this->db->from('forward_order_master');
        $this->db->where('logistic_id',$id);
        $query = $this->db->get();
        $result = $query->result_array();
        if(empty($result)){
            $this->db->select('id as temp_id');
            $this->db->from('temp_forward_order_master');
            $this->db->where('logistic_id',$id);
            $query = $this->db->get();
            $result = $query->result_array();
            if(empty($result)){
                $this->db->select('id as bulk_temp_id');
                $this->db->from('temp_order_master');
                $this->db->where('logistic_id',$id);
                $query = $this->db->get();
                $result = $query->result_array();
            }   
        }
        return $result;
    }
}
?>