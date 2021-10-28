<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Plan extends Auth_Controller
{

	public function index()
	{
		$this->load->view('admin/plan/early_cod');
	}
}

/* End of file Plan.php */
