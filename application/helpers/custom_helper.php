<?php
class CUSTOM
{

	static function download($file, $name, $mime_type = '')
	{
		if (!is_readable($file)) {
			die('File not found or inaccessible!');
		}
		$size = filesize($file);
		$name = rawurldecode($name);
		$known_mime_types = array(
			"htm" => "text/html",
			"exe" => "application/octet-stream",
			"zip" => "application/zip",
			"doc" => "application/msword",
			"jpg" => "image/jpg",
			"php" => "text/plain",
			"xls" => "application/vnd.ms-excel",
			"ppt" => "application/vnd.ms-powerpoint",
			"gif" => "image/gif",
			"pdf" => "application/pdf",
			"txt" => "text/plain",
			"html" => "text/html",
			"png" => "image/png",
			"jpeg" => "image/jpg",
		);
		if ($mime_type == '') {
			$file_extension = strtolower(substr(strrchr($file, "."), 1));
			if (array_key_exists($file_extension, $known_mime_types)) {
				$mime_type = $known_mime_types[$file_extension];
			} else {
				$mime_type = "application/force-download";
			};
		};
		//turn off output buffering to decrease cpu usage
		@ob_end_clean();
		// required for IE, otherwise Content-Disposition may be ignored
		if (ini_get('zlib.output_compression')) {
			ini_set('zlib.output_compression', 'Off');
		}
		header('Content-Type: ' . $mime_type);
		header('Content-Disposition: attachment; filename="' . $name . '"');
		header("Content-Transfer-Encoding: binary");
		header('Accept-Ranges: bytes');
		// multipart-download and download resuming support
		if (isset($_SERVER['HTTP_RANGE'])) {
			list($a, $range) = explode("=", $_SERVER['HTTP_RANGE'], 2);
			list($range) = explode(",", $range, 2);
			list($range, $range_end) = explode("-", $range);
			$range = intval($range);
			if (!$range_end) {
				$range_end = $size - 1;
			} else {
				$range_end = intval($range_end);
			}
			$new_length = $range_end - $range + 1;
			header("HTTP/1.1 206 Partial Content");
			header("Content-Length: $new_length");
			header("Content-Range: bytes $range-$range_end/$size");
		} else {
			$new_length = $size;
			header("Content-Length: " . $size);
		}
		/* Will output the file itself */
		$chunksize = 1 * (1024 * 1024); //you may want to change this
		$bytes_send = 0;
		if ($file = fopen($file, 'r')) {
			if (isset($_SERVER['HTTP_RANGE'])) {
				fseek($file, $range);
			}
			while (
				!feof($file) &&
				(!connection_aborted()) &&
				($bytes_send < $new_length)
			) {
				$buffer = fread($file, $chunksize);
				echo ($buffer);
				flush();
				$bytes_send += strlen($buffer);
			}
			fclose($file);
		} else {
			die('Error - can not open file.');
		} //If no permissiion
		//die
		die();
	}

	static function put_log_in_file($customer_id, $log_array_name, $log_array_value, $first_log = "", $last_log = "")
	{
		$log_data[$log_array_name] = $log_array_value;
		if ($first_log != "") {
			$CI = &get_instance();
			$CI->load->config('config');
			file_put_contents($CI->config->item('FILE_PATH') . '/Log_Upload/user_wise_log/' . $customer_id . '/' . date("d-m-Y") . '_log.txt', "\n\n---------------------------LOG START TIME:: " . date("H:i:s") . "---------------------------\n", FILE_APPEND);
		}
		file_put_contents($CI->config->item('FILE_PATH') . '/Log_Upload/user_wise_log/' . $customer_id . '/' . date("d-m-Y") . '_log.txt', "\n" . print_r($log_data, true), FILE_APPEND);
		if ($last_log != "") {
			file_put_contents($CI->config->item('FILE_PATH') . '/Log_Upload/user_wise_log/' . $customer_id . '/' . date("d-m-Y") . '_log.txt', "\n---------------------------LOG END TIME:: " . date("H:i:s") . "---------------------------\n\n", FILE_APPEND);
		}
	}

