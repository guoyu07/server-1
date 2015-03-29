<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/3/27
 * Time: 下午5:59
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Server;

/**
 * Class ServerBuilder
 *
 * @package Dobee\Server
 */
class ServerBuilder
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $port;

    /**
     * @var string
     */
    private $mode;

    /**
     * @var int
     */
    private $flag;

    /**
     * @var array
     */
    private $config = array(
        'backlog'   => 128,
        'user'      => 'www',
        'group'     => 'www',
    );

    /**
     * @var
     */
    protected $server;

    /**
     * @param $host
     * @param $port
     * @param $ssl
     * @return ServerBuilder
     */
    public static function createServer($host, $port, $mode, $ssl = false)
    {
        return new self($host, $port, $mode, $ssl);
    }

    /**
     * @param      $host
     * @param      $port
     * @param      $mode
     * @param bool $ssl
     */
    public function __construct($host, $port, $mode, $ssl = false)
    {
        $this->host = $host;

        $this->port = $port;

        $this->mode = $mode;

        $this->flag = $ssl ? (SWOOLE_SOCK_TCP | SWOOLE_SSL) : SWOOLE_SOCK_TCP;
    }

    public function createDaemonize(Server $server, array $config = array(), $daemonize = true)
    {
        $config = array_merge($this->config, $config, array('daemonize' => $daemonize));

        $server->createServer($this->host, $this->port, $this->mode, $this->flag);

        $server->setConfig($config);

        foreach ($server->getHandlers() as $event => $handle) {
            if (is_string($handle)) {
                $server->getServer()->on($event, array($server, $handle));
                continue;
            }

            $server->getServer()->on($event, $handle);
        }

        return $server;
    }
}