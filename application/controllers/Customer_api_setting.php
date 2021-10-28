<?php 
    
  
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Customer_api_setting extends Auth_Controller {

        
        public function __construct()
        {
            parent::__construct();
            $this->userId = $this->session->userdata('id');
		    $this->userType = $this->session->userdata('user_type');
		    $this->customerStatus = $this->session->userdata('customer_status');
        }
        

        public $data;
        
        public function loadview(string $viewname)
        {
            
            $this->load->view('admin/template/header');
            $this->load->view('admin/template/sidebar');
            $this->load->view('admin/manage_customer/' . $viewname, $this->data);
            $this->load->view('admin/template/footer');
            
        }//common view function created by rutvik 


        public function index()
        {
            $this->data['customer_list'] = $this->Common_model->getResultArray(array('status' => '1', 'is_active' => '1'), 'id,name,email,allow_credit,allow_credit_limit', 'sender_master');

            $this->loadview('customer_api_setting');
            
        }
        public function get_customer_api_info(){
            $sender_id = $this->input->post('sender_id');
            $customer_data_result = $this->Common_model->getSingleRowArray(array('id' => $sender_id), 'api_pickup_address_id,api_is_web_access,api_key,api_user_id', 'sender_master');
            
            $api_pickup_address_id = @$customer_data_result['api_pickup_address_id'];
		    $api_is_web_access = @$customer_data_result['api_is_web_access'];
            if (@$customer_data_result['api_key'] != "") {
			$api_key = @$customer_data_result['api_key'];
            } else {
                $api_key = md5("admin_sender_web_access_api_key_" . $sender_id);
            }
            if (@$customer_data_result['api_user_id'] != "") {
                $api_user_id = @$customer_data_result['api_user_id'];
            } else {
                $api_user_id = md5("admin_sender_web_access_user_id_" . $sender_id);
            }
            $all_pickup_address = '';
            $pickup_address_result = $this->Common_model->getResultArray(array('sender_id' => $sender_id), 'id,warehouse_name,address_line_1,address_line_2,city,state,pincode', 'sender_address_master');
            foreach ($pickup_address_result as $single_pickup_address) {
                if ($single_pickup_address['id'] == $api_pickup_address_id) {
                    $select = 'selected';
                } else { $select = "";}
                $all_pickup_address .= '<option value="' . $single_pickup_address['id'] . '" ' . $select . '>' . $single_pickup_address['warehouse_name'] . ' - ' . str_replace(",,", ",", $single_pickup_address['address_line_1'] . ", " . $single_pickup_address['address_line_2'] . ", " . $single_pickup_address['city'] . ", " . $single_pickup_address['state'] . ", " . $single_pickup_address['pincode']) . '</option>';
            }
            echo json_encode(array('api_is_web_access' => $api_is_web_access, 'api_key' => $api_key, 'api_user_id' => $api_user_id, 'all_pickup_address' => $all_pickup_address));
            exit();
            
        }

        public function update_customer_api_settings() {
            $data['api_pickup_address_id'] = $this->input->post('api_pickup_address_id');
            $sender_id = $this->input->post('sender_id');
            if ($this->input->post('api_is_web_access') == 1) {
                $pdf_view['api_is_web_access'] = $data['api_is_web_access'] = $this->input->post('api_is_web_access');
                $pdf_view['api_key'] = $data['api_key'] = $this->input->post('api_key');
                $pdf_view['api_user_id'] = $data['api_user_id'] = $this->input->post('api_user_id');
            } else {
                $data['api_is_web_access'] = 0;
                $pdf_view['api_key'] = "";
                $pdf_view['api_user_id'] = "";
            }
            $result = $this->Common_model->update($data, 'sender_master', array('id' => $sender_id));
            if ($this->input->post('action_perfom') == 'customer_api_setting_info_pdf_button') {
                $pickup_address_result = $this->Common_model->getSingleRowArray(array('id' => $data['api_pickup_address_id']), 'address_line_1,address_line_2,city,state,pincode', 'sender_address_master');
                $customer_result = $this->Common_model->getSingleRowArray(array('id' => $this->input->post('sender_id')), 'name', 'sender_master');
                $pdf_view['customer_name'] = $customer_result['name'];
                $pdf_view['pickup_address'] = str_replace(",,", ",", $pickup_address_result['address_line_1'] . ", " . $pickup_address_result['address_line_2'] . ", " . $pickup_address_result['city'] . ", " . $pickup_address_result['state'] . ", " . $pickup_address_result['pincode']);

                $html = $this->load->view('admin/manage_customer/customer_api_setting_pdf', $pdf_view, true);
                $this->load->library('pdf');
                $filename = base64_encode($this->input->post('sender_id')) . "api_setting.pdf";
                if (file_exists(base_url() . 'uploads/customer_api_pdf/' . $filename)) {
                    unlink('uploads/customer_api_pdf/' . $filename);
                }
                $this->pdf->load_html($html);
                $this->pdf->render();
                $output = $this->pdf->output();
                file_put_contents($this->config->item('FILE_PATH') . 'uploads/customer_api_pdf/' . $filename, $output);
                echo $filename;
            } else {
                if ($result) {
                    echo "success";
                } else {
                    echo "error";
                }
            }
            exit();
        }
    }
    
    /* End of file Customer_api_setting.php */
    
?>