	static function curl_request($content_type, $token, $url, $body, $method, $merchant_code = '', $xbkey = '', $xbtoken = '', $shadowfax = "")
	{
		$headers = array(
			"content-type: " . $content_type,
		);
		if ($merchant_code != '') {
			$headers[] = "HTTP_X_MERCHANT_CODE: " . $merchant_code;
		}
		if ($token != "") {
			if ($shadowfax == "1") {
				$headers[] = "Authorization: Token " . $token;
			} else {
				$headers[] = "Authorization: " . $token;
			}
		}
		if ($xbkey != "") {
			$headers[] = "XBKey: " . $xbkey;
		}
		if ($xbtoken != "") {
			$headers[] = "token: " . $xbtoken;
			$headers[] = "versionnumber: V6";
		}

		//  else if ($version_number != "") {
		// 	$headers[] = "versionnumber: " . $version_number;
		// } else if ($api_url != "") {
		// 	$headers[] = "api-key: " . $api_url;
		// } else if ($client_id != "") {
		// 	$headers[] = "Authorization: " . $client_id;
		// }
		$data['header'] = $headers;
		$data['method'] = $method;
		$data['body'] = $body;
		$data['url'] = $url;

		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';


		// dd($data);
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
		$data['curl_response'] = $response;
		$err = curl_error($curl);
		$data['curl_response_err'] = $err;
		curl_close($curl);
		if ($err) {
			$res['error_response'] = $err;
		} else {
			$res['success_response'] = json_decode($response, true);
		}
		$data['result'] = $res;
		file_put_contents(APPPATH . 'logs/curl_request/' . date("d-m-Y") . '_log.txt', "\n" . print_r($data, true), FILE_APPEND);
		return $res;
	}

	static function startsWith($string, $startString)
	{
		$len = strlen($startString);
		return (substr($string, 0, $len) === $startString);
	}
	static function remove_special_characters_and_extra_space($string)
	{
		return preg_replace('/\s+/', ' ', str_replace(array("\r\n", "\r", "\n", '"', "?", "'", "\\", "/", "%", "#", "!", "{", "}", " ", ":", "&"), ' ', $string));
	}

