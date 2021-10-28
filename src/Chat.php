<?php
//Chat.php
namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
// require dirname(__DIR__) . "/database/ChatUser.php";
// require dirname(__DIR__) . "/database/ChatRooms.php";

// class Chat implements MessageComponentInterface {
//     protected $clients;
//     public $url = "http://192.168.1.202/packanddrop/Ratchat/";

//     public function __construct() {
//         $this->clients = new \SplObjectStorage;
//         echo 'Server Started';
//     }

//     public function onOpen(ConnectionInterface $conn) {
             
//         $this->clients->attach($conn);
//         $ch = curl_init();
//         curl_setopt($ch, CURLOPT_URL,$this->url.'open/'.$conn->resourceId);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//         curl_setopt($ch, CURLOPT_HEADER, false);
//         $output=curl_exec($ch);
//         curl_close($ch);
//         echo $output." :: Total Connections = ".count($this->clients)."\n";
//     }

//     public function onMessage(ConnectionInterface $from, $msg) {        
//         $url = $this->url."message";
//         $data = json_decode($msg, true);
//         $data['from_resource_id'] = $from->resourceId;
//         $data = $this->test_curl($url,$data);
//         foreach ($this->clients as $client) {
//             if($from != $client){
//                 $client->send(json_encode($data));
//             }
//         }             
//     }

//     public function onClose(ConnectionInterface $conn) {
//         // The connection is closed, remove it, as we can no longer send it messages
//         $this->clients->detach($conn);
//         $ch = curl_init();        
//         curl_setopt($ch, CURLOPT_URL,$this->url.'close/'.$conn->resourceId);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//         curl_setopt($ch, CURLOPT_HEADER, false);
//         $output=curl_exec($ch);
//         curl_close($ch);
//         echo $output." :: Total Connections = ".count($this->clients)."\n";        
//     }

//     public function onError(ConnectionInterface $conn, \Exception $e) {
//         echo "An error has occurred: {$e->getMessage()}\n";
//         file_put_contents(date("d-m-Y").'Conn.txt', print_r($conn, true),FILE_APPEND);
//         file_put_contents(date("d-m-Y").'Get_Message.txt', print_r($e->getMessage(), true),FILE_APPEND);
//         $conn->close();
//     }
//     public function test_curl($url,$params)
//     {
//         $url = $url;
//         if(is_array($params) && filter_var($url, FILTER_VALIDATE_URL)) {
//             $postData = '';
//             $count = ($postData != "" && count($postData) != 0 && count($postData) > 0 && !empty($postData))?count($postData):1;
//             foreach($params as $k => $v) {
//                 $postData .= $k . '='.$v.'&';
//             }
//             rtrim($postData, '&');
//             $ch = curl_init();
//             curl_setopt($ch, CURLOPT_URL,$url);
//             curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//             curl_setopt($ch, CURLOPT_HEADER, false);
//             curl_setopt($ch, CURLOPT_POST, $count);
//             curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
//             $output=curl_exec($ch);
//             curl_close($ch);
//             $data = json_decode($output,true);
//         } else {
//             $data['status'] = FALSE;
//             $data['message'] = 'invalid arguments';                
//         }
//         return $data;            
//     }
// }
