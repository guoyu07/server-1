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

use Dobee\Server\Handlers\Handler;

/**
 * Class Server
 *
 * @package Dobee\Server
 */
abstract class Server
{
    /**
     * @var
     */
    protected $server;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var array
     */
    protected $handlers = array();

    /**
     * @return Server
     */
    public function getServer()
    {
        return $this->server;
    }

    abstract public function getMasterName();

    abstract public function getManagerName();

    abstract public function getWorkerName();

    /**
     * @return void
     */
    public function configure()
    {
        $defaultHandler = new Handler();

        $handlers = array_merge(array(
            'Start'         => array($defaultHandler, 'start'),
            'Shutdown'      => array($defaultHandler, 'shutdown'),
            'WorkerStart'   => array($defaultHandler, 'workerStart'),
            'WorkerStop'    => array($defaultHandler, 'workerStop'),
            'WorkerError'   => array($defaultHandler, 'workerError'),
            'Connect'       => array($defaultHandler, 'connect'),
            'ManagerStart'  => array($defaultHandler, 'managerStart'),
            'ManagerStop'   => array($defaultHandler, 'managerStop'),
            'Receive'       => array($defaultHandler, 'receive'),
            'Close'         => array($defaultHandler, 'close'),
            'Task'          => array($defaultHandler, 'task'),
            'Finish'        => array($defaultHandler, 'finish'),
        ), $this->handlers);

        $defaultHandler->setMasterName($this->getMasterName());
        $defaultHandler->setManagerName($this->getManagerName());
        $defaultHandler->setWorkerName($this->getWorkerName());

        foreach ($handlers as $event => $handler) {
            if ('task' == strtolower($event) && !isset($this->config['task_worker_num'])) {
                continue;
            }

            $this->server->on($event, $handler);
        }
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
    public function stop()
    {
        $defaultHandler = new Handler();

        exec('kill -15 ' . $defaultHandler->getMasterPid());
    }

    /**
     * @return void
     */
    public function reload()
    {
        $defaultHandler = new Handler();

        exec('kill -USR1 ' . $defaultHandler->getMasterPid());
    }

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