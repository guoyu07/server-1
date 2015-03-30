<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/3/30
 * Time: 下午3:13
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

include __DIR__ . '/../vendor/autoload.php';

$builder = \Dobee\Server\ServerBuilder::createServer('127.0.0.1', 9501);

$http = $builder->getHttpServer(new \Dobee\Server\HttpServer(), array(), false);

$http->stop();