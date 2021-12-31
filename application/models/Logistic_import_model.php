<?php
defined('BASEPATH') or exit('No direct script access allowed');

ini_set("memory_limit", "-1");
set_time_limit(0);

class Logistic_import_model extends Common_model
{

	/**
	 * [manage_logistic_entries] function to handle import logistic entries
	 * @param  $allDataInSheet
	 * @param  $import_option 
	 * @param  $logistic_id
	 * @return                
	 */
	public function manage_logistic_entries($allDataInSheet)
	{

		$formatArr = $allDataInSheet[1];
		unset($allDataInSheet[1]);

		$rowInsertCount = $rowSkipCount = 0;
		if (!empty($allDataInSheet)) {

			/*Manage pincode_detail entries*/
			foreach ($allDataInSheet as $value) {
				$dataArr = array_combine($formatArr, $value);
				if (empty(array_filter($dataArr))) {
					break;
				}

				/*first fetch pincode_id from pincode_master*/
				$insert_data['logistic_name'] = $dataArr['courier name'];
				$insert_data['api_name']      = url_title($dataArr['courier name'], 'underscore', true) . '_ssl';
				$insert_data['courier_id']      = $dataArr['courier_id'];
				$insert_data['is_active']         = '1';
				$insert_data['cod_price']         = '0.00';
				$insert_data['cod_percentage']    = '0.00';
				$insert_data['updated_date'] = date('Y-m-d H:i:s');
				/*Insert or update pincode_detail table data*/
				$logistic_detail_response = $this->manage_logistic_details($insert_data);
				if ($logistic_detail_response) {
					$rowInsertCount++;
				} else {
					$rowSkipCount++;
					$skiparr[] = $insert_data;
				}
			}
			/*Return complete reponse data*/
			return array('response' => 'message', 'message' => 'Total Inserted:' . $rowInsertCount . ' and skipped:' . $rowSkipCount);
		} else {
			return array('response' => 'error', 'message' => 'No data exist');
		}
	}

	/**
	 * [manage_logistic_details] function to handle logistic details table entries
	 * @param  $insert_data 
	 * @return              
	 */
	public function manage_logistic_details($insert_data)
	{
		$logistic_data = $this->getWhere(array('api_name' => $insert_data['api_name']), 'id', 'logistic_master');
		// dd($logistic_data);
		if (empty($logistic_data)) {
			$insert_data['created_date'] = date('Y-m-d H:i:s');
			return $this->insert($insert_data, 'logistic_master');
		} else {
			return $this->update($insert_data, 'logistic_master', array('id' => $logistic_data['id']));
		}
	}
}
