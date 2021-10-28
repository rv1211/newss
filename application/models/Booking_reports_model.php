
<?php
    class Booking_reports_model extends CI_Model
    {

        public function get_booking_data($fromdate,$todate){
                $fromdate=date("Y-m-d",strtotime($fromdate));
                $todate=date("Y-m-d",strtotime($todate));
                $sql = "SELECT count(fom.id) as logistic_order_count,sm.name as sender_name,lm.logistic_name as logistic_name FROM forward_order_master as fom INNER JOIN logistic_master as lm ON fom.logistic_id = lm.id INNER JOIN sender_master as sm ON fom.sender_id = sm.id WHERE DATE_FORMAT(fom.created_date,'%Y-%m-%d') between '$fromdate' AND '$todate' AND fom.is_cancelled = '0' AND fom.is_reverse= '0'  GROUP BY fom.sender_id,fom.logistic_id ";
                // $sql ""
            
               $query = $this->db->query($sql);
		        return $query->result_array();
        }
            
    }
?>