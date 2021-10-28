<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Rate extends Auth_Controller
{
	public function index()
	{
		load_admin_view('rate', 'index');
	}
}

/* End of file Rate.php */
