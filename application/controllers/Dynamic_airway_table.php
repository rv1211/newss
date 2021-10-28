<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dynamic_airway_table extends Auth_Controller {
	
     public function index()
     {
         $this->load->model('Dynamic_model');
         $this->Dynamic_model->createDatabaseSchema();
     }


}