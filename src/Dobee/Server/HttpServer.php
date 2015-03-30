<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/3/30
 * Time: 下午2:10
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Server;

class HttpServer extends Server
{
    public function __construct($host, $port)
    {
        $this->server = new \swoole_http_server($host, $port);
    }

    public function getMasterName()
    {
        return 'swoole_http_server';
    }

    public function getManagerName()
    {
        return 'swoole_http_manager';
    }

    public function getWorkerName()
    {
        return 'swoole_http_worker';
    }
}