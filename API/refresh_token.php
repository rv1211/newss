<?php
require 'config.php';

$connect = new Connect();

$query = "select  * from zship_token_master where id=1";

$data = $connect->Execute($query);

$row = mysqli_fetch_assoc($data);

$token =  $row['token'];

$local_conn =  mysqli_connect("192.168.1.200","pack_crm","Pack@2020","pack_crm_new");


if ($local_conn) {
	$sql = "UPDATE zship_token_master SET token='".$token."' WHERE id=1";
	$query =   mysqli_query($local_conn,$sql);

if($query)
{
	echo "Token copied successfully";
}else
{
	echo "Token cant be copied";
}

}else{
echo "connection failed";
}


?>