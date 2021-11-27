<?php
ini_set("memory_limit", "-1");
set_time_limit(0);

defined('BASEPATH') or exit('No direct script access allowed');

class Daily_booking_reports extends Auth_Controller
{
	public $data = array();
	public $user_type;
	public $userid;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Booking_reports_model');
		$this->load->model('Report_model');
		$this->user_type = $this->session->userdata('userType');
		$this->user_id = $this->session->userdata('userId');
		//Do your magic here
	}

	public function loadview($viewname, $data = "")
	{
		$this->load->view('admin/template/header');
		$this->load->view('admin/template/sidebar');
		$this->load->view('admin/reports/' . $viewname);
		$this->load->view('admin/template/footer');
	}

	//booking report view
	public function booking_report_view()
	{
		$array = array();

		if ($this->input->post()) {
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
		} else {
			$from_date = date("Y-m-d", strtotime("-1 days"));
			$to_date = date("Y-m-d");
		}

		$get_booking_data = $this->Booking_reports_model->get_booking_data($from_date, $to_date);

		$sender = $logistic_name = array();
		foreach ($get_booking_data as $key => $data) {

			if (in_array($data['sender_name'], $sender)) {
				$array[$data['sender_name']]['sender_name'] = $data['sender_name'];
				$array[$data['sender_name']]['logistic_name'][] = $data['logistic_name'];
				$array[$data['sender_name']][$data['logistic_name']]['count'] = $data['logistic_order_count'];
			} else {
				$sender[] = $data['sender_name'];
				$array[$data['sender_name']]['sender_name'] = $data['sender_name'];
				$array[$data['sender_name']]['logistic_name'][] = $data['logistic_name'];
				$array[$data['sender_name']][$data['logistic_name']]['count'] = $data['logistic_order_count'];
			}
			if (!in_array($data['logistic_name'], $logistic_name)) {
				$logistic_name[] = $data['logistic_name'];
			}
		}
		$this->data['get_booking_data'] = $array;
		$this->data['logistic_name12'] = $logistic_name;

		$this->data['from_date'] = $from_date;
		$this->data['to_date'] = $to_date;

		load_admin_view('reports', 'daily_booking_report', $this->data);
	}


	public function intrasit_report()
	{
		if (!empty($this->input->post())) {
			try {
				// post value
				$Dpath = FCPATH . 'uploads\intransit_order_report_export_excel\*';
				$files = glob($Dpath . 'xlsx');
				if (isset($files)) {
					foreach ($files as $findfile) {
						unlink($findfile);
					}
				}
				$searchVal = array('Order ID', 'Order Number', 'Airwaybill Number', 'Shipment Type', 'Customer Name', 'Customer Mobile No', 'Customer Address', 'City', 'Pincode', 'State', 'Order Type', 'COD Amount', 'Courier Company', 'Order Status', 'Product Name', 'Product Value', 'Product Quantity', 'Physical Weight', 'Shipping Charge', 'Order Create Date', 'Order Last status Date', 'User', 'User Email');
				$fileName = 'intrasit-order-report-' . date("d-m-Y-H-i-s") . '.xlsx';
				// dd($fileName);
				// load excel library
				$objPHPExcel = new PHPExcel();
				// set Header
				$styleArray = array(
					'font' => array(
						'bold' => true,
						'color' => array('rgb' => '000000'),
						'size' => 12,
					),
				);
				$objPHPExcel->setActiveSheetIndex(0);
				$ary = $this->Report_model->get_daily_shipment_count('3', $this->input->post('to_date'), $this->input->post('from_date'), $this->user_type, $this->user_id);

				// dd($ary);
				// $i =  0;
				// foreach ($order_data as $single_data) {
				//     $ary[$i]['Order ID'] = $single_data['order_no'];
				//     $ary[$i]['Order Number'] = $single_data['customer_order_no'];
				//     $ary[$i]['Airwaybill Number'] = $single_data['awb_number'];
				//     $ary[$i]['Shipment Type'] = $single_data['shipment_type'];
				//     $ary[$i]['Customer Name'] = $single_data['customer_name'];
				//     $ary[$i]['Customer Mobile No'] = $single_data['customer_mobile_no'];
				//     $ary[$i]['Customer Address'] = $single_data['reciver_address'];
				//     $ary[$i]['Order Type'] = $single_data['remittance_rto_amount'];
				//     $ary[$i]['total_amount'] = $single_data['shipping_charge'];
				//     $ary[$i]['delivered_date'] = date("d-m-Y", strtotime($single_data['delivered_date']));
				//     $i++;
				// }
				$j1 = 'A';
				foreach ($searchVal as $key1) {
					$objPHPExcel->getActiveSheet()->getStyle($j1 . '1')->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->SetCellValue($j1 . '1', $key1);
					$objPHPExcel->getActiveSheet()
						->getStyle($j1 . '1')
						->getFill()
						->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()
						->setARGB('B6C5CE');
					$j1++;
				}
				$rowCount1 = 2;
				if (!empty($ary)) {
					$count = count($ary);
					foreach (@$ary as $element1) {
						$index = 'A';
						foreach ($element1 as $value) {
							$objPHPExcel->getActiveSheet()->SetCellValue($index . $rowCount1, $value . ' ');
							$objPHPExcel->getActiveSheet()->getColumnDimension($index)->setWidth(20);
							$index++;
						}
						$rowCount1++;
					}
				}
				$objPHPExcel->getActiveSheet()->setTitle('statment');
				$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
				header("Content-Type: application/vnd.ms-excel");
				$objWriter->save('uploads/intransit_order_report_export_excel/' . @$fileName);
				$finalpath = base_url() . 'uploads/intransit_order_report_export_excel/' . @$fileName;
				$file = FCPATH . '/uploads/intransit_order_report_export_excel/' . @$fileName;
				// dd($finalpath);

				CUSTOM::download($file, @$fileName, 'application/vnd.ms-excel');
			} catch (Exception $e) {
				echo $e;
			}
			exit();
		}
		load_admin_view('reports', 'intransit_booking_report', $this->data);
	}

	public function delivery_report()
	{
		if (!empty($this->input->post())) {
			try {
				// post value
				$Dpath = FCPATH . 'uploads\delivery_order_report_export_excel\*';
				$files = glob($Dpath . 'xlsx');
				if (isset($files)) {
					foreach ($files as $findfile) {
						unlink($findfile);
					}
				}
				$searchVal = array('Order ID', 'Order Number', 'Airwaybill Number', 'Shipment Type', 'Customer Name', 'Customer Mobile No', 'Customer Address', 'City', 'Pincode', 'State', 'Order Type', 'COD Amount', 'Courier Company', 'Order Status', 'Product Name', 'Product Value', 'Product Quantity', 'Physical Weight', 'Shipping Charge', 'Order Create Date', 'Order Last status Date', 'User', 'User Email');
				$fileName = 'delivery_order_report_' . date("d-m-Y-H-i-s") . '.xlsx';
				// load excel library
				$objPHPExcel = new PHPExcel();
				// set Header
				$styleArray = array(
					'font' => array(
						'bold' => true,
						'color' => array('rgb' => '000000'),
						'size' => 12,
					),
				);
				$objPHPExcel->setActiveSheetIndex(0);
				$ary = $this->Report_model->get_daily_shipment_count('6', $this->input->post('to_date'), $this->input->post('from_date'), $this->user_type, $this->user_id);
				// dd($ary);
				// $i =  0;
				// foreach ($order_data as $single_data) {
				//     $ary[$i]['Order ID'] = $single_data['order_no'];
				//     $ary[$i]['Order Number'] = $single_data['customer_order_no'];
				//     $ary[$i]['Airwaybill Number'] = $single_data['awb_number'];
				//     $ary[$i]['Shipment Type'] = $single_data['shipment_type'];
				//     $ary[$i]['Customer Name'] = $single_data['customer_name'];
				//     $ary[$i]['Customer Mobile No'] = $single_data['customer_mobile_no'];
				//     $ary[$i]['Customer Address'] = $single_data['reciver_address'];
				//     $ary[$i]['Order Type'] = $single_data['remittance_rto_amount'];
				//     $ary[$i]['total_amount'] = $single_data['shipping_charge'];
				//     $ary[$i]['delivered_date'] = date("d-m-Y", strtotime($single_data['delivered_date']));
				//     $i++;
				// }
				$j1 = 'A';
				foreach ($searchVal as $key1) {
					$objPHPExcel->getActiveSheet()->getStyle($j1 . '1')->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->SetCellValue($j1 . '1', $key1);
					$objPHPExcel->getActiveSheet()
						->getStyle($j1 . '1')
						->getFill()
						->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()
						->setARGB('B6C5CE');
					$j1++;
				}
				$rowCount1 = 2;
				if (!empty($ary)) {
					$count = count($ary);
					foreach (@$ary as $element1) {
						$index = 'A';
						foreach ($element1 as $value) {
							$objPHPExcel->getActiveSheet()->SetCellValue($index . $rowCount1, $value . ' ');
							$objPHPExcel->getActiveSheet()->getColumnDimension($index)->setWidth(20);
							$index++;
						}
						$rowCount1++;
					}
				}
				$objPHPExcel->getActiveSheet()->setTitle('statment');
				$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
				header("Content-Type: application/vnd.ms-excel");
				$objWriter->save('uploads/delivery_order_report_export_excel/' . @$fileName);
				$finalpath = base_url() . 'uploads/delivery_order_report_export_excel/' . @$fileName;
				$file = FCPATH . '/uploads/delivery_order_report_export_excel/' . @$fileName;
				CUSTOM::download($file, @$fileName, 'application/vnd.ms-excel');
			} catch (Exception $e) {
				echo $e;
			}
			exit();
		}
		load_admin_view('reports', 'delivery_booking_report', $this->data);
	}

	public function rto_report()
	{
		if (!empty($this->input->post())) {
			try {
				// post value
				$Dpath = FCPATH . 'uploads\rto_order_report_export_excel\*';
				$files = glob($Dpath . 'xlsx');
				if (isset($files)) {
					foreach ($files as $findfile) {
						unlink($findfile);
					}
				}
				$searchVal = array('Order ID', 'Order Number', 'Airwaybill Number', 'Shipment Type', 'Customer Name', 'Customer Mobile No', 'Customer Address', 'City', 'Pincode', 'State', 'Order Type', 'COD Amount', 'Courier Company', 'Order Status', 'Product Name', 'Product Value', 'Product Quantity', 'Physical Weight', 'Shipping Charge', 'Order Create Date', 'Order Last status Date', 'User', 'User Email');
				$fileName = 'rto_order_report_' . date("d-m-Y-H-i-s") . '.xlsx';
				// load excel library
				$objPHPExcel = new PHPExcel();
				// set Header
				$styleArray = array(
					'font' => array(
						'bold' => true,
						'color' => array('rgb' => '000000'),
						'size' => 12,
					),
				);
				$objPHPExcel->setActiveSheetIndex(0);
				$ary = $this->Report_model->get_daily_shipment_count(array('9', '10', '11', '12', '13', '14'), $this->input->post('to_date'), $this->input->post('from_date'), $this->user_type, $this->user_id);

				// dd($ary);
				// $i =  0;
				// foreach ($order_data as $single_data) {
				//     $ary[$i]['Order ID'] = $single_data['order_no'];
				//     $ary[$i]['Order Number'] = $single_data['customer_order_no'];
				//     $ary[$i]['Airwaybill Number'] = $single_data['awb_number'];
				//     $ary[$i]['Shipment Type'] = $single_data['shipment_type'];
				//     $ary[$i]['Customer Name'] = $single_data['customer_name'];
				//     $ary[$i]['Customer Mobile No'] = $single_data['customer_mobile_no'];
				//     $ary[$i]['Customer Address'] = $single_data['reciver_address'];
				//     $ary[$i]['Order Type'] = $single_data['remittance_rto_amount'];
				//     $ary[$i]['total_amount'] = $single_data['shipping_charge'];
				//     $ary[$i]['delivered_date'] = date("d-m-Y", strtotime($single_data['delivered_date']));
				//     $i++;
				// }
				$j1 = 'A';
				foreach ($searchVal as $key1) {
					$objPHPExcel->getActiveSheet()->getStyle($j1 . '1')->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->SetCellValue($j1 . '1', $key1);
					$objPHPExcel->getActiveSheet()
						->getStyle($j1 . '1')
						->getFill()
						->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()
						->setARGB('B6C5CE');
					$j1++;
				}
				$rowCount1 = 2;
				if (!empty($ary)) {
					$count = count($ary);
					foreach (@$ary as $element1) {
						$index = 'A';
						foreach ($element1 as $value) {
							$objPHPExcel->getActiveSheet()->SetCellValue($index . $rowCount1, $value . ' ');
							$objPHPExcel->getActiveSheet()->getColumnDimension($index)->setWidth(20);
							$index++;
						}
						$rowCount1++;
					}
				}
				$objPHPExcel->getActiveSheet()->setTitle('statment');
				$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
				header("Content-Type: application/vnd.ms-excel");
				$objWriter->save('uploads/rto_order_report_export_excel/' . @$fileName);
				$finalpath = base_url() . 'uploads/rto_order_report_export_excel/' . @$fileName;
				$file = FCPATH . '/uploads/rto_order_report_export_excel/' . @$fileName;
				CUSTOM::download($file, @$fileName, 'application/vnd.ms-excel');
			} catch (Exception $e) {
				echo $e;
			}
			exit();
		}
		load_admin_view('reports', 'rto_booking_report', $this->data);
	}

	public function cod_report()
	{
		if (!empty($this->input->post())) {
			try {
				// post value
				$Dpath = FCPATH . 'uploads\cod_order_report_export_excel\*';
				$files = glob($Dpath . 'xlsx');
				if (isset($files)) {
					foreach ($files as $findfile) {
						unlink($findfile);
					}
				}
				$searchVal = array('Order ID', 'Order Number', 'Airwaybill Number', 'Shipment Type', 'Customer Name', 'Customer Mobile No', 'Customer Address', 'City', 'Pincode', 'State', 'Order Type', 'COD Amount', 'Courier Company', 'Order Status', 'Product Name', 'Product Value', 'Product Quantity', 'Physical Weight', 'Shipping Charge', 'Order Create Date', 'Order Last status Date', 'User', 'User Email');
				$fileName = 'cod_order_report_' . date("d-m-Y-H-i-s") . '.xlsx';
				// load excel library
				$objPHPExcel = new PHPExcel();
				// set Header
				$styleArray = array(
					'font' => array(
						'bold' => true,
						'color' => array('rgb' => '000000'),
						'size' => 12,
					),
				);
				$objPHPExcel->setActiveSheetIndex(0);
				$ary = $this->Report_model->get_daily_shipment_count('3', $this->input->post('to_date'), $this->input->post('from_date'), $this->user_type, $this->user_id, '1');
				// dd($ary);
				// $i =  0;
				// foreach ($order_data as $single_data) {
				//     $ary[$i]['Order ID'] = $single_data['order_no'];
				//     $ary[$i]['Order Number'] = $single_data['customer_order_no'];
				//     $ary[$i]['Airwaybill Number'] = $single_data['awb_number'];
				//     $ary[$i]['Shipment Type'] = $single_data['shipment_type'];
				//     $ary[$i]['Customer Name'] = $single_data['customer_name'];
				//     $ary[$i]['Customer Mobile No'] = $single_data['customer_mobile_no'];
				//     $ary[$i]['Customer Address'] = $single_data['reciver_address'];
				//     $ary[$i]['Order Type'] = $single_data['remittance_rto_amount'];
				//     $ary[$i]['total_amount'] = $single_data['shipping_charge'];
				//     $ary[$i]['delivered_date'] = date("d-m-Y", strtotime($single_data['delivered_date']));
				//     $i++;
				// }
				$j1 = 'A';
				foreach ($searchVal as $key1) {
					$objPHPExcel->getActiveSheet()->getStyle($j1 . '1')->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->SetCellValue($j1 . '1', $key1);
					$objPHPExcel->getActiveSheet()
						->getStyle($j1 . '1')
						->getFill()
						->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()
						->setARGB('B6C5CE');
					$j1++;
				}
				$rowCount1 = 2;
				if (!empty($ary)) {
					$count = count($ary);
					foreach (@$ary as $element1) {
						$index = 'A';
						foreach ($element1 as $value) {
							$objPHPExcel->getActiveSheet()->SetCellValue($index . $rowCount1, $value . ' ');
							$objPHPExcel->getActiveSheet()->getColumnDimension($index)->setWidth(20);
							$index++;
						}
						$rowCount1++;
					}
				}
				$objPHPExcel->getActiveSheet()->setTitle('statment');
				$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
				header("Content-Type: application/vnd.ms-excel");
				$objWriter->save('uploads/cod_order_report_export_excel/' . @$fileName);
				$finalpath = base_url() . 'uploads/cod_order_report_export_excel/' . @$fileName;
				$file = FCPATH . '/uploads/cod_order_report_export_excel/' . @$fileName;
				CUSTOM::download($file, @$fileName, 'application/vnd.ms-excel');
			} catch (Exception $e) {
				echo $e;
			}
			exit();
		}
		load_admin_view('reports', 'cod_booking_report', $this->data);
	}

	public function ndr_report()
	{
		if (!empty($this->input->post())) {
			try {
				// post value
				$from_date = date("Y-m-d 00:00:00", strtotime($this->input->post('from_date')));
				if ($this->input->post('to_date') != "") {
					$to_date = date("Y-m-d 23:59:59", strtotime($this->input->post('to_date')));
				} else {
					$to_date = date("Y-m-d 23:59:59", strtotime($this->input->post('from_date')));
				}
				$Dpath = FCPATH . 'uploads\ndr_booking_report\*';
				$files = glob($Dpath . 'xlsx');
				if (isset($files)) {
					foreach ($files as $findfile) {
						unlink($findfile);
					}
				}

				$searchVal = array('Order ID', 'Order Number', 'Airwaybill Number', 'Name', 'Customer Mobile No', 'COD Amount', 'Courier Company', 'NDR Create Date', 'ShipSecure Comment', 'Shipsecure Comment Date', 'Client Comment', 'Client Comment Date', 'Email');

				$fileName = 'export_ndr_report_' . date("d-m-Y-H-i-s") . '.xlsx';
				// load excel library
				$objPHPExcel = new PHPExcel();
				// set Header
				$styleArray = array(
					'font' => array(
						'bold' => true,
						'color' => array('rgb' => '000000'),
						'size' => 12,
					),
				);
				$objPHPExcel->setActiveSheetIndex(0);
				if ($this->type == 1) {
					$cust_id = "";
				} else {
					$cust_id = $this->customer_id;
				}
				$ndr_data = $this->Report_model->get_all_ndr_comment_details($from_date, $to_date, $this->user_type, $this->user_id);
				$j1 = 'A';
				foreach ($searchVal as $key1) {
					$objPHPExcel->getActiveSheet()->getStyle($j1 . '1')->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->SetCellValue($j1 . '1', $key1);
					$objPHPExcel->getActiveSheet()
						->getStyle($j1 . '1')
						->getFill()
						->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()
						->setARGB('B6C5CE');
					$j1++;
				}
				$rowCount1 = 2;
				if (!empty($ndr_data)) {
					$count = count($ndr_data);
					foreach (@$ndr_data as $element1) {
						$index = 'A';
						foreach ($element1 as $value) {
							$objPHPExcel->getActiveSheet()->SetCellValue($index . $rowCount1, $value . ' ');
							$objPHPExcel->getActiveSheet()->getColumnDimension($index)->setWidth(20);
							$index++;
						}
						$rowCount1++;
					}
				}
				$objPHPExcel->getActiveSheet()->setTitle('NDR Comment Report');
				$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
				header("Content-Type: application/vnd.ms-excel");

				// header("Content-Type: application/vnd.ms-excel");
				$objWriter->save('uploads/ndr_booking_report/' . @$fileName);
				$finalpath = base_url() . 'uploads/ndr_booking_report/' . @$fileName;
				$file = FCPATH . '/uploads/ndr_booking_report/' . @$fileName;

				CUSTOM::download($file, @$fileName, 'application/vnd.ms-excel');
			} catch (Exception $e) {
				echo $e;
			}
		}
		load_admin_view('reports', 'ndr_booking_report', $this->data);
	}

	public function all_report()
	{
		if (!empty($this->input->post())) {
			try {
				// post value
				$Dpath = FCPATH . 'uploads\all_order_report_export_excel\*';
				$files = glob($Dpath . 'xlsx');
				if (isset($files)) {
					foreach ($files as $findfile) {
						unlink($findfile);
					}
				}
				$searchVal = array('Order ID',  'Airwaybill Number', 'Shipment Type', 'Zone', 'Customer Name', 'Customer Mobile No', 'Customer Address', 'City', 'Pincode', 'State', 'Order Type', 'COD Amount', 'Courier Company', 'Order Status', 'Product Name', 'Product Value', 'Product Quantity', 'Physical Weight', 'Shipping Charge', 'Order Create Date', 'Order Last status Date', 'User', 'User Email', 'Pickup Username', 'Pickup Contact No', 'Pickup Address', 'Pickup Warehouse', 'Pickup Pincode', 'Pickup City', 'Pickup State');
				// $searchVal = array('awb');
				$fileName = 'all_order_report_' . date("d-m-Y-H-i-s") . '.xlsx';
				// load excel library
				$objPHPExcel = new PHPExcel();
				// set Header
				$styleArray = array(
					'font' => array(
						'bold' => true,
						'color' => array('rgb' => '000000'),
						'size' => 12,
					),
				);
				$objPHPExcel->setActiveSheetIndex(0);
				$order_data = $this->Report_model->get_daily_shipment_count(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18'], $this->input->post('to_date'), $this->input->post('from_date'), $this->user_type, $this->user_id, "", 1);
				$i =  0;

				// unset($order_data['customer_order_no']);
				// dd($order_data);

				foreach ($order_data as $single_data) {
					$ary[$i]['Order ID'] = $single_data['order_no'];
					$ary[$i]['Airwaybill Number'] = $single_data['awb_number'];
					$ary[$i]['Shipment Type'] = $single_data['shipment_type'];
					$ary[$i]['Zone'] = $single_data['zone'];
					$ary[$i]['Customer Name'] = $single_data['customer_name'];
					$ary[$i]['Customer Mobile No'] = $single_data['customer_mobile_no'];
					$ary[$i]['Customer Address'] = $single_data['reciver_address'];
					$ary[$i]['City'] = $single_data['city'];
					$ary[$i]['Pincode'] = $single_data['pincode'];
					$ary[$i]['State'] = $single_data['state'];
					$ary[$i]['Order Type'] = $single_data['order_type'];
					if (strcasecmp($single_data['order_type'], "cod") == 0) {
						$ary[$i]['COD Amount'] = $single_data['cod_amount'];
					} else {
						$ary[$i]['COD Amount'] = "0";
					}

					$ary[$i]['Courier Company'] = $single_data['logistic_name'];
					$ary[$i]['Order Status'] = $single_data['order_status'];
					$ary[$i]['Product Name'] = $single_data['product_name'];
					$ary[$i]['Product Value'] = $single_data['product_value'];
					$ary[$i]['Product Quantity'] = $single_data['product_quantity'];
					$ary[$i]['Physical Weight'] = $single_data['physical_weight'];
					$ary[$i]['Shipping Charge'] = $single_data['total_shipping_amount'];
					$ary[$i]['Order Create Date'] = date("d-m-Y", strtotime($single_data['created_date']));
					$ary[$i]['Order Last status Date'] = date("d-m-Y", strtotime($single_data['last_status_date']));

					$ary[$i]['User'] = $single_data['sender_name'];
					$ary[$i]['User Email'] = $single_data['sender_email'];
					$ary[$i]['Pickup Username'] = $single_data['pickup_username'];
					$ary[$i]['Pickup Contact No'] = $single_data['pickup_contact'];
					$ary[$i]['Pickup Address'] = $single_data['pickup_address'];
					$ary[$i]['Pickup Warehouse'] = $single_data['warehouse'];
					$ary[$i]['Pickup Pincode'] = $single_data['pickup_pincode'];
					$ary[$i]['Pickup City'] = $single_data['pickup_city'];
					$ary[$i]['Pickup State'] = $single_data['pickup_state'];
					$i++;
				}
				$j1 = 'A';
				foreach ($searchVal as $key1) {
					$objPHPExcel->getActiveSheet()->getStyle($j1 . '1')->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->SetCellValue($j1 . '1', $key1);

					$objPHPExcel->getActiveSheet()
						->getStyle($j1 . '1')
						->getFill()
						->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()
						->setARGB('B6C5CE');
					$j1++;
				}
				$rowCount1 = 2;
				if (!empty($ary)) {
					$count = count($ary);

					foreach (@$ary as $element1) {
						$value = "";
						$index = 'A';

						foreach ($element1 as $value) {
							$objPHPExcel->getActiveSheet()->SetCellValue($index . $rowCount1, $value . ' ');
							$objPHPExcel->getActiveSheet()->getColumnDimension($index)->setWidth(20);
							$index++;
						}
						$rowCount1++;
					}
				}
				$objPHPExcel->getActiveSheet()->setTitle('statment');
				$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
				header("Content-Type: application/vnd.ms-excel");
				$objWriter->save('uploads/all_order_report_export_excel/' . @$fileName);
				$finalpath = base_url() . 'uploads/all_order_report_export_excel/' . @$fileName;
				$file = FCPATH . '/uploads/all_order_report_export_excel/' . @$fileName;
				// echo $file;
				CUSTOM::download($file, @$fileName, 'application/vnd.ms-excel');
			} catch (Exception $e) {
				echo $e;
			}
			exit();
		}
		load_admin_view('reports', 'all_booking_report', $this->data);
	}

	public function wallet_report()
	{

		if (!empty($this->input->post())) {
			try {
				// post value
				$Dpath = FCPATH . 'uploads\wallet_report_export_excel\*';
				$files = glob($Dpath . 'xlsx');
				if (isset($files)) {
					foreach ($files as $findfile) {
						unlink($findfile);
					}
				}
				$searchVal = array('Customer Name', 'Email', 'Debit Amount', 'Credit Amount', 'Balance', 'Remarks', 'Airwaybill Number', 'Transaction Date');
				$fileName = 'all_order_report_' . date("d-m-Y-H-i-s") . '.xlsx';
				// load excel library
				$objPHPExcel = new PHPExcel();
				// set Header
				$styleArray = array(
					'font' => array(
						'bold' => true,
						'color' => array('rgb' => '000000'),
						'size' => 12,
					),
				);
				$objPHPExcel->setActiveSheetIndex(0);
				$ary = $this->Report_model->get_daily_shipment_count(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18'], $this->input->post('to_date'), $this->input->post('from_date'), $this->user_type, $this->user_id);
				// dd($ary);
				// $i =  0;
				// foreach ($order_data as $single_data) {
				//     $ary[$i]['Order ID'] = $single_data['order_no'];
				//     $ary[$i]['Order Number'] = $single_data['customer_order_no'];
				//     $ary[$i]['Airwaybill Number'] = $single_data['awb_number'];
				//     $ary[$i]['Shipment Type'] = $single_data['shipment_type'];
				//     $ary[$i]['Customer Name'] = $single_data['customer_name'];
				//     $ary[$i]['Customer Mobile No'] = $single_data['customer_mobile_no'];
				//     $ary[$i]['Customer Address'] = $single_data['reciver_address'];
				//     $ary[$i]['Order Type'] = $single_data['remittance_rto_amount'];
				//     $ary[$i]['total_amount'] = $single_data['shipping_charge'];
				//     $ary[$i]['delivered_date'] = date("d-m-Y", strtotime($single_data['delivered_date']));
				//     $i++;
				// }
				$j1 = 'A';
				foreach ($searchVal as $key1) {
					$objPHPExcel->getActiveSheet()->getStyle($j1 . '1')->applyFromArray($styleArray);
					$objPHPExcel->getActiveSheet()->SetCellValue($j1 . '1', $key1);
					$objPHPExcel->getActiveSheet()
						->getStyle($j1 . '1')
						->getFill()
						->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()
						->setARGB('B6C5CE');
					$j1++;
				}
				$rowCount1 = 2;
				if (!empty($ary)) {
					$count = count($ary);
					foreach (@$ary as $element1) {
						$index = 'A';
						foreach ($element1 as $value) {
							$objPHPExcel->getActiveSheet()->SetCellValue($index . $rowCount1, $value . ' ');
							$objPHPExcel->getActiveSheet()->getColumnDimension($index)->setWidth(20);
							$index++;
						}
						$rowCount1++;
					}
				}
				$objPHPExcel->getActiveSheet()->setTitle('statment');
				$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
				header("Content-Type: application/vnd.ms-excel");
				$objWriter->save('uploads/wallet_report_export_excel/' . @$fileName);
				$finalpath = base_url() . 'uploads/wallet_report_export_excel/' . @$fileName;
				$file = FCPATH . '/uploads/wallet_report_export_excel/' . @$fileName;
				CUSTOM::download($file, @$fileName, 'application/vnd.ms-excel');
			} catch (Exception $e) {
				echo $e;
			}
			exit();
		}
		load_admin_view('reports', 'wallet_booking_report', $this->data);
	}
}
