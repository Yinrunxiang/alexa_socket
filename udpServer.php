<?php
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('PRC');
use Workerman\Worker;
use Workerman\WebServer;
use Workerman\Lib\Timer;


require_once __DIR__ . '/vendor/autoload.php';
// $con = mysqli_connect('localhost', 'root', 'root');
// // if (!$con) {
// //     die('Could not connect: ' . mysqli_error($con));
// // }
// mysqli_select_db($con, "admin");
// mysqli_set_charset($con, "utf8");
class udpServer
{
    public function __construct($sender_io)
    {
        global $sender_io;


        $udp_worker = new Worker('udp://0.0.0.0:8000');

        $udp_worker->onMessage = function ($udp_connection, $data) {
            global $sender_io;
            // global $con;

            $data = json_decode($data);
            $post_data = array(
                'access_token' => $data->token
            );
            $post_data = json_encode($post_data);
            echo 'post_data:'.$post_data;
            // $user_id = $this->http_request('../oauth2_server/resource.php?access_token='.$data->token);



            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://yinrunxiang.cn/alexa/oauth2_server/resource.php?access_token=5798415f389fe03288149f4e67619de61c62967c",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => "",
              CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
                "postman-token: 1ca12502-b01d-3585-62ad-4fbaa983deda"
              ),
            ));
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            
            curl_close($curl);
            
            if ($err) {
              echo "cURL Error #:" . $err;
            } else {
              echo $response;
            }

            // echo 'user_id:'.$user_id;
            // $alexa = ["intent" => $data->intent, "user_id" => $user_id];
            // var_dump($alexa);
            // $sender_io->emit('alexa', $alexa);
        };
            // 执行监听
        $udp_worker->listen();
    }

    // public function http_request($url, $data = null)
    // {
    //     $curl = curl_init();
    //     curl_setopt($curl, CURLOPT_URL, $url);
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    //     if (!empty($data)) {
    //         curl_setopt($curl, CURLOPT_POST, 1);
    //         curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    //     }
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //     $output = curl_exec($curl);
    //     curl_close($curl);
    //     return $output;
    // }

    // public function send_post($url, $data)
    // {

    //     $postdata = http_build_query($data);
    //     $options = array(
    //         'http' => array(
    //             'method' => 'POST',
    //             'header' => 'Content-type:application/x-www-form-urlencoded',
    //             'content' => $postdata,
    //             'timeout' => 15 * 60 // 超时时间（单位:s）  
    //         )
    //     );
    //     $context = stream_context_create($options);
    //     $result = file_get_contents($url, false, $context);

    //     return $result;
    // }

}



