<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Manage_user extends Auth_Controller
{
    public $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->library('encryption');
        //Do your magic here
    }

    /**
     * loadview coommon fucntion for load a view
     *
     * @param   string  $viewname  name of view that need to load
     * @param   array  $data      Data that passes to view
     *
     * @return  view        load a view 
     */
    public function loadview(string $viewname, $data = "")
    {

        $this->load->view('admin/template/header');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/manage_user/' . $viewname, $this->data);
        $this->load->view('admin/template/footer');
    }
    /**
     * add user view load
     *
     * @return  view  load add logistic form
     */
    public function index($data = "")
    {
        $this->loadview("manage_user_form");
    }

    // add user in database

    public function add_user()
    {
        //form validation using CI
        $validation = [
            ['field' => 'user_type', 'label' => 'User Type', 'rules' => 'required'],
            ['field' => 'fullname', 'label' => 'Full Name', 'rules' => 'required'],
            ['field' => 'phone', 'label' => 'Mobile Number', 'rules' => 'required|min_length[10]'],
            ['field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email|is_unique[user_master.user_email]|is_unique[sender_master.email]'],
            ['field' => 'password', 'label' => 'Password', 'rules' => 'required|min_length[8]|max_length[16]'],
        ];
        $this->form_validation->set_rules($validation);
        if ($this->form_validation->run() == false) {
            $this->data['errors'] = $this->form_validation->error_array();
            $this->loadview("add_user_form", $this->data);
        } else {
            if (isset($_POST['is_active'])) {
                $active = '1';
            } else {
                $active = '0';
            }
            $insert_user = [
                'user_type' => $this->input->post('user_type'),
                'name' => $this->input->post('fullname'),
                'user_email' => $this->input->post('email'),
                'user_password' => trim($this->input->post('password')),
                'user_mobile_no' => $this->input->post('phone'),
                'is_active' => $active,
                'created_by' => $_SESSION['userId'],
                'updated_by' => $_SESSION['userId'],
            ];
            $user_result = $this->Common_model->insert($insert_user, 'user_master');
            if ($user_result) {
                $this->session->set_flashdata('message', "User Inserted Successfully");
            } else {
                $this->session->set_flashdata('message', "Something Went Wrong");
            }
            redirect('manage-user', 'refresh');
        }
    }

    //list of user
    public function user_list()
    {

        $columns = array();
        $table = 'user_master';
        $primaryKey = 'id';
        $where = "";
        $joinQuery = '';

        $columns[0] = array('db' => 'id', 'dt' => 0, 'field' => 'id');
        $columns[1] = array('db' => 'name', 'dt' => 1, 'field' => 'name');
        $columns[2] = array('db' => 'user_mobile_no', 'dt' => 2, 'field' => 'user_mobile_no');
        $columns[3] = array('db' => 'user_email', 'dt' => 3, 'field' => 'user_email');
        $columns[4] = array('db' => 'user_type', 'dt' => 4, 'field' => 'user_type', 'formatter' => function ($d, $row) {
            if ($row[4] == '2') {
                return "Member";
            } elseif ($row[4] == '1') {
                return "Admin";
            } elseif ($row[4] == '3') {
                return "Accountant";
            }
        });
        $columns[5] = array('db' => 'is_active', 'dt' => 5, 'field' => 'is_active', 'formatter' => function ($d, $row) {
            if ($row[5] == '0') {
                return "In Active";
            } elseif ($row[5] == '1') {
                return "Active";
            }
        });
        $columns[6] = array('db' => 'id', 'dt' => 6, 'field' => 'id', 'formatter' => function ($d, $row) {

            $action = "<a href='" . base_url('manage-user/edit/' . $row[0]) . "'>
            <button type='button' class='btn btn-primary btn-sm ladda-button waves-effect waves-classic'>
            <i class='icon md-edit' aria-hidden='true'></i></button></a>";
            if ($row[5] == 0) {
                $action .= "<a href='" . base_url('manage-user/change_status/' . $row[0]) . "'>
                <button type='button' class='btn btn-primary btn-sm ladda-button waves-effect waves-classic' style='width:84px;'>
                Activate</button></a>";
            } else {
                $action .= "<a href='" . base_url('manage-user/change_status/' . $row[0]) . "'>
                <button type='button' class='btn btn-danger btn-sm ladda-button waves-effect waves-classic'>
                Deactivate</button></a>";
            }
            return $action;
        });

        echo json_encode(
            SSP::simple($_GET, $table, $primaryKey, $columns)
        );
    }


    public function user_profile()
    {

        $id = $this->uri->segment(3);
        $this->data['user_data'] = $this->Common_model->getDatabyId($id, 'user_master', 'id');

        if ($this->input->post()) {
            $validation = [
                ['field' => 'user_type', 'label' => 'User Type', 'rules' => 'required'],
                ['field' => 'fullname', 'label' => 'Full Name', 'rules' => 'required'],
                ['field' => 'phone', 'label' => 'Mobile Number', 'rules' => 'required|min_length[10]'],
            ];
            if ($this->input->post('password') != '') {
                $edit_user['user_password'] = trim($this->input->post('password'));
                $validation[] = ['field' => 'password', 'label' => 'Password', 'rules' => 'required|min_length[8]|max_length[16]'];
            }
            if ($this->data['user_data']->user_email != $this->input->post('email')) {
                $validation[] = ['field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email|is_unique[user_master.user_email]|is_unique[sender_master.email]'];
            }
            $this->form_validation->set_rules($validation);
            if ($this->form_validation->run() == false) {
                $this->data['errors'] = $this->form_validation->error_array();
                $this->loadview("edit_user_form", $this->data);
            } else {
                if (isset($_POST['is_active'])) {
                    $active = '1';
                } else {
                    $active = '0';
                }
                $edit_user['user_type'] = $this->input->post('user_type');
                $edit_user['name'] = $this->input->post('fullname');
                $edit_user['user_email'] = $this->input->post('email');
                $edit_user['user_mobile_no'] = $this->input->post('phone');
                $edit_user['is_active'] = @$active;
                $edit_user['updated_by'] = @$_SESSION['userId'];
                $user_result = $this->Common_model->update($edit_user, 'user_master', array('id' => $_POST['id']));
                if ($user_result) {
                    $this->session->set_flashdata('message', "User Update Successfully");
                    redirect('manage-user', 'refresh');
                }
            }
        } else {

            $this->loadview("edit_user_form", $this->data);
        }
    }

    //change status of user
    public function change_user_status()
    {
        $id = $this->uri->segment(3);
        $user_status = $this->Common_model->getSingle_data('id,is_active', 'user_master', array('id' => $id));

        if ($user_status['is_active'] == '0') {
            $user_status = '1';
        } else {
            $user_status = '0';
        }

        $update_status = [
            'is_active' => $user_status,
            'updated_by' => $_SESSION['userId'],
        ];
        $user_status_data = $this->Common_model->update($update_status, 'user_master', array('id' => $id));
        if ($user_status_data) {
            $this->session->set_flashdata('message', "User Status Update Successfully");
            redirect('manage-user', 'refresh');
        }
    }
}

/* End of file manage user.php */