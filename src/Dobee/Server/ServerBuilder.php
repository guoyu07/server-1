<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/3/30
 * Time: 下午2:07
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Server;

use Dobee\Server\Handlers\Handler;

/**
 * Class ServerBuilder
 *
 * @package Dobee\Server
 */
class ServerBuilder
{
    /**
     * @var
     */
    private $host;

    /**
     * @var
     */
    private $port;

    /**
     * @var
     */
    private $mode;

    /**
     * @param      $host
     * @param      $port
     * @param null $mode
     * @return ServerBuilder
     */
    public static function createServer($host, $port, $mode = null)
    {
        return new self($host, $port, $mode);
    }

    /**
     * @param $host
     * @param $port
     * @param $mode
     */
    public function __construct($host, $port, $mode)
    {
        date_default_timezone_set('Asia/Shanghai');

        $this->host = $host;

        $this->port = $port;

        $this->mode = $mode;
    }

    /**
     * @param array $config
     * @param bool  $daemon
     * @return HttpServer
     */
    public function getHttpServer(array $config = array(), $daemon = true)
    {
        $server = new HttpServer($this->host, $this->port);

        $config = array_merge($config, array('daemonize' => $daemon));

        $server->setConfig($config);

        return $server;
    }
}