<?php

use PhpMyAdmin\MoTranslator\Loader;

defined('BASEPATH') or exit('No direct script access allowed');
ini_set("memory_limit", "-1");
set_time_limit(0);

class Order_list extends Auth_Controller
{
	public $data = array();
	public function __construct()
	{
		parent::__construct();

		$this->load->model('View_order_model');
		$this->load->model('Order_model');
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
		if ($this->session->userdata('userType') == '1') {
			$where = "fom.is_pre_awb = '0'  AND fom.is_delete = '0'";
		} else {
			$where = "fom.is_pre_awb = '0'   AND fom.is_delete = '0' AND fom.sender_id='" . $this->session->userdata('userId') . "'";
		}
		$joinQuery = ' FROM ' . $table . ' fom  JOIN sender_master as sm ON sm.id=fom.sender_id  JOIN logistic_master as lm ON lm.id=fom.logistic_id  JOIN receiver_address as ra ON ra.id=fom.deliver_address_id JOIN order_airwaybill_detail as owd ON owd.order_id = fom.id  JOIN order_status as os ON os.order_status_id = owd.order_status_id';
		//$joinQuery = ' FROM ' . $table . ' fom INNER JOIN sender_master as sm ON sm.id=fom.sender_id INNER JOIN logistic_master as lm ON lm.id=fom.logistic_id INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id LEFT JOIN order_airwaybill_detail as owd ON owd.order_id = fom.id LEFT JOIN order_status as os ON os.order_status_id = owd.order_status_id';

		$columns[0] = array('db' => 'fom.id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {
			return '<input type="checkbox" class="select-item" name="id[]" value="' . $d . '">';
		});
		$columns[1] = array('db' => 'fom.order_no', 'dt' => 1, 'field' => 'order_no');
		$columns[2] = array('db' => 'fom.customer_order_no', 'dt' => 2, 'field' => 'customer_order_no');
		$columns[3] = array('db' => 'fom.awb_number', 'dt' => 3, 'field' => 'awb_number');
		$columns[4] = array('db' => 'lm.logistic_name', 'dt' => 4, 'field' => 'logistic_name', 'formatter' => function ($d, $row) {
			return "<span>" . $d . "</span>";
		});
		$columns[5] = array('db' => 'ra.name', 'dt' => 5, 'field' => 'reciver_name', 'as' => 'reciver_name', 'formatter' => function ($d, $row) {
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
		$columns[8] = array('db' => 'fom.created_date', 'dt' => 8, 'field' => 'created_date', 'formatter' => function ($d, $row) {
			return date('d-m-Y H:i:s', strtotime($d));
		});
		$columns[9] = array(
			'db' => '(SELECT max(otd.scan_date_time) as detail_create_date FROM order_tracking_detail as otd WHERE otd.order_id=fom.id) as detail_create_date', 'dt' => 9, 'field' => 'detail_create_date', 'formatter' => function ($d, $row) {
				if ($d != "") {
					return date("d-m-Y", strtotime($d));
				} else {
					return "";
				}
			}
		);
		$columns[10] = array(
			'db' => '(SELECT otd.scan as latest_scan FROM order_tracking_detail as otd WHERE otd.order_id=fom.id ORDER BY scan_date_time DESC LIMIT 1) as latest_scan', 'dt' => 10, 'field' => 'latest_scan', 'formatter' => function ($d, $row) {
				if ($d != "") {
					return $d;
				} else {
					return "";
				}
			}
		);
		$columns[11] = array(
			'db' => 'os.status_name', 'dt' => 11, 'field' => 'status_name'
			// , 'formatter' => function ($d, $row) {
			//     return "<span>".$d."</span>";}
		);
		// print_r($columns);
		if ($this->session->userdata('userType') == '1') {
			$columns[12] = array('db' => '(SELECT DATEDIFF("' . date("Y-m-d H:i:s") . '", (SELECT scan_date_time FROM order_tracking_detail WHERE order_id = ' . $columns[0]['db'] . ' AND (scan="intransit" OR scan="In Transit") LIMIT 1))) as totalDays', 'dt' => 12, 'field' => 'totalDays', 'formatter' => function ($d, $row) {
				if ($row[11] == 'Delivered' || $row[11] == 'RTO' || $row[11] == 'Returned' || $row[11] == 'Created') {
					return "";
				} else {
					return $d;
				}
			});
			$columns[13] = array('db' => 'sm.email', 'dt' => 13, 'field' => 'email', 'formatter' => function ($d, $row) {
				return "<span>" . $d . "</span>";
			});
			$columns[14] = array('db' => 'fom.id', 'dt' => 14, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#all_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button>";
			});
		} else {

			$columns[12] = array('db' => 'fom.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#all_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button>";
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
		if ($this->session->userdata('userType') == '1') {
			$where = "fom.is_pre_awb = '0' AND fom.is_created = '1'";
		} else {
			$where = "fom.is_pre_awb = '0' AND fom.sender_id='" . $this->session->userdata('userId') . "' AND fom.is_created = '1'";
		}
		$joinQuery = ' FROM ' . $table . ' fom INNER JOIN sender_master as sm ON sm.id=fom.sender_id INNER JOIN logistic_master as lm ON lm.id=fom.logistic_id INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id ';
		// $joinQuery = 'FROM' .$table . 'fom INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id INNER JOIN sender_master as sm ON sm.id=fom.sender_id';
		$columns[0] = array('db' => 'fom.id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {
			return '<input type="checkbox" class="select-item" name="id[]" value="' . $d . '">';
		});
		$columns[1] = array('db' => 'fom.order_no', 'dt' => 1, 'field' => 'order_no');
		$columns[2] = array('db' => 'fom.customer_order_no', 'dt' => 2, 'field' => 'customer_order_no');
		$columns[3] = array('db' => 'fom.awb_number', 'dt' => 3, 'field' => 'awb_number');
		$columns[4] = array('db' => 'lm.logistic_name', 'dt' => 4, 'field' => 'logistic_name', 'formatter' => function ($d, $row) {
			return "<span>" . $d . "</span>";
		});
		$columns[5] = array('db' => 'ra.name', 'dt' => 5, 'field' => 'reciver_name', 'as' => 'reciver_name', 'formatter' => function ($d, $row) {
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
			return date('d-m-Y H:i:s', strtotime($d));
		});
		$columns[9] = array(
			'db' => '(SELECT max(otd.scan_date_time) as detail_create_date FROM order_tracking_detail as otd WHERE otd.order_id=fom.id) as detail_create_date', 'dt' => 9, 'field' => 'detail_create_date', 'formatter' => function ($d, $row) {
				if ($d != "") {
					return date("d-m-Y", strtotime($d));
				} else {
					return "";
				}
			}
		);
		$columns[10] = array(
			'db' => '(SELECT otd.scan as latest_scan FROM order_tracking_detail as otd WHERE otd.order_id=fom.id ORDER BY scan_date_time DESC LIMIT 1) as latest_scan', 'dt' => 10, 'field' => 'latest_scan', 'formatter' => function ($d, $row) {
				if ($d != "") {
					return $d;
				} else {
					return "";
				}
			}
		);


		if ($this->session->userdata('userType') == '1') {
			$columns[11] = array('db' => 'sm.email', 'dt' => 11, 'field' => 'email', 'formatter' => function ($d, $row) {
				return "<span>" . $d . "</span>";
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
		if ($this->session->userdata('userType') == '1') {
			$where = "os.order_status_id = '1' AND fom.is_pre_awb = '0' AND fom.is_delete='0'";
		} else {
			$where = "os.order_status_id = '1' AND fom.is_pre_awb = '0' AND fom.is_delete='0' AND fom.sender_id='" . $this->session->userdata('userId') . "'";
		}

		$joinQuery = ' FROM ' . $table . ' fom INNER JOIN sender_master as sm ON sm.id=fom.sender_id INNER JOIN logistic_master as lm ON lm.id=fom.logistic_id INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id LEFT JOIN order_airwaybill_detail as owd ON owd.order_id = fom.id LEFT JOIN order_status as os ON os.order_status_id = owd.order_status_id';

		$columns[0] = array('db' => 'fom.id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {
			return '<input type="checkbox" class="select-item" name="id[]" value="' . $d . '">';
		});
		$columns[1] = array('db' => 'fom.order_no', 'dt' => 1, 'field' => 'order_no');

		$columns[2] = array('db' => 'fom.customer_order_no', 'dt' => 2, 'field' => 'customer_order_no');
		$columns[3] = array('db' => 'fom.awb_number', 'dt' => 3, 'field' => 'awb_number');
		$columns[4] = array('db' => 'lm.logistic_name', 'dt' => 4, 'field' => 'logistic_name', 'formatter' => function ($d, $row) {
			return "<span>" . $d . "</span>";
		});
		$columns[5] = array('db' => 'ra.name', 'dt' => 5, 'field' => 'reciver_name', 'as' => 'reciver_name', 'formatter' => function ($d, $row) {
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
		$columns[8] = array('db' => 'fom.created_date', 'dt' => 8, 'field' => 'created_date', 'formatter' => function ($d, $row) {
			return date('d-m-Y H:i:s', strtotime($d));
		});
		$columns[9] = array(
			'db' => '(SELECT max(otd.scan_date_time) as detail_create_date FROM order_tracking_detail as otd WHERE otd.order_id=fom.id) as detail_create_date', 'dt' => 9, 'field' => 'detail_create_date', 'formatter' => function ($d, $row) {
				if ($d != "") {
					return date("d-m-Y", strtotime($d));
				} else {
					return "";
				}
			}
		);
		$columns[10] = array(
			'db' => '(SELECT otd.scan as latest_scan FROM order_tracking_detail as otd WHERE otd.order_id=fom.id ORDER BY scan_date_time DESC LIMIT 1) as latest_scan', 'dt' => 10, 'field' => 'latest_scan', 'formatter' => function ($d, $row) {
				if ($d != "") {
					return $d;
				} else {
					return "";
				}
			}
		);

		$columns[11] = array(
			'db' => 'os.status_name', 'dt' => 11, 'field' => 'status_name'
		);

		if ($this->session->userdata('userType') == '1') {
			$columns[12] = array('db' => 'sm.email', 'dt' => 12, 'field' => 'email', 'formatter' => function ($d, $row) {
				return "<span>" . $d . "</span>";
			});
			$columns[13] = array('db' => 'fom.id', 'dt' => 13, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<div class=''><a class='single_order_print_button' data-id='" . $d . "'><i class='fa fa-print' aria-hidden='true' style='font-size:30px;'></i></a></div>";
			});
			$columns[14] = array('db' => 'fom.id', 'dt' => 14, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<div class='row'><a class='btn btn-danger' href='" . base_url('delete-created-order/' . $d) . "'>Cancel</a></div>";
			});
		} else {
			$columns[12] = array('db' => 'fom.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<div class=''><a class='single_order_print_button' data-id='" . $d . "'><i class='fa fa-print' aria-hidden='true' style='font-size:30px;'></i></a></div>";
			});
			$columns[13] = array('db' => 'fom.id', 'dt' => 13, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<div class='row'><a class='btn btn-danger' href='" . base_url('delete-created-order/' . $d) . "'>Cancel</a></div>";
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
		if ($this->session->userdata('userType') == '1') {
			$where = "os.order_status_id = '3' AND fom.is_pre_awb = '0' AND fom.is_delete='0'";
		} else {
			$where = "os.order_status_id = '3' AND fom.is_pre_awb = '0' AND fom.is_delete='0' AND fom.sender_id='" . $this->session->userdata('userId') . "'";
		}

		$joinQuery = ' FROM ' . $table . ' fom INNER JOIN sender_master as sm ON sm.id=fom.sender_id INNER JOIN logistic_master as lm ON lm.id=fom.logistic_id INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id LEFT JOIN order_airwaybill_detail as owd ON owd.order_id = fom.id LEFT JOIN order_status as os ON os.order_status_id = owd.order_status_id INNER JOIN logistic_master as lom ON fom.logistic_id = lom.id';

		$columns[0] = array('db' => 'fom.id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {
			return '<input type="checkbox" class="select-item" name="id[]" value="' . $d . '">';
		});
		$columns[1] = array('db' => 'fom.order_no', 'dt' => 1, 'field' => 'order_no');
		$columns[2] = array('db' => 'fom.customer_order_no', 'dt' => 2, 'field' => 'customer_order_no');
		$columns[3] = array('db' => 'fom.awb_number', 'dt' => 3, 'field' => 'awb_number');
		$columns[4] = array('db' => 'lm.logistic_name', 'dt' => 4, 'field' => 'logistic_name', 'formatter' => function ($d, $row) {
			return "<span>" . $d . "</span>";
		});

		$columns[5] = array('db' => 'ra.name', 'dt' => 5, 'field' => 'reciver_name', 'as' => 'reciver_name', 'formatter' => function ($d, $row) {
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
		$columns[8] = array('db' => 'fom.created_date', 'dt' => 8, 'field' => 'created_date', 'formatter' => function ($d, $row) {
			return date('d-m-Y H:i:s', strtotime($d));
		});
		$columns[9] = array(
			'db' => '(SELECT max(otd.scan_date_time) as detail_create_date FROM order_tracking_detail as otd WHERE otd.order_id=fom.id) as detail_create_date', 'dt' => 9, 'field' => 'detail_create_date', 'formatter' => function ($d, $row) {
				if ($d != "") {
					return date("d-m-Y", strtotime($d));
				} else {
					return "";
				}
			}
		);
		$columns[10] = array(
			'db' => '(SELECT otd.scan as latest_scan FROM order_tracking_detail as otd WHERE otd.order_id=fom.id ORDER BY scan_date_time DESC LIMIT 1) as latest_scan', 'dt' => 10, 'field' => 'latest_scan', 'formatter' => function ($d, $row) {
				if ($d != "") {
					return $d;
				} else {
					return "";
				}
			}
		);
		$columns[11] = array(
			'db' => 'os.status_name', 'dt' => 11, 'field' => 'status_name'
		);

		if ($this->session->userdata('userType') == '1') {

			$columns[12] = array('db' => '(SELECT DATEDIFF("' . date("Y-m-d H:i:s") . '", (SELECT scan_date_time FROM order_tracking_detail WHERE order_id = ' . $columns[0]['db'] . ' AND (scan="intransit" OR scan="In Transit") LIMIT 1))) as totalDays', 'dt' => 12, 'field' => 'totalDays', 'formatter' => function ($d, $row) {
				if ($row[11] == 'Delivered' || $row[11] == 'RTO' || $row[11] == 'Returned' || $row[11] == 'Created') {
					return "";
				} else {
					return $d;
				}
			});
			$columns[13] = array('db' => 'sm.email', 'dt' => 13, 'field' => 'email', 'formatter' => function ($d, $row) {
				return "<span>" . $d . "</span>";
			});

			$columns[14] = array('db' => 'fom.id', 'dt' => 14, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-toggle='modal' data-id='$row[0]' id='order_detail_btn' data-target='#intransit_order_details' data-details='order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'>Order Details</button>";
			});
			$columns[15] = array('db' => 'fom.id', 'dt' => 15, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#intransit_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button></div>
            ";
			});
		} else {
			$columns[12] = array('db' => 'fom.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-toggle='modal' id='order_detail_btn' data-target='#intransit_order_details' data-id='$row[0]' data-details='order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'>Order Details</button>";
			});
			$columns[13] = array('db' => 'fom.id', 'dt' => 13, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#intransit_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button></div>
            ";
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
		if ($this->session->userdata('userType') == '1') {
			$where = "os.order_status_id = '5' AND fom.is_pre_awb = '0' AND fom.is_delete='0'";
		} else {
			$where = "os.order_status_id = '5' AND fom.is_pre_awb = '0' AND fom.is_delete='0' AND fom.sender_id='" . $this->session->userdata('userId') . "'";
		}
		$joinQuery = ' FROM ' . $table . ' fom INNER JOIN sender_master as sm ON sm.id=fom.sender_id INNER JOIN logistic_master as lm ON lm.id=fom.logistic_id INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id LEFT JOIN order_airwaybill_detail as owd ON owd.order_id = fom.id LEFT JOIN order_status as os ON os.order_status_id = owd.order_status_id';

		$columns[0] = array('db' => 'fom.id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {
			return '<input type="checkbox" class="select-item" name="id[]" value="' . $d . '">';
		});
		$columns[1] = array('db' => 'fom.order_no', 'dt' => 1, 'field' => 'order_no');
		$columns[2] = array('db' => 'fom.customer_order_no', 'dt' => 2, 'field' => 'customer_order_no');
		$columns[3] = array('db' => 'fom.awb_number', 'dt' => 3, 'field' => 'awb_number');
		$columns[4] = array('db' => 'lm.logistic_name', 'dt' => 4, 'field' => 'logistic_name', 'formatter' => function ($d, $row) {
			return "<span>" . $d . "</span>";
		});
		$columns[5] = array('db' => 'ra.name', 'dt' => 5, 'field' => 'reciver_name', 'as' => 'reciver_name', 'formatter' => function ($d, $row) {
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
		$columns[8] = array('db' => 'fom.created_date', 'dt' => 8, 'field' => 'created_date', 'formatter' => function ($d, $row) {
			return date('d-m-Y H:i:s', strtotime($d));
		});
		$columns[9] = array(
			'db' => '(SELECT max(otd.scan_date_time) as detail_create_date FROM order_tracking_detail as otd WHERE otd.order_id=fom.id) as detail_create_date', 'dt' => 9, 'field' => 'detail_create_date', 'formatter' => function ($d, $row) {
				if ($d != "") {
					return date("d-m-Y", strtotime($d));
				} else {
					return "";
				}
			}
		);
		$columns[10] = array(
			'db' => '(SELECT otd.scan as latest_scan FROM order_tracking_detail as otd WHERE otd.order_id=fom.id ORDER BY scan_date_time DESC LIMIT 1) as latest_scan', 'dt' => 10, 'field' => 'latest_scan', 'formatter' => function ($d, $row) {
				if ($d != "") {
					return $d;
				} else {
					return "";
				}
			}
		);
		$columns[11] = array(
			'db' => 'os.status_name', 'dt' => 11, 'field' => 'status_name'
		);
		if ($this->session->userdata('userType') == '1') {

			$columns[12] = array('db' => '(SELECT DATEDIFF("' . date("Y-m-d H:i:s") . '", (SELECT scan_date_time FROM order_tracking_detail WHERE order_id = ' . $columns[0]['db'] . ' AND (scan="intransit" OR scan="In Transit") LIMIT 1))) as totalDays', 'dt' => 12, 'field' => 'totalDays', 'formatter' => function ($d, $row) {
				if ($row[11] == 'Delivered' || $row[11] == 'RTO' || $row[11] == 'Returned' || $row[11] == 'Created') {
					return "";
				} else {
					return $d;
				}
			});


			$columns[13] = array('db' => 'sm.email', 'dt' => 13, 'field' => 'email', 'formatter' => function ($d, $row) {
				return "<span>" . $d . "</span>";
			});

			$columns[14] = array('db' => 'fom.id', 'dt' => 14, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-toggle='modal' data-id='$row[0]' id='order_detail_btn'  data-details='order_details' data-target='#ofd_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'>Order Details</button>
                ";
			});
			$columns[15] = array('db' => 'fom.id', 'dt' => 15, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#ofd_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button>";
			});
		} else {
			$columns[12] = array('db' => 'fom.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-toggle='modal' id='order_detail_btn' data-details='order_details' data-target='#ofd_order_details' data-id='$row[0]' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'>Order Details</button>
                ";
			});
			$columns[13] = array('db' => 'fom.id', 'dt' => 13, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#ofd_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button>";
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
		if ($this->session->userdata('userType') == '1') {
			$where = "os.order_status_id = '18' AND fom.is_pre_awb = '0' AND fom.is_delete='0'";
		} else {
			$where = "os.order_status_id = '18' AND fom.is_pre_awb = '0' AND fom.is_delete='0' AND fom.sender_id='" . $this->session->userdata('userId') . "'";
		}
		$joinQuery = ' FROM ' . $table . ' fom INNER JOIN sender_master as sm ON sm.id=fom.sender_id INNER JOIN logistic_master as lm ON lm.id=fom.logistic_id INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id LEFT JOIN order_airwaybill_detail as owd ON owd.order_id = fom.id LEFT JOIN order_status as os ON os.order_status_id = owd.order_status_id ';

		$columns[0] = array('db' => 'fom.id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {
			return '<input type="checkbox" class="select-item" name="id[]" value="' . $d . '">';
		});
		$columns[1] = array('db' => 'fom.order_no', 'dt' => 1, 'field' => 'order_no');
		$columns[2] = array('db' => 'fom.customer_order_no', 'dt' => 2, 'field' => 'customer_order_no');
		$columns[3] = array('db' => 'fom.awb_number', 'dt' => 3, 'field' => 'awb_number');
		$columns[4] = array('db' => 'lm.logistic_name', 'dt' => 4, 'field' => 'logistic_name', 'formatter' => function ($d, $row) {
			return "<span>" . $d . "</span>";
		});
		$columns[5] = array('db' => 'ra.name', 'dt' => 5, 'field' => 'reciver_name', 'as' => 'reciver_name', 'formatter' => function ($d, $row) {
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
		$columns[8] = array('db' => 'fom.created_date', 'dt' => 8, 'field' => 'created_date', 'formatter' => function ($d, $row) {
			return date('d-m-Y H:i:s', strtotime($d));
		});
		$columns[9] = array(
			'db' => '(SELECT max(otd.scan_date_time) as detail_create_date FROM order_tracking_detail as otd WHERE otd.order_id=fom.id) as detail_create_date', 'dt' => 9, 'field' => 'detail_create_date', 'formatter' => function ($d, $row) {
				if ($d != "") {
					return date("d-m-Y", strtotime($d));
				} else {
					return "";
				}
			}
		);
		$columns[10] = array(
			'db' => '(SELECT otd.scan as latest_scan FROM order_tracking_detail as otd WHERE otd.order_id=fom.id ORDER BY scan_date_time DESC LIMIT 1) as latest_scan', 'dt' => 10, 'field' => 'latest_scan', 'formatter' => function ($d, $row) {
				if ($d != "") {
					return $d;
				} else {
					return "";
				}
			}
		);
		$columns[11] = array(
			'db' => 'os.status_name', 'dt' => 11, 'field' => 'status_name'
		);
		if ($this->session->userdata('userType') == '1') {
			$columns[12] = array('db' => '(SELECT DATEDIFF("' . date("Y-m-d H:i:s") . '", (SELECT scan_date_time FROM order_tracking_detail WHERE order_id = ' . $columns[0]['db'] . ' AND (scan="intransit" OR scan="In Transit") LIMIT 1))) as totalDays', 'dt' => 12, 'field' => 'totalDays', 'formatter' => function ($d, $row) {
				if ($row[11] == 'Delivered' || $row[11] == 'RTO' || $row[11] == 'Returned' || $row[11] == 'Created') {
					return "";
				} else {
					return $d;
				}
			});
			$columns[13] = array('db' => 'sm.email', 'dt' => 13, 'field' => 'email', 'formatter' => function ($d, $row) {
				return "<span>" . $d . "</span>";
			});

			$columns[14] = array('db' => 'fom.id', 'dt' => 14, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-toggle='modal' data-id='$row[0]' id='order_detail_btn' data-target='#ndr_order_details' data-details='order_details' class='btn btn-primary btn-xs waves-effect waves-classic' style='margin-bottom:5px;'>Order Detail</button></div>
                <button type='button' data-toggle='modal' data-target='#ndr_order_comment' data-id='$row[0]' data-ndr='ndr_tab' id='order_ndr_comment' class='btn btn-primary btn-xs waves-effect waves-classic'style='margin-top: 5px;'>NDR Comment</button>";
			});
			$columns[15] = array('db' => 'fom.id', 'dt' => 15, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#ndr_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button>";
			});
		} else {
			$columns[12] = array('db' => 'fom.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-toggle='modal' data-id='$row[0]' id='order_detail_btn' data-target='#ndr_order_details' data-details='order_details' class='btn btn-primary btn-xs waves-effect waves-classic' style='margin-bottom:5px;'>Order Detail</button> </div>
                <button type='button' data-toggle='modal' data-target='#ndr_order_comment' data-ndr='ndr_tab' data-id='$row[0]' id='order_ndr_comment' class='btn btn-primary btn-xs waves-effect waves-classic'style='margin-top: 5px;'>NDR Comment</button>";
			});
			$columns[13] = array('db' => 'fom.id', 'dt' => 13, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#ndr_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button>";
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
		if ($this->session->userdata('userType') == '1') {
			$where = "os.order_status_id = '6' AND fom.is_pre_awb = '0' AND fom.is_delete='0'";
		} else {
			$where = "os.order_status_id = '6' AND fom.is_pre_awb = '0' AND fom.is_delete='0' AND fom.sender_id='" . $this->session->userdata('userId') . "'";
		}
		$joinQuery = ' FROM ' . $table . ' fom INNER JOIN sender_master as sm ON sm.id=fom.sender_id INNER JOIN logistic_master as lm ON lm.id=fom.logistic_id INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id LEFT JOIN order_airwaybill_detail as owd ON owd.order_id = fom.id LEFT JOIN order_status as os ON os.order_status_id = owd.order_status_id';

		$columns[0] = array('db' => 'fom.id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {
			return '<input type="checkbox" class="select-item" name="id[]" value="' . $d . '">';
		});
		$columns[1] = array('db' => 'fom.order_no', 'dt' => 1, 'field' => 'order_no');
		$columns[2] = array('db' => 'fom.customer_order_no', 'dt' => 2, 'field' => 'customer_order_no');

		$columns[3] = array('db' => 'fom.awb_number', 'dt' => 3, 'field' => 'awb_number');
		$columns[4] = array('db' => 'lm.logistic_name', 'dt' => 4, 'field' => 'logistic_name', 'formatter' => function ($d, $row) {
			return "<span>" . $d . "</span>";
		});
		$columns[5] = array('db' => 'ra.name', 'dt' => 5, 'field' => 'reciver_name', 'as' => 'reciver_name', 'formatter' => function ($d, $row) {
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
		$columns[8] = array('db' => 'fom.created_date', 'dt' => 8, 'field' => 'created_date', 'formatter' => function ($d, $row) {
			return date('d-m-Y H:i:s', strtotime($d));
		});
		$columns[9] = array(
			'db' => '(SELECT max(otd.scan_date_time) as detail_create_date FROM order_tracking_detail as otd WHERE otd.order_id=fom.id) as detail_create_date', 'dt' => 9, 'field' => 'detail_create_date', 'formatter' => function ($d, $row) {
				if ($d != "") {
					return date("d-m-Y", strtotime($d));
				} else {
					return "";
				}
			}
		);
		$columns[10] = array(
			'db' => '(SELECT otd.scan as latest_scan FROM order_tracking_detail as otd WHERE otd.order_id=fom.id ORDER BY scan_date_time DESC LIMIT 1) as latest_scan', 'dt' => 10, 'field' => 'latest_scan', 'formatter' => function ($d, $row) {
				if ($d != "") {
					return $d;
				} else {
					return "";
				}
			}
		);
		$columns[11] = array(
			'db' => 'os.status_name', 'dt' => 11, 'field' => 'status_name'
		);
		if ($this->session->userdata('userType') == '1') {

			$columns[12] = array('db' => 'sm.email', 'dt' => 12, 'field' => 'email', 'formatter' => function ($d, $row) {
				return "<span>" . $d . "</span>";
			});

			$columns[13] = array('db' => 'fom.id', 'dt' => 13, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-toggle='modal' data-id='$row[0]' id='order_detail_btn' data-details='order_details' data-target='#delivered_order_details' attr-btntype='order_tracking' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'>Order Details</button><button type='button' data-toggle='modal' data-target='#ndr_order_comment' data-id='$row[0]' data-ndr='other_tabs' id='order_ndr_comment' class='btn btn-primary btn-xs waves-effect waves-classic'style='margin-top: 5px;'>NDR Comment</button>";
			});
			$columns[14] = array('db' => 'fom.id', 'dt' => 14, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#delivered_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button>";
			});
		} else {
			$columns[12] = array('db' => 'fom.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-toggle='modal' id='order_detail_btn' data-details='order_details' data-target='#delivered_order_details' attr-btntype='order_tracking' data-id='$row[0]' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'>Order Details</button>
                <button type='button' data-toggle='modal' data-target='#ndr_order_comment' data-id='$row[0]' data-ndr='other_tabs' id='order_ndr_comment' class='btn btn-primary btn-xs waves-effect waves-classic'style='margin-top: 5px;'>NDR Comment</button>";
			});

			$columns[13] = array('db' => 'fom.id', 'dt' => 13, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#delivered_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button>";
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
		if ($this->session->userdata('userType') == '1') {
			$where = "(os.order_status_id = '9' OR os.order_status_id = '10' OR os.order_status_id = '11' OR os.order_status_id = '12') AND fom.is_pre_awb = '0'";
		} else {
			$where = "(os.order_status_id = '9' OR os.order_status_id = '10' OR os.order_status_id = '11' OR os.order_status_id = '12') AND fom.is_pre_awb = '0' AND fom.is_delete = '0' AND fom.sender_id='" . $this->session->userdata('userId') . "'";
		}

		$joinQuery = ' FROM ' . $table . ' fom INNER JOIN sender_master as sm ON sm.id=fom.sender_id INNER JOIN logistic_master as lm ON lm.id=fom.logistic_id INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id LEFT JOIN order_airwaybill_detail as owd ON owd.order_id = fom.id LEFT JOIN order_status as os ON os.order_status_id = owd.order_status_id';

		$columns[0] = array('db' => 'fom.id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {
			return '<input type="checkbox" class="select-item" name="id[]" value="' . $d . '">';
		});
		$columns[1] = array('db' => 'fom.order_no', 'dt' => 1, 'field' => 'order_no');
		$columns[2] = array('db' => 'fom.customer_order_no', 'dt' => 2, 'field' => 'customer_order_no');
		$columns[3] = array('db' => 'fom.awb_number', 'dt' => 3, 'field' => 'awb_number');
		$columns[4] = array('db' => 'lm.logistic_name', 'dt' => 4, 'field' => 'logistic_name', 'formatter' => function ($d, $row) {
			return "<span>" . $d . "</span>";
		});
		$columns[5] = array('db' => 'ra.name', 'dt' => 5, 'field' => 'reciver_name', 'as' => 'reciver_name', 'formatter' => function ($d, $row) {
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
		$columns[8] = array('db' => 'fom.created_date', 'dt' => 8, 'field' => 'created_date', 'formatter' => function ($d, $row) {
			return date('d-m-Y H:i:s', strtotime($d));
		});
		$columns[9] = array(
			'db' => '(SELECT max(otd.scan_date_time) as detail_create_date FROM order_tracking_detail as otd WHERE otd.order_id=fom.id) as detail_create_date', 'dt' => 9, 'field' => 'detail_create_date', 'formatter' => function ($d, $row) {
				if ($d != "") {
					return date("d-m-Y", strtotime($d));
				} else {
					return "";
				}
			}
		);
		$columns[10] = array(
			'db' => '(SELECT otd.scan as latest_scan FROM order_tracking_detail as otd WHERE otd.order_id=fom.id ORDER BY scan_date_time DESC LIMIT 1) as latest_scan', 'dt' => 10, 'field' => 'latest_scan', 'formatter' => function ($d, $row) {
				if ($d != "") {
					return $d;
				} else {
					return "";
				}
			}
		);
		$columns[11] = array(
			'db' => 'os.status_name', 'dt' => 11, 'field' => 'status_name'
		);
		if ($this->session->userdata('userType') == '1') {
			$columns[12] = array('db' => '(SELECT DATEDIFF("' . date("Y-m-d H:i:s") . '", (SELECT scan_date_time FROM order_tracking_detail WHERE order_id = ' . $columns[0]['db'] . ' AND (scan="intransit" OR scan="In Transit") LIMIT 1))) as totalDays', 'dt' => 12, 'field' => 'totalDays', 'formatter' => function ($d, $row) {
				if ($row[11] == 'Delivered' || $row[11] == 'RTO' || $row[11] == 'Returned' || $row[11] == 'Created') {
					return "";
				} else {
					return $d;
				}
			});
			$columns[13] = array('db' => 'sm.email', 'dt' => 13, 'field' => 'email', 'formatter' => function ($d, $row) {
				return "<span>" . $d . "</span>";
			});

			$columns[14] = array('db' => 'fom.id', 'dt' => 14, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button 'data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_detail_btn' data-info='intransit_order' data-target='#rto_intransit_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'>Order Details</button><button type='button' data-toggle='modal' data-target='#ndr_order_comment' data-id='$row[0]' id='order_ndr_comment' data-ndr='other_tabs' class='btn btn-primary btn-xs waves-effect waves-classic'style='margin-top: 5px;'>NDR Comment</button>";
			});
			$columns[15] = array('db' => 'fom.id', 'dt' => 15, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#rto_intransit_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button>";
			});
		} else {
			$columns[12] = array('db' => 'fom.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-details='order_details' data-toggle='modal' data-info='intransit_order' data-info='intransit_order' id='order_detail_btn' data-target='#rto_intransit_order_details' data-id='$row[0]' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'>Order Details</button><button type='button' data-toggle='modal' data-target='#ndr_order_comment' data-id='$row[0]' data-ndr='other_tabs' id='order_ndr_comment' class='btn btn-primary btn-xs waves-effect waves-classic'style='margin-top: 5px;'>NDR Comment</button>";
			});
			$columns[13] = array('db' => 'fom.id', 'dt' => 13, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#rto_intransit_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button>";
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
		if ($this->session->userdata('userType') == '1') {
			$where = "(os.order_status_id = '13' OR os.order_status_id='14') AND fom.is_pre_awb = '0' AND fom.is_delete = '0'";
		} else {
			$where = "(os.order_status_id = '13' OR os.order_status_id='14') AND fom.is_pre_awb = '0' AND fom.is_delete = '0' AND fom.sender_id='" . $this->session->userdata('userId') . "'";
		}
		$joinQuery = ' FROM ' . $table . ' fom INNER JOIN sender_master as sm ON sm.id=fom.sender_id INNER JOIN logistic_master as lm ON lm.id=fom.logistic_id INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id LEFT JOIN order_airwaybill_detail as owd ON owd.order_id = fom.id LEFT JOIN order_status as os ON os.order_status_id = owd.order_status_id';

		$columns[0] = array('db' => 'fom.id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {
			return '<input type="checkbox" class="select-item" name="id[]" value="' . $d . '">';
		});
		$columns[1] = array('db' => 'fom.order_no', 'dt' => 1, 'field' => 'order_no');
		$columns[2] = array('db' => 'fom.customer_order_no', 'dt' => 2, 'field' => 'customer_order_no');
		$columns[3] = array('db' => 'fom.awb_number', 'dt' => 3, 'field' => 'awb_number');
		$columns[4] = array('db' => 'lm.logistic_name', 'dt' => 4, 'field' => 'logistic_name', 'formatter' => function ($d, $row) {
			return "<span>" . $d . "</span>";
		});
		$columns[5] = array('db' => 'ra.name', 'dt' => 5, 'field' => 'reciver_name', 'as' => 'reciver_name', 'formatter' => function ($d, $row) {
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
		$columns[8] = array('db' => 'fom.created_date', 'dt' => 8, 'field' => 'created_date', 'formatter' => function ($d, $row) {
			return date('d-m-Y H:i:s', strtotime($d));
		});
		$columns[9] = array(
			'db' => '(SELECT max(otd.scan_date_time) as detail_create_date FROM order_tracking_detail as otd WHERE otd.order_id=fom.id) as detail_create_date', 'dt' => 9, 'field' => 'detail_create_date', 'formatter' => function ($d, $row) {
				if ($d != "") {
					return date("d-m-Y", strtotime($d));
				} else {
					return "";
				}
			}
		);
		$columns[10] = array(
			'db' => '(SELECT otd.scan as latest_scan FROM order_tracking_detail as otd WHERE otd.order_id=fom.id ORDER BY scan_date_time DESC LIMIT 1) as latest_scan', 'dt' => 10, 'field' => 'latest_scan', 'formatter' => function ($d, $row) {
				if ($d != "") {
					return $d;
				} else {
					return "";
				}
			}
		);
		$columns[11] = array(
			'db' => 'os.status_name', 'dt' => 11, 'field' => 'status_name'
		);
		if ($this->session->userdata('userType') == '1') {

			$columns[12] = array('db' => 'sm.email', 'dt' => 12, 'field' => 'email', 'formatter' => function ($d, $row) {
				return "<span>" . $d . "</span>";
			});

			$columns[13] = array('db' => 'fom.id', 'dt' => 13, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_detail_btn' data-target='#rto_delivered_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'>Order Details</button><button type='button' data-toggle='modal' data-target='#ndr_order_comment' data-id='$row[0]' data-ndr='other_tabs' id='order_ndr_comment' class='btn btn-primary btn-xs waves-effect waves-classic'style='margin-top: 5px;'>NDR Comment</button>";
			});
			$columns[14] = array('db' => 'fom.id', 'dt' => 14, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#rto_delivered_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button>";
			});
		} else {
			$columns[12] = array('db' => 'fom.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-details='order_details' data-toggle='modal' id='order_detail_btn' data-target='#rto_delivered_order_details' data-id='$row[0]' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'>Order Details</button><button type='button' data-toggle='modal' data-target='#ndr_order_comment' data-id='$row[0]' data-ndr='other_tabs' id='order_ndr_comment' class='btn btn-primary btn-xs waves-effect waves-classic'style='margin-top: 5px;'>NDR Comment</button>";
			});
			$columns[13] = array('db' => 'fom.id', 'dt' => 13, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#rto_delivered_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' stysle='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button>";
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
		if ($this->session->userdata('userType') == '1') {
			$where = "fom.is_pre_awb = '0' AND fom.is_delete = '0'";
		} else {
			$where = "fom.is_pre_awb = '0' AND fom.is_delete = '0' AND fom.sender_id='" . $this->session->userdata('userId') . "'";
		}
		$joinQuery = ' FROM ' . $table . ' fom INNER JOIN logistic_master as lm ON lm.id=fom.logistic_id INNER JOIN sender_master as sm ON sm.id=fom.sender_id  INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id LEFT JOIN order_airwaybill_detail as owd ON owd.order_id = fom.id LEFT JOIN order_error_log as oel ON fom.id=oel.order_Error_id';

		$columns[0] = array('db' => 'fom.id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {
			return '<input type="checkbox" class="select-item" name="id[]" value="' . $d . '">';
		});
		$columns[1] = array('db' => 'fom.order_no', 'dt' => 1, 'field' => 'order_no');

		$columns[2] = array('db' => 'fom.customer_order_no', 'dt' => 2, 'field' => 'customer_order_no');
		$columns[3] = array('db' => 'fom.awb_number', 'dt' => 3, 'field' => 'awb_number');
		$columns[4] = array('db' => 'lm.logistic_name', 'dt' => 4, 'field' => 'logistic_name', 'formatter' => function ($d, $row) {
			return "<span>" . $d . "</span>";
		});
		$columns[5] = array('db' => 'ra.name', 'dt' => 5, 'field' => 'reciver_name', 'as' => 'reciver_name', 'formatter' => function ($d, $row) {
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
		$columns[8] = array('db' => 'fom.created_date', 'dt' => 8, 'field' => 'created_date', 'formatter' => function ($d, $row) {
			return date('d-m-Y H:i:s', strtotime($d));
		});
		$columns[9] = array(
			'db' => 'oel.error', 'dt' => 9, 'field' => 'error'
		);
		if ($this->session->userdata('userType') == '1') {
			$columns[10] = array('db' => 'sm.email', 'dt' => 10, 'field' => 'email', 'formatter' => function ($d, $row) {
				return "<span>" . $d . "</span>";
			});
			$columns[11] = array('db' => 'fom.id', 'dt' => 11, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<a class='btn btn-danger' href='" . base_url('delete-error-order/' . $d) . "'>Delete</a>";
			});
		} else {
			$columns[10] = array('db' => 'fom.id', 'dt' => 10, 'field' => 'id', 'formatter' => function ($d, $row) {
				return "<a class='btn btn-danger' href='" . base_url('delete-error-order/' . $d) . "'>Delete</a>";
			});
		}

		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where)
		);
	}

	public function waitingorder_list_view()
	{
		$this->data['order_count'] = $this->get_order_count();
		$this->loadview('waiting_order_list', $this->data);
	}
	public function waiting_order_table()
	{

		$columns = array();
		$table = 'temp_order_master';
		$primaryKey = 'id';
		if ($this->session->userdata('userType') == '1') {
			$where = "fom.is_pre_awb = '0'  AND is_flag='1'";
		} else {
			$where = "fom.is_pre_awb = '0'  AND is_flag='1' AND fom.sender_id='" . $this->session->userdata('userId') . "'";
		}
		$joinQuery = ' FROM ' . $table . ' fom INNER JOIN logistic_master as lm ON lm.id=fom.logistic_id INNER JOIN sender_master as sm ON sm.id=fom.sender_id  INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id LEFT JOIN order_airwaybill_detail as owd ON owd.order_id = fom.id LEFT JOIN order_error_log as oel ON fom.id=oel.order_Error_id';

		$columns[0] = array('db' => 'fom.id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {
			return '<input type="checkbox" class="select-item" name="id[]" value="' . $d . '">';
		});
		$columns[1] = array('db' => 'fom.order_no', 'dt' => 1, 'field' => 'order_no');

		$columns[2] = array('db' => 'fom.customer_order_no', 'dt' => 2, 'field' => 'customer_order_no');
		$columns[3] = array('db' => 'fom.awb_number', 'dt' => 3, 'field' => 'awb_number');
		$columns[4] = array('db' => 'lm.logistic_name', 'dt' => 4, 'field' => 'logistic_name', 'formatter' => function ($d, $row) {
			return "<span>" . $d . "</span>";
		});
		$columns[5] = array('db' => 'ra.name', 'dt' => 5, 'field' => 'reciver_name', 'as' => 'reciver_name', 'formatter' => function ($d, $row) {
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
		$columns[8] = array('db' => 'fom.created_date', 'dt' => 8, 'field' => 'created_date', 'formatter' => function ($d, $row) {
			return date('d-m-Y H:i:s', strtotime($d));
		});
		$columns[9] = array(
			'db' => 'oel.error', 'dt' => 9, 'field' => 'error'
		);
		$columns[10] = array('db' => 'sm.email', 'dt' => 10, 'field' => 'email', 'formatter' => function ($d, $row) {
			return "<span>" . $d . "</span>";
		});


		echo json_encode(
			SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where)
		);
	}

	//first single packing slip
	public function packing_slip($order_id)
	{
		// die($order_id);
		$this->load->model('Order_model');
		// $order_id = 11;
		$order_info = $this->Order_model->get_multiple_order_list_for_slip($order_id);

		foreach ($order_info as $single_order_info) {
			$data['order_info'] = $single_order_info;
			if ($single_order_info['airwaybill_barcode_img'] != "" && file_exists('uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'] != 1)) {
				$data['order_info']['airwaybill_barcode_img'] = 'uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'];
			} else {
				$data['order_info']['airwaybill_barcode_img'] = $this->createWaybillBarcodeImage($single_order_info['id'], $single_order_info['awb_number']);
			}
		}
		// dd($data);
		$this->load->library('pdf');
		$html = $this->load->view('admin/order/single_packing_slip', $data, true);
		// echo $html;
		// exit;
		$this->pdf->createPDF($html, 'packing-slip', false, 'A4', 'portrait');
	}

