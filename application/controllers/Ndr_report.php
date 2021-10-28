<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ndr_report extends Auth_Controller
{
	public $data = array();

	public function loadview($viewname)
	{
		$this->load->view('admin/template/header');
		$this->load->view('admin/template/sidebar');
		$this->load->view('admin/ndr_report/' . $viewname, $this->data);
		$this->load->view('admin/template/footer');
	}


	public function import_ndr_report()
	{
		$this->loadview('ndr_report_form');
	}
	public function import_ndr_excel_download()
	{
		$file = FCPATH . 'assets/import_ndr_report/import-ndr-sample.xlsx';

		CUSTOM::download($file, 'import-ndr-sample.xlsx', 'text/plain');
	}
	public function import_ndr_report_airwaybill_number()
	{
		$error = $success = "";
		$paths = FCPATH . "assets/import_ndr_report/";
		$config['upload_path'] = 'assets/import_ndr_report/';
		$config['allowed_types'] = 'xlsx|xls|csv';
		$config['max_size'] = 7000;
		$config['overwrite'] = TRUE;

		$this->upload->initialize($config);
		if (!$this->upload->do_upload('ndr_excel')) {
			if (strpos($this->upload->display_errors(), "upload is larger than the permitted size")) {
				$error = 'File size larger than 7MB.';
			} elseif (strpos($this->upload->display_errors(), "The filetype you are attempting to upload is not allowed")) {
				$error = 'Only Excel and CSV File Allow.';
			} else {
				$error = $this->upload->display_errors();
			}
			echo json_encode(array("success" => $success, "error" => $error));
			exit();
		} else {
			$data = array('upload_data' => $this->upload->data());
		}
		if (!empty($data['upload_data']['file_name'])) {
			$import_xls_file = $data['upload_data']['file_name'];
		} else {
			$import_xls_file = 0;
		}

		$inputFileName = $paths . $import_xls_file;

		try {
			$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($inputFileName);
		} catch (Exception $e) {
			die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
				. '": ' . $e->getMessage());
		}
		$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true); //destiny
		$arrayCount = count($allDataInSheet);
		$flag = 0;
		$createArray = array('airwaybill_number', 'provider_comment', 'shipsecure_comment');
		$makeArray = array('airwaybill_number' => 'airwaybill_number', 'provider_comment' => 'provider_comment', 'shipsecure_comment' => 'shipsecure_comment');

		$SheetDataKey = array();
		foreach ($allDataInSheet as $key => $dataInSheet) {
			foreach ($dataInSheet as $key => $value) {
				if (in_array(trim($value), $createArray)) {
					$value = preg_replace('/\s+/', '', $value);
					$SheetDataKey[trim($value)] = $key;
				}
			}
		}
		$table_view = $break_error = "";
		$data = array_diff_key($makeArray, $SheetDataKey);
		if (empty($data)) {
			$flag = 1;
		}
		$flag = 1;
		$j = 1;
		$rowSkipCount = $rowInsertCount = 0;
		if ($arrayCount > 1) {
			if (@$SheetDataKey['airwaybill_number'] == "" || @$SheetDataKey['provider_comment'] == "" || @$SheetDataKey['shipsecure_comment'] == "") {
				$rowSkipCount++;
			} else {
				for ($i = 2; $i <= $arrayCount; $i++) {
					$status = "";
					$airwaybill_number = (string)(@$SheetDataKey['airwaybill_number']);
					$provider_comment = @$SheetDataKey['provider_comment'];
					$admin_comment = @$SheetDataKey['shipsecure_comment'];
					$result = $this->Common_model->getSingle_data('id,order_no', 'forward_order_master', array('awb_number' => ($allDataInSheet[$i][$airwaybill_number])));
					if (!empty($result)) {
						$insert_ndr_data = array(
							"order_id" => $result['id'],
							"provider_comment" => $allDataInSheet[$i]['B'],
							"admin_comment" => $allDataInSheet[$i]['C'],
							"forder_id" => $result['id'],
						);
						$importdata = $this->Common_model->insert($insert_ndr_data, "ndr_comment_detail");
						$rowInsertCount++;
					}
				}
				$this->session->set_flashdata('message', 'Total Inserted:' . $rowInsertCount . ' and skipped:' . $rowSkipCount);
				redirect('import-ndr-report');
			}
		} else {
			$this->session->set_flashdata('error', 'Please Fill Excel Data');
			redirect('import-ndr-report');
		}
		exit;
	}
}
