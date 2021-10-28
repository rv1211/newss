<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order_list extends Auth_Controller
{
	public $data = array();
	public function __construct()
	{
		parent::__construct();

		$this->load->model('View_order_model');
		ini_set('memory_limit', '-1');

		//Do your magic here
	}
	public function loadview($viewname)
	{
		$this->load->view('admin/template/header');
		$this->load->view('admin/template/sidebar');
		$this->load->view('admin/order/' . $viewname, $this->data);
		$this->load->view('admin/template/footer');
	}

	public function index()
	{
		$this->data['order_count'] = $this->get_order_count();
		$this->loadview('order_list_demo', $this->data);
	}

	/**
	 * Order datatable
	 *
	 * @return  datatable  load all Shipping Price in database
	 */
	public function order_list_table()
	{
		$columns = array();
		$table = 'forward_order_master';
		$primaryKey = 'id';
		if ($this->session->userdata['userType'] == '1') {
			$where = "fom.is_pre_awb = '0' AND fom.is_pre_awb = '0'";
		} else {
			$where = "fom.is_pre_awb = '0' AND fom.is_pre_awb = '0' AND fom.sender_id='" . $this->session->userdata['userId'] . "'";
		}
		$joinQuery = ' FROM ' . $table . ' fom INNER JOIN sender_master as sm ON sm.id=fom.sender_id INNER JOIN logistic_master as lm ON lm.id=fom.logistic_id INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id LEFT JOIN order_airwaybill_detail as owd ON owd.order_id = fom.id LEFT JOIN order_status as os ON os.order_status_id = owd.order_status_id';

		$columns[0] = array('db' => 'fom.id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {
			return '<input type="checkbox" class="select-item" name="id[]" value="' . $d . '">';
		});
		$columns[1] = array('db' => 'fom.order_no', 'dt' => 1, 'field' => 'order_no');
		$columns[2] = array('db' => 'fom.customer_order_no', 'dt' => 2, 'field' => 'customer_order_no');
		$columns[3] = array('db' => 'fom.awb_number', 'dt' => 3, 'field' => 'awb_number');
		$columns[4] = array('db' => 'ra.name', 'dt' => 4, 'field' => 'name', 'formatter' => function ($d, $row) {
			return "<span>" . $d . "</span>";
		});
		$columns[5] = array('db' => 'ra.mobile_no', 'dt' => 5, 'field' => 'mobile_no', 'formatter' => function ($d, $row) {
			return '<span>' . $d . '</span>';
		});
		$columns[6] = array('db' => 'fom.order_type', 'dt' => 6, 'field' => 'order_type', 'formatter' => function ($d, $row) {
			switch ($d) {
				case '0':
					return "Prepaid";
					break;
				case '1':
					return "COD";
					break;
				default:
					return "";
					break;
			}
		});
		// $columns[7] = array('db' => 'lm.logistic_name', 'dt' => 7, 'field' => 'logistic_name');
		$columns[7] = array('db' => 'fom.created_date', 'dt' => 7, 'field' => 'created_date', 'formatter' => function ($d, $row) {
			return date('m-d-Y H:i:s', strtotime($d));
		});
		$columns[8] = array(
			'db' => 'fom.id', 'dt' => 8, 'field' => 'id',
			'formatter' => function ($d, $row) {
				return "";
			}
		);
		$columns[9] = array(
			'db' => 'fom.created_date', 'dt' => 9, 'field' => 'created_date',
			'formatter' => function ($d, $row) {
				return "";
			}
		);
		$columns[10] = array(
			'db' => 'os.status_name', 'dt' => 10, 'field' => 'status_name'
			// , 'formatter' => function ($d, $row) {
			//     return "<span>".$d."</span>";}
		);
		if ($this->session->userdata('userType') == '1') {
			$columns[11] = array('db' => 'sm.name', 'dt' => 11, 'field' => 'name', 'formatter' => function ($d, $row) {
				return "<span>" . $d . "</span>";
			});
			$columns[12] = array('db' => 'fom.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "";
			});
		} else {
			$columns[11] = array('db' => 'fom.id', 'dt' => 11, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "";
			});
		}

		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where)
		);
	}

	public function onprocess_order_list_view()
	{
		$this->data['order_count'] = $this->get_order_count();
		$this->loadview('onprocess_order_list');
	}

	public function onprocess_order_list_table()
	{
		$columns = array();
		$table = 'temp_forward_order_master';
		$primaryKey = 'id';
		if ($this->session->userdata['userType'] == '1') {
			$where = "fom.is_pre_awb = '0' AND fom.is_created = '1'";
		} else {
			$where = "fom.is_pre_awb = '0' AND fom.sender_id='" . $this->session->userdata['userId'] . "' AND fom.is_created = '1'";
		}
		$joinQuery = ' FROM ' . $table . ' fom INNER JOIN sender_master as sm ON sm.id=fom.sender_id INNER JOIN logistic_master as lm ON lm.id=fom.logistic_id INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id';
		// $joinQuery = 'FROM' .$table . 'fom INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id INNER JOIN sender_master as sm ON sm.id=fom.sender_id';
		$columns[0] = array('db' => 'fom.id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {
			return '<input type="checkbox" class="select-item" name="id[]" value="' . $d . '">';
		});
		$columns[1] = array('db' => 'fom.order_no', 'dt' => 1, 'field' => 'order_no');
		$columns[2] = array('db' => 'fom.customer_order_no', 'dt' => 2, 'field' => 'customer_order_no');
		$columns[3] = array('db' => 'fom.awb_number', 'dt' => 3, 'field' => 'awb_number');
		$columns[4] = array('db' => 'ra.name', 'dt' => 4, 'field' => 'name', 'formatter' => function ($d, $row) {
			return "<span>" . $d . "</span>";
		});
		$columns[5] = array('db' => 'ra.mobile_no', 'dt' => 5, 'field' => 'mobile_no', 'formatter' => function ($d, $row) {
			return '<span>' . $d . '</span>';
		});
		$columns[6] = array('db' => 'fom.order_type', 'dt' => 6, 'field' => 'order_type', 'formatter' => function ($d, $row) {
			switch ($d) {
				case '0':
					return "Prepaid";
					break;
				case '1':
					return "COD";
					break;
				default:
					return "";
					break;
			}
		});
		// $columns[7] = array('db' => 'lm.logistic_name', 'dt' => 7, 'field' => 'logistic_name');
		$columns[7] = array('db' => 'fom.created_date', 'dt' => 7, 'field' => 'created_date', 'formatter' => function ($d, $row) {
			return date('m-d-Y H:i:s', strtotime($d));
		});
		$columns[8] = array(
			'db' => 'fom.id', 'dt' => 8, 'field' => 'id',
			'formatter' => function ($d, $row) {
				return "";
			}
		);
		$columns[9] = array(
			'db' => 'fom.created_date', 'dt' => 9, 'field' => 'created_date',
			'formatter' => function ($d, $row) {
				return "";
			}
		);

		if ($this->session->userdata('userType') == '1') {
			$columns[10] = array('db' => 'sm.name', 'dt' => 10, 'field' => 'name', 'formatter' => function ($d, $row) {
				return "<span>" . $d . "</span>";
			});
			$columns[11] = array('db' => 'sm.name', 'dt' => 11, 'field' => 'name', 'formatter' => function ($d, $row) {
				return "<span>" . $d . "</span>";
			});
		} else {
			$columns[10] = array('db' => 'fom.id', 'dt' => 10, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<div class='row'><a href='" . base_url('packing-slip/' . $d) . "' target='_blank'>
                <i class='fa fa-print' aria-hidden='true' style='font-size:20px;'></i>
                </a><a><button type='button' class='btn btn-danger btn-xs waves-effect waves-classic' style=''>Delete</button></a></div>";
			});
		}


		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where)
		);
	}

	/**
	 * Created Order Table
	 */

	public function createdorder_list_view()
	{
		$this->data['order_count'] = $this->get_order_count();
		$user_id = $this->session->userdata('userId');
		$this->load->model('Order_model');
		$this->data['assign_labels'] = $this->Order_model->get_user_assign_label($user_id);
		$this->loadview('created_order_list', $this->data);
	}
	public function created_order_table()
	{
		$columns = array();
		$table = 'forward_order_master';
		$primaryKey = 'id';
		if ($this->session->userdata['userType'] == '1') {
			$where = "os.order_status_id = '1' AND fom.is_pre_awb = '0' AND fom.is_delete='0'";
		} else {
			$where = "os.order_status_id = '1' AND fom.is_pre_awb = '0' AND fom.is_delete='0' AND fom.sender_id='" . $this->session->userdata['userId'] . "'";
		}

		$joinQuery = ' FROM ' . $table . ' fom INNER JOIN sender_master as sm ON sm.id=fom.sender_id INNER JOIN logistic_master as lm ON lm.id=fom.logistic_id INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id LEFT JOIN order_airwaybill_detail as owd ON owd.order_id = fom.id LEFT JOIN order_status as os ON os.order_status_id = owd.order_status_id';

		$columns[0] = array('db' => 'fom.id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {
			return '<input type="checkbox" class="select-item" name="id[]" value="' . $d . '">';
		});
		$columns[1] = array('db' => 'fom.order_no', 'dt' => 1, 'field' => 'order_no');

		$columns[2] = array('db' => 'fom.customer_order_no', 'dt' => 2, 'field' => 'customer_order_no');
		$columns[3] = array('db' => 'fom.awb_number', 'dt' => 3, 'field' => 'awb_number');
		$columns[4] = array('db' => 'ra.name', 'dt' => 4, 'field' => 'name', 'formatter' => function ($d, $row) {
			return "<span>" . $d . "</span>";
		});
		$columns[5] = array('db' => 'ra.mobile_no', 'dt' => 5, 'field' => 'mobile_no', 'formatter' => function ($d, $row) {
			return '<span>' . $d . '</span>';
		});
		$columns[6] = array('db' => 'fom.order_type', 'dt' => 6, 'field' => 'order_type', 'formatter' => function ($d, $row) {
			switch ($d) {
				case '0':
					return "Prepaid";
					break;
				case '1':
					return "COD";
					break;
				default:
					return "";
					break;
			}
		});
		// $columns[7] = array('db' => 'lm.logistic_name', 'dt' => 7, 'field' => 'logistic_name');
		$columns[7] = array('db' => 'fom.created_date', 'dt' => 7, 'field' => 'created_date', 'formatter' => function ($d, $row) {
			return date('m-d-Y H:i:s', strtotime($d));
		});
		$columns[8] = array(
			'db' => 'fom.id', 'dt' => 8, 'field' => 'id',
			'formatter' => function ($d, $row) {
				return "";
			}
		);
		$columns[9] = array(
			'db' => 'fom.created_date', 'dt' => 9, 'field' => 'created_date',
			'formatter' => function ($d, $row) {
				return "";
			}
		);

		$columns[10] = array(
			'db' => 'os.status_name', 'dt' => 10, 'field' => 'status_name'
			// , 'formatter' => function ($d, $row) {
			//     return "<span>".$d."</span>";}
		);

		if ($this->session->userdata('userType') == '1') {
			$columns[11] = array('db' => 'sm.name', 'dt' => 11, 'field' => 'name', 'formatter' => function ($d, $row) {
				return "<span>" . $d . "</span>";
			});
			$columns[12] = array('db' => 'fom.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<div class=''><a class='single_order_print_button' data-id='" . $d . "'><i class='fa fa-print' aria-hidden='true' style='font-size:30px;'></i></a></div>";
			});
			$columns[13] = array('db' => 'fom.id', 'dt' => 13, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<div class='row'><a class='btn btn-danger' href='" . base_url('delete-created-order/' . $d) . "'>Delete</a></div>";
			});
		} else {
			$columns[11] = array('db' => 'fom.id', 'dt' => 11, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<div class=''><a class='single_order_print_button' data-id='" . $d . "'><i class='fa fa-print' aria-hidden='true' style='font-size:30px;'></i></a></div>";
			});
			$columns[12] = array('db' => 'fom.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<div class='row'><a class='btn btn-danger' href='" . base_url('delete-created-order/' . $d) . "'>Delete</a></div>";
			});
		}

		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where)
		);
	}

	/**
	 * Intransit Order Table
	 */
	public function intransit_order_list()
	{
		$this->data['order_count'] = $this->get_order_count();
		$this->loadview('intransit_order_list', $this->data);
	}
	public function intransit_order_table()
	{
		$columns = array();
		$table = 'forward_order_master';
		$primaryKey = 'id';
		$where = "os.order_status_id = '3' AND fom.is_pre_awb = '0'";
		$joinQuery = ' FROM ' . $table . ' fom INNER JOIN sender_master as sm ON sm.id=fom.sender_id INNER JOIN logistic_master as lm ON lm.id=fom.logistic_id INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id LEFT JOIN order_airwaybill_detail as owd ON owd.order_id = fom.id LEFT JOIN order_status as os ON os.order_status_id = owd.order_status_id INNER JOIN logistic_master as lom ON fom.logistic_id = lom.id';

		$columns[0] = array('db' => 'fom.id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {
			return '<input type="checkbox" class="select-item" name="id[]" value="' . $d . '">';
		});
		$columns[1] = array('db' => 'fom.order_no', 'dt' => 1, 'field' => 'order_no');
		$columns[2] = array('db' => 'fom.customer_order_no', 'dt' => 2, 'field' => 'customer_order_no');
		$columns[3] = array('db' => 'fom.awb_number', 'dt' => 3, 'field' => 'awb_number');
		$columns[4] = array('db' => 'lom.logistic_name', 'dt' => 4, 'field' => 'logistic_name');
		$columns[5] = array('db' => 'ra.name', 'dt' => 5, 'field' => 'name', 'formatter' => function ($d, $row) {
			return "<span>" . $d . "</span>";
		});
		$columns[6] = array('db' => 'ra.mobile_no', 'dt' => 6, 'field' => 'mobile_no', 'formatter' => function ($d, $row) {
			return '<span>' . $d . '</span>';
		});
		$columns[7] = array('db' => 'fom.order_type', 'dt' => 7, 'field' => 'order_type', 'formatter' => function ($d, $row) {
			switch ($d) {
				case '0':
					return "Prepaid";
					break;
				case '1':
					return "COD";
					break;
				default:
					return "";
					break;
			}
		});
		// $columns[7] = array('db' => 'lm.logistic_name', 'dt' => 7, 'field' => 'logistic_name');
		$columns[8] = array('db' => 'fom.created_date', 'dt' => 8, 'field' => 'created_date', 'formatter' => function ($d, $row) {
			return date('m-d-Y H:i:s', strtotime($d));
		});
		$columns[9] = array(
			'db' => 'fom.id', 'dt' => 9, 'field' => 'id',
			'formatter' => function ($d, $row) {
				return "";
			}
		);
		$columns[10] = array(
			'db' => 'fom.created_date', 'dt' => 10, 'field' => 'created_date',
			'formatter' => function ($d, $row) {
				return "";
			}
		);
		$columns[11] = array(
			'db' => 'os.status_name', 'dt' => 11, 'field' => 'status_name'
			// , 'formatter' => function ($d, $row) {
			//     return "<span>".$d."</span>";}
		);

		if ($this->session->userdata('userType') == '1') {
			$columns[12] = array('db' => 'sm.name', 'dt' => 12, 'field' => 'name', 'formatter' => function ($d, $row) {
				return "<span>" . $d . "</span>";
			});

			$columns[13] = array('db' => 'fom.id', 'dt' => 13, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-toggle='modal' data-id='$row[1]' id='intransit_order_btn' data-target='#intransit_order_details' data-details='order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'>Order Details</button></div>
                <a><button type='button' data-toggle='modal' id='order_tracking_btn' data-target='#intransit_order_details' data-details='order_tracking' data-id='$row[1]' class='btn btn-primary btn-xs waves-effect waves-classic'style='margin-top: 5px;'>Order Tracking</button>
                </a>";
			});
		} else {
			$columns[12] = array('db' => 'fom.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-toggle='modal' id='intransit_order_btn' data-target='#intransit_order_details' data-id='$row[1]' data-details='order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'>Order Details</button></div>
                <a><button type='button' data-toggle='modal' id='order_tracking_btn' data-target='#intransit_order_details'data-details='order_tracking' data-id='$row[1]' class='btn btn-primary btn-xs waves-effect waves-classic'style='margin-top: 5px;'>Order Tracking</button></a>";
			});
		}

		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where)
		);
	}

	/**
	 * OFD Order Table
	 */
	public function ofd_order_list()
	{
		$this->data['order_count'] = $this->get_order_count();
		$this->loadview('ofd_order_list', $this->data);
	}
	public function ofd_order_table()
	{
		$columns = array();
		$table = 'forward_order_master';
		$primaryKey = 'id';
		$where = "os.order_status_id = '5' AND fom.is_pre_awb = '0'";
		$joinQuery = ' FROM ' . $table . ' fom INNER JOIN sender_master as sm ON sm.id=fom.sender_id INNER JOIN logistic_master as lm ON lm.id=fom.logistic_id INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id LEFT JOIN order_airwaybill_detail as owd ON owd.order_id = fom.id LEFT JOIN order_status as os ON os.order_status_id = owd.order_status_id';

		$columns[0] = array('db' => 'fom.id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {
			return '<input type="checkbox" class="select-item" name="id[]" value="' . $d . '">';
		});
		$columns[1] = array('db' => 'fom.order_no', 'dt' => 1, 'field' => 'order_no');
		$columns[2] = array('db' => 'fom.customer_order_no', 'dt' => 2, 'field' => 'customer_order_no');
		$columns[3] = array('db' => 'fom.awb_number', 'dt' => 3, 'field' => 'awb_number');
		$columns[4] = array('db' => 'ra.name', 'dt' => 4, 'field' => 'name', 'formatter' => function ($d, $row) {
			return "<span>" . $d . "</span>";
		});
		$columns[5] = array('db' => 'ra.mobile_no', 'dt' => 5, 'field' => 'mobile_no', 'formatter' => function ($d, $row) {
			return '<span>' . $d . '</span>';
		});
		$columns[6] = array('db' => 'fom.order_type', 'dt' => 6, 'field' => 'order_type', 'formatter' => function ($d, $row) {
			switch ($d) {
				case '0':
					return "Prepaid";
					break;
				case '1':
					return "COD";
					break;
				default:
					return "";
					break;
			}
		});
		// $columns[7] = array('db' => 'lm.logistic_name', 'dt' => 7, 'field' => 'logistic_name');
		$columns[7] = array('db' => 'fom.created_date', 'dt' => 7, 'field' => 'created_date', 'formatter' => function ($d, $row) {
			return date('m-d-Y H:i:s', strtotime($d));
		});
		$columns[8] = array(
			'db' => 'fom.id', 'dt' => 8, 'field' => 'id',
			'formatter' => function ($d, $row) {
				return "";
			}
		);
		$columns[9] = array(
			'db' => 'fom.created_date', 'dt' => 9, 'field' => 'created_date',
			'formatter' => function ($d, $row) {
				return "";
			}
		);
		$columns[10] = array(
			'db' => 'os.status_name', 'dt' => 10, 'field' => 'status_name'
			// , 'formatter' => function ($d, $row) {
			//     return "<span>".$d."</span>";}
		);
		if ($this->session->userdata('userType') == '1') {
			$columns[11] = array('db' => 'sm.name', 'dt' => 11, 'field' => 'name', 'formatter' => function ($d, $row) {
				return "<span>" . $d . "</span>";
			});

			$columns[12] = array('db' => 'fom.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-toggle='modal' data-id='$row[1]' id='ofd_order_btn' data-target='#ofd_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'>Order Details</button></div>
                <a><button type='button' class='btn btn-primary btn-xs waves-effect waves-classic'style='margin-top: 5px;' >Order Tracking</button></a>";
			});
		} else {
			$columns[11] = array('db' => 'fom.id', 'dt' => 11, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-toggle='modal' id='ofd_order_btn' data-target='#ofd_order_details' data-id='$row[1]' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'>Order Details</button></div>
                <a><button type='button' class='btn btn-primary btn-xs waves-effect waves-classic'style='margin-top: 5px;'>Order Tracking</button></a>";
			});
		}

		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where)
		);
	}

	/**
	 * NDR Order Table
	 */
	public function ndr_order_list()
	{
		$this->data['order_count'] = $this->get_order_count();
		$this->loadview('ndr_order_list', $this->data);
	}
	public function ndr_order_table()
	{
		$columns = array();
		$table = 'forward_order_master';
		$primaryKey = 'id';
		$where = "os.order_status_id = '18' AND fom.is_pre_awb = '0'";
		$joinQuery = ' FROM ' . $table . ' fom INNER JOIN sender_master as sm ON sm.id=fom.sender_id INNER JOIN logistic_master as lm ON lm.id=fom.logistic_id INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id LEFT JOIN order_airwaybill_detail as owd ON owd.order_id = fom.id LEFT JOIN order_status as os ON os.order_status_id = owd.order_status_id ';
		//$order = 'created_date DESC';

		$columns[0] = array('db' => 'fom.id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {
			return '<input type="checkbox" class="select-item" name="id[]" value="' . $d . '">';
		});
		$columns[1] = array('db' => 'fom.order_no', 'dt' => 1, 'field' => 'order_no');
		$columns[2] = array('db' => 'fom.customer_order_no', 'dt' => 2, 'field' => 'customer_order_no');
		$columns[3] = array('db' => 'fom.awb_number', 'dt' => 3, 'field' => 'awb_number');
		$columns[4] = array('db' => 'ra.name', 'dt' => 4, 'field' => 'name', 'formatter' => function ($d, $row) {
			return "<span>" . $d . "</span>";
		});
		$columns[5] = array('db' => 'ra.mobile_no', 'dt' => 5, 'field' => 'mobile_no', 'formatter' => function ($d, $row) {
			return '<span>' . $d . '</span>';
		});
		$columns[6] = array('db' => 'fom.order_type', 'dt' => 6, 'field' => 'order_type', 'formatter' => function ($d, $row) {
			switch ($d) {
				case '0':
					return "Prepaid";
					break;
				case '1':
					return "COD";
					break;
				default:
					return "";
					break;
			}
		});
		// $columns[7] = array('db' => 'lm.logistic_name', 'dt' => 7, 'field' => 'logistic_name');
		$columns[7] = array('db' => 'fom.created_date', 'dt' => 7, 'field' => 'created_date', 'formatter' => function ($d, $row) {
			return date('m-d-Y H:i:s', strtotime($d));
		});
		$columns[8] = array(
			'db' => 'fom.created_date', 'dt' => 8, 'field' => 'created_date', 'formatter' => function ($d, $row) {
				return "";
			}
		);
		$columns[9] = array(
			'db' => 'fom.created_date', 'dt' => 9, 'field' => 'created_date',
			'formatter' => function ($d, $row) {
				return "";
			}
		);
		$columns[10] = array(
			'db' => 'os.status_name', 'dt' => 10, 'field' => 'status_name'
			// , 'formatter' => function ($d, $row) {
			//     return "<span>".$d."</span>";}
		);
		if ($this->session->userdata('userType') == '1') {
			$columns[11] = array('db' => 'sm.name', 'dt' => 11, 'field' => 'name', 'formatter' => function ($d, $row) {
				return "<span>" . $d . "</span>";
			});

			$columns[12] = array('db' => 'fom.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-toggle='modal' data-id='$row[1]' id='ndr_order_btn' data-target='#ndr_order_details' data-details='order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'>Order Tracking</button></div>
                <button type='button' data-toggle='modal' data-target='#ndr_order_comment' data-id='$row[1]' id='order_ndr_comment' class='btn btn-primary btn-xs waves-effect waves-classic'style='margin-top: 5px;'>NDR Comment</button>";
			});
		} else {
			$columns[11] = array('db' => 'fom.id', 'dt' => 11, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-toggle='modal' data-id='$row[1]' id='ndr_order_btn' data-target='#ndr_order_details' data-details='order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'>Order Tracking</button></div>
                <button type='button' data-toggle='modal' data-target='#ndr_order_comment' data-id='$row[1]' id='order_ndr_comment' class='btn btn-primary btn-xs waves-effect waves-classic'style='margin-top: 5px;'>NDR Comment</button>";
			});
		}

		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where)
		);
	}

	/**
	 * Delivered Order Table
	 */
	public function delivered_order_list()
	{
		$this->data['order_count'] = $this->get_order_count();
		$this->loadview('delivered_order_list', $this->data);
	}
	public function delivered_order_table()
	{
		$columns = array();
		$table = 'forward_order_master';
		$primaryKey = 'id';
		$where = "os.order_status_id = '6' AND fom.is_pre_awb = '0'";
		$joinQuery = ' FROM ' . $table . ' fom INNER JOIN sender_master as sm ON sm.id=fom.sender_id INNER JOIN logistic_master as lm ON lm.id=fom.logistic_id INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id LEFT JOIN order_airwaybill_detail as owd ON owd.order_id = fom.id LEFT JOIN order_status as os ON os.order_status_id = owd.order_status_id';

		$columns[0] = array('db' => 'fom.id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {
			return '<input type="checkbox" class="select-item" name="id[]" value="' . $d . '">';
		});
		$columns[1] = array('db' => 'fom.order_no', 'dt' => 1, 'field' => 'order_no');
		$columns[2] = array('db' => 'fom.customer_order_no', 'dt' => 2, 'field' => 'customer_order_no');
		$columns[3] = array('db' => 'fom.awb_number', 'dt' => 3, 'field' => 'awb_number');
		$columns[4] = array('db' => 'ra.name', 'dt' => 4, 'field' => 'name', 'formatter' => function ($d, $row) {
			return "<span>" . $d . "</span>";
		});
		$columns[5] = array('db' => 'ra.mobile_no', 'dt' => 5, 'field' => 'mobile_no', 'formatter' => function ($d, $row) {
			return '<span>' . $d . '</span>';
		});
		$columns[6] = array('db' => 'fom.order_type', 'dt' => 6, 'field' => 'order_type', 'formatter' => function ($d, $row) {
			switch ($d) {
				case '0':
					return "Prepaid";
					break;
				case '1':
					return "COD";
					break;
				default:
					return "";
					break;
			}
		});
		// $columns[7] = array('db' => 'lm.logistic_name', 'dt' => 7, 'field' => 'logistic_name');
		$columns[7] = array('db' => 'fom.created_date', 'dt' => 7, 'field' => 'created_date', 'formatter' => function ($d, $row) {
			return date('m-d-Y H:i:s', strtotime($d));
		});
		$columns[8] = array(
			'db' => 'fom.id', 'dt' => 8, 'field' => 'id',
			'formatter' => function ($d, $row) {
				return "";
			}
		);
		$columns[9] = array(
			'db' => 'fom.created_date', 'dt' => 9, 'field' => 'created_date',
			'formatter' => function ($d, $row) {
				return "";
			}
		);
		$columns[10] = array(
			'db' => 'os.status_name', 'dt' => 10, 'field' => 'status_name'
			// , 'formatter' => function ($d, $row) {
			//     return "<span>".$d."</span>";}
		);
		if ($this->session->userdata('userType') == '1') {
			$columns[11] = array('db' => 'sm.name', 'dt' => 11, 'field' => 'name', 'formatter' => function ($d, $row) {
				return "<span>" . $d . "</span>";
			});

			$columns[12] = array('db' => 'fom.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-toggle='modal' data-id='$row[1]' id='delivered_order_btn' data-target='#delivered_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'>Order Details</button></div>
                <a><button type='button' class='btn btn-primary btn-xs waves-effect waves-classic'style='margin-top: 5px;' >Order Tracking</button></a>";
			});
		} else {
			$columns[11] = array('db' => 'fom.id', 'dt' => 11, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-toggle='modal' id='delivered_order_btn' data-target='#delivered_order_details' data-id='$row[1]' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'>Order Details</button></div>
                <a><button type='button' class='btn btn-primary btn-xs waves-effect waves-classic'style='margin-top: 5px;'>Order Tracking</button></a>";
			});
		}


		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where)
		);
	}

	/**
	 * RTO InTransit Order Table
	 */
	public function rtoIntransit_order_list()
	{
		$this->data['order_count'] = $this->get_order_count();
		$this->loadview('rto_order_list', $this->data);
	}
	public function rtointransit_order_table()
	{
		$columns = array();
		$table = 'forward_order_master';
		$primaryKey = 'id';
		$where = "os.order_status_id = '11' AND fom.is_pre_awb = '0'";
		$joinQuery = ' FROM ' . $table . ' fom INNER JOIN sender_master as sm ON sm.id=fom.sender_id INNER JOIN logistic_master as lm ON lm.id=fom.logistic_id INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id LEFT JOIN order_airwaybill_detail as owd ON owd.order_id = fom.id LEFT JOIN order_status as os ON os.order_status_id = owd.order_status_id';

		$columns[0] = array('db' => 'fom.id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {
			return '<input type="checkbox" class="select-item" name="id[]" value="' . $d . '">';
		});
		$columns[1] = array('db' => 'fom.order_no', 'dt' => 1, 'field' => 'order_no');
		$columns[2] = array('db' => 'fom.customer_order_no', 'dt' => 2, 'field' => 'customer_order_no');
		$columns[3] = array('db' => 'fom.awb_number', 'dt' => 3, 'field' => 'awb_number');
		$columns[4] = array('db' => 'ra.name', 'dt' => 4, 'field' => 'name', 'formatter' => function ($d, $row) {
			return "<span>" . $d . "</span>";
		});
		$columns[5] = array('db' => 'ra.mobile_no', 'dt' => 5, 'field' => 'mobile_no', 'formatter' => function ($d, $row) {
			return '<span>' . $d . '</span>';
		});
		$columns[6] = array('db' => 'fom.order_type', 'dt' => 6, 'field' => 'order_type', 'formatter' => function ($d, $row) {
			switch ($d) {
				case '0':
					return "Prepaid";
					break;
				case '1':
					return "COD";
					break;
				default:
					return "";
					break;
			}
		});
		// $columns[7] = array('db' => 'lm.logistic_name', 'dt' => 7, 'field' => 'logistic_name');
		$columns[7] = array('db' => 'fom.created_date', 'dt' => 7, 'field' => 'created_date', 'formatter' => function ($d, $row) {
			return date('m-d-Y H:i:s', strtotime($d));
		});
		$columns[8] = array(
			'db' => 'fom.id', 'dt' => 8, 'field' => 'id',
			'formatter' => function ($d, $row) {
				return "";
			}
		);
		$columns[9] = array(
			'db' => 'fom.created_date', 'dt' => 9, 'field' => 'created_date',
			'formatter' => function ($d, $row) {
				return "";
			}
		);
		$columns[10] = array(
			'db' => 'os.status_name', 'dt' => 10, 'field' => 'status_name'
			// , 'formatter' => function ($d, $row) {
			//     return "<span>".$d."</span>";}
		);
		if ($this->session->userdata('userType') == '1') {
			$columns[11] = array('db' => 'sm.name', 'dt' => 11, 'field' => 'name', 'formatter' => function ($d, $row) {
				return "<span>" . $d . "</span>";
			});

			$columns[12] = array('db' => 'fom.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-toggle='modal' data-id='$row[1]' id='rto_intransit_order_btn' data-target='#rto_intransit_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'>Order Details</button></div>
                <a><button type='button' data-id='$row[1]' data-target='#rto_intransit_order_details' class='btn btn-primary btn-xs waves-effect waves-classic'style='margin-top: 5px;' >Order Tracking</button></a>";
			});
		} else {
			$columns[11] = array('db' => 'fom.id', 'dt' => 11, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-toggle='modal' id='rto_intransit_order_btn' data-target='#rto_intransit_order_details' data-id='$row[1]' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'>Order Details</button></div>
                <a><button type='button' data-target='#rto_intransit_order_details' class='btn btn-primary btn-xs waves-effect waves-classic'style='margin-top: 5px;'>Order Tracking</button></a>";
			});
		}
		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where)
		);
	}

	/**
	 * RTO Delivered Order Table
	 */
	public function rtodelivered_order_list()
	{
		$this->data['order_count'] = $this->get_order_count();
		$this->loadview('rto_delivered_list', $this->data);
	}
	public function rtodelivered_order_table()
	{
		$columns = array();
		$table = 'forward_order_master';
		$primaryKey = 'id';
		$where = "os.order_status_id = '12' AND fom.is_pre_awb = '0'";
		$joinQuery = ' FROM ' . $table . ' fom INNER JOIN sender_master as sm ON sm.id=fom.sender_id INNER JOIN logistic_master as lm ON lm.id=fom.logistic_id INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id LEFT JOIN order_airwaybill_detail as owd ON owd.order_id = fom.id LEFT JOIN order_status as os ON os.order_status_id = owd.order_status_id';

		$columns[0] = array('db' => 'fom.id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {
			return '<input type="checkbox" class="select-item" name="id[]" value="' . $d . '">';
		});
		$columns[1] = array('db' => 'fom.order_no', 'dt' => 1, 'field' => 'order_no');
		$columns[2] = array('db' => 'fom.customer_order_no', 'dt' => 2, 'field' => 'customer_order_no');
		$columns[3] = array('db' => 'fom.awb_number', 'dt' => 3, 'field' => 'awb_number');
		$columns[4] = array('db' => 'ra.name', 'dt' => 4, 'field' => 'name', 'formatter' => function ($d, $row) {
			return "<span>" . $d . "</span>";
		});
		$columns[5] = array('db' => 'ra.mobile_no', 'dt' => 5, 'field' => 'mobile_no', 'formatter' => function ($d, $row) {
			return '<span>' . $d . '</span>';
		});
		$columns[6] = array('db' => 'fom.order_type', 'dt' => 6, 'field' => 'order_type', 'formatter' => function ($d, $row) {
			switch ($d) {
				case '0':
					return "Prepaid";
					break;
				case '1':
					return "COD";
					break;
				default:
					return "";
					break;
			}
		});
		// $columns[7] = array('db' => 'lm.logistic_name', 'dt' => 7, 'field' => 'logistic_name');
		$columns[7] = array('db' => 'fom.created_date', 'dt' => 7, 'field' => 'created_date', 'formatter' => function ($d, $row) {
			return date('m-d-Y H:i:s', strtotime($d));
		});
		$columns[8] = array(
			'db' => 'fom.id', 'dt' => 8, 'field' => 'id',
			'formatter' => function ($d, $row) {
				return "";
			}
		);
		$columns[9] = array(
			'db' => 'fom.created_date', 'dt' => 9, 'field' => 'created_date',
			'formatter' => function ($d, $row) {
				return "";
			}
		);
		$columns[10] = array(
			'db' => 'os.status_name', 'dt' => 10, 'field' => 'status_name'
			// , 'formatter' => function ($d, $row) {
			//     return "<span>".$d."</span>";}
		);
		if ($this->session->userdata('userType') == '1') {
			$columns[11] = array('db' => 'sm.name', 'dt' => 11, 'field' => 'name', 'formatter' => function ($d, $row) {
				return "<span>" . $d . "</span>";
			});

			$columns[12] = array('db' => 'fom.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-toggle='modal' data-id='$row[1]' id='rto_delivered_order_btn' data-target='#rto_delivered_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'>Order Details</button></div>
                <a><button type='button' class='btn btn-primary btn-xs waves-effect waves-classic'style='margin-top: 5px;' >Order Tracking</button></a>";
			});
		} else {
			$columns[11] = array('db' => 'fom.id', 'dt' => 11, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-toggle='modal' id='rto_delivered_order_btn' data-target='#rto_delivered_order_details' data-id='$row[1]' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'>Order Details</button></div>
                <a><button type='button' class='btn btn-primary btn-xs waves-effect waves-classic'style='margin-top: 5px;'>Order Tracking</button></a>";
			});
		}

		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where)
		);
	}

	/**
	 * Created Order Table
	 */

	public function errororder_list_view()
	{
		$this->data['order_count'] = $this->get_order_count();
		$this->loadview('error_order_list', $this->data);
	}
	public function error_order_table()
	{
		$columns = array();
		$table = 'error_order_master';
		$primaryKey = 'id';
		if ($this->session->userdata['userType'] == '1') {
			$where = "fom.is_pre_awb = '0' AND fom.is_delete = '0'";
		} else {
			$where = "fom.is_pre_awb = '0' AND fom.sender_id='" . $this->session->userdata['userId'] . "'";
		}
		//$where = "fom.is_pre_awb = '0' AND fom.is_delete='0'";
		$joinQuery = ' FROM ' . $table . ' fom INNER JOIN sender_master as sm ON sm.id=fom.sender_id INNER JOIN logistic_master as lm ON lm.id=fom.logistic_id INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id LEFT JOIN order_airwaybill_detail as owd ON owd.order_id = fom.id JOIN order_error_log as oel ON fom.id=oel.order_Error_id';

		$columns[0] = array('db' => 'fom.id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {
			return '<input type="checkbox" class="select-item" name="id[]" value="' . $d . '">';
		});
		$columns[1] = array('db' => 'fom.order_no', 'dt' => 1, 'field' => 'order_no');

		$columns[2] = array('db' => 'fom.customer_order_no', 'dt' => 2, 'field' => 'customer_order_no');
		$columns[3] = array('db' => 'fom.awb_number', 'dt' => 3, 'field' => 'awb_number');
		$columns[4] = array('db' => 'ra.name', 'dt' => 4, 'field' => 'name', 'formatter' => function ($d, $row) {
			return "<span>" . $d . "</span>";
		});
		$columns[5] = array('db' => 'ra.mobile_no', 'dt' => 5, 'field' => 'mobile_no', 'formatter' => function ($d, $row) {
			return '<span>' . $d . '</span>';
		});
		$columns[6] = array('db' => 'fom.order_type', 'dt' => 6, 'field' => 'order_type', 'formatter' => function ($d, $row) {
			switch ($d) {
				case '0':
					return "Prepaid";
					break;
				case '1':
					return "COD";
					break;
				default:
					return "";
					break;
			}
		});
		// $columns[7] = array('db' => 'lm.logistic_name', 'dt' => 7, 'field' => 'logistic_name');
		$columns[7] = array('db' => 'fom.created_date', 'dt' => 7, 'field' => 'created_date', 'formatter' => function ($d, $row) {
			return date('m-d-Y H:i:s', strtotime($d));
		});
		$columns[8] = array(
			'db' => 'oel.error', 'dt' => 8, 'field' => 'error'
		);

		// $columns[8] = array('db' => 'oel.error', 'dt' => 8, 'field' => 'remarks');

		if ($this->session->userdata('userType') == '1') {
			$columns[9] = array('db' => 'sm.name', 'dt' => 9, 'field' => 'name', 'formatter' => function ($d, $row) {
				return "<span>" . $d . "</span>";
			});
			$columns[10] = array('db' => 'fom.id', 'dt' => 10, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<a class='btn btn-danger' href='" . base_url('delete-error-order/' . $d) . "'>Delete</a>";
			});
		} else {
			$columns[9] = array('db' => 'fom.id', 'dt' => 9, 'field' => 'id', 'formatter' => function ($d, $row) {
			});
			$columns[10] = array('db' => 'fom.id', 'dt' => 10, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<a class='btn btn-danger' href='" . base_url('delete-error-order/' . $d) . "'>Delete</a>";
			});
		}

		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where)
		);
	}

	public function packing_slip($order_id)
	{
		// die($order_id);
		$this->load->model('Order_model');
		// $order_id = 11;
		$order_info = $this->Order_model->get_multiple_order_list_for_slip($order_id);

		foreach ($order_info as $single_order_info) {
			$data['order_info'] = $single_order_info;
			if ($single_order_info['airwaybill_barcode_img'] != "") {
				$data['order_info']['airwaybill_barcode_img'] = 'uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'];
			} else {
				$data['order_info']['airwaybill_barcode_img'] = $this->createWaybillBarcodeImage($single_order_info['id'], $single_order_info['awb_number']);
			}
		}
		// $this->load->library('Pdf');
		// $this->pdf->set_options(array('tempDir', '/home/admin/web/app.packanddrop.com/tmp'));
		// $html = $this->load->view('admin/order/single_packing_slip', $data, true);
		// $this->pdf->createPDF($html, 'packing-slip', false, 'A4', 'portrait');
		$this->load->library('pdf');
		$html = $this->load->view('admin/order/single_packing_slip', $data, true);
		// echo $html;
		// exit;
		$this->pdf->createPDF($html, 'packing-slip', false, 'A4', 'portrait');
	}

	//get order list count
	public function get_order_count()
	{
		$data['get_all_order_list'] = $this->View_order_model->get_count('');
		$data['get_created_order_list'] = $this->View_order_model->get_count('1');
		$data['get_intransit_order_list'] = $this->View_order_model->get_count('3');
		$data['get_ofd_order_list'] = $this->View_order_model->get_count('5');
		$data['get_ndr_order_list'] = $this->View_order_model->get_count('18');
		$data['get_delivered_order_list'] = $this->View_order_model->get_count('6');
		$data['get_rtointransit_order_list'] = $this->View_order_model->get_count('11');
		$data['get_rtodelivered_order_list '] = $this->View_order_model->get_count('12');
		$data['get_onprocess_order_list'] = $this->View_order_model->get_onprocess_data();
		$data['get_error_order_list'] = $this->View_order_model->get_error_data($this->session->userdata('userId'), $this->session->userdata('userType'));
		return $data;
	}

	function createWaybillBarcodeImage($order_id, $airwaybill_number)
	{
		$data1 =  CUSTOM::barcode($this->config->item('FILE_PATH') . 'uploads/order_barcode/' . $order_id . '.jpg', $airwaybill_number, 40, 'horizontal', 'Code128', '', 1);
		$data['airwaybill_barcode_img'] = $order_id . '.jpg';
		$this->Common_model->update($data, 'order_airwaybill_detail', array('order_id' => $order_id));
		return 'uploads/order_barcode/' . $order_id . ".jpg";
	}

	//multiple packing slip (1st packing slip)
	public function multiple_packing_slip()
	{
		$order_ids = $this->input->post('id');
		$this->load->model('Order_model');
		$order_info = $this->Order_model->get_multiple_order_list_for_slip($order_ids);
		$this->load->library('pdf');
		$i = 0;
		foreach ($order_info as $single_order_info) {
			$data['order_info'][$i] = $single_order_info;
			if ($single_order_info['airwaybill_barcode_img'] != "") {

				$data['order_info'][$i]['airwaybill_barcode_img1'] = 'uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'];
			} else {
				$data['order_info'][$i]['airwaybill_barcode_img1'] = $this->createWaybillBarcodeImage($single_order_info['id'], $single_order_info['awb_number']);
			}
			$i++;
		}
		// dd($data);
		// multiple_packing_slip_first
		// multiple_packing_slip_second
		// multiple_packing_slip_third
		// multiple_packing_slip_forth
		// echo $this->input->post('label_type');
		// exit;
		$html = $this->load->view('admin/order/multiple_packing_slip_' . str_replace(array('1', '2', '3', '4'), array('first', 'second', 'third', 'forth'), $this->input->post('label_type')), $data, true);

		// echo $html;
		// exit();


		$filename = rand() . ".pdf";
		$Dpath = $this->config->item('FILE_PATH') . 'uploads/multiple_print/*';
		$files = glob($Dpath);
		if (isset($files)) {
			foreach ($files as $findfile) {
				unlink($findfile);
			}
		}
		$this->pdf->load_html($html);
		$this->pdf->render();
		$output = $this->pdf->output();

		file_put_contents($this->config->item('FILE_PATH') . 'uploads/multiple_print/' . $filename, $output);
		echo $filename;
		exit();
	}

	// 2nd packing slip single
	public function new_single_packing_slip($id)
	{
		$this->load->model('Order_model');
		$order_id = $id;
		$order_info = $this->Order_model->get_multiple_order_list_for_slip($order_id);
		$this->load->library('pdf');
		// dd($order_info);
		foreach ($order_info as $single_order_info) {
			$data['order_info'] = $single_order_info;
			if ($single_order_info['airwaybill_barcode_img'] != "") {
				$data['order_info']['airwaybill_barcode_img'] = 'uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'];
			} else {
				$data['order_info']['airwaybill_barcode_img'] = $this->createWaybillBarcodeImage($single_order_info['id'], $single_order_info['awb_number']);
			}
		}
		$html = $this->load->view('admin/order/new_single_packing_slip', $data, true);
		// echo $html;
		// exit;
		$this->pdf->createPDF($html, 'packing-slip', false, 'A4', 'portrait');
	}

	//mulitple 2nd packing slip
	public function new_multiple_packing_slip()
	{
		$order_ids = $this->input->post('id');

		$this->load->model('Order_model');
		$order_info = $this->Order_model->get_multiple_order_list_for_slip($order_ids);
		$this->load->library('pdf');
		$i = 0;
		$data = array();
		foreach ($order_info as $single_order_info) {
			$data['order_info'][$i] = $single_order_info;
			if ($single_order_info['airwaybill_barcode_img'] != "") {

				$data['order_info'][$i]['airwaybill_barcode_img1'] = 'Uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'];
			} else {
				$data['order_info'][$i]['airwaybill_barcode_img1'] = $this->createWaybillBarcodeImage($single_order_info['id'], $single_order_info['awb_number']);
			}
			$i++;
		}

		$html = $this->load->view('admin/order/new_multiple_single_packing_slip', $data, true);
		$filename = rand() . ".pdf";
		$Dpath = FCPATH . 'Document_Upload\multiple_print\*';
		$files = glob($Dpath);
		if (isset($files)) {
			foreach ($files as $findfile) {
				unlink($findfile);
			}
		}

		// echo $html;
		// exit;

		$this->pdf->load_html($html);
		$this->pdf->render();
		$output = $this->pdf->output();

		file_put_contents($this->config->item('FILE_PATH') . 'uploads/multiple_print/' . $filename, $output);
		echo $filename;
		exit();
	}

	//3rd vali packing slip  single
	public function third_single_packing_slip($id)
	{
		$this->load->model('Order_model');
		$order_id = $id;
		$order_info = $this->Order_model->get_multiple_order_list_for_slip($order_id);
		$this->load->library('pdf');
		// dd($order_info);
		foreach ($order_info as $single_order_info) {
			$data['order_info'] = $single_order_info;
			if ($single_order_info['airwaybill_barcode_img'] != "") {
				$data['order_info']['airwaybill_barcode_img'] = 'uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'];
			} else {
				$data['order_info']['airwaybill_barcode_img'] = $this->createWaybillBarcodeImage($single_order_info['id'], $single_order_info['awb_number']);
			}
		}
		$html = $this->load->view('admin/order/third_single_packing_slip', $data, true);
		// echo $html;
		// exit;
		$this->pdf->load_html($html);
		$this->pdf->createPDF($html, 'packing-slip', false, 'A4', 'portrait');
	}

	//3rd vali multiple packing slip
	public function third_multiple_packing_slip()
	{
		ini_set('memory_limit', '-1');
		$order_ids = $this->input->post('id');
		$this->load->model('Order_model');
		$order_info = $this->Order_model->get_multiple_order_list_for_slip($order_ids);
		$this->load->library('pdf');
		$i = 0;
		$data = array();
		foreach ($order_info as $single_order_info) {
			$data['order_info'][$i] = $single_order_info;
			if ($single_order_info['airwaybill_barcode_img'] != "") {
				$data['order_info'][$i]['airwaybill_barcode_img1'] = 'Uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'];
			} else {
				$data['order_info'][$i]['airwaybill_barcode_img1'] = $this->createWaybillBarcodeImage($single_order_info['id'], $single_order_info['awb_number']);
			}
			$i++;
		}

		$html = $this->load->view('admin/order/third_multiple_single_packing_slip', $data, true);
		$filename = rand() . ".pdf";
		$Dpath = FCPATH . 'Document_Upload\multiple_print\*';
		$files = glob($Dpath);
		if (isset($files)) {
			foreach ($files as $findfile) {
				unlink($findfile);
			}
		}

		// echo $html;
		// exit;

		$this->pdf->load_html($html);
		$this->pdf->render();
		$output = $this->pdf->output();

		file_put_contents($this->config->item('FILE_PATH') . 'uploads/multiple_print/' . $filename, $output);
		echo $filename;
		exit();
	}

	//4th single packing slip
	public function forth_single_packing_slip($id)
	{
		$this->load->model('Order_model');
		$order_id = $id;
		$order_info = $this->Order_model->get_multiple_order_list_for_slip($order_id);
		$this->load->library('pdf');
		// dd($order_info);
		foreach ($order_info as $single_order_info) {
			$data['order_info'] = $single_order_info;
			if ($single_order_info['airwaybill_barcode_img'] != "") {
				$data['order_info']['airwaybill_barcode_img'] = 'uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'];
			} else {
				$data['order_info']['airwaybill_barcode_img'] = $this->createWaybillBarcodeImage($single_order_info['id'], $single_order_info['awb_number']);
			}
		}
		$html = $this->load->view('admin/order/forth_single_packing_slip', $data, true);
		// echo $html;
		// exit;
		$this->pdf->load_html($html);
		$this->pdf->createPDF($html, 'packing-slip', false, 'A4', 'portrait');
	}

	//4th multiple packing slip
	public function forth_multiple_packing_slip()
	{
		ini_set('memory_limit', '-1');
		$order_ids = $this->input->post('id');
		$this->load->model('Order_model');
		$order_info = $this->Order_model->get_multiple_order_list_for_slip($order_ids);
		$this->load->library('pdf');
		$i = 0;
		$data = array();
		foreach ($order_info as $single_order_info) {
			$data['order_info'][$i] = $single_order_info;
			if ($single_order_info['airwaybill_barcode_img'] != "") {

				$data['order_info'][$i]['airwaybill_barcode_img1'] = 'Uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'];
			} else {
				$data['order_info'][$i]['airwaybill_barcode_img1'] = $this->createWaybillBarcodeImage($single_order_info['id'], $single_order_info['awb_number']);
			}
			$i++;
		}

		$html = $this->load->view('admin/order/forth_multiple_single_packing_slip', $data, true);
		$filename = rand() . ".pdf";
		$Dpath = FCPATH . 'Document_Upload\multiple_print\*';
		$files = glob($Dpath);
		if (isset($files)) {
			foreach ($files as $findfile) {
				unlink($findfile);
			}
		}

		// echo $html;
		// exit;

		$this->pdf->load_html($html);
		$this->pdf->render();
		$output = $this->pdf->output();

		file_put_contents($this->config->item('FILE_PATH') . 'uploads/multiple_print/' . $filename, $output);
		echo $filename;
		exit();
	}

	//multiple manifest pdf create
	public function multiple_manifest()
	{

		$this->load->model('Order_model');
		$multiple_order = $this->input->post('order_id');
		$data = array();
		$order_info = $this->Order_model->get_manifest_data($this->input->post('order_id'));
		// dd($order_info);
		$i = 0;
		foreach ($order_info as $single_order_info) {
			// $arr['order_info'][$single_order_info['logistic_id']][] = $single_order_info;

			// for ($i = 0; $i < count($multiple_order); $i++) {

			if ($single_order_info['awb_number'] != "") {
				$arr['order']['user_result'] = $this->Common_model->getRow(array('id' => $single_order_info['sender_id']), 'name', 'sender_master');

				$arr['order']['user_kyc_result'] = $this->Common_model->getRow(array('sender_id' => $single_order_info['sender_id']), 'gst_no', 'kyc_verification_master');
				$arr['order']['logistic_result'] = $this->Common_model->getRow(array('id' => $single_order_info['logistic_id']), 'api_name,id', 'logistic_master');
				$arr['order']['order_info'][$arr['order']['logistic_result']->id]['logistic_name_display'] = $single_order_info['logistic_name'];
				$arr['order']['order_info'][$arr['order']['logistic_result']->id]['info'][$i] = $single_order_info;
				$i++;
			}
		}

		// dd($arr);
		$this->load->library('pdf');
		$html = $this->load->view('admin/order/multiple_manifest', $arr, true);
		$filename = rand() . ".pdf";

		if (file_exists(base_url() . 'uploads/multiple_manifest/' . $filename)) {
			unlink('multiple_manifest/' . $filename);
		}
		$this->pdf->load_html($html);
		$this->pdf->render();
		$output = $this->pdf->output();
		//dd($this->config->item('FILE_PATH')  . 'uploads/multiple_manifest/' . $filename);
		file_put_contents($this->config->item('FILE_PATH')  . 'uploads/multiple_manifest/' . $filename, $output);
		echo $filename;
		exit();
		// }
	}


	//insert ndr comment
	public function insert_ndr_comment()
	{
		$insert_data['order_id'] = $this->input->post('orderid');

		if ($this->session->userdata('userType') == '1') {
			$insert_data['provider_comment'] = $this->input->post('p_comment');
			$insert_data['admin_comment'] = $this->input->post('pd_comment');
		} else {
			// $insert_data['p_comment'] = $this->input->post('p_comment');
			//$insert_data['packanddrop_comment'] = $this->input->post('pd_comment');
			$insert_data['client_comment'] = $this->input->post('client_comment');
		}
		//dd($insert_data);
		$insert_cmnt = $this->Common_model->insert($insert_data, 'ndr_comment_detail');
		if ($insert_cmnt) {
			$this->session->set_flashdata('message', "NDR comment save Successfully.");
			redirect('ndr-Order-List');
		} else {
			$this->session->set_flashdata('error', "Failed!! try again");
			redirect('ndr-Order-List');
		}
	}

	public function delete_error_order($order_id)
	{
		$data = ['is_delete' => '1'];
		$this->db->where('id', $order_id);
		$this->db->update('error_order_master', $data);
		$this->session->set_flashdata('message', "Order Deleted Successfully.");
		redirect('error-order-list');
	}

	public function delete_created_order($order_id)
	{
		$data = ['is_delete' => '1'];

		$this->db->where('id', $order_id);
		$this->db->update('forward_order_master', $data);
		$this->session->set_flashdata('message', "Order Deleted Successfully.");
		redirect('createdOrderList');
	}
}

/* End of file Price.php */
