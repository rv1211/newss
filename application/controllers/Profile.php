<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends Auth_Controller
{
    public $data = array();

        public function __construct()
    {
        parent::__construct();
        $this->userId = $this->session->userdata('userId');
        $this->userType = $this->session->userdata('userType');
    }
    public function loadview($viewname)
    {
        $this->load->view('admin/template/header');
        $this->load->view('admin/profile/' . $viewname, $this->data);
        $this->load->view('admin/template/footer');
    }
    // view my_profile form
    public function index()
    {
        $table_name = ($this->userType == 4) ? 'sender_master':'user_master';  
        $this->data['user_data'] = $this->Common_model->getSingleRowArray(array('id' => $this->userId), '*', $table_name);
        $this->loadview('my_profile', $this->data);
    }

    // update profile data
    public function manage_my_profile()
    {
        if(!empty($this->input->post('password')) || !empty($this->input->post('fullname')) || !empty($this->input->post('phone')) || !empty($this->input->post('website'))){
             $validation = [
                ['field' => 'fullname', 'label' => 'Full Name', 'rules' => 'required'],
                ['field' => 'phone', 'label' => 'Mobile Number', 'rules' => 'required|min_length[10]'],
                ['field' => 'password', 'label' => 'Password', 'rules' => 'min_length[8]|max_length[16]']
            ];
            if($this->userType == 4)
            {
                $table_name = 'sender_master';
                $edit_user['name'] = $this->input->post('fullname');
                $edit_user['mobile_no'] = $this->input->post('phone');
                $edit_user['website'] = $this->input->post('website');
                if (!empty($this->input->post('password'))) {
                    $edit_user['password'] = $this->input->post('password');
                }

            }else{
                $table_name = 'user_master';
                $edit_user['name'] = $this->input->post('fullname');
                $edit_user['user_mobile_no'] = $this->input->post('phone');
                if($this->userType == 1){
                    if(!empty($this->input->post('user_type'))){

                        $edit_user['user_type'] = $this->input->post('user_type');
                    }
                }
                if (!empty($this->input->post('password'))) {
                     $edit_user['user_password'] = $this->input->post('password');
                 }
            }
            $this->form_validation->set_rules($validation);
            
            if ($this->form_validation->run() == false) {
                $this->data['errors'] = $this->form_validation->error_array();
                $this->index();
            }else{
                $result = $this->Common_model->update($edit_user, $table_name, array('id' => $this->input->post('id')));
                
                if ($result) {
                    $this->session->set_flashdata('message', "Profile Update Successfully");
                    redirect('profile','refresh');
                }else{
                    $this->session->set_flashdata('error', "Something Went Wrong");
                    redirect('profile','refresh');
                }
            }

        }else{
             redirect('profile','refresh');
        }
        

    }

}

/* End of file profile.php */