	static function barcode($filepath = "", $text = "0", $size = "20", $orientation = "horizontal", $code_type = "code128", $print = false, $SizeFactor = 1)
	{
		$code_string = "";
		// Translate the $text into barcode the correct $code_type
		if (in_array(strtolower($code_type), array("code128", "code128b"))) {
			$chksum = 104;
			// Must not change order of array elements as the checksum depends on the array's key to validate final code
			$code_array = array(" " => "212222", "!" => "222122", "\"" => "222221", "#" => "121223", "$" => "121322", "%" => "131222", "&" => "122213", "'" => "122312", "(" => "132212", ")" => "221213", "*" => "221312", "+" => "231212", "," => "112232", "-" => "122132", "." => "122231", "/" => "113222", "0" => "123122", "1" => "123221", "2" => "223211", "3" => "221132", "4" => "221231", "5" => "213212", "6" => "223112", "7" => "312131", "8" => "311222", "9" => "321122", ":" => "321221", ";" => "312212", "<" => "322112", "=" => "322211", ">" => "212123", "?" => "212321", "@" => "232121", "A" => "111323", "B" => "131123", "C" => "131321", "D" => "112313", "E" => "132113", "F" => "132311", "G" => "211313", "H" => "231113", "I" => "231311", "J" => "112133", "K" => "112331", "L" => "132131", "M" => "113123", "N" => "113321", "O" => "133121", "P" => "313121", "Q" => "211331", "R" => "231131", "S" => "213113", "T" => "213311", "U" => "213131", "V" => "311123", "W" => "311321", "X" => "331121", "Y" => "312113", "Z" => "312311", "[" => "332111", "\\" => "314111", "]" => "221411", "^" => "431111", "_" => "111224", "\`" => "111422", "a" => "121124", "b" => "121421", "c" => "141122", "d" => "141221", "e" => "112214", "f" => "112412", "g" => "122114", "h" => "122411", "i" => "142112", "j" => "142211", "k" => "241211", "l" => "221114", "m" => "413111", "n" => "241112", "o" => "134111", "p" => "111242", "q" => "121142", "r" => "121241", "s" => "114212", "t" => "124112", "u" => "124211", "v" => "411212", "w" => "421112", "x" => "421211", "y" => "212141", "z" => "214121", "{" => "412121", "|" => "111143", "}" => "111341", "~" => "131141", "DEL" => "114113", "FNC 3" => "114311", "FNC 2" => "411113", "SHIFT" => "411311", "CODE C" => "113141", "FNC 4" => "114131", "CODE A" => "311141", "FNC 1" => "411131", "Start A" => "211412", "Start B" => "211214", "Start C" => "211232", "Stop" => "2331112");
			$code_keys = array_keys($code_array);
			$code_values = array_flip($code_keys);
			for ($X = 1; $X <= strlen($text); $X++) {
				$activeKey = substr($text, ($X - 1), 1);
				$code_string .= $code_array[$activeKey];
				$chksum = ($chksum + ($code_values[$activeKey] * $X));
			}
			$code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

			$code_string = "211214" . $code_string . "2331112";
		} elseif (strtolower($code_type) == "code128a") {
			$chksum = 103;
			$text = strtoupper($text); // Code 128A doesn't support lower case
			// Must not change order of array elements as the checksum depends on the array's key to validate final code
			$code_array = array(" " => "212222", "!" => "222122", "\"" => "222221", "#" => "121223", "$" => "121322", "%" => "131222", "&" => "122213", "'" => "122312", "(" => "132212", ")" => "221213", "*" => "221312", "+" => "231212", "," => "112232", "-" => "122132", "." => "122231", "/" => "113222", "0" => "123122", "1" => "123221", "2" => "223211", "3" => "221132", "4" => "221231", "5" => "213212", "6" => "223112", "7" => "312131", "8" => "311222", "9" => "321122", ":" => "321221", ";" => "312212", "<" => "322112", "=" => "322211", ">" => "212123", "?" => "212321", "@" => "232121", "A" => "111323", "B" => "131123", "C" => "131321", "D" => "112313", "E" => "132113", "F" => "132311", "G" => "211313", "H" => "231113", "I" => "231311", "J" => "112133", "K" => "112331", "L" => "132131", "M" => "113123", "N" => "113321", "O" => "133121", "P" => "313121", "Q" => "211331", "R" => "231131", "S" => "213113", "T" => "213311", "U" => "213131", "V" => "311123", "W" => "311321", "X" => "331121", "Y" => "312113", "Z" => "312311", "[" => "332111", "\\" => "314111", "]" => "221411", "^" => "431111", "_" => "111224", "NUL" => "111422", "SOH" => "121124", "STX" => "121421", "ETX" => "141122", "EOT" => "141221", "ENQ" => "112214", "ACK" => "112412", "BEL" => "122114", "BS" => "122411", "HT" => "142112", "LF" => "142211", "VT" => "241211", "FF" => "221114", "CR" => "413111", "SO" => "241112", "SI" => "134111", "DLE" => "111242", "DC1" => "121142", "DC2" => "121241", "DC3" => "114212", "DC4" => "124112", "NAK" => "124211", "SYN" => "411212", "ETB" => "421112", "CAN" => "421211", "EM" => "212141", "SUB" => "214121", "ESC" => "412121", "FS" => "111143", "GS" => "111341", "RS" => "131141", "US" => "114113", "FNC 3" => "114311", "FNC 2" => "411113", "SHIFT" => "411311", "CODE C" => "113141", "CODE B" => "114131", "FNC 4" => "311141", "FNC 1" => "411131", "Start A" => "211412", "Start B" => "211214", "Start C" => "211232", "Stop" => "2331112");
			$code_keys = array_keys($code_array);
			$code_values = array_flip($code_keys);
			for ($X = 1; $X <= strlen($text); $X++) {
				$activeKey = substr($text, ($X - 1), 1);
				$code_string .= $code_array[$activeKey];
				$chksum = ($chksum + ($code_values[$activeKey] * $X));
			}
			$code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

			$code_string = "211412" . $code_string . "2331112";
		} elseif (strtolower($code_type) == "code39") {
			$code_array = array("0" => "111221211", "1" => "211211112", "2" => "112211112", "3" => "212211111", "4" => "111221112", "5" => "211221111", "6" => "112221111", "7" => "111211212", "8" => "211211211", "9" => "112211211", "A" => "211112112", "B" => "112112112", "C" => "212112111", "D" => "111122112", "E" => "211122111", "F" => "112122111", "G" => "111112212", "H" => "211112211", "I" => "112112211", "J" => "111122211", "K" => "211111122", "L" => "112111122", "M" => "212111121", "N" => "111121122", "O" => "211121121", "P" => "112121121", "Q" => "111111222", "R" => "211111221", "S" => "112111221", "T" => "111121221", "U" => "221111112", "V" => "122111112", "W" => "222111111", "X" => "121121112", "Y" => "221121111", "Z" => "122121111", "-" => "121111212", "." => "221111211", " " => "122111211", "$" => "121212111", "/" => "121211121", "+" => "121112121", "%" => "111212121", "*" => "121121211");
			// Convert to uppercase
			$upper_text = strtoupper($text);
			for ($X = 1; $X <= strlen($upper_text); $X++) {
				$code_string .= $code_array[substr($upper_text, ($X - 1), 1)] . "1";
			}
			$code_string = "1211212111" . $code_string . "121121211";
		} elseif (strtolower($code_type) == "code25") {
			$code_array1 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
			$code_array2 = array("3-1-1-1-3", "1-3-1-1-3", "3-3-1-1-1", "1-1-3-1-3", "3-1-3-1-1", "1-3-3-1-1", "1-1-1-3-3", "3-1-1-3-1", "1-3-1-3-1", "1-1-3-3-1");
			for ($X = 1; $X <= strlen($text); $X++) {
				for ($Y = 0; $Y < count($code_array1); $Y++) {
					if (substr($text, ($X - 1), 1) == $code_array1[$Y]) {
						$temp[$X] = $code_array2[$Y];
					}
				}
			}
			for ($X = 1; $X <= strlen($text); $X += 2) {
				if (isset($temp[$X]) && isset($temp[($X + 1)])) {
					$temp1 = explode("-", $temp[$X]);
					$temp2 = explode("-", $temp[($X + 1)]);
					for ($Y = 0; $Y < count($temp1); $Y++) {
						$code_string .= $temp1[$Y] . $temp2[$Y];
					}
				}
			}
			$code_string = "1111" . $code_string . "311";
		} elseif (strtolower($code_type) == "codabar") {
			$code_array1 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "-", "$", ":", "/", ".", "+", "A", "B", "C", "D");
			$code_array2 = array("1111221", "1112112", "2211111", "1121121", "2111121", "1211112", "1211211", "1221111", "2112111", "1111122", "1112211", "1122111", "2111212", "2121112", "2121211", "1121212", "1122121", "1212112", "1112122", "1112221");
			// Convert to uppercase
			$upper_text = strtoupper($text);
			for ($X = 1; $X <= strlen($upper_text); $X++) {
				for ($Y = 0; $Y < count($code_array1); $Y++) {
					if (substr($upper_text, ($X - 1), 1) == $code_array1[$Y]) {
						$code_string .= $code_array2[$Y] . "1";
					}
				}
			}
			$code_string = "11221211" . $code_string . "1122121";
		}
		// Pad the edges of the barcode
		$code_length = 20;
		if ($print) {
			$text_height = 30;
		} else {
			$text_height = 0;
		}
		for ($i = 1; $i <= strlen($code_string); $i++) {
			$code_length = $code_length + (int) (substr($code_string, ($i - 1), 1));
		}
		if (strtolower($orientation) == "horizontal") {
			$img_width = $code_length * $SizeFactor;
			$img_height = $size;
		} else {
			$img_width = $size;
			$img_height = $code_length * $SizeFactor;
		}
		$image = imagecreate($img_width, $img_height + $text_height);
		$black = imagecolorallocate($image, 0, 0, 0);
		$white = imagecolorallocate($image, 255, 255, 255);
		imagefill($image, 0, 0, $white);
		if ($print) {
			imagestring($image, 5, 31, $img_height, $text, $black);
		}
		$location = 10;
		for ($position = 1; $position <= strlen($code_string); $position++) {
			$cur_size = $location + (substr($code_string, ($position - 1), 1));
			if (strtolower($orientation) == "horizontal") {
				imagefilledrectangle($image, $location * $SizeFactor, 0, $cur_size * $SizeFactor, $img_height, ($position % 2 == 0 ? $white : $black));
			} else {
				imagefilledrectangle($image, 0, $location * $SizeFactor, $img_width, $cur_size * $SizeFactor, ($position % 2 == 0 ? $white : $black));
			}

			$location = $cur_size;
		}
		// echo $image;
		// Draw barcode to the screen or save in a file
		// dd($filepath);
		if ($filepath == "") {
			// return $image;
			header('Content-type: image/jpeg');
			imagejpeg($image, 100);
			imagedestroy($image);
		} else {
			// return $image;
			// header('Content-Type: image/jpeg');
			imagejpeg($image, $filepath, 100);
			imagedestroy($image);
		}
	}


	//remove word from address
	static function remove_word($sentence)
	{
		$exp = explode(' ', $sentence);
		$removed_words = array_shift($exp);
		if (count($exp) > 1) {
			$w = implode(' ', $exp);
		} else {
			$w = @$exp[0];
		}
		return $w;
	}
}
