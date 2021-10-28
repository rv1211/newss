<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Import_airway_bill extends Auth_Controller {
	public $data = [];

	public function __construct() {
		parent::__construct();
		$this->customer_id = $this->session->userdata('userId');
		$this->load->model('Common_model');
		$this->load->model('Import_airway_model','Import_airway');
       }

	//manage customer view
	public function import_airway_index() {
        $this->data['active_logistic'] = $this->Common_model->getResultArray(array('is_active' => '1'), '*', 'logistic_master');
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/sidebar');
		$this->load->view('admin/import_airway_bill/import_airway_bill',$this->data);
		$this->load->view('admin/template/footer');
	}

        
    public function import_airway_bill(){
       
        
        if($this->input->post()){
            
            $validation = [
                ['field' => 'logistic', 'label' => 'Logistic Type', 'rules' => 'required'],
                ['field' => 'type', 'label' => 'Type', 'rules' => 'required'],
                ['field' => 'for_what', 'label' => 'For  What', 'rules' => 'required'],
            ];
            $this->form_validation->set_rules($validation);
                if ($this->form_validation->run() == false) {
                    $this->data['errors'] = $this->form_validation->error_array();
                    $this->import_airway_index($this->data);
                } else {
                    
                $paths = FCPATH . "./assets/import_airway_bill/";
                $config['upload_path'] = './assets/import_airway_bill/';
                $config['allowed_types'] = 'xlsx|xls|csv';
                $config['remove_spaces'] = TRUE;
                $config['overwrite'] = TRUE;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
        
                if (!$this->upload->do_upload('airway_import_file')) {
                    
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('airway-bill');
                } else {
                    $data = array('upload_data' => $this->upload->data());
                    if (!empty($data['upload_data']['file_name'])) {
                        $import_xls_file = $data['upload_data']['file_name'];
                    } else {
                        $import_xls_file = 0;
                    }
                }

        $inputFileName = $paths . $import_xls_file;
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                . '": ' . $e->getMessage());
        }
 
        $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

        $arrayCount = count($allDataInSheet);
        $flag = true;
        $i=0;
        $logicstic =  $this->input->post('logistic');
        $type = $this->input->post('type');
        $for_what = $this->input->post('for_what');
            foreach ($allDataInSheet as $value) {                                                
                if ($value['B'] != "") {
                    if($flag == 1){
                        $flag++;
                        $flag =false;
                        continue;
                    }
                    $inserdata[$i]['awb_number'] = $value['B'];
                    $inserdata[$i]['is_used'] = '1';
                    $inserdata[$i]['type'] = $type;
                    $inserdata[$i]['for_what'] = $for_what;
                }else{
                    break;
                }
                $i++;
            }                       
            
            $firstdata = array_values($inserdata)[0]['awb_number'];
            $last_array = end($inserdata);
            $lastdata = $last_array['awb_number'];
            $is_exist = array($firstdata,$lastdata);
           $this->load->model('Dynamic_model');
           $logicstic = str_replace(' ','_',$logicstic);
           $this->Dynamic_model->createDatabaseSchema($logicstic);                      
           $retrundata = $this->Import_airway->cheak($is_exist,$logicstic);
            if($retrundata == true)
            {
                $this->session->set_flashdata('error', 'Already Inserted this file');
                redirect('airway-bill');
            }
            else{
           $result  = $this->Import_airway->insert($inserdata,$logicstic);
           if($result){     
               $this->session->set_flashdata('message',"Import successfully");  
                       redirect(base_url('airway-bill'));
           }
           else{
               $this->session->set_flashdata('error', 'something went wrong');
               redirect('airway-bill');
           }
            }
    //     }
    // else{
    //     $this->session->set_flashdata('error', 'something went wrong');
    //     redirect('airway-bill');
    
        }
    }else{
        $this->session->set_flashdata('error', 'something went wrong');
        redirect('airway-bill');
    }
    }
  
    
}