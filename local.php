<?php
use PHPSocketIO\SocketIO;
use Workerman\Worker;
use Workerman\WebServer;
use Workerman\Lib\Timer;
require_once './udpServer.php';

$sender_io = new SocketIO(2121);
// 客户端发起连接事件时，设置连接socket的各种事件回调
$sender_io->on('connection', function ($socket) {
    $socket->emit('update_online_count', "连接成功");
});
$sender_io->on('workerStart', function () {
    global $sender_io;
    $loacl = new udpServer($sender_io);
    // $remote = new udpServer($sender_io,$remotePort);
});

if (!defined('GLOBAL_START')) {
    Worker::runAll();
}


