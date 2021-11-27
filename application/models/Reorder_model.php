<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reorder_model extends CI_Model
{
	public function get_error_data($id)
	{
		$this->db->select();
		$this->db->from('error_order_master');
		$this->db->where('id', $id);
		$this->db->where('is_delete', '0');
		$query = $this->db->get();
		return $query->row_array();
	}

	/**
	 * delete from error table insert new entry in temp table for process
	 *
	 * @param   array  $orderdata  order data to insert in temp table	
	 *
	 * @return  int	   returns the inserted id of temp table
	 */
	public function delete_and_insert(array $orderdata)
	{
		$res = "";
		try {
			$id = $orderdata['id'];

			unset($orderdata['id']);
			unset($orderdata['is_delete']);
			unset($orderdata['awb_number']);



			$this->db->insert("temp_forward_order_master", $orderdata);
			$insert_id = $this->db->insert_id();

			if ($insert_id) {
				$this->db->delete("error_order_master", ['id' => $id]);
				$res = ['status' => '1', 'temp_id' => $insert_id];
			} else {
				throw new Exception("Data cannot be inserted", 1);
			}
		} catch (\Throwable $th) {
			$res = ['status' => '0', 'msg' => "$th->getMessage()"];
		}

		return $res;
	}
}

/* End of file Reorder_model.php */
