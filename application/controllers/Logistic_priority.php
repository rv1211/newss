<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Logistic_priority extends Auth_Controller
{    
    public $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Logistic_priority_model');
        $this->customer_id = $this->session->userdata('userId');
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

        $this->load->view('admin/logistic_priority/' . $viewname, $data);
        $this->load->view('admin/template/footer');
        
    }
     /**
     * add logistic view load
     *
     * @return  view  load add logistic form
     */
    public function index()
    {   
        $this->data['logistics'] = $this->Logistic_priority_model->get_logistic(@$this->session->userdata['userId']);
        if($this->input->post()){
            $validation = [
                ['field' => 'logistic_name', 'label' => 'Logistic Name', 'rules' => 'required'],
                ['field' => 'priority_set', 'label' => 'priority set', 'rules' => 'required|numeric'],
            ];
            $this->form_validation->set_rules($validation);
    
            if ($this->form_validation->run() == FALSE) {
                $this->data['errors'] = $this->form_validation->error_array();
                // dd($this->form_validation->error_array());
                $this->loadview("priority_form",$this->data);
            } else {
                $logistic = $this->Common_model->getSingle_data('logistic_id', 'logistic_priority', array('sender_id' => $this->customer_id, 'logistic_id' => $this->input->post('logistic_name')));
                if(!empty($logistic)){
                    $this->data['errors']['logistic_name'] = 'Priority alredy Set of this Logistic';
                }
                $logisticPriority = $this->Common_model->getSingle_data('priority', 'logistic_priority', array('sender_id' => $this->customer_id, 'priority' => $this->input->post('priority_set')));
                if(!empty($logisticPriority)){
                    $this->data['errors']['priority_set'] = 'This Priority alredy Set for other Logistic';
                }
                if(!empty($this->data['errors'])){
                    // dd($logisticPriority);
                    $this->loadview("priority_form",$this->data);
                } else{
                    $logisticarr = [
                        'logistic_id' => $this->input->post('logistic_name'),
                        'priority' => $this->input->post('priority_set'),
                        'sender_id' => $this->session->userdata['userId'],
                    ];
        
                    $result = $this->Common_model->insert($logisticarr,'logistic_priority');
                    if($result)
                    {
                        $this->session->set_flashdata('message',"Logistic Priority Inserted Successfully"); 
                    }else{
                        $this->session->set_flashdata('error',"Something went wrong");
                    }
                    redirect('logistic-priority');
                }
            }
        }else{
            $this->loadview("priority_form",$this->data);
        }
    }

    /**
     * logisctic list datatable
     *
     * @return  datatable  load all logistic in database
     */
    public function loadlogistics_priority()
    {
        $columns = array();
        $table = 'logistic_priority';
        $primaryKey = 'id';

        $columns[0] = array('db' => 'lm.logistic_name', 'dt' => 0, 'field' => 'logistic_name');
        $columns[1] = array('db' => 'priority', 'dt' => 1, 'field' => 'priority');
        $columns[2] = array('db' => 'lp.id', 'dt' => 2, 'field' => 'id' ,'formatter' => function ($d, $row) {
            $action = "<a href='".base_url('logistic-priority/delete/'.$row[2])."'><button type='button' id='delete_btn' class='btn-raised btn-sm btn btn-danger btn-floating waves-effect waves-classic waves-effect waves-light'><i class='icon md-delete' aria-hidden='true'></i></button></a>"; 
            
           return $action;

          });
          $join_query = "FROM {$table} AS lp INNER JOIN logistic_master AS lm ON lp.logistic_id=lm.id";
          $where = "lp.sender_id=".$this->session->userdata['userId'];
          $joinQuery=$join_query;
          
          echo json_encode(
            SSP::simple($_GET, $table, $primaryKey, $columns,$joinQuery,$where)
          ); 
    }

    /**
     * add logistic to database
     *
     * @return  view  return to add logicstic form after login
     */
    // public function addlogistic_priority()
    // {
    //     if($this->input->post()){
    //         // $validation = [
    //         //     ['field' => 'logistic_name', 'label' => 'Logistic Name', 'rules' => 'required|is_unique[logistic_priority.logistic_id.sender_id.'.$this->customer_id.']'],
    //         //     ['field' => 'priority_set', 'label' => 'priority set', 'rules' => 'required|numeric|is_unique[logistic_priority.priority.logistic_id.sender_id.'.$this->customer_id.']'],
    //         // ];
    //         $validation = [
    //             ['field' => 'logistic_name', 'label' => 'Logistic Name', 'rules' => 'required]'],
    //             ['field' => 'priority_set', 'label' => 'priority set', 'rules' => 'required|numeric]'],
    //         ];
    //         $this->form_validation->set_rules($validation);
    
    //         if ($this->form_validation->run() == FALSE) {
    //             $this->data['errors'] = $this->form_validation->error_array();
    //             $this->index($this->data);
    //         } else {
    //             $logisticarr = [
    //                 'logistic_id' => $this->input->post('logistic_name'),
    //                 'priority' => $this->input->post('priority_set'),
    //                 'sender_id' => $this->session->userdata['userId'],
    //             ];
    
    //             $result = $this->Common_model->insert($logisticarr,'logistic_priority');
    //             if($result)
    //             {
    //                 $this->session->set_flashdata('message',"Logistic Priority Inserted Successfully"); 
    //             }else{
    //                 $this->session->set_flashdata('error',"Something went wrong");
    //             }
    //             redirect('logistic-priority');  
    //         }
    //     }else{
    //         $this->loadview("priority_form",$this->data);
    //     }
       
    // }
    
    public function deletepriority($id)
    {
        	
    	$id  = $this->uri->segment(3);
		if(!empty($id)){
            $result = $this->Common_model->delete('logistic_priority',array('id'=>$id));
            if($result)
            {
                $this->session->set_flashdata('message',"Logistic Priority Delete Successfully"); 
                redirect('logistic-priority');
            }else{
                $this->session->set_flashdata('error',"Something Went Wrong");  
                redirect('logistic-priority');
            }
		}
    }
}

/* End of file Logistic_priority.php */