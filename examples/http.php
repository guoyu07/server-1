<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/3/30
 * Time: 下午2:09
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

include __DIR__ . '/../vendor/autoload.php';

$builder = \Dobee\Server\ServerBuilder::createServer('127.0.0.1', 9501);

$http = $builder->getHttpServer(array(), false);

$http->setHandler('request', array(new \Dobee\Server\Handlers\HttpHandler(), 'request'));

$http->start();