	//get order list count
	public function get_order_count()
	{
		$this->benchmark->mark('code_start');
		// $data['get_all_order_list'] = $this->View_order_model->get_count('');
		$this->benchmark->mark('code_end');
		$this->benchmark->elapsed_time('code_start', 'code_end') . "<br>";

		$this->benchmark->mark('code_start');
		// $data['get_all_order_list'] = $this->db->select('id')->from('forward_order_master')->where('is_reverse', '0')->where('is_cancelled', '0')->where('is_delete', '0')->where('is_pre_awb', '0')->count_all_results();
		$this->benchmark->mark('code_end');
		$this->benchmark->elapsed_time('code_start', 'code_end') . "<br>";
		// dd($data);
		$status = array('1', '3', '5', '6', '18');
		$get_all_count = $this->View_order_model->get_count($status);
		$data['get_created_order_list'] = $data['get_intransit_order_list'] = $data['get_ofd_order_list'] = $data['get_ndr_order_list'] = $data['get_delivered_order_list'] = '0';
		// dd($get_all_count);
		if (!empty($get_all_count)) {
			foreach ($get_all_count as $count) {
				switch ($count['order_status_id']) {
					case '1':
						$data['get_created_order_list'] = $count['numrows'];
						break;
					case '3':
						$data['get_intransit_order_list'] = $count['numrows'];
						break;
					case '5':
						$data['get_ofd_order_list'] = $count['numrows'];
						break;

					case '6':
						$data['get_delivered_order_list'] = $count['numrows'];
						break;

					case '18':
						$data['get_ndr_order_list'] = $count['numrows'];
						break;

					default:
						$de = '0';
						break;
				}
			}
		}
		$data['get_all_order_list'] = $this->View_order_model->get_intransit_order_count('1,3,5,6,18,9,10,11,12,13,14');
		$data['get_rtointransit_order_list'] = $this->View_order_model->get_intransit_order_count('9,10,11,12');
		$data['get_rtodelivered_order_list '] = $this->View_order_model->get_intransit_order_count('13,14');
		$data['get_onprocess_order_list'] = $this->View_order_model->get_onprocess_data($this->session->userdata('userId'), $this->session->userdata('userType'));
		$data['get_error_order_list'] = $this->View_order_model->get_error_data($this->session->userdata('userId'), $this->session->userdata('userType'));
		$data['get_waiting_order_list'] = $this->View_order_model->get_waiting_order_data($this->session->userdata('userId'), $this->session->userdata('userType'));
		// dd($data);
		return $data;
	}

	function createWaybillBarcodeImage($order_id, $airwaybill_number)
	{
		$data1 =  CUSTOM::barcode($this->config->item('FILE_PATH') . 'uploads/order_barcode/' . $order_id . '.jpg', $airwaybill_number, 40, 'horizontal', 'Code128', '', 1);
		$data['airwaybill_barcode_img'] = $order_id . '.jpg';
		$this->Common_model->update($data, 'order_airwaybill_detail', array('order_id' => $order_id));
		return 'uploads/order_barcode/' . $order_id . ".jpg";
	}

	//Genrate uddan baracode and store
	public function createuddanbarcode($order_id, $uddan_ship_id)
	{
		$data1 =  CUSTOM::barcode($this->config->item('FILE_PATH') . 'uploads/uddan_barcode/' . $order_id . '.jpg', $uddan_ship_id, 40, 'horizontal', 'Code128', '', 1);
		return 'uploads/uddan_barcode/' . $order_id . ".jpg";
	}

	//multiple packing slip (all)
	public function multiple_packing_slip()
	{
		$order_ids = $this->input->post('id');
		$this->load->model('Order_model');
		$order_info = $this->Order_model->get_multiple_order_list_for_slip($order_ids);
		// dd($order_info);
		$this->load->library('pdf');
		$i = 0;
		foreach ($order_info as $single_order_info) {
			$data['order_info'][$i] = $single_order_info;
			if ($single_order_info['airwaybill_barcode_img'] != "" && file_exists('uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'])) {
				$data['order_info'][$i]['airwaybill_barcode_img1'] = 'uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'];
			} else {
				$data['order_info'][$i]['airwaybill_barcode_img1'] = $this->createWaybillBarcodeImage($single_order_info['id'], $single_order_info['awb_number']);
			}
			if ($single_order_info['api_name'] == 'Udaan_Direct') {
				$uddan_awb_no = $this->Order_model->get_uddan_id($single_order_info['id']);
				$data['order_info'][$i]['uddan_barcode_text'] = $uddan_awb_no['udaan_shipment_id'];
				$data['order_info'][$i]['uddan_barcode_img'] = $this->createuddanbarcode($single_order_info['id'], $uddan_awb_no['udaan_shipment_id']);
			}
			$i++;
		}
		$html = $this->load->view('admin/order/multiple_packing_slip_' . str_replace(array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0'), array('first', 'second', 'third', 'forth', 'fifth', 'sixth', 'seventh', 'eight', 'nineth', 'tenth'), $this->input->post('label_type')), $data, true);

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
			if ($single_order_info['airwaybill_barcode_img'] != "" && file_exists('uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'])) {
				$data['order_info']['airwaybill_barcode_img'] = 'uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'];
				$path = $data['order_info']['airwaybill_barcode_img'];
				$type = pathinfo($path, PATHINFO_EXTENSION);
				$file_data = file_get_contents($path);
				$base64 = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
				$data['order_info']['base64_barcode_img'] = $base64;
			} else {
				$data['order_info']['airwaybill_barcode_img'] = $this->createWaybillBarcodeImage($single_order_info['id'], $single_order_info['awb_number']);
				$path = $data['order_info']['airwaybill_barcode_img'];
				$type = pathinfo($path, PATHINFO_EXTENSION);
				$file_data = file_get_contents($path);
				$base64 = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
				$data['order_info']['base64_barcode_img'] = $base64;
			}
		}
		$html = $this->load->view('admin/order/new_single_packing_slip', $data, true);
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
			if ($single_order_info['airwaybill_barcode_img'] != "" && file_exists('uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'])) {

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
		foreach ($order_info as $single_order_info) {
			$data['order_info'] = $single_order_info;
			if ($single_order_info['airwaybill_barcode_img'] != "" && file_exists('uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'])) {
				$data['order_info']['airwaybill_barcode_img'] = 'uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'];
			} else {
				$data['order_info']['airwaybill_barcode_img'] = $this->createWaybillBarcodeImage($single_order_info['id'], $single_order_info['awb_number']);
			}
		}
		$html = $this->load->view('admin/order/third_single_packing_slip', $data, true);

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
			if ($single_order_info['airwaybill_barcode_img'] != "" && file_exists('uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'])) {
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
		foreach ($order_info as $single_order_info) {
			$data['order_info'] = $single_order_info;
			if ($single_order_info['airwaybill_barcode_img'] != "" && file_exists('uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'])) {
				$data['order_info']['airwaybill_barcode_img'] = 'uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'];
			} else {
				$data['order_info']['airwaybill_barcode_img'] = $this->createWaybillBarcodeImage($single_order_info['id'], $single_order_info['awb_number']);
			}
		}
		$html = $this->load->view('admin/order/forth_single_packing_slip', $data, true);
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
			if ($single_order_info['airwaybill_barcode_img'] != "" && file_exists('uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'])) {

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
		$this->pdf->load_html($html);
		$this->pdf->render();
		$output = $this->pdf->output();

		file_put_contents($this->config->item('FILE_PATH') . 'uploads/multiple_print/' . $filename, $output);
		echo $filename;
		exit();
	}


	public function fifth_single_packing_slip($id)
	{
		$this->load->model('Order_model');
		$order_id = $id;
		$order_info = $this->Order_model->get_multiple_order_list_for_slip($order_id);
		$this->load->library('pdf');
		foreach ($order_info as $single_order_info) {
			$data['order_info'] = $single_order_info;
			if ($single_order_info['airwaybill_barcode_img'] != "" && file_exists('uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'] != 1)) {
				$data['order_info']['airwaybill_barcode_img'] = 'uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'];
			} else {
				$data['order_info']['airwaybill_barcode_img'] = $this->createWaybillBarcodeImage($single_order_info['id'], $single_order_info['awb_number']);
			}


			if ($single_order_info['api_name'] == 'Udaan_Direct') {
				$uddan_awb_no = $this->Order_model->get_uddan_id($single_order_info['id']);
				$data['order_info']['uddan_barcode_text'] = $uddan_awb_no['udaan_shipment_id'];
				$data['order_info']['uddan_barcode_img'] = $this->createuddanbarcode($single_order_info['id'], $uddan_awb_no['udaan_shipment_id']);
			}
		}


		$html = $this->load->view('admin/order/fifth_single_packing_slip', $data, true);
		$this->pdf->load_html($html);
		$this->pdf->createPDF($html, 'packing-slip', false, 'A4', 'portrait');
	}


	//multiple manifest pdf create
	public function multiple_manifest()
	{
		$arr = array();
		$this->load->model('Order_model');
		$multiple_order = $this->input->post('order_id');
		$data = array();
		$order_info = $this->Order_model->get_manifest_data($this->input->post('order_id'));
		// dd($order_info);
		$i = 0;
		foreach ($order_info as $single_order_info) {
			if ($single_order_info['awb_number'] != "" || $single_order_info['order_no']) {
				$arr['order']['user_result'] = $this->Common_model->getRow(array('id' => $single_order_info['sender_id']), 'name', 'sender_master');

				$arr['order']['user_kyc_result'] = $this->Common_model->getRow(array('sender_id' => $single_order_info['sender_id']), 'gst_no', 'kyc_verification_master');
				$arr['order']['logistic_result'] = $this->Common_model->getRow(array('id' => $single_order_info['logistic_id']), 'api_name,id,logistic_name', 'logistic_master');
				$arr['order']['order_info'][$arr['order']['logistic_result']->id]['logistic_name_display'] = $single_order_info['logistic_name'];
				$arr['order']['order_info'][$arr['order']['logistic_result']->id]['api_name_display'] = $single_order_info['api_name'];
				$arr['order']['order_info'][$arr['order']['logistic_result']->id]['info'][$i] = $single_order_info;
				if ($single_order_info['airwaybill_barcode_img'] != ""  && file_exists('uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'])) {
					$arr['order']['order_info'][$arr['order']['logistic_result']->id]['info'][$i]['logistic_name_display'] = base_url('uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img']);
				} else {
					$arr['order']['order_info'][$arr['order']['logistic_result']->id]['info'][$i]['logistic_name_display'] = base_url($this->createWaybillBarcodeImage($single_order_info['id'], $single_order_info['awb_number']));
				}

				if ($single_order_info['api_name'] == 'Udaan_Direct') {
					$uddan_awb_no = $this->Order_model->get_uddan_id($single_order_info['id']);
					$single_order_info['awb_number'] = $uddan_awb_no['udaan_shipment_id'];
					$data['order_info']['airwaybill_barcode_img'] = $this->createuddanbarcode($single_order_info['id'], $uddan_awb_no['udaan_shipment_id']);
				}
				$i++;
			}
		}
		$this->load->library('pdf');
		$html = $this->load->view('admin/order/multiple_manifest', $arr, true);
		$filename = rand() . ".pdf";

		if (file_exists(base_url() . 'uploads/multiple_manifest/' . $filename)) {
			unlink('multiple_manifest/' . $filename);
		}
		$this->pdf->load_html($html);
		$this->pdf->render();
		$output = $this->pdf->output();
		file_put_contents($this->config->item('FILE_PATH')  . 'uploads/multiple_manifest/' . $filename, $output);
		echo $filename;
		exit();
		// }
	}


	//insert ndr comment
	public function insert_ndr_comment()
	{
		$order_id = $this->input->post('orderid');

		$insert_data['order_id'] = $order_id;
		$insert_data['forder_id'] = $order_id;

		if ($this->session->userdata('userType') == '1') {
			$insert_data['created_by_user'] = $this->session->userdata('userId');
			if (($this->input->post('p_comment') != "" || $this->input->post('pd_comment') != "")) {
				if ($this->input->post('submit') != "") {
					$ndr_cmnt_id = $this->input->post('submit');
					if ($this->input->post('p_comment') != "") {
						$insert_data['provider_comment'] = $this->input->post('p_comment');
					}
					if ($this->input->post('pd_comment') != "") {
						$insert_data['admin_comment'] = $this->input->post('pd_comment');
					}
					$insert_cmnt = $this->Common_model->update($insert_data, 'ndr_comment_detail', array('ndr_comment_detail_id' => $ndr_cmnt_id));
				} else {
					if ($this->input->post('p_comment') != "") {
						$insert_data['provider_comment'] = $this->input->post('p_comment');
					}
					if ($this->input->post('pd_comment') != "") {
						$insert_data['admin_comment'] = $this->input->post('pd_comment');
					}
					$insert_cmnt = $this->Common_model->insert($insert_data, 'ndr_comment_detail');
				}
				if ($insert_cmnt) {
					$this->session->set_flashdata('message', "NDR comment save Successfully.");
					redirect('ndr-Order-List');
				} else {
					$this->session->set_flashdata('error', "Failed!! try again");
					redirect('ndr-Order-List');
				}
			} else {
				$this->session->set_flashdata('error', "Failed!! try again");
				redirect('ndr-Order-List');
			}
		} else {
			$insert_data['created_by_sender'] = $this->session->userdata('userId');

			if ($this->input->post('client_comment') != "") {
				if ($this->input->post('submit') != "") {
					//update client comment
					$ndr_cmnt_id = $this->input->post('submit');
					$insert_data['client_comment'] = $this->input->post('client_comment');
					$insert_cmnt = $this->Common_model->update($insert_data, 'ndr_comment_detail', array('ndr_comment_detail_id' => $ndr_cmnt_id));
				} else {
					//insert new comment
					$insert_data['client_comment'] = $this->input->post('client_comment');
					$insert_cmnt = $this->Common_model->insert($insert_data, 'ndr_comment_detail');
				}
				if ($insert_cmnt) {
					$this->session->set_flashdata('message', "NDR comment save Successfully.");
					redirect('ndr-Order-List');
				} else {
					$this->session->set_flashdata('error', "Failed!! try again");
					redirect('ndr-Order-List');
				}
			} else {
				$this->session->set_flashdata('error', "Failed!! try again");
				redirect('ndr-Order-List');
			}
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

	public function delete_multiple_error_order()
	{

		$order_id = $this->input->post('order_id');
		$result = $this->View_order_model->delete_bulk_order($order_id);
		echo $result;
		exit;
	}

	public function delete_created_order($order_id)
	{

		$order_data_info = $this->Common_model->getSingleRowArray(array('id' => $order_id), 'logistic_id', 'forward_order_master');
		$logistic_data_info = $this->Common_model->getSingleRowArray(array('id' => $order_data_info['logistic_id']), 'api_name,is_zship', 'logistic_master');

		switch ($logistic_data_info['is_zship']) {
			case '1':
				$data = ['is_delete' => '1'];
				$this->Common_model->update($data, 'forward_order_master', array('id' => $order_id));
				if (strpos($logistic_data_info['api_name'], 'Delhivery') !== false) {
					$this->load->helper('delhiver_direct');
					switch ($logistic_data_info['api_name']) {
						case 'Delhivery_Direct':
							delhiver_direct::cancel_order($order_id);
							break;
						case 'Deliverysexpress_Direct':
							delhiver_direct::cancel_order($order_id, 1);
							break;
					}
					$this->session->set_flashdata('message', "Order Deleted Successfully.");
				} else {
					$this->load->helper(strtolower(trim($logistic_data_info['api_name'])));
					$response = strtolower(trim($logistic_data_info['api_name']))::cancel_order($order_id);
					// $this->load->helper('wallet');
					// wallet::refund_wallet($order_id);
					$this->session->set_flashdata('message', "Order Deleted Successfully.");
				}

				break;
			default:
				$data = ['is_delete' => '1'];
				$this->Common_model->update($data, 'forward_order_master', array('id' => $order_id));
				// $this->load->helper('wallet');
				// wallet::refund_wallet($order_id);
				$this->session->set_flashdata('message', "Order Deleted Successfully.");
				break;
		}
		redirect('createdOrderList');
	}


	public function delete_multiple_created_order()
	{
		$total_order = $error_count = count($this->input->post('order_id'));
		$succes_count = 0;

		if ($this->input->post('order_id')) {
			foreach ($this->input->post('order_id') as $key => $order_id_value) {
				// $this->delete_created_order($order_id_value);
				$order_data_info = $this->Common_model->getSingleRowArray(array('id' => $order_id_value), 'logistic_id', 'forward_order_master');
				$logistic_data_info = $this->Common_model->getSingleRowArray(array('id' => $order_data_info['logistic_id']), 'api_name,is_zship', 'logistic_master');

				switch ($logistic_data_info['is_zship']) {
					case '1':
						$data = ['is_delete' => '1'];
						$this->Common_model->update($data, 'forward_order_master', array('id' => $order_id_value));
						$this->load->helper(strtolower(trim($logistic_data_info['api_name'])));
						$response = strtolower(trim($logistic_data_info['api_name']))::cancel_order($order_id_value);
						// $this->load->helper('wallet');
						// $status = wallet::refund_wallet($order_id_value);
						if (!empty($status['1'])) {
							$succes_count++;
							$error_count--;
						}
						break;
					default:
						$data = ['is_delete' => '1'];
						$this->Common_model->update($data, 'forward_order_master', array('id' => $order_id_value));
						// $this->load->helper('wallet');
						// $status = wallet::refund_wallet($order_id_value);
						if (!empty($status['1'])) {
							$succes_count++;
							$error_count--;
						}
						break;
				}
			}
			echo json_encode(['total' => $total_order, 'success' => $succes_count, 'error' => $error_count]);
		}
	}

	//first single packing slip with  logo
	public function packing_slip_logo($order_id)
	{
		// die($order_id);
		$this->load->model('Order_model');
		// $order_id = 11;
		$order_info = $this->Order_model->get_multiple_order_list_for_slip($order_id);
		// dd($order_info);
		foreach ($order_info as $single_order_info) {
			$data['order_info'] = $single_order_info;
			if ($single_order_info['airwaybill_barcode_img'] != "" && file_exists('uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'])) {
				$data['order_info']['airwaybill_barcode_img'] = 'uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'];
			} else {
				$data['order_info']['airwaybill_barcode_img'] = $this->createWaybillBarcodeImage($single_order_info['id'], $single_order_info['awb_number']);
			}
		}

		$this->load->library('pdf');
		$html = $this->load->view('admin/order/single_packing_slip_logo', $data, true);
		// echo $html;
		// exit;
		$this->pdf->createPDF($html, 'packing-slip', false, 'A4', 'portrait');
	}

	// 2nd packing slip single with  logo
	public function new_single_packing_slip_logo($id)
	{
		$this->load->model('Order_model');
		$order_id = $id;
		$order_info = $this->Order_model->get_multiple_order_list_for_slip($order_id);
		$this->load->library('pdf');
		// dd($order_info);
		foreach ($order_info as $single_order_info) {
			$data['order_info'] = $single_order_info;
			if ($single_order_info['airwaybill_barcode_img'] != "" && file_exists('uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'])) {
				$data['order_info']['airwaybill_barcode_img'] = 'uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'];
				$path = $data['order_info']['airwaybill_barcode_img'];
				$type = pathinfo($path, PATHINFO_EXTENSION);
				$file_data = file_get_contents($path);
				$base64 = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
				$data['order_info']['base64_barcode_img'] = $base64;
			} else {
				$data['order_info']['airwaybill_barcode_img'] = $this->createWaybillBarcodeImage($single_order_info['id'], $single_order_info['awb_number']);
				$path = $data['order_info']['airwaybill_barcode_img'];
				$type = pathinfo($path, PATHINFO_EXTENSION);
				$file_data = file_get_contents($path);
				$base64 = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
				$data['order_info']['base64_barcode_img'] = $base64;
			}
		}
		$html = $this->load->view('admin/order/new_single_packing_slip_logo', $data, true);
		$this->pdf->createPDF($html, 'packing-slip', false, 'A4', 'portrait');
	}

	//3rd vali packing slip  single
	public function third_single_packing_slip_logo($id)
	{
		$this->load->model('Order_model');
		$order_id = $id;
		$order_info = $this->Order_model->get_multiple_order_list_for_slip($order_id);
		$this->load->library('pdf');
		foreach ($order_info as $single_order_info) {
			$data['order_info'] = $single_order_info;
			if ($single_order_info['airwaybill_barcode_img'] != "" && file_exists('uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'])) {
				$data['order_info']['airwaybill_barcode_img'] = 'uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'];
			} else {
				$data['order_info']['airwaybill_barcode_img'] = $this->createWaybillBarcodeImage($single_order_info['id'], $single_order_info['awb_number']);
			}
		}
		$html = $this->load->view('admin/order/third_single_packing_slip_logo', $data, true);

		$this->pdf->load_html($html);
		$this->pdf->createPDF($html, 'packing-slip', false, 'A4', 'portrait');
	}

	//4th single packing slip
	public function forth_single_packing_slip_logo($id)
	{
		$this->load->model('Order_model');
		$order_id = $id;
		$order_info = $this->Order_model->get_multiple_order_list_for_slip($order_id);
		$this->load->library('pdf');
		foreach ($order_info as $single_order_info) {
			$data['order_info'] = $single_order_info;
			if ($single_order_info['airwaybill_barcode_img'] != "" && file_exists('uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'])) {
				$data['order_info']['airwaybill_barcode_img'] = 'uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'];
			} else {
				$data['order_info']['airwaybill_barcode_img'] = $this->createWaybillBarcodeImage($single_order_info['id'], $single_order_info['awb_number']);
			}
		}
		$html = $this->load->view('admin/order/forth_single_packing_slip_logo', $data, true);
		$this->pdf->load_html($html);
		$this->pdf->createPDF($html, 'packing-slip', false, 'A4', 'portrait');
	}

	public function fifth_single_packing_slip_logo($id)
	{
		$this->load->model('Order_model');
		$order_id = $id;
		$order_info = $this->Order_model->get_multiple_order_list_for_slip($order_id);
		$this->load->library('pdf');
		foreach ($order_info as $single_order_info) {
			$data['order_info'] = $single_order_info;
			if ($single_order_info['airwaybill_barcode_img'] != "" && file_exists('uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'])) {
				$data['order_info']['airwaybill_barcode_img'] = 'uploads/order_barcode/' . $single_order_info['airwaybill_barcode_img'];
			} else {
				$data['order_info']['airwaybill_barcode_img'] = $this->createWaybillBarcodeImage($single_order_info['id'], $single_order_info['awb_number']);
			}

			if ($single_order_info['api_name'] == 'Udaan_Direct') {
				$uddan_awb_no = $this->Order_model->get_uddan_id($single_order_info['id']);
				$data['order_info']['uddan_barcode_text'] = $uddan_awb_no['udaan_shipment_id'];
				$data['order_info']['uddan_barcode_img'] = $this->createuddanbarcode($single_order_info['id'], $uddan_awb_no['udaan_shipment_id']);
			}
		}
		$html = $this->load->view('admin/order/fifth_single_packing_slip_logo', $data, true);
		$this->pdf->load_html($html);
		$this->pdf->createPDF($html, 'packing-slip', false, 'A4', 'portrait');
	}
}


/* End of file Price.php */
