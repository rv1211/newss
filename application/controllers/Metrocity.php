<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Metrocity extends Auth_Controller
{    
    public $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Metrocity_model');
        $this->customer_id = $this->session->userdata('userId');
        //Do your magic here
    }

    /**
     * loadview coommon fucntion for load a view
     *
     * @param   string  $viewname  name of view that need to load
     * @param   array  $data      Data that passes to view
     * @return  view  load a view 
     */
    public function loadview(string $viewname, $data = "")
    {
        
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/metrocity/' .$viewname, $data);
        $this->load->view('admin/template/footer');
        
    }
     /**
     * add metrocity view load
     *
     * @return  view  load add metrocity form
     */
    public function index($data="")
    {
        $this->loadview("metrocity_form",$data);
    }

    /**
     * logisctic list datatable
     *
     * @return  datatable  load all logistic in database
     */
    public function metrocity_list()
    {
        $columns = array();
        $table = 'metrocity_master';
        $primaryKey = 'id';

        $columns[0] = array('db' => 'id', 'dt' => 0, 'field' => 'id');
        $columns[1] = array('db' => 'metrocity_name', 'dt' => 1, 'field' => 'metrocity_name');
        $columns[2] = array('db' => 'is_active', 'dt' => 2, 'field' => 'is_active', 'formatter' => function ($d, $row) {
            if ($row[2] == '0') {
                return "Inactive";
            } elseif ($row[2] == '1') {
                return "Active";
            }
        });
        $columns[3] = array('db' => 'id', 'dt' => 3, 'field' => 'id' ,'formatter' => function ($d, $row) {
            $action = "<button type='button' data-id='".$row[3]."' data-name='".$row[1]."' class='edit btn-raised btn-sm btn btn-success btn-floating waves-effect waves-classic waves-effect waves-light'>
            <i class='icon md-edit' aria-hidden='true'></i></button>";
            if ($row[2] == '1') {
                $action .= "<a href='" . base_url('manage-metrocity/status/'.$row[0])."'>
                <button type='button' class='btn btn-danger btn-sm ladda-button waves-effect waves-classic'>
                Inactive</button></a>";
            }else{
                $action .= "<a href='" . base_url('manage-metrocity/status/'.$row[0])."'>
                <button type='button' class='btn btn-primary btn-sm ladda-button waves-effect waves-classic'style='width:70px;'>
                Active</button></a>";
            }
           return $action;

          });          
          echo json_encode(
            SSP::simple($_GET, $table, $primaryKey, $columns)
          ); 
    }

    /**
     * add & update metrocity
     *
     */
    public function add_metrocity()
    {
        $id = $this->input->post('metrocity_id');
        $validation = [
            ['field' => 'metrocity_name', 'label' => 'Metrocity Name', 'rules' => 'required|is_unique[metrocity_master.metrocity_name]']
        ];
        $this->form_validation->set_rules($validation);

        if ($this->form_validation->run() == FALSE) {
            $this->data['errors'] = $this->form_validation->error_array();
            $this->index($this->data);
        } else {
            $metrocity = [
                'metrocity_name' => $this->input->post('metrocity_name'),
                'updated_by' => $this->customer_id,
            ];
            if($id != '0'){
                $result = $this->Common_model->update($metrocity,'metrocity_master',array('id'=>$id));
                if($result)
                {
                    $this->session->set_flashdata('message',"Metrocity Updated Successfully");
                }else{
                    $this->session->set_flashdata('error',"Something went wrong"); 
                }
                redirect('manage-metrocity');

            }else{
                $metrocity = ['metrocity_name' => $this->input->post('metrocity_name'),
                'updated_by' => $this->customer_id,
                'created_by' => $this->customer_id ];

                $result1 = $this->Common_model->insert($metrocity,'metrocity_master');
                if($result1)
                {
                    $this->session->set_flashdata('message',"Metrocity Inserted Successfully");
                }else{
                    $this->session->set_flashdata('error',"Something went wrong");
                }
                redirect('manage-metrocity');
            }
                
        }
    }

    // change status of metrocity name
    public function change_user_status()
    {
        $id = $this->uri->segment(3);
        $user_status = $this->Common_model->getSingle_data('id,is_active', 'metrocity_master', array('id' => $id));
        if($user_status['is_active'] == '0') {
            $user_status = '1';
        } else {
            $user_status = '0';
        }
        $update_status = [
            'is_active' => $user_status,
            'updated_by' => $_SESSION['userId'],
        ];
        $city_status_data = $this->Common_model->update($update_status, 'metrocity_master', array('id' => $id));
        if ($city_status_data) {
            $this->session->set_flashdata('message', "Metrocity Status Update Successfully");
        }else{
            $this->session->set_flashdata('error',"Something went wrong");
        }
        redirect('manage-metrocity');
    }
}

/* End of file metrocity_master.php */