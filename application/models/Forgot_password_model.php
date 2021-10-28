<?php
class Forgot_password_model extends CI_Model
{

    public function check_valid_email($email)
    {
        $this->db->select('*');
        $this->db->from('sender_master');
        $this->db->where('sender_master.email', $email);
        $query = $this->db->get();

        if (isset($query->result_array()[0]['email']) && $query->result_array()[0]['email'] == $email) {
            return 'sender';
        } else {
            $this->db->select('*');
            $this->db->from('user_master');
            $this->db->where('user_master.user_email', $email);
            $query1 = $this->db->get();
            $userEmail = $query1->result_array();
            if (isset($userEmail[0]['user_email']) && $userEmail[0]['user_email'] == $email) {
                return 'user';
            } else {
                return false;
            }
        }
    }
    public function check_exist($email)
    {
        $this->db->select('*');
        $this->db->from('user_email');
        $this->db->where('user_email.email', $email);
        $query = $this->db->get();
        if (isset($query->result_array()[0]['email']) && $query->result_array()[0]['email'] == $email) {
            return true;
        } else {
            return false;
        }
    }
    public function check_valid_string($string)
    {
        $this->db->select('email,type');
        $this->db->from('user_email');
        $this->db->where('user_email.string', $string);
        $query = $this->db->get();
        return $query->row();
    }

    public function check_for_delete($string)
    {
        $this->db->select('string,created_at, updated_at');
        $this->db->from('user_email');
        $this->db->where('user_email.string', $string);
        $query = $this->db->get();
        return $query->row();
    }
}