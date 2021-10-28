<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pre_awb_Order_list extends Auth_Controller
{
    public $data = array();
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pre_awb_View_order_model');

        //Do your magic here
    }
    public function loadview($viewname)
    {

        $this->load->view('admin/template/header');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/order/' . $viewname, $this->data);
        $this->load->view('admin/template/footer');
    }


    public function pre_awb_onprocess_order_list_view()
    {

        $this->data['order_count'] = $this->pre_awb_get_order_count();
        $this->loadview('pre_awb_onprocess_order_list', $this->data);
    }

    public function  pre_awb_onprocess_order_list_table()
    {
        $columns = array();
        $table = 'temp_forward_order_master';
        $primaryKey = 'id';
        if ($this->session->userdata['userType'] == '1') {
            $where = "fom.is_pre_awb = '1' AND fom.is_created = '1'";
        } else {
            $where = "fom.is_pre_awb = '1' AND fom.sender_id='" . $this->session->userdata['userId'] . "' AND fom.is_created = '1'";
        }
        $joinQuery = ' FROM ' . $table . ' fom INNER JOIN sender_master as sm ON sm.id=fom.sender_id INNER JOIN logistic_master as lm ON lm.id=fom.logistic_id INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id';
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



        if ($this->session->userdata('userType') == '1') {
            $columns[11] = array('db' => 'sm.email', 'dt' => 11, 'field' => 'email', 'formatter' => function ($d, $row) {
                return "<span>" . $d . "</span>";
            });
        }


        echo json_encode(
            SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where)
        );
    }

    public function index()
    {
        $this->data['order_count'] = $this->pre_awb_get_order_count();

        $this->loadview('pre_awb_order_list_demo', $this->data);
    }

    /**
     * Order datatable
     *
     * @return  datatable  load all Shipping Price in database
     */
    public function pre_awb_order_list_table()
    {

        $columns = array();
        $table = 'forward_order_master';
        $primaryKey = 'id';
        if ($this->session->userdata['userType'] == '1') {
            $where = "fom.is_pre_awb = '1' AND is_delete='0' ";
        } else {
            $where = "fom.is_pre_awb = '1' AND is_delete='0' AND fom.sender_id='" . $this->session->userdata['userId'] . "'";
        }
        $joinQuery = ' FROM ' . $table . ' fom INNER JOIN sender_master as sm ON sm.id=fom.sender_id INNER JOIN logistic_master as lm ON lm.id=fom.logistic_id INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id LEFT JOIN order_airwaybill_detail as owd ON owd.order_id = fom.id LEFT JOIN order_status as os ON os.order_status_id = owd.order_status_id
        ';

        $columns[0] = array('db' => 'fom.id', 'dt' => 0, 'field' => 'id', 'formatter' => function ($d, $row) {
            return '<input type="checkbox" class="single_manifested_order" name="id[]" value="' . $d . '">';
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
        }

        echo json_encode(
            SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where)
        );
    }

    /**
     * Manifast Order Table
     */

    public function pre_awb_createdorder_list_view()
    {
        $this->data['order_count'] = $this->pre_awb_get_order_count();
        $user_id = $this->session->userdata('userId');

        $this->load->model('Order_model');
        $this->data['assign_labels'] = $this->Order_model->get_user_assign_label($user_id);
        $this->loadview('pre_awb_created_order_list', $this->data);
    }
    public function pre_awb_created_order_table()
    {

        $columns = array();
        $table = 'forward_order_master';
        $primaryKey = 'id';
        if ($this->session->userdata['userType'] == '1') {
            $where = "fom.is_pre_awb = '1' AND is_delete='0' AND os.order_status_id = '1'";
        } else {
            $where = "fom.is_pre_awb = '1' AND is_delete='0' AND os.order_status_id = '1'  AND fom.sender_id='" . $this->session->userdata['userId'] . "'";
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
                return "<div class='row'><a class='btn btn-danger' href='" . base_url('delete-created-order/' . $d) . "'>Delete</a></div>";
            });
        } else {
            $columns[12] = array('db' => 'fom.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
                return "<div class=''><a class='single_order_print_button' data-id='" . $d . "'><i class='fa fa-print' aria-hidden='true' style='font-size:30px;'></i></a></div>";
            });
            $columns[13] = array('db' => 'fom.id', 'dt' => 13, 'field' => 'id', 'formatter' => function ($d, $row) {
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
    public function pre_awb_intransit_order_list()
    {
        $this->data['order_count'] = $this->pre_awb_get_order_count();
        $this->loadview('pre_awb_intransit_order_list', $this->data);
    }
    public function pre_awb_intransit_order_table()
    {
        $columns = array();
        $table = 'forward_order_master';
        $primaryKey = 'id';
        if ($this->session->userdata['userType'] == '1') {
            $where = "fom.is_pre_awb = '1' AND os.order_status_id = '3'  AND fom.is_delete = '0'";
        } else {
            $where = "fom.is_pre_awb = '1' AND os.order_status_id = '3'  AND fom.is_delete = '0' AND fom.sender_id='" . $this->session->userdata['userId'] . "'";
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
        $columns[11] = array('db' => 'os.status_name', 'dt' => 11, 'field' => 'status_name');
        if ($this->session->userdata('userType') == '1') {
            $columns[12] = array('db' => 'sm.email', 'dt' => 12, 'field' => 'email', 'formatter' => function ($d, $row) {
                return "<span>" . $d . "</span>";
            });

            $columns[13] = array('db' => 'fom.id', 'dt' => 13, 'field' => 'id', 'formatter' => function ($d, $row) {
                return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_detail_btn' data-target='#pre_intransit_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' style='margin-bottom:5px;'>Order Details</button>";
            });
            $columns[14] = array('db' => 'fom.id', 'dt' => 14, 'field' => 'id', 'formatter' => function ($d, $row) {
                return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#pre_intransit_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' style='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button>";
            });
        } else {
            $columns[12] = array('db' => 'fom.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
                return "<button type='button' data-details='order_details' data-toggle='modal' id='order_detail_btn' data-target='#pre_intransit_order_btn' data-id='$row[0]' class='btn btn-primary btn-xs waves-effect waves-classic' style='margin-bottom:5px;'>Order Details</button>";
            });
            $columns[13] = array('db' => 'fom.id', 'dt' => 13, 'field' => 'id', 'formatter' => function ($d, $row) {
                return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#pre_intransit_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' style='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button>";
            });
        }

        echo json_encode(
            SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where)
        );
    }

    /**
     * OFD Order Table
     */
    public function pre_awb_ofd_order_list()
    {
        $this->data['order_count'] = $this->pre_awb_get_order_count();
        $this->loadview('pre_awb_ofd_order_list', $this->data);
    }
    public function pre_awb_ofd_order_table()
    {
        $columns = array();
        $table = 'forward_order_master';
        $primaryKey = 'id';
        if ($this->session->userdata['userType'] == '1') {
            $where = "fom.is_pre_awb = '1' AND os.order_status_id = '5'  AND fom.is_delete = '0'";
        } else {
            $where = "fom.is_pre_awb = '1' AND os.order_status_id = '5'  AND fom.is_delete = '0' AND fom.sender_id='" . $this->session->userdata['userId'] . "'";
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
                return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_detail_btn' data-target='#pre_ofd_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' style='margin-bottom:5px;'>Order Details</button>";
            });
            $columns[14] = array('db' => 'fom.id', 'dt' => 14, 'field' => 'id', 'formatter' => function ($d, $row) {
                return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#pre_ofd_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' style='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button></div>";
            });
        } else {
            $columns[12] = array('db' => 'fom.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
                return "<button type='button' data-details='order_details' data-toggle='modal' id='order_detail_btn' data-target='#pre_ofd_order_details' data-id='$row[0]' class='btn btn-primary btn-xs waves-effect waves-classic' style='margin-bottom:5px;'>Order Details</button>";
            });
            $columns[13] = array('db' => 'fom.id', 'dt' => 13, 'field' => 'id', 'formatter' => function ($d, $row) {
                return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#pre_ofd_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' style='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button></div>";
            });
        }

        echo json_encode(
            SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where)
        );
    }

    /**
     * NDR Order Table
     */
    public function pre_awb_ndr_order_list()
    {
        $this->data['order_count'] = $this->pre_awb_get_order_count();
        $this->loadview('pre_awb_ndr_order_list', $this->data);
    }
    public function pre_awb_ndr_order_table()
    {
        $columns = array();
        $table = 'forward_order_master';
        $primaryKey = 'id';
        if ($this->session->userdata['userType'] == '1') {
            $where = "fom.is_pre_awb = '1' AND os.order_status_id = '18'  AND fom.is_delete = '0'";
        } else {
            $where = "fom.is_pre_awb = '1' AND os.order_status_id = '18'  AND fom.is_delete = '0' AND fom.sender_id='" . $this->session->userdata['userId'] . "'";
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
                return "<button type='button' data-toggle='modal' data-id='$row[0]' id='order_detail_btn' data-target='#pre_ndr_order_details' data-details='order_details' class='btn btn-primary btn-xs waves-effect waves-classic'style='margin-top: 5px;' >Order Detail</button> <button type='button' data-type='pre_awb' data-toggle='modal' data-target='#pre_ndr_order_comment' data-id='$row[1]' id='pre_order_ndr_comment' class='btn btn-primary btn-xs waves-effect waves-classic'style='margin-top: 5px;'>NDR Comment</button>";
            });
            $columns[14] = array('db' => 'fom.id', 'dt' => 14, 'field' => 'id', 'formatter' => function ($d, $row) {
                return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#pre_ndr_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' style='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button>";
            });
        } else {
            $columns[12] = array('db' => 'fom.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
                return "<button type='button' data-toggle='modal' data-id='$row[0]' id='order_detail_btn' data-target='#pre_ndr_order_details' data-details='order_details' class='btn btn-primary btn-xs waves-effect waves-classic'style='margin-top: 5px;'>Order Detail</button> <button type='button' data-toggle='modal'data-type='pre_awb' data-target='#pre_ndr_order_comment' data-id='$row[1]' id='pre_order_ndr_comment' class='btn btn-primary btn-xs waves-effect waves-classic'style='margin-top: 5px;'>NDR Comment</button>";
            });
            $columns[13] = array('db' => 'fom.id', 'dt' => 13, 'field' => 'id', 'formatter' => function ($d, $row) {
                return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#pre_ndr_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' style='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button>";
            });
        }


        echo json_encode(
            SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where)
        );
    }

    /**
     * Delivered Order Table
     */
    public function pre_awb_delivered_order_list()
    {
        $this->data['order_count'] = $this->pre_awb_get_order_count();
        $this->loadview('pre_awb_delivered_order_list', $this->data);
    }
    public function pre_awb_delivered_order_table()
    {
        $columns = array();
        $table = 'forward_order_master';
        $primaryKey = 'id';
        if ($this->session->userdata['userType'] == '1') {
            $where = "fom.is_pre_awb = '1' AND os.order_status_id = '6'  AND fom.is_delete = '0'";
        } else {
            $where = "fom.is_pre_awb = '1' AND os.order_status_id = '6'  AND fom.is_delete = '0' AND fom.sender_id='" . $this->session->userdata['userId'] . "'";
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
                return "<button type='button' data-toggle='modal' data-id='$row[0]' id='order_detail_btn' data-details='order_details' data-target='#pre_delivred_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' style='margin-bottom:5px;'>Order Details</button>";
            });
            $columns[14] = array('db' => 'fom.id', 'dt' => 14, 'field' => 'id', 'formatter' => function ($d, $row) {
                return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#pre_delivred_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' style='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button>";
            });
        } else {
            $columns[12] = array('db' => 'fom.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
                return "<button type='button' data-toggle='modal' id='order_detail_btn' data-target='#pre_delivred_order_details' data-details='order_details' data-id='$row[0]' class='btn btn-primary btn-xs waves-effect waves-classic' style='margin-bottom:5px;'>Order Details</button>";
            });
            $columns[13] = array('db' => 'fom.id', 'dt' => 13, 'field' => 'id', 'formatter' => function ($d, $row) {
                return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#pre_delivred_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' style='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button>";
            });
        }

        echo json_encode(
            SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where)
        );
    }

    /**
     * RTO InTransit Order Table
     */
    public function pre_awb_rtoIntransit_order_list()
    {
        $this->data['order_count'] = $this->pre_awb_get_order_count();
        $this->loadview('pre_awb_rto_order_list', $this->data);
    }
    public function pre_awb_rtointransit_order_table()
    {
        $columns = array();
        $table = 'forward_order_master';
        $primaryKey = 'id';
        if ($this->session->userdata['userType'] == '1') {
            $where = "fom.is_pre_awb = '1'  AND fom.is_delete = '0' AND  (os.order_status_id = '9' OR os.order_status_id = '10' OR os.order_status_id = '11' OR os.order_status_id = '12')";
        } else {
            $where = "fom.is_pre_awb = '1'  AND fom.is_delete = '0' AND (os.order_status_id = '9' OR os.order_status_id = '10' OR os.order_status_id = '11' OR os.order_status_id = '12') AND fom.sender_id='" . $this->session->userdata['userId'] . "'";
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
                return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_detail_btn' data-target='#pre_rto_intransit_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' style='margin-bottom:5px;'>Order Details</button>";
            });
            $columns[14] = array('db' => 'fom.id', 'dt' => 14, 'field' => 'id', 'formatter' => function ($d, $row) {
                return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#pre_rto_intransit_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' style='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button></div>";
            });
        } else {
            $columns[12] = array('db' => 'fom.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
                return "<button type='button' data-details='order_details' data-toggle='modal' id='order_detail_btn' data-target='#pre_rto_intransit_order_details' data-id='$row[0]' class='btn btn-primary btn-xs waves-effect waves-classic' style='margin-bottom:5px;'>Order Details</button>";
            });
            $columns[13] = array('db' => 'fom.id', 'dt' => 13, 'field' => 'id', 'formatter' => function ($d, $row) {
                return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#pre_rto_intransit_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' style='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button></div>";
            });
        }

        echo json_encode(
            SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where)
        );
    }

    /**
     * RTO Delivered Order Table
     */
    public function pre_awb_rtodelivered_order_list()
    {
        $this->data['order_count'] = $this->pre_awb_get_order_count();
        $this->loadview('pre_awb_rto_delivered_list', $this->data);
    }
    public function pre_awb_rtodelivered_order_table()
    {
        $columns = array();
        $table = 'forward_order_master';
        $primaryKey = 'id';
        if ($this->session->userdata['userType'] == '1') {
            $where = "fom.is_pre_awb = '1'  AND fom.is_delete = '0' AND (os.order_status_id = '13' OR os.order_status_id = '14')";
        } else {
            $where = "fom.is_pre_awb = '1'  AND fom.is_delete = '0' AND (os.order_status_id = '13' OR os.order_status_id = '14') AND fom.sender_id='" . $this->session->userdata['userId'] . "'";
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
                return "<button type='button' data-toggle='modal' data-id='$row[0]' id='order_detail_btn' data-details='order_details' data-target='#pre_rto_delivered_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' style='margin-bottom:5px;'>Order Details</button>";
            });
            $columns[14] = array('db' => 'fom.id', 'dt' => 14, 'field' => 'id', 'formatter' => function ($d, $row) {
                return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#pre_rto_delivered_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' style='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button></div>";
            });
        } else {
            $columns[12] = array('db' => 'fom.id', 'dt' => 12, 'field' => 'id', 'formatter' => function ($d, $row) {
                return "<button type='button' data-toggle='modal' id='order_detail_btn' data-target='#pre_rto_delivered_order_details' data-id='$row[0]' data-details='order_details' class='btn btn-primary btn-xs waves-effect waves-classic' style='margin-bottom:5px;'>Order Details</button>";
            });
            $columns[13] = array('db' => 'fom.id', 'dt' => 13, 'field' => 'id', 'formatter' => function ($d, $row) {
                return "<button type='button' data-details='order_details' data-toggle='modal' data-id='$row[0]' id='order_tracking_btn' data-target='#pre_rto_delivered_order_details' class='btn btn-primary btn-xs waves-effect waves-classic' style='margin-bottom:5px;'><i class='fa fa-map-marker' aria-hidden='true'></i></button></div>";
            });
        }
        echo json_encode(
            SSP::simple($_GET, $table, $primaryKey, $columns, $joinQuery, $where)
        );
    }
    //error order

    public function pre_awb_error_order_list_view()
    {

        $this->data['order_count'] = $this->pre_awb_get_order_count();
        $this->loadview('pre_awb_error_order_list', $this->data);
    }

    public function  pre_awb_error_order_list_table()
    {
        $columns = array();
        $table = 'error_order_master';
        $primaryKey = 'id';
        if ($this->session->userdata['userType'] == '1') {
            $where = "fom.is_pre_awb = '1' AND fom.is_delete = '0'  ";
        } else {
            $where = "fom.is_pre_awb = '1' AND fom.is_delete = '0'  AND fom.sender_id='" . $this->session->userdata['userId'] . "'";
        }
        $joinQuery = ' FROM ' . $table . ' fom INNER JOIN sender_master as sm ON sm.id=fom.sender_id INNER JOIN logistic_master as lm ON lm.id=fom.logistic_id INNER JOIN receiver_address as ra ON ra.id=fom.deliver_address_id LEFT JOIN order_airwaybill_detail as owd ON owd.order_id = fom.id';

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
            'db' => 'fom.created_date', 'dt' => 9, 'field' => 'created_date',
            'formatter' => function ($d, $row) {
                return "";
            }
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

    public function pre_awb_waiting_order_list_view()
    {

        $this->data['order_count'] = $this->pre_awb_get_order_count();
        $this->loadview('pre_awb_waiting_list', $this->data);
    }

    public function  pre_awb_waiting_order_list_table()
    {
        $columns = array();
        $table = 'temp_order_master';
        $primaryKey = 'id';
        if ($this->session->userdata('userType') == '1') {
            $where = "fom.is_pre_awb = '1'  AND is_flag='1'";
        } else {
            $where = "fom.is_pre_awb = '1'  AND is_flag='1' AND fom.sender_id='" . $this->session->userdata('userId') . "'";
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


    //get order list count
    public function pre_awb_get_order_count()
    {
        $data['get_all_pre_awb_order_list'] = $this->Pre_awb_View_order_model->get_count('');
        $data['get_pre_awb_created_order_list'] = $this->Pre_awb_View_order_model->get_count('1');
        $data['get_pre_awb_intransit_order_list'] = $this->Pre_awb_View_order_model->get_count('3');
        $data['get_pre_awb_ofd_order_list'] = $this->Pre_awb_View_order_model->get_count('5');
        $data['get_pre_awb_ndr_order_list'] = $this->Pre_awb_View_order_model->get_count('18');
        $data['get_pre_awb_delivered_order_list'] = $this->Pre_awb_View_order_model->get_count('6');
        $data['get_pre_awb_rtointransit_order_list'] = $this->Pre_awb_View_order_model->get_intransit_order_count('9,10,11,12');
        $data['get_pre_awb_rtodelivered_order_list'] = $this->Pre_awb_View_order_model->get_intransit_order_count('13,14');
        $data['get_pre_awb_onprocess_order_list'] = $this->Pre_awb_View_order_model->get_onprocess_data($this->session->userdata('userId'), $this->session->userdata('userType'));
        $data['get_pre_awb_error_order_list'] = $this->Pre_awb_View_order_model->get_error_data($this->session->userdata('userId'), $this->session->userdata('userType'));
        $data['get_pre_awb_waiting_order_list'] = $this->Pre_awb_View_order_model->get_waiting_order_data($this->session->userdata('userId'), $this->session->userdata('userType'));

        // dd($data);
        return $data;
    }

    public function delete_error_order($order_id)
    {
        $data = ['is_delete' => '1'];
        $this->db->where('id', $order_id);
        $this->db->update('error_order_master', $data);
        $this->session->set_flashdata('message', "Order Deleted Successfully.");
        redirect('Pre-awb-error-order-list');
    }
}

/* End of file Price.php */