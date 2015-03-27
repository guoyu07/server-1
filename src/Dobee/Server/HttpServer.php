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

use Dobee\Server\Handler\EventHandlerInterface;

/**
 * Class HttpServer
 *
 * @package Dobee\Server
 */
class HttpServer implements ServerInterface
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var \swoole_http_server
     */
    protected $server;

    /**
     * @var EventHandlerInterface
     */
    protected $eventHandlers = array();

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $config
     * @return $this
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        if (empty($config['host']) || empty($config['port'])) {
            throw new \InvalidArgumentException('Arguments missing "host" or "port"');
        }

        $this->config = $config;

        $this->server = new \swoole_http_server($config['host'], $config['port'], $config['mode']);
    }

    /**
     * @return void
     */
    public function start()
    {
        $this->configure();

        $this->server->start();
    }

    /**
     * @return void
     */
    public function configure()
    {
        $this->server->set($this->config);

        foreach ($this->getEventHandler() as $event => $handler) {
            $this->server->on($event, $handler);
        }
    }

    /**
     * @return void
     */
    public function reload()
    {
        $this->server->reload();
    }

    /**
     * @return void
     */
    public function status()
    {
        $this->server->stats();
    }

    /**
     * @return void
     */
    public function restart()
    {
        $this->stop();

        $this->start();
    }

    /**
     * @return void
     */
    public function stop()
    {
        $this->server->shutdown();
    }

    /**
     * @param EventHandlerInterface $eventHandlerInterface
     * @return $this
     */
    public function setEventHandler(EventHandlerInterface $eventHandlerInterface)
    {
        $this->eventHandlers[$eventHandlerInterface->event()] = $eventHandlerInterface->handler();

        return $this;
    }

    /**
     * @return EventHandlerInterface
     */
    public function getEventHandler()
    {
        return $this->eventHandlers;
    }
}