<?php 
class Import_airway_model extends CI_Model{

    public function insert($data,$table) {
        $res = $this->db->insert_batch($table."_airwaybill",$data);
            if($res){
            return TRUE;
            }else{
            return FALSE;
            }
        }


        public function cheak($is_exist,$logicstic)
        {
            // print_r($is_exist);
            $this->db->select('*');
            $this->db->from($logicstic."_airwaybill");
            $this->db->where_in('awb_number',$is_exist);
            $query1 = $this->db->get() ;

            $result = $query1->num_rows();
            // lq();
            // dd($result);
            // lq();
            
            if($result){
                // echo "true";
                return true;
            }
            else{
                // echo "sadsad";
                return false;
            }
        }
}