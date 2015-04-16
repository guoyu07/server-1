<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/3/30
 * Time: 下午2:12
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Server;

use Dobee\Server\Handlers\HandlerInterface;

/**
 * Class Server
 *
 * @package Dobee\Server
 */
abstract class Server implements ServerInterface
{
    /**
     * @var array
     */
    protected $config = array();

    /**
     * @var bool
     */
    protected $daemonize = false;

    /**
     * @var HandlerInterface[]
     */
    protected $handlers = array();

    /**
     * @param array $config
     * @return $this
     */
    public function setConfig(array $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @param bool $daemonize
     * @return $this
     */
    public function setDaemonize($daemonize = false)
    {
        $this->daemonize = $daemonize;

        $this->config = array_merge($this->config, array('daemonize' => $daemonize));

        return $this;
    }

    /**
     * @param $event
     * @param $handler
     * @return $this
     */
    public function setHandler($event, $handler)
    {
        $this->handlers[$event] = $handler;

        return $this;
    }
}