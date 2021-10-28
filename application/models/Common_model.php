<?php 
class Common_model extends CI_Model{

  /**
   *  Insert Function
   *  @return Last insert ID
   */
  public function insert($data ,$table){
    $this->db->insert($table, $data);
    return $this->db->insert_id();
  }

  

  /**
   *  Update Function
   *  @return true or false
   */
  public function update($data, $table, $where){
  	$this->db->where($where);
  	return $this->db->update($table, $data);
  }

  /**
   *  Delete Function
   *  @return true or false
   */
  public function delete($table, $where){
    $this->db->where($where);
    return $this->db->delete($table);
  }

  public function delete_in($id, $data, $tableName, $id_name) {
		$this->db->where_in($id_name, str_replace("'", "", $id));
		return $this->db->delete($tableName, $data);

	}

  /**
   *  Get Multiple Data
   *  @return result array
   */
  public function getall_data($data, $table, $where=''){
  	$this->db->select($data);
  	$this->db->from($table);
    if($where != ''){
      $this->db->where($where);
    }
  	$info = $this->db->get();
  	return $info->result_array();
  }

  /**
   *  Get Single Data
   *  @return Row array
   */
  public function getSingle_data($data, $table, $where=''){
    $this->db->select($data);
    $this->db->from($table);
    if($where != ''){
      $this->db->where($where);
    }
    $info = $this->db->get();
    return $info->row_array();
  }
  
	/**
	 * getDatabyId
	 * @param $id
	 * @param $tableName
	 * @param $id_name
	 * @return array
	 */
	public function getDatabyId($id, $tableName, $id_name) {
		$sql = "SELECT * FROM $tableName WHERE $id_name = '" . $id . "'";
		$query = $this->db->query($sql);
		if ($query->num_rows($query) > 0) {
			return $query->row();
		}
	}

	/**
	 * getAllData
	 * @param  $tableName
	 * @return array
	 */
	public function getAllData($tableName) {
		$sql = "SELECT * FROM $tableName";
		$query = $this->db->query($sql);
		return $query->result();
	}

	/**
	 * getAllDatabyId
	 * @param $tableName
	 * @param $table_field
	 * @param $get_id
	 * @return array
	 */
	public function getAllDatabyId($tableName, $table_field, $get_id) {
		$sql = "SELECT * FROM $tableName WHERE $table_field = " . $get_id;
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function update_in($id, $data, $tableName, $id_name) {
		$this->db->where_in($id_name, str_replace("'", "", $id));
		return $this->db->update($tableName, $data);

	}
	

	/**
	 * check Duplicate
	 * @param  $tableName
	 * @param  $filedvalue
	 * @param  $id
	 * @param  $filedname
	 * @return boolean
	 */
	public function checkDuplicate($tableName, $filedvalue, $id = '', $filedname, $idname) {
		if (isset($id) && $id > 0) {
			$sql = 'SELECT ' . $idname . ' FROM ' . $tableName . ' WHERE ' . $filedname . '="' . trim($filedvalue) . '" AND ' . $idname . ' != "' . $id . '"';
		} else {
			$sql = 'SELECT ' . $idname . ' FROM ' . $tableName . ' WHERE ' . $filedname . '="' . trim($filedvalue) . '"';
		}

		$query = $this->db->query($sql);
		if ($query->num_rows($query) > 0) {
			return 'false';
		} else {
			return 'true';
		}
	}

	/**
	 * getWhere
	 * @param $where array
	 * @param $fields array
	 * @param $tableName array
	 * @return array
	 */
	public function getWhere($where, $fields, $tableName) {
		$this->db->select($fields);
		$this->db->from($tableName);
		$this->db->where($where);
		$query = $this->db->get();
		$query->num_rows($query);
		if ($query->num_rows($query) == 1) {
			return $query->row_array();
		} elseif ($query->num_rows($query) > 1) {
			return $query->result_array();
		}
	}

	/**
	 * getdata
	 * @return result array
	 */
	public function getResultArray($where, $fields, $tableName) {
		$this->db->select($fields);
		$this->db->from($tableName);
		$this->db->where($where);
		$query = $this->db->get();
		return $query->result_array();
	}

	/**
	 * getResult
	 * @return array with sub object data
	 */
	public function getResult($where, $fields, $tableName){
        $this->db->select($fields);
        $this->db->from($tableName);
        if (!empty($where)) {
            $this->db->where($where);
        }        
        $query = $this->db->get();
        return $query->result();
    }    

	/**
	 * getdata
	 * @return result array
	 */
	public function getRowArray($where, $fields, $tableName) {
		$this->db->select($fields);
		$this->db->from($tableName);
		$this->db->where($where);
		$query = $this->db->get();
		return $query->result_array();
	}
		/**
	 * getdata
	 * @return row
	 */
	public function getSingleRowArray($where, $fields, $tableName) {
		$this->db->select($fields);
		$this->db->from($tableName);
		$this->db->where($where);
		$query = $this->db->get();
		return $query->row_array();
	}
	/**
	 * getRow
	 * @return row object
	 */
	public function getRow($where, $fields, $tableName){
        $this->db->select($fields);
        $this->db->from($tableName);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row();
    }

	


}