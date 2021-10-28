<?php

class Ratchat extends CI_Controller {
    public $data;
	/**
	 * construct
	 */
	public function __construct() {
		parent::__construct();
	}
    public function open($resource_id)
    {
        echo "New Resource Connected (".$resource_id.")";
    }
    public function close($resource_id)
    {
        echo "Old Resource Disconnect (".$resource_id.")";
    }
    public function message()
    {        
        $data['status'] = TRUE;        
        switch ($this->input->post('type')) {
            case 'user_logged_in':
                    if ($this->input->post('u_type') == "4" || $this->input->post('u_type') == 4) {
                        $this->db->where('id',$this->input->post('user'));
                        $this->db->update('sender_master',array('is_online' => '2'));
                    }else{
                        $this->db->where('id',$this->input->post('user'));
                        $this->db->update('user_master',array('is_online' => '2'));
                    }
                break;
            case 'user_logged_out':                
                if ($this->input->post('u_type') == "4" || $this->input->post('u_type') == 4) {
                    $this->db->where('id',$this->input->post('user'));
                    $this->db->update('sender_master',array('is_online' => '1'));
                }else{
                    $this->db->where('id',$this->input->post('user'));
                    $this->db->update('user_master',array('is_online' => '1'));
                }   
            default:
                $data['data'] = $this->input->post();
                break;
        }
        echo $response = json_encode($data);        
    }
}