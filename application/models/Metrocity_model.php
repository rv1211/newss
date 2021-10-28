<?php

class Metrocity_model extends CI_Model{

    public function dublicate_metrocity_name($metrocity_name, $id){
    if($id != ''){
        $sql = "SELECT id FROM metrocity_master WHERE metrocity_name='$metrocity_name' AND id != '$id'";
      } else{
        $sql = "SELECT id FROM metrocity_master WHERE metrocity_name='$metrocity_name'";
      }
        $query = $this->db->query($sql);
        if ($query->num_rows($query) > 0) {
            return 'false';
        } else {
            return 'true';
        }
      } 
}