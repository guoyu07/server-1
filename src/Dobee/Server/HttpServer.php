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
    protected $server;

    public function getMasterName()
    {
        return 'dobee master';
    }

    public function getManagerName()
    {
        return 'dobee manager';
    }

    public function getWorkerName()
    {
        return 'dobee worker';
    }

    public function __construct($host, $port, $mode = null, $ssl = null)
    {
        $this->server = new \swoole_http_server($host, $port);
    }

    public function configure()
    {
        foreach ($this->handlers as $event => $handle) {
            $this->server->on($event, $handle);
        }
    }

    /**
     * @return void
     */
    public function start()
    {
        $this->server->set($this->config);

        $this->configure();

        $this->server->start();
    }

    /**
     * @return void
     */
    public function reload()
    {
        // TODO: Implement reload() method.
    }

    /**
     * @return void
     */
    public function stop()
    {
        // TODO: Implement stop() method.
    }
}