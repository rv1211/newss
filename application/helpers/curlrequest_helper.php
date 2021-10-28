<?php
class CURLREQUEST
{
	public function __construct()
	{
		parent::__construct();
	}

	//curl request with return array format
	static function curlRequest($client_id, $version_number, $api_url, $token, $url, $body, $method)
	{
		file_put_contents(APPPATH . 'logs/log_error/' . date("d-m-Y") . '_curl_request_log.txt', "\n---------------------- START LOG ----------------------" . date("d-m-Y H:i:s") . "-----------------------\n", FILE_APPEND);
		$headers = array(
			"content-type: application/json",
		);
		if ($token != "") {
			$headers[] = "Authorization: Token " . $token;
		} else if ($version_number != "") {
			$headers[] = "versionnumber: " . $version_number;
		} else if ($api_url != "") {
			$headers[] = "api-key: " . $api_url;
		} else if ($client_id != "") {
			$headers[] = "Authorization: " . $client_id;
		}
		if ($body != '') {
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_URL => $url,
				CURLOPT_CUSTOMREQUEST => $method,
				CURLOPT_HTTPHEADER => $headers,
				CURLOPT_POSTFIELDS => $body,
			));
		} else {
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_URL => $url,
				CURLOPT_CUSTOMREQUEST => $method,
				CURLOPT_HTTPHEADER => $headers,
			));
		}
		$response = curl_exec($curl);
		$err = curl_error($curl);
		$log_data['curl_header'] = $headers;
		$log_data['curl_method'] = $method;
		$log_data['curl_url'] = $url;
		$log_data['curl_body'] = $body;
		$log_data['curl_response'] = $response;
		$log_data['curl_err'] = $err;
		file_put_contents(APPPATH . 'logs/log_error/' . date("d-m-Y") . '_curl_request_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		curl_close($curl);
		if ($err) {
			$res['Error'] = $err;
		} else {
			$res['Data'] = json_decode($response, true);
		}
		file_put_contents(APPPATH . 'logs/log_error/' . date("d-m-Y") . '_curl_request_log.txt', "\n---------------------- END LOG ----------------------" . date("d-m-Y H:i:s") . "-----------------------\n", FILE_APPEND);
		return $res;
	}

	//curl request with return excel format
	static function curlXmlResponseRequest($token, $url, $body, $method)
	{
		file_put_contents(APPPATH . 'logs/log_error/' . date("d-m-Y") . '_curl_request_log.txt', "\n---------------------- START LOG ----------------------" . date("d-m-Y H:i:s") . "-----------------------\n", FILE_APPEND);
		$url = $url;
		$headers = array(
			"content-type: application/json",
			"Authorization: Token " . $token,
		);
		if ($body != '') {
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_URL => $url,
				CURLOPT_CUSTOMREQUEST => $method,
				CURLOPT_HTTPHEADER => $headers,
				CURLOPT_POSTFIELDS => $body,
			));
		} else {
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_URL => $url,
				CURLOPT_CUSTOMREQUEST => $method,
				CURLOPT_HTTPHEADER => $headers,
			));
		}
		$response = curl_exec($curl);
		$err = curl_error($curl);
		$log_data['curl_header'] = $headers;
		$log_data['curl_method'] = $method;
		$log_data['curl_url'] = $url;
		$log_data['curl_body'] = $body;
		$log_data['curl_response'] = $response;
		$log_data['curl_err'] = $err;
		file_put_contents(APPPATH . 'logs/log_error/' . date("d-m-Y") . '_curl_request_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		curl_close($curl);
		if ($err) {
			$res['Error'] = $err;
		} else {
			$res['Data'] = $response;
		}
		file_put_contents(APPPATH . 'logs/log_error/' . date("d-m-Y") . '_curl_request_log.txt', "\n---------------------- END LOG ----------------------" . date("d-m-Y H:i:s") . "-----------------------\n", FILE_APPEND);
		return $res;
	}

	//curl request for track order with return excel and array format
	static function curlTrackRequest($logistic, $token, $url, $body, $method)
	{
		file_put_contents(APPPATH . 'logs/log_error/' . date("d-m-Y") . '_curl_request_log.txt', "\n---------------------- START LOG ----------------------" . date("d-m-Y H:i:s") . "-----------------------\n", FILE_APPEND);
		$url = $url;
		if ($token != "") {
			$headers = array(
				"content-type: application/json",
				"Authorization: Token " . $token,
			);
		} else {
			$headers = array(
				"content-type: application/json",
			);
		}
		if ($body != '') {
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_URL => $url,
				CURLOPT_CUSTOMREQUEST => $method,
				CURLOPT_HTTPHEADER => $headers,
				CURLOPT_POSTFIELDS => $body,
			));
		} else {
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_URL => $url,
				CURLOPT_CUSTOMREQUEST => $method,
				CURLOPT_HTTPHEADER => $headers,
			));
		}
		$response = curl_exec($curl);
		$err = curl_error($curl);
		$log_data['curl_header'] = $headers;
		$log_data['curl_method'] = $method;
		$log_data['curl_url'] = $url;
		$log_data['curl_body'] = $body;
		$log_data['curl_response'] = $response;
		$log_data['curl_err'] = $err;
		file_put_contents(APPPATH . 'logs/log_error/' . date("d-m-Y") . '_curl_request_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		curl_close($curl);
		if ($err) {
			$res['Error'] = $err;
		} else {
			if ($logistic == 'DTDC') {
				$res['Data'] = $response;
			} else {
				$res['Data'] = json_decode($response, true);
			}
		}
		file_put_contents(APPPATH . 'logs/log_error/' . date("d-m-Y") . '_curl_request_log.txt', "\n---------------------- END LOG ----------------------" . date("d-m-Y H:i:s") . "-----------------------\n", FILE_APPEND);
		return $res;
	}
}
