<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/3/24
 * Time: 下午2:38
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

include __DIR__ . '/../vendor/autoload.php';

$builder = \Dobee\Server\ServerBuilder::createServer('127.0.0.1', 1680, SWOOLE_BASE);

$http = new \Dobee\Server\HttpServer();

$http->setHandlers('Request', function ($request, $response) {
    $response->end('hello swoole');
});

$server = $builder->createDaemonize($http, array(
//    'task_worker_num' => 4
), false);

$server->reload();

