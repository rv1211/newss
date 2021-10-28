<?php

defined('BASEPATH') or exit('No direct script access allowed');

class flood extends CI_Controller
{



    public function index()
    {
        load_admin_view('test', 'flooder');
    }

        public function flood_table($table = "",$row = 10)
        {
        ini_set('max_execution_time', 0);
        $table_name = $table;
        $rows = $row;
        $fields = $this->db->field_data($table_name);

        // dd($fields);
        for ($i = 1; $i <= $rows; $i++) {
            foreach ($fields as $field) {

                switch ($field->type) {
                    case 'int' : case 'bigint' :
                        if ($field->primary_key == 1 )
                            continue;
                        $data[$field->name]  = $this->genrate_int($field->max_length);
                        break;

                    case 'float': case 'decimal':

                        $data[$field->name] =  $this->genrate_int($field->max_length);
                        break;

                    case 'varchar': case 'text':
                        $length = (isset($field->max_length) && !empty($field->max_length) && $field->max_length != "")?$field->max_length:10;
                        $data[$field->name] = $this->genrate_varchar($length);

                        break;

                    case 'enum':
                        $allowed_values['allowed_values'][$field->name] = $this->get_enum_values($table_name, $field->name);                        
                        $data[$field->name] = $this->genrate_int(end($allowed_values['allowed_values'][$field->name]),$allowed_values['allowed_values'][$field->name][0]);
                        // dd($data);
                        break;
                }
            }
            
            $this->db->insert($table_name, $data);
        }
        echo "inseted";
    }



    function get_enum_values($table, $field)
    {
        $type = $this->db->query("SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'")->row(0)->Type;
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
        $enum = explode("','", $matches[1]);
        return $enum;
    }

    function genrate_varchar($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function genrate_int($max, $min = 0)
    {        
        $randomint =  random_int($min, $max);
        // dd($randomint);
        return $randomint;
    }
}

/* End of file Controllername.php */
