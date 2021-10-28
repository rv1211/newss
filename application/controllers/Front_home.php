<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Front_home extends CI_Controller
{

	public function index()
	{
		$this->load->view('front/template/headerlinks');
		$this->load->view('front/template/header');
		$this->load->view('front/layout/front-content');
		$this->load->view('front/template/footer');
	}

	public function about_us()
	{
		$this->load->view('front/template/headerlinks');
		$this->load->view('front/template/header');
		$this->load->view('front/layout/about-us');
		$this->load->view('front/template/footer');
	}

	public function contact_us()
	{
		$this->load->view('front/template/headerlinks');
		$this->load->view('front/template/header');
		$this->load->view('front/layout/contact-us');
		$this->load->view('front/template/footer');
	}

	public function features()
	{
		$this->load->view('front/template/headerlinks');
		$this->load->view('front/template/header');
		$this->load->view('front/layout/features');
		$this->load->view('front/template/footer');
	}

	public function faq()
	{
		$this->load->view('front/template/headerlinks');
		$this->load->view('front/template/header');
		$this->load->view('front/layout/faq');
		$this->load->view('front/template/footer');
	}

	public function disclaimer()
	{
		$this->load->view('front/template/headerlinks');
		$this->load->view('front/template/header');
		$this->load->view('front/layout/disclaimer');
		$this->load->view('front/template/footer');
	}

	public function term_conditions()
	{
		$this->load->view('front/template/headerlinks');
		$this->load->view('front/template/header');
		$this->load->view('front/layout/term-conditions');
		$this->load->view('front/template/footer');
	}

	public function privacy_policy()
	{
		$this->load->view('front/template/headerlinks');
		$this->load->view('front/template/header');
		$this->load->view('front/layout/privacy-policy');
		$this->load->view('front/template/footer');
	}

	public function support_policy()
	{
		$this->load->view('front/template/headerlinks');
		$this->load->view('front/template/header');
		$this->load->view('front/layout/support-policy');
		$this->load->view('front/template/footer');
	}

	public function refund_cancellation_policy()
	{
		$this->load->view('front/template/headerlinks');
		$this->load->view('front/template/header');
		$this->load->view('front/layout/refund-cancellation-policy');
		$this->load->view('front/template/footer');
	}

	public function who_are_we()
	{
		$this->load->view('front/template/headerlinks');
		$this->load->view('front/template/header');
		$this->load->view('front/layout/who-are-we');
		$this->load->view('front/template/footer');
	}

	public function benifits()
	{
		$this->load->view('front/template/headerlinks');
		$this->load->view('front/template/header');
		$this->load->view('front/layout/benifits');
		$this->load->view('front/template/footer');
	}
}
