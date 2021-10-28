<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set("memory_limit", "-1");
set_time_limit(0);

class Pincode_import_model extends Common_model{

	/**
	 * [manage_pincode_entries] function to handle import pincode entries
	 * @param  $allDataInSheet
	 * @param  $import_option 
	 * @param  $logistic_id
	 * @return                
	 */
	public function manage_pincode_entries($allDataInSheet,$import_option,$logistic_id){
		
        $formatArr = $allDataInSheet[1];
		unset($allDataInSheet[1]);
	
		$rowInsertCount = $rowSkipCount = 0;
		$insert_data['logistic_id'] = $logistic_id;
		if(!empty($allDataInSheet)){
			/*Delete all data row which has given logistic_id*/
			if($import_option=="3"){
				$this->db->where(array('logistic_id'=>$logistic_id))->delete('pincode_detail');
			}
			
			/*Manage pincode_detail entries*/
			foreach ($allDataInSheet as $value){
				$dataArr = array_combine($formatArr,$value);
				if(empty(array_filter($dataArr))){ break; }
				
				/*first fetch pincode_id from pincode_master*/
				$insert_data['pincode_id'] = $this->manage_pincode_master($dataArr['Pincode'],$dataArr['City'],$dataArr['State']);
				$insert_data['zone_mapping']      = (!empty($dataArr['ZoneMapping']))?$dataArr['ZoneMapping']:NULL;
				$insert_data['area_code']         = (!empty($dataArr['AreaCode']))?$dataArr['AreaCode']:NULL;
				$insert_data['zone_name']         = (!empty($dataArr['HubZoneName']))?$dataArr['HubZoneName']:NULL;
				$insert_data['is_cod']            = (trim($dataArr['COD(Y/N)'])=="Y"||trim($dataArr['COD(Y/N)'])=="y")?"1":"0";
				$insert_data['is_prepaid']        = (trim($dataArr['Prepaid(Y/N)'])=="Y"||trim($dataArr['Prepaid(Y/N)'])=="y")?"1":"0";
				$insert_data['is_pickup']         = (trim($dataArr['Pickup(Y/N)'])=="Y"||trim($dataArr['Pickup(Y/N)'])=="y")?"1":"0";
				$insert_data['is_reverse_pickup'] = (trim($dataArr['ReversePickup(Y/N)'])=="Y"||trim($dataArr['ReversePickup(Y/N)'])=="y")?"1":"0";
				
				/*Logistic wise mandatory fields check*/
				if($logistic_id=="111" && empty($insert_data['zone_mapping'])){ $rowSkipCount++;continue;}
				
				if(($logistic_id=="222" || $logistic_id=="322") && (empty($insert_data['area_code']) || empty($insert_data['zone_name']))){ 
					$rowSkipCount++; continue;
				}
				/*Insert or update pincode_detail table data*/
				$pincode_detail_response = $this->manage_pincode_details($insert_data,$logistic_id,$insert_data['pincode_id']);
				if($pincode_detail_response){
					$rowInsertCount++;
				}else{
					$rowSkipCount++;
					$skiparr[] = $insert_data;
				}
			}
			/*Return complete reponse data*/
			return array('response'=>'message','message'=>'Total Inserted:'.$rowInsertCount.' and skipped:'.$rowSkipCount);
		}else{
			return array('response'=>'error','message'=>'No data exist');
		}
    }
    /**
	 * [manage_pincode_master] function to handle pincode master table entries
	 * @param  $pincode
	 * @param  $city   
	 * @param  $state  
	 * @return         
	 */
	public function manage_pincode_master($pincode,$city,$state){
		/*first check if any entry already exist with given data*/
		$this->db->select('id');
		$this->db->like('pincode',$pincode,'both');
		$pincode_data = $this->db->from('pincode_master')->get()->row();
		
		if(empty($pincode_data->id)){

			/*Insert New Pincode data in pincode_master table and return insert id*/
			return $this->insert(array('pincode'=>trim($pincode),'city'=>trim(strtoupper($city)),'state'=>trim(strtoupper($state))),'pincode_master');
		}
		 return $pincode_data->id;
	}
	/**
	 * [manage_pincode_details] function to handle pincode details table entries
	 * @param  $insert_data 
	 * @param  $logistic_id 
	 * @param  $pincode_id  
	 * @return              
	 */
	public function manage_pincode_details($insert_data,$logistic_id,$pincode_id){
		$pincode_data = $this->getWhere(array('pincode_id'=>$pincode_id,'logistic_id'=>$logistic_id),'id','pincode_detail');
		
		if(empty($pincode_data)){
			
			/*Insert New data*/
			$insert_data['created_by'] =$this->session->userdata('userId');
			$insert = $this->insert($insert_data,'pincode_detail');
		
		}else{
			
			switch($logistic_id)
			{
				case '1':
					$update_data['zone_mapping'] =$insert_data['zone_mapping'];
					break;
				case '2':
					$update_data['area_code'] =$insert_data['area_code'];
					break;
				case '3':
					$update_data['area_code'] =$insert_data['area_code'];
					break;
			}
			
			$update_data['is_cod'] = $insert_data['is_cod'];
			$update_data['is_prepaid'] = $insert_data['is_prepaid'];
			$update_data['is_pickup'] = $insert_data['is_pickup'];
			$update_data['is_reverse_pickup'] = $insert_data['is_reverse_pickup'];
			$update_data['update_date'] =  date('Y-m-d H:i:s');
			$update_data['updated_by'] = $this->session->userdata('userId');
			
			return $this->update($update_data,'pincode_detail',array('id'=>$pincode_data['id']));
			 
		}
	}

