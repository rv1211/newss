<?php
if (!function_exists('dd')) {
	function dd($data)
	{
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		die("------------------- Destiny Solutions---------------");
	}
}

if (!function_exists('lq')) {
	function lq()
	{
		$CI = &get_instance();
		$CI->load->database();
		$CI->load->library('session');
		echo "------------------------------- <br><pre>" . $CI->db->last_query() . "</pre>";
		echo "----------------------------------<br>";
		echo "User Ip : " . $CI->input->ip_address() . "<br>";
		echo "------------------------------------<br>";
		die("--------- Thank You -----------");
	}
}

if (!function_exists('load_admin_view')) {
	function load_admin_view($folder_name = "", $view_name = "", $data = "")
	{
		$CI = &get_instance();
		$CI->load->view('admin/template/header');
		$CI->load->view('admin/template/sidebar');
		$CI->load->view("admin/" . $folder_name . "/" . $view_name, $data);
		$CI->load->view('admin/template/footer');
	}
}

if (!function_exists('load_user_view')) {

	function load_user_view($folder_name = "", $view_name = "", $data = "")
	{
		$CI = &get_instance();
		$CI->load->view('front/layout/front-headerlinks');
		$CI->load->view('front/layout/front-header');
		$CI->load->view("front/" . $folder_name . "/" . $view_name, $data);
		$CI->load->view('front/layout/front-footer');
	}
}

if (!function_exists('load_front_view')) {
	function load_front_view($view_name, $data = "")
	{
		$CI = &get_instance();
		$CI->load->view('template/header');
		$CI->load->view('front/' . $view_name, $data);
		$CI->load->view('template/footer');
	}
}


if (!function_exists('show_errors')) {
	function show_errors()
	{
		error_reporting(E_ALL ^ E_NOTICE);
		ini_set('display_errors', '1');
	}
}

if (!function_exists('urlseg')) {
	function urlseg($position)
	{
		$CI = &get_instance();
		$CI->load->helper('url');
		return $CI->uri->segment($position);
	}
}

if (!function_exists('allowhooks')) {
	function allowhooks()
	{
		$CI = &get_instance();
		$CI->config->set_item('allowhooks', 1);
	}
}
