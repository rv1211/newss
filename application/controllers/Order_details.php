<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order_details extends Auth_Controller
{
	public $data = array();
	public function __construct()
	{
		parent::__construct();

		$this->load->model('View_order_model');
		//Do your magic here
	}

	//get order details of intransit order
	public function intransit_order_details()
	{
		$orderId = $this->input->post('order_id');

		$this->data['order_data'] = $this->View_order_model->getOrder_details($orderId);

		echo $this->load->view('admin/order/order_detail_table', $this->data, true);
	}

	public function ndr_tracking_details()
	{
		$orderId = $this->input->post('order_id');
		$this->data['order_id'] = $this->input->post('order_id');
		// dd($_SESSION);
		$this->data['comment_data'] = $this->View_order_model->get_ndr_data($orderId);

		if ($_POST) {
			echo $this->load->view('admin/order/ndr_comment_table', $this->data, true);
		}
	}

	public function all_order_details()
	{
		$orderId = $this->input->post('order_id');

		$this->data['order_data'] = $this->View_order_model->getOrder_details($orderId);

		// $this->data['tracking_data'] = $this->Common_model->getall_data('*', 'order_tracking_detail', array('order_id' => $this->input->post('order_id')));
		$this->data['tracking_data']  = $this->View_order_model->getTracking_details($this->input->post('order_id'));
		$this->data['button_type'] = $this->input->post('button_type');
		echo $this->load->view('admin/order/order_details', $this->data, true);
	}

	public function order_tracking_details()
	{
		// $this->data['tracking_data'] = $this->Common_model->getall_data('*', 'order_tracking_detail', array('order_id' => $this->input->post('order_id')));
		$this->data['tracking_data']  = $this->view_order_model->getTracking_details($this->input->post('order_id'));
		$this->load->view('admin/order/tracking_details', $this->data, true);
	}
}
