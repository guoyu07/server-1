<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/3/22
 * Time: 下午8:24
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Server;

/**
 * Class HttpServer
 *
 * @package Dobee\Server
 */
class HttpServer extends Server
{
    public function createServer($host, $port, $mode, $flag = SWOOLE_SOCK_TCP)
    {
        $this->server = new \swoole_http_server($host, $port, $mode, $flag);
    }

    /**
     * @return string
     */
    public function getMasterName()
    {
        return 'dobee_server';
    }

    /**
     * @return string
     */
    public function getWorkerName()
    {
        return 'dobee_worker';
    }
}