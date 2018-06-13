<?php
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('PRC');
use Workerman\Worker;
use Workerman\WebServer;
use Workerman\Lib\Timer;


require_once __DIR__ . '/vendor/autoload.php';

$con = mysqli_connect('localhost', 'root', 'root');
// if (!$con) {
//     die('Could not connect: ' . mysqli_error($con));
// }
mysqli_select_db($con, "admin");
mysqli_set_charset($con, "utf8");
class udpServer
{
    public function __construct($sender_io)
    {
        global $sender_io;
       

        $udp_worker = new Worker('udp://0.0.0.0:8000');

        $udp_worker->onMessage = function ($udp_connection, $data) {
            global $sender_io;
            global $con;
            // echo $data;
            $sender_io->emit('alexa', $data);
        };
            // 执行监听
        $udp_worker->listen();
    }

}



