<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/5/16
 * Time: 下午8:14
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

include __DIR__ . '/../vendor/autoload.php';

$server = \Dobee\Server\Builder::createServer('tcp://127.0.0.1:9501');

$server->addFunction('hello', function ($name) {
    return 'hello' . $name;
});

$server->start();
