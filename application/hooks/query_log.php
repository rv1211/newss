<?php
class query_log
{

    function logQueries()
    {
        $CI = &get_instance();
        $CI->load->library('session');
        // $CI->router->class;

        $filepath = APPPATH . 'logs/Query-log-' . date('Y-m-d') . '.log';
        $handle = fopen($filepath, "a+");
        $user_ip = $CI->input->ip_address();
        $times = $CI->db->query_times;
        $classname =  $CI->router->class;
        //if($user_ip == '49.36.93.180'){
        foreach ($CI->db->queries as $key => $query) {
            $sql = "-----------------------------------------------------\n".$query . " \n-----------------------------------------------------\nExecution Time:" . $times[$key] . "\n-----------------------------------------------------\nUser Ip : " ."". $user_ip . "\nClass Name :" . $classname."\n-----------------------------------------------------\n";
            fwrite($handle, $sql . "\n\n");
        }
        //}
        fclose($handle);
    }
}
