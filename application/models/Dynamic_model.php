<?php 
class Dynamic_model extends CI_Model{

public function __construct(){ }
public function createDatabaseSchema($logistic)
{
        $this->load->dbforge();

        $fields = array(
            'id' => array(
                'type' =>'bigint',
                'auto_increment' => true,
            ),
            'awb_number' => array(
                'type'       => 'varchar',
                'constraint' => 50,
                'unique'     => true,
            ),
            'is_used' => array(
                'type'  => 'ENUM("1","2")',
                'null' => FALSE,
                'comment' => '1-not_used,2-used',

            ),
            'type' => array(
                'type' => 'ENUM("1","2","3")',
                'null' => FALSE,
                'comment' => '1-Forward_Cod,2-Forward_Prepaid,3-Reverse',
            ),
            'for_what' => array(
                'type' => 'ENUM("1","2")',
                'null' => FALSE,
                'comment' => '1-Manually,2-Auto',

            ),
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id',true);
        $this->dbforge->create_table($logistic."_airwaybill",TRUE);
    
}


}