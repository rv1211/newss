<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Zship_refrash_token extends CI_Controller
{
	public $data = array();
	public $test_db = array();
	public function __construct()
	{
		parent::__construct();
		$this->customer_id = $this->session->userdata('userId');
		$this->load->model('Common_model');
		$this->test_db = $this->load->database('default', true);
	}

	public function refrash_token()
	{

		$tokenData = $this->Common_model->getSingle_data('*', 'zship_token_master', '');
		$username = @$tokenData['username'];
		$password = @$tokenData['password'];
		$URL = @$tokenData['URL'];

		$xpressbees_refrashToken = $this->xpressbees_refrash_token();
		$xpressbees_air_refrashToken = $this->xpressbees_air_refrash_token();
		// echo '<pre>';
		// print_r($xpressbees_air_refrashToken);
		// echo '</pre>';
		dd($xpressbees_refrashToken);

		if ($username != '' && $password != '') {
			//refresh token 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $URL);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			$output = curl_exec($ch);
			$info = curl_getinfo($ch);
			curl_close($ch);
			$output = json_decode($output);
			if ($output->token != '') {
				$data['token'] = $output->token;
				$result = $this->Common_model->update($data, 'zship_token_master', array('id' => '1'));
				$arr2['message'] = "Token updated successfully.";
				$arr2['date'] = date('Y-m-d H:i:s');
				echo "Token updated successfully.";
				file_put_contents(APPPATH . 'logs/zship_awb/' . date("d-m-Y") . '_zship_refrash_token.txt', print_r($arr2, true) . "\n------------------- Get AWB End ---------------\n", FILE_APPEND);
			} else {
				echo "Error";
			}
		}
	}

	public function xpressbees_refrash_token()
	{


		$body = '{
			"username":"' . $this->config->item('XPRESSBEES_USERNAME') . '",
			"password":"' . $this->config->item('XPRESSBEES_PASSWORD') . '", 
			"secretkey":"' . $this->config->item('XPRESSBEES_ORDER_API_TOKEN') . '"
		}';


		$response = CUSTOM::curl_request(
			'application/json',
			'',
			$this->config->item('XPRESSBEES_GENERATE_TOKEN'),
			$body,
			"POST"
		);


		$arr2['response'] = $response;

		if (@$response['success_response'] != '') {
			$resultResponse = (@$response['success_response']);
			if (@$resultResponse['code'] == '200') {
				$data['xbtoken'] = @$resultResponse['token'];
				$result = $this->Common_model->update($data, 'zship_token_master', array('id' => '1'));

				$this->test_db->where('id', '1')->update('zship_token_master', $data);

				$arr2['message'] = "Token updated successfully.";
				$arr2['date'] = date('Y-m-d H:i:s');
				echo "Token updated successfully.";
			} else {
				echo "Your Order Failed to Shipped due to some error. ";
			}
		} else {
			echo "Your Order Failed to Shipped due to some error. " . @$response['error_response'];
		}
		file_put_contents(APPPATH . 'logs/zship_awb/' . date("d-m-Y") . '_xpressbees_refrash_token.txt', print_r($arr2, true) . "\n------------------- Refrash Token End ---------------\n", FILE_APPEND);
	}



	public function xpressbees_air_refrash_token()
	{
		$body = '{
			"username":"' . $this->config->item('XPRESSBEES_AIR_USERNAME') . '",
			"password":"' . $this->config->item('XPRESSBEES_AIR_PASSWORD') . '", 
			"secretkey":"' . $this->config->item('XPRESSBEES_AIR_ORDER_API_TOKEN') . '"
		}';

		$response = CUSTOM::curl_request(
			'application/json',
			'',
			$this->config->item('XPRESSBEES_GENERATE_TOKEN'),
			$body,
			"POST"
		);

		// dd($response);

		// dd($response);
		$arr2['response'] = $response;
		if (@$response['success_response'] != '') {
			$resultResponse = (@$response['success_response']);
			if (@$resultResponse['code'] == '200') {
				$data['xbairtoken'] = @$resultResponse['token'];
				$result = $this->Common_model->update($data, 'zship_token_master', array('id' => '1'));
				$this->test_db->where('id', '1')->update('zship_token_master', $data);
				$arr2['message'] = "Token updated successfully.";
				$arr2['date'] = date('Y-m-d H:i:s');
				echo "Token updated successfully.";
			} else {
				echo "Your Order Failed to Shipped due to some error. ";
			}
		} else {
			echo "Your Order Failed to Shipped due to some error. " . @$response['error_response'];
		}
		file_put_contents(APPPATH . 'logs/zship_awb/' . date("d-m-Y") . '_xpressbees_AIR_refrash_token.txt', print_r($arr2, true) . "\n------------------- Refrash Token End ---------------\n", FILE_APPEND);
	}
}
