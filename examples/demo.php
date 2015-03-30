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

$http->set(array(
    'task_worker_num' => 4
));

set_exception_handler(function (Exception $exception) {
    echo $exception->getMessage();
});

$http->on('Start', function ($server) {
    echo 'start' . PHP_EOL;
});

$http->on('WorkerStart', function ($server, $workerId) {
    echo 'worker start' . PHP_EOL;
});

$http->on('Connect', function ($server, $fd, $from_id) {
    echo 'connect' . PHP_EOL;
    $server->task('tj');
});

$http->on('Task', function ($server, $task_id, $form_id, $data) {
    switch ($data) {
        case 'tj':
            // TODO 任务业务处理
            break;
    }

    $server->finish('ok');
});

$http->on('Finish', function ($server, $task_id, $data) {
    echo 'finish' . $data . ' from ' . $task_id;
});

$http->on('Close', function ($server, $fd, $from_id) {
    echo 'close' . PHP_EOL;
});

$http->on('request', function ($request, $response) {
    print_r($response);
    try {
        $response->write('hello world');
    } catch (Exception $e) {
        $response->write('error');
    }

    $response->end();
});

$http->start();
