<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pickup_address extends Auth_Controller {

    public $data;
	/**
	 * construct
	 */
	public function __construct() {
		parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Pickup_address_model');
        $this->customer_id = $this->session->userdata('userId');
	}
	public function index()
	{
        load_admin_view('pickup_address', 'pickup_address', '');
	}    
    public function create_pickup_address()
    {
        
        load_admin_view('pickup_address', 'add_pickup_address', '');       
    }
    public function add_pickup_address()
	{
        if($this->input->post())
        {
            $validation = [
                ['field' => 'warehouse_name', 'label' => 'Warehouse Name', 'rules' => 'required'],
                ['field' => 'contact_person_name', 'label' => 'Contact Person Name', 'rules' => 'required'],
                ['field' => 'contact_no', 'label' => 'Contact No', 'rules' => 'required'],
                ['field' => 'contact_email', 'label' => 'Contact Email', 'rules' => 'required|valid_email'],
                ['field' => 'address_line_1', 'label' => 'Address_line_1', 'rules' => 'required'],
                // ['field' => 'address_line_2', 'label' => 'Address_line_2', 'rules' => 'required'],
                ['field' => 'pincode', 'label' => 'Pincode', 'rules' => 'required|exact_length[6]'],
                ['field' => 'city', 'label' => 'City', 'rules' => 'required'],
                ['field' => 'state', 'label' => 'State', 'rules' => 'required'],
                ['field' => 'website', 'label' => 'Website' ,'rules' => 'valid_url']
            ];
            $this->form_validation->set_rules($validation);
            if ($this->form_validation->run() == FALSE) {
                // $this->create_pickup_address();
                $this->data['errors'] = $this->form_validation->error_array();
                load_admin_view('pickup_address', 'add_pickup_address', $this->data);
            } else {
                $add_pickup = [
                    'sender_id' => $this->customer_id,
                    'warehouse_name' => $this->input->post('warehouse_name'),
                    'contact_person_name' => $this->input->post('contact_person_name'),
                    'contact_no' => $this->input->post('contact_no'),
                    'contact_email' => $this->input->post('contact_email'),
                    'website' => $this->input->post('website'),
                    'address_line_1' => $this->input->post('address_line_1'),
                    'address_line_2' => $this->input->post('address_line_2'),
                    'pincode' => $this->input->post('pincode'),
                    'city' => $this->input->post('city'),
                    'state' => $this->input->post('state')
                ];       
                $result = $this->Common_model->insert($add_pickup,'sender_address_master');
                if($result)
                {
                    if($this->session->userdata('userAllow') == 'pickup' || $this->session->userdata('userAllow') == 'kyc' || $this->session->userdata('userAllow') == 'kycPending'){
                        $this->session->set_userdata('userAllow', '');
                    }
                    $this->session->set_flashdata('message',"Pickup address Inserted Successfully");  
                    redirect(base_url('pickup-address'));
                }       
            }
        }
        else{
            load_admin_view('pickup_address', 'add_pickup_address', '');    
        }
    }
    public function delete_pickup_address($id)
    {
        $result = $this->Common_model->delete('sender_address_master',array('id'=>$id));
            if($result)
            {
                $this->session->set_flashdata('error',"Pickup address Deleted Successfully");  
                redirect(base_url('pickup-address'));
            }
    }
    public function pickup_add_load()
    {   
        $columns = array();
        $table = 'sender_address_master';
        $primaryKey = 'id';
        $where = "";
        if ($this->session->userdata('userType') != '1') {
            $where = 'sender_id ="'.$this->customer_id.'"';
        }
        
        $joinquery = '';
       
        $columns[0] = array('db' => 'id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {
                return '<input data-id="'.$d.'"class="selectable-item-pickup getChecked_single_pickup" name="checkbox_item_pickup" type="checkbox">';

        });
        $columns[1] = array('db' => 'warehouse_name', 'dt' => 1, 'field' => 'warehouse_name');
        $columns[2] = array('db' => 'contact_person_name', 'dt' => 2, 'field' => 'contact_person_name');
        $columns[3] = array('db' => 'contact_no', 'dt' => 3, 'field' => 'contact_no');
        $columns[4] = array('db' => 'contact_email', 'dt' => 4, 'field' => 'contact_email');
        $columns[5] = array('db' => 'website', 'dt' => 5, 'field' => 'website');
        $columns[6] = array('db' => 'address_line_1', 'dt' => 6, 'field' => 'address_line_1');
        $columns[7] = array('db' => 'address_line_2', 'dt' => 7, 'field' => 'address_line_2');
        $columns[8] = array('db' => 'pincode', 'dt' => 8, 'field' => 'pincode');
        $columns[9] = array('db' => 'state', 'dt' => 9, 'field' => 'state');
        $columns[10] = array('db' => 'city', 'dt' => 10, 'field' => 'city');
        if ($this->session->userdata('userType') == '1') {
            $columns[11] = array('db' => 'id', 'dt' => 11, 'field' => 'id', 'formatter' => function ($d, $row) {
                $action = "<a href='" . base_url('delete-pickup-address/' . $d) . "'>
                <button type='button' id='delete_btn' class='btn-raised btn-sm btn btn-danger btn-floating waves-effect waves-classic waves-effect waves-light'>
                <i class='icon md-delete' aria-hidden='true'></i></button></a>";
                return $action;
        });
        }
        
        echo json_encode(
            SSP::simple($_GET, $table, $primaryKey, $columns, $joinquery, $where)
          ); 
    }

    //get city ,state from pincode
    public function get_pincode_pickup_address(){
        $pincode = $this->input->post('pincode_data');
        $pincode_data = str_replace("<br>","",$this->Common_model->getSingle_data('city,state','pincode_master',array('pincode'=>$pincode)));
        if(!empty($pincode_data)){
        echo (json_encode($pincode_data));exit;}
        else{
            $error = ["error"=>"error"];
        echo (json_encode($error));exit;}
        
    }
    public function export_data()
    {        
        $id_array = $this->input->post('check_array');
        
        $data = $this->Pickup_address_model->get_excel_data($id_array);
        
        $path = base_url('assets/export_pickup_address');
        $files = glob($path . 'xlsx');
        if (isset($files)) {
            foreach ($files as $findfiles) {
                unlink($findfiles);
            }
        }
        $searchVal = array('Warehouse_Name', 'Contact_Person_Name', 'Contact_Number','Contact_Email','Website','Address_1','Address_2','Pincode','State','City');

        $fileName = 'Pickupaddress_' . time() . '.xlsx';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $stylearray = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => 'FFFFFF'),
                'size' => 12,
            ),
        );
        $j = 'A';
        foreach ($searchVal as $key) {
            $objPHPExcel->getActiveSheet()->getStyle($j . '1')->applyFromArray($stylearray);
            $objPHPExcel->getActiveSheet()->SetCellValue($j . '1', $key);
            $objPHPExcel->getActiveSheet()
                ->getStyle($j . '1')
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('000000');                    
            $j++;
        }
        $rowCount = 2;
        if (!empty($data)) {
            foreach (@$data as $element1) {
                $index = 'A';
                foreach ($element1 as $value) {
                    $objPHPExcel->getActiveSheet()->SetCellValue($index . $rowCount, $value);
                    $objPHPExcel->getActiveSheet()->getColumnDimension($index)->setWidth(20);
                    $index++;
                }
                $rowCount++;
            }
        }
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header("Content-Type: application/vnd.ms-excel");
        $objWriter->save('assets/export_pickup_address/' . @$fileName);
        $finalpath = base_url() . 'assets/export_pickup_address/' . @$fileName;
        echo base64_encode($finalpath);
        exit;
    }
}