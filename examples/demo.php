<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/3/29
 * Time: 下午2:30
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */
$http = new swoole_http_server("127.0.0.1", 9501);

set_exception_handler(function (Exception $exception) {
    echo $exception->getMessage();
});

$http->on('WorkerStart', function ($server, $workerId) {

});
$http->on('request', function ($request, $response) {
    try {
        throw new Exception('demo exception');
    } catch (Exception $e) {
        $response->end('error');
    }

    $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
});
$http->start();