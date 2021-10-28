<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Price extends Auth_Controller
{
    public $data = array();

    public function loadview($viewname)
    {
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/price/' . $viewname, $this->data);
        $this->load->view('admin/template/footer');
    }

    public function index()
    {
        $this->data['logistics'] = $this->Common_model->getall_data('id,logistic_name', 'logistic_master', array('is_active' => '1'));
        $this->data['rules'] = $this->Common_model->getall_data('*', 'rule_master', array('is_active' => '1'));

        if ($this->input->post()) {
            $validation = [
                ['field' => 'logistic', 'label' => 'Logistic', 'rules' => 'required'],
                ['field' => 'rule', 'label' => 'Rule', 'rules' => 'required'],
                ['field' => 'shipment', 'label' => 'Shipment', 'rules' => 'required'],
                ['field' => 'withinzone', 'label' => 'Withinzone', 'rules' => 'required|numeric'],
                ['field' => 'withincity', 'label' => 'Withincity', 'rules' => 'required|numeric'],
                ['field' => 'withinstate', 'label' => 'Withinstate', 'rules' => 'required|numeric'],
                ['field' => 'metro', 'label' => 'Metro', 'rules' => 'required|numeric'],
                ['field' => 'metro2', 'label' => 'Metro2', 'rules' => 'required|numeric'],
                ['field' => 'restofindia', 'label' => 'Rest of india', 'rules' => 'required|numeric'],
                ['field' => 'restofindia2', 'label' => 'Rest of india2', 'rules' => 'required|numeric'],
                ['field' => 'specialzone', 'label' => 'Specialzone', 'rules' => 'required|numeric|callback_valid_index[' . $this->input->post('logistic') . ']'],
                ['field' => 'rule_index', 'label' => 'Rule Index', 'rules' => 'required|numeric|greater_than[0]'],
            ];
            $this->form_validation->set_rules($validation);

            if ($this->form_validation->run() == false) {
                $this->data['errors'] = $this->form_validation->error_array();
                $this->loadview('add_single_shipping_charge');
            } else {
                $manage_price_id = $this->input->post('manage_price_id');
                if ($manage_price_id != '0') {
                    $duplicateResult = $this->Common_model->getSingle_data('id', 'manage_price', array('logistic_id' => $this->input->post('logistic'), 'rule' => $this->input->post('rule'), 'shipment_type' => $this->input->post('shipment'), 'id !=' => $manage_price_id));
                } else {
                    $duplicateResult = $this->Common_model->getSingle_data('id', 'manage_price', array('logistic_id' => $this->input->post('logistic'), 'rule' => $this->input->post('rule'), 'shipment_type' => $this->input->post('shipment')));
                }
                if (!empty($duplicateResult)) {
                    $this->data['errors']['logistic'] = 'Price Already set for this logistic with same Rule and Shipment';
                    $this->data['errors']['rule'] = 'Price Already set for this Rule with same logistic and Shipment';
                    $this->data['errors']['shipment'] = 'Price Already set for this Shipment with same logistic and Rule';
                    $this->loadview('add_single_shipping_charge');
                } else {
                    $pricearr = [
                        'logistic_id' => $this->input->post('logistic'),
                        'rule' => $this->input->post('rule'),
                        'shipment_type' => $this->input->post('shipment'),
                        'within_city' => $this->input->post('withincity'),
                        'within_state' => $this->input->post('withinstate'),
                        'within_zone' => $this->input->post('withinzone'),
                        'metro' => $this->input->post('metro'),
                        'metro_2' => $this->input->post('metro2'),
                        'rest_of_india' => $this->input->post('restofindia'),
                        'rest_of_india_2' => $this->input->post('restofindia2'),
                        'special_zone' => $this->input->post('specialzone'),
                        'jammu_kashmir' => $this->input->post('specialzone'),
                        'rule_index' => $this->input->post('rule_index'),
                        'is_cod_charge_return' => (!empty($this->input->post('cod_return'))) ? "1" : "0",
                    ];
                    if ($manage_price_id != '0') {
                        $result = $this->Common_model->update($pricearr, 'manage_price', array('id' => $manage_price_id));
                        if ($result) {
                            $this->session->set_flashdata('message', "Price Updated Successfully");
                            redirect('shipping-price');
                        } else {
                            $this->session->set_flashdata('error', 'Something Went Wrong');
                            redirect('shipping-price');
                        }
                    } else {
                        $result = $this->Common_model->insert($pricearr, 'manage_price');
                        if ($result) {
                            $this->session->set_flashdata('message', "Price Inserted Successfully");
                            redirect('shipping-price');
                        } else {
                            $this->session->set_flashdata('error', 'Something Went Wrong');
                            redirect('shipping-price');
                        }
                    }
                }
            }
        } else {
            $this->loadview('add_single_shipping_charge');
        }
    }

    public function add_single_price()
    {
        $validation = [
            ['field' => 'logistic', 'label' => 'Logistic', 'rules' => 'required'],
            ['field' => 'rule', 'label' => 'Rule', 'rules' => 'required'],
            ['field' => 'shipment', 'label' => 'Shipment', 'rules' => 'required'],
            ['field' => 'withinzone', 'label' => 'Withinzone', 'rules' => 'required|numeric|greater_than[0]'],
            ['field' => 'withincity', 'label' => 'Withincity', 'rules' => 'required|numeric|greater_than[0]'],
            ['field' => 'withinstate', 'label' => 'Withinstate', 'rules' => 'required|numeric|greater_than[0]'],
            ['field' => 'metro', 'label' => 'Metro', 'rules' => 'required|numeric|greater_than[0]'],
            ['field' => 'metro2', 'label' => 'Metro2', 'rules' => 'required|numeric|greater_than[0]'],
            ['field' => 'restofindia', 'label' => 'Rest of india', 'rules' => 'required|numeric|greater_than[0]'],
            ['field' => 'restofindia2', 'label' => 'Rest of india2', 'rules' => 'required|numeric|greater_than[0]'],
            ['field' => 'specialzone', 'label' => 'Specialzone', 'rules' => 'required|numeric|greater_than[0]'],
            ['field' => 'rule_index', 'label' => 'Rule Index', 'rules' => 'required|numeric|greater_than[0]'],
        ];
        $this->form_validation->set_rules($validation);
        if ($this->form_validation->run() == false) {
            $this->data['errors'] = $this->form_validation->error_array();
            $this->index('add_single_shipping_charge');
        } else {
            $pricearr = [
                'logistic_id' => $this->input->post('logistic'),
                'rule' => $this->input->post('rule'),
                'shipment_type' => $this->input->post('shipment'),
                'within_city' => $this->input->post('withincity'),
                'within_state' => $this->input->post('withinstate'),
                'within_zone' => $this->input->post('withinzone'),
                'metro' => $this->input->post('metro'),
                'metro_2' => $this->input->post('metro2'),
                'rest_of_india' => $this->input->post('restofindia'),
                'rest_of_india_2' => $this->input->post('restofindia2'),
                'special_zone' => $this->input->post('specialzone'),
                'is_cod_charge_return' => (!empty($this->input->post('cod_return'))) ? "1" : "0",
            ];
            $result = $this->Common_model->insert($pricearr, 'manage_price');
            if ($result) {
                $this->session->set_flashdata('message', "Price Inserted Successfully");
                redirect('add-single-shipping-price');
            } else {

                $this->session->set_flashdata('error', 'Something Went Wrong');
                redirect('add-single-shipping-price');
            }
        }
    }

    public function manage_price()
    {

        if ($this->input->post()) {

            $manage_price_id = array();
            if ($this->input->post('user_id') != "") {
                $customer_id = $this->input->post('user_id');
            } else {
                $customer_id = "";
            }
            //get assign logistic of user
            $get_assign_logistic = $this->Price_model->get_assing_logistic($customer_id);
            $result = array_column($get_assign_logistic, 'logistic_id');
            if (!empty($result)) {
                //get data from sender manage price
                $sender_assing_price = $this->Price_model->get_sender_price_data($result, $customer_id);
                foreach ($sender_assing_price as $key => $sender_assign_price_value) {
                    $this->data['logistic_price'][$sender_assign_price_value['logistic_id']]['logistic_name'] = $sender_assign_price_value['logistic_name'];
                    $this->data['logistic_price'][$sender_assign_price_value['logistic_id']]['assign_price_info'][] = $sender_assign_price_value;
                    $manage_price_id[] = $sender_assign_price_value['manage_price_id'];
                }
                //get data from manage price
                $sender_pending_price = $this->Price_model->get_ship_price_data($result, $manage_price_id);
                foreach ($sender_pending_price as $key => $sender_assign_price_value) {
                    $this->data['logistic_price'][$sender_assign_price_value['logistic_id']]['logistic_name'] = $sender_assign_price_value['logistic_name'];
                    $this->data['logistic_price'][$sender_assign_price_value['logistic_id']]['pending_price_info'][] = $sender_assign_price_value;
                }
            } else {
                $this->session->set_flashdata('error', "This user has not assign any logistic !! First you have to assign logistic to this user");
            }
            $this->data['user_id'] = $customer_id;
        }
        $this->data['users'] = $this->Common_model->getResult(array('status' => '1', 'is_active' => '1'), '*', 'sender_master');
        // dd($this->data);
        $this->loadview('view_all_shipping_price', $this->data);
    }

    //save price data
    public function insert_price_data()
    {
        if ($this->input->post('assign_price')) {
            foreach ($this->input->post('assign_price')['id'] as $key => $id_value) {
                $sender_price_id = $this->input->post('assign_price')['sender_price_id'][$key];
                $update_data['logistic_id'] = $this->input->post('assign_price')['logistic_id'][$key];
                $update_data['sender_id'] = $this->input->post('assign_price')['sender_price_id'][$key];
                $update_data['shipment_type'] = $this->input->post('assign_price')['shipment_type'][$key];
                $update_data['rule'] = $this->input->post('assign_price')['rules'][$key];
                $update_data['rule_index'] = $this->input->post('assign_price')['rule_index'][$key];
                $update_data['within_city'] = $this->input->post('assign_price')['within_city'][$key];
                $update_data['within_state'] = $this->input->post('assign_price')['within_state'][$key];
                $update_data['within_zone'] = $this->input->post('assign_price')['within_zone'][$key];
                $update_data['metro'] = $this->input->post('assign_price')['metro'][$key];
                $update_data['metro_2'] = $this->input->post('assign_price')['metro_2'][$key];
                $update_data['rest_of_india'] = $this->input->post('assign_price')['rest_of_india'][$key];
                $update_data['rest_of_india_2'] = $this->input->post('assign_price')['rest_of_india_2'][$key];
                $update_data['special_zone'] = $this->input->post('assign_price')['special_zone'][$key];
                $update_data['jammu_kashmir'] = $this->input->post('assign_price')['jammu_kashmir'][$key];
                $update_data['cod_price'] = $this->input->post('assign_price')['cod_price'][$this->input->post('assign_price')['logistic_id'][$key]];
                $update_data['cod_percentage'] = $this->input->post('assign_price')['cod_percentage'][$this->input->post('assign_price')['logistic_id'][$key]];

                $result = $this->Common_model->update($update_data, 'sender_manage_price', array('id' => $id_value));
            }
        }

        if ($this->input->post('pending_price')) {

            foreach ($this->input->post('pending_price') as $key1 => $id_value1) {
                // dd($key1);
                if (!empty($this->input->post('pending_price')[$key1]['checkbox_item'])) {
                    foreach ($this->input->post('pending_price')[$key1]['checkbox_item'] as $key => $id_value) {
                        $cod_detail = $this->Common_model->getSingle_data('cod_price, cod_percentage', 'manage_price', array('id' => $id_value));
                        $insert_data['logistic_id'] = $key1;
                        $insert_data['manage_price_id'] = $id_value;
                        $insert_data['sender_id'] = $this->input->post('pending_price')[$key1]['hidden_user_id'];
                        $insert_data['shipment_type'] = $this->input->post('pending_price')[$key1]['shipment_type'][$key];
                        $insert_data['rule'] = $this->input->post('pending_price')[$key1]['rules'][$key];
                        $insert_data['rule_index'] = $this->input->post('pending_price')[$key1]['rule_index'][$key];
                        $insert_data['within_city'] = $this->input->post('pending_price')[$key1]['within_city'][$key];
                        $insert_data['within_state'] = $this->input->post('pending_price')[$key1]['within_state'][$key];
                        $insert_data['within_zone'] = $this->input->post('pending_price')[$key1]['within_zone'][$key];
                        $insert_data['metro'] = $this->input->post('pending_price')[$key1]['metro'][$key];
                        $insert_data['metro_2'] = $this->input->post('pending_price')[$key1]['metro_2'][$key];
                        $insert_data['rest_of_india'] = $this->input->post('pending_price')[$key1]['rest_of_india'][$key];
                        $insert_data['rest_of_india_2'] = $this->input->post('pending_price')[$key1]['rest_of_india_2'][$key];
                        $insert_data['special_zone'] = $this->input->post('pending_price')[$key1]['special_zone'][$key];
                        $insert_data['jammu_kashmir'] = $this->input->post('pending_price')[$key1]['jammu_kashmir'][$key];
                        $insert_data['cod_price'] = $cod_detail['cod_price'];
                        $insert_data['cod_percentage'] = $cod_detail['cod_percentage'];

                        $result = $this->Common_model->insert($insert_data, 'sender_manage_price');
                    }
                }
            }
        }
        if ($result) {
            $this->session->set_flashdata('message', 'Shipping Price Update Sucessfully');
            redirect('manage-price');
        } else {
            $this->session->set_flashdata('error', 'Shipping Price Update Failed');
            redirect('manage-price');
        }
    }

    public function update_shipping_price()
    {

        $logistic_id = $this->input->post('logistic_id');
        $sender_id = $this->input->post('user_id');
        $shipment_type = $this->input->post('shipment_type');
        // dd($_POST);
        // $result = $this->Common_model->delete("sender_manage_price",array('logistic_id' =>  $this->input->post('logistic_id'), 'sender_id' => $this->input->post('user_id')));

        foreach ($this->input->post('id') as $key => $value) {
            $sender_price_id = $this->input->post('sender_price_id')[$key];
            $update_data['logistic_id'] = $logistic_id;
            $update_data['sender_id'] = $sender_id;
            $update_data['shipment_type'] = $shipment_type[$key];
            $update_data['rule'] = $this->input->post('rules')[$key];
            $update_data['rule_index'] = $this->input->post('rule_index')[$key];
            $update_data['within_city'] = $this->input->post('within_city')[$key];
            $update_data['within_state'] = $this->input->post('within_state')[$key];
            $update_data['within_zone'] = $this->input->post('within_zone')[$key];
            $update_data['metro'] = $this->input->post('metro')[$key];
            $update_data['metro_2'] = $this->input->post('metro_2')[$key];
            $update_data['rest_of_india'] = $this->input->post('rest_of_india')[$key];
            $update_data['rest_of_india_2'] = $this->input->post('rest_of_india_2')[$key];
            $update_data['special_zone'] = $this->input->post('special_zone')[$key];
            $update_data['jammu_kashmir'] = $this->input->post('jammu_kashmir')[$key];
            $update_data['cod_price'] = $this->input->post('cod_price');
            $update_data['cod_percentage'] = $this->input->post('cod_percentage');

            $result = $this->Common_model->update($update_data, 'sender_manage_price', array('id' => $sender_price_id));
            //echo $this->db->last_query().$result."<br>"; 
        }

        if ($result) {
            $this->session->set_flashdata('message', 'Shipping Price Update Sucessfully');
            redirect('manage-price');
        } else {
            $this->session->set_flashdata('error', 'Shipping Price Update Failed');
            redirect('manage-price');
        }
    }


    //assign price to customer
    public function assign_shipping_price()
    {
        foreach ($this->input->post('id') as $key => $idvalue) {
            if (in_array($idvalue, $this->input->post('checkbox_item'))) {
                $assign_data['shipment_type'] = $this->input->post('shipment_type')[$key];
                $assign_data['manage_price_id'] = $this->input->post('id')[$key];
                $assign_data['rule'] = $this->input->post('rules')[$key];
                $assign_data['rule_index'] = $this->input->post('rule_index')[$key];
                $assign_data['within_city'] = $this->input->post('within_city')[$key];
                $assign_data['within_state'] = $this->input->post('within_state')[$key];
                $assign_data['within_zone'] = $this->input->post('within_zone')[$key];
                $assign_data['metro'] = $this->input->post('metro')[$key];
                $assign_data['metro_2'] = $this->input->post('metro_2')[$key];
                $assign_data['rest_of_india'] = $this->input->post('rest_of_india')[$key];
                $assign_data['rest_of_india_2'] = $this->input->post('rest_of_india_2')[$key];
                $assign_data['special_zone'] = $this->input->post('special_zone')[$key];
                //$assign_data['cod_price'] = $this->input->post('cod_price')[$key];
                $assign_data['logistic_id'] = $this->input->post('logistic_id');
                $assign_data['jammu_kashmir'] = $this->input->post('jammu_kashmir')[$key];
                //$assign_data['cod_percentage'] = $this->input->post('cod_percentage');
                $assign_data['sender_id'] = $this->input->post('userid');
                //    $result =  $this->db->insert_batch('sender_manage_price', $assign_data);
                $result = $this->Common_model->insert($assign_data, 'sender_manage_price');
            }
        }
        if ($result) {
            $this->session->set_flashdata('message', 'Shipping Price Assign Sucessfully');
            redirect('manage-price');
        } else {
            $this->session->set_flashdata('error', 'Shipping Price Assign Failed');
            redirect('manage-price');
        }
    }

    /**
     * Shipping Price datatable
     *
     * @return  datatable  load all Shipping Price in database
     */
    public function loadshipprice()
    {
        $columns = array();
        $table = 'manage_price';
        $primaryKey = 'id';
        $where = "";
        $joinQuery = ' FROM ' . $table . ' as mp INNER JOIN logistic_master as lm ON lm.id=mp.logistic_id INNER JOIN rule_master as rm ON rm.id=mp.rule';

        $columns[0] = array('db' => 'lm.logistic_name', 'dt' => 0, 'field' => 'logistic_name');
        $columns[1] = array('db' => 'rm.name', 'dt' => 1, 'field' => 'name');
        $columns[2] = array('db' => 'mp.rule_index', 'dt' => 2, 'field' => 'rule_index');
        $columns[3] = array('db' => 'mp.shipment_type', 'dt' => 3, 'field' => 'shipment_type', 'formatter' => function ($d, $row) {
            switch ($d) {
                case '0':
                    return "Forward";
                    break;
                case '1':
                    return "Reverse";
                    break;
                default:
                    return "";
                    break;
            }
        });
        $columns[4] = array('db' => 'mp.within_zone', 'dt' => 4, 'field' => 'within_zone');
        $columns[5] = array('db' => 'mp.within_city', 'dt' => 5, 'field' => 'within_city');
        $columns[6] = array('db' => 'mp.within_state', 'dt' => 6, 'field' => 'within_state');
        $columns[7] = array('db' => 'mp.metro', 'dt' => 7, 'field' => 'metro');
        $columns[8] = array('db' => 'mp.metro_2', 'dt' => 8, 'field' => 'metro_2');
        $columns[9] = array('db' => 'mp.rest_of_india', 'dt' => 9, 'field' => 'rest_of_india');
        $columns[10] = array('db' => 'mp.rest_of_india_2', 'dt' => 10, 'field' => 'rest_of_india_2');
        $columns[11] = array('db' => 'mp.special_zone', 'dt' => 11, 'field' => 'special_zone');
        $columns[12] = array('db' => 'mp.is_cod_charge_return', 'dt' => 12, 'field' => 'is_cod_charge_return', 'formatter' => function ($d, $row) {
            switch ($d) {
                case '0':
                    return "No";
                    break;
                case '1':
                    return "Yes";
                    break;
                default:
                    return "";
                    break;
            }
        });
        $columns[13] = array('db' => 'mp.id', 'dt' => 13, 'field' => 'id', 'formatter' => function ($d, $row) {
            $action = "<button type='button' data-id='" . $d . "' class='shipping_price_edit btn btn-primary btn-sm ladda-button waves-effect waves-classic'>
            <i class='icon md-edit' aria-hidden='true'></i></button>
                <a href='" . base_url('delete-shipping-price/' . $d) . "'>
                <button type='button' id='delete_btn' class='btn-raised btn-sm btn btn-danger btn-floating waves-effect waves-classic waves-effect waves-light'>
                <i class='icon md-delete' aria-hidden='true'></i></button></a>";
            return $action;
        });

        echo json_encode(
            SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where)
        );
    }

    public function get_assigned_logistic()
    {
        $user_id = $this->input->post('user_id');
        $logistic = $this->Price_model->get_logistic($user_id);
        $logistic_ids = array_column($logistic, "logistic_id");
        $logistic_data = $this->Price_model->get_logistic_details($logistic_ids);
        $output = "";
        foreach ($logistic_data as $single_logistic) {
            $output .= "<option value=" . $single_logistic->id . ">" . $single_logistic->logistic_name . "</option>";
        }
        echo $output;
    }

    /**
     * load Shiipng Parice for edit
     */
    public function edit_shipping_price()
    {
        $shipPrice = $this->input->post('ship_price_id');
        $shipResult = $this->Common_model->getSingle_data('*', 'manage_price', array('id' => $shipPrice));
        $logistics = $this->Common_model->getall_data('id,logistic_name', 'logistic_master', array('is_active' => '1'));
        $rules = $this->Common_model->getall_data('*', 'rule_master');
        $logisticDrop = $ruleDrop = $shipDrop = '';
        if (!empty($shipResult)) {
            // Logistic Dropdown
            $logisticDrop = '<h4 class="example-">Logistic</h4>
                                <select name="logistic" id="logistic" class="form-control select2">';
            foreach ($logistics as $val) :
                if ($shipResult['logistic_id'] == $val['id']) {
                    $select = 'selected';
                } else {
                    $select = '';
                }
                $logisticDrop .= '<option value="' . $val['id'] . '" ' . $select . '>' . $val['logistic_name'] . '</option>';
            endforeach;
            $logisticDrop .= '</select>';

            // Rule Dropdown
            $ruleDrop = '<h4 class="example-">Rule</h4>
                           <select name="rule" id="rule" class="form-control select2">';
            foreach ($rules as $val) :
                if ($shipResult['rule'] == $val['id']) {
                    $select = 'selected';
                } else {
                    $select = '';
                }
                $ruleDrop .= '<option value="' . $val['id'] . '" ' . $select . '>' . $val['name'] . '</option>';
            endforeach;
            $ruleDrop .= '</select>';

            // Shipment Type Dropdown
            if ($shipResult['shipment_type'] == '0') {
                $forwa = 'selected';
                $reve = '';
            } else {
                $forwa = '';
                $reve = 'selected';
            }
            $shipDrop = '<h4 class="example-">Shipment Type</h4>
                            <select name="shipment" id="shipment" class="form-control select2">
                                <option value="0" ' . $forwa . '>Forward</option>
                                <option value="1" ' . $reve . '>Reverse</option>
                            </select>';
        }
        $shipResult['logisticDrop'] = $logisticDrop;
        $shipResult['ruleDrop'] = $ruleDrop;
        $shipResult['shipDrop'] = $shipDrop;
        echo json_encode($shipResult);
        exit;
    }

    /**
     * Delete Shipping Price
     */
    public function delete_shipping_price($id)
    {
        $deleteResult = $this->Common_model->delete('manage_price', array('id' => $id));
        if ($deleteResult) {
            $update = "DELETE FROM `sender_manage_price` WHERE `manage_price_id` = " . $id;
            $this->db->query($update);
            $this->session->set_flashdata('message', "Shipping Price Deleted Successfully");
            redirect('shipping-price');
        } else {
            $this->session->set_flashdata('error', "Shipping Price Delete Failed.");
            redirect('shipping-price');
        }
    }

    function valid_index($index, $field)
    {
        $data = $this->db->select('id')->from('manage_price')->where('logistic_id', $field)->where('rule_index', $index)->get()->result_array();
        if (empty($data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

/* End of file Price.php */