	public function insert_ecom_pincode($pincode_data){
		$rowInsertCount = $rowSkipCount =0;
		if($pincode_data){
			$logistic=$this->Common_model->getall_data('id,logistic_name','logistic_master',array('api_name'=>'Ecom_Direct'));
			foreach ($logistic as $key => $logistic_value) {
				//delete all pincode from pincode details table
				$delete_pincode = $this->Common_model->delete('pincode_detail',array('logistic_id'=>$logistic_value['id']));

				foreach ($pincode_data['success_response'] as $key => $pincode_data_value) {
					if($pincode_data_value['active'] == '1'){
						$pincode_master_id =  $this->manage_pincode_master($pincode_data_value['pincode'],$pincode_data_value['city'],$pincode_data_value['state_code']);
						$insert_data['pincode_id'] = $pincode_master_id;
						$check_pincode_data = $this->getWhere(array('pincode_id'=>$pincode_master_id,'logistic_id'=>$logistic_value['id']),'id','pincode_detail');
						if(empty($check_pincode_data)){
							$insert_data['logistic_id']=$logistic_value['id'];
							$insert_data['is_cod']='1';
							$insert_data['is_prepaid']='1';
							$insert_data['is_reverse_pickup']='1';
							$insert_data['is_pickup']='1';
							$insert_data['created_date']=date('Y-m-d H:i:s');
							$insert_data['created_by']=$this->session->userdata('userId');
							$result = $this->insert($insert_data,'pincode_detail');
							$log['insert_query'] = $this->db->last_query();
	
						}else{
							$update_data['is_cod'] = '1';
							$update_data['is_prepaid'] = '1';
							$update_data['is_pickup'] = '1';
							$update_data['is_reverse_pickup'] = '1';
							$update_data['update_date'] =  date('Y-m-d H:i:s');
							$update_data['updated_by'] = $this->session->userdata('userId');
							$result= $this->update($update_data,'pincode_detail',array('id'=>$check_pincode_data['id']));
							$log['update_query'] = $this->db->last_query();
						}
						file_put_contents(APPPATH . 'logs/ecom_pincode/' . date("d-m-Y") . '_ecom_pincode_log.txt', "\n" . print_r($log, true), FILE_APPEND);
					
					}
				}
				return $result;
			}
		}	
	}
	
}
