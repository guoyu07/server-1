<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/3/27
 * Time: 下午6:57
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Server;

/**
 * Class Server
 *
 * @package Dobee\Server
 */
abstract class Server
{
    /**
     * @var \swoole_server
     */
    protected $server;

    /**
     * @var string
     */
    protected $sock = '/tmp/swoole.sock';

    /**
     * @var string
     */
    protected $log = 'swoole.logs';

    /**
     * @return string
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * @param string $log
     * @return $this
     */
    public function setLog($log)
    {
        $this->log = $log;

        return $this;
    }

    /**
     * @return string
     */
    public function getSock()
    {
        return $this->sock;
    }

    /**
     * @param string $sock
     * @return $this
     */
    public function setSock($sock)
    {
        $this->sock = $sock;

        return $this;
    }

    /**
     * @param $name
     * @param $handler
     * @return $this
     */
    public function setHandlers($name, $handler)
    {
        $this->handlers[$name] = $handler;

        return $this;
    }

    /**
     * @return array
     */
    public function getHandlers()
    {
        return $this->handlers;
    }

    /**
     * @param array $config
     * @return $this
     */
    public function setConfig(array $config)
    {
        $this->server->set($config);

        return $this;
    }

    public function getMaster()
    {
        $server = null;

        if (file_exists($this->sock)) {
            $server = file_get_contents($this->sock);
        }

        if (null !== $server) {
            $server = unserialize($server);
        }

        return $server;
    }

    /**
     * @return mixed
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param mixed $server
     * @return $this
     */
    public function setServer($server)
    {
        $this->server = $server;

        return $this;
    }

    public function writeLog($message)
    {
        if (is_writable(dirname($this->log))) {
            file_put_contents($this->log, $message . "\t in date: " . date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);
        }
    }

    /**
     * @param $name
     * @return bool|void
     */
    public function setProcessName($name)
    {
        if (strtolower(substr(PHP_OS, -3)) === 'win') {
            return false;
        }

        if (function_exists('cli_set_process_title')) {
            cli_set_process_title($name);
        } else if(function_exists('swoole_set_process_name')) {
            swoole_set_process_name($name);
        }
    }

    /**
     * @return string
     */
    public function getMasterName()
    {
        return 'swoole_manager';
    }

    /**
     * @return string
     */
    public function getWorkerName()
    {
        return 'swoole_worker';
    }

    /**
     * @var array
     */
    protected $handlers = array(
        'Start'         => 'onStart',
        'Shutdown'      => 'onShutdown',
        'Connect'       => 'onConnect',
        'Close'         => 'onClose',
        'Receive'       => 'onReceive',
        'ManagerStop'   => 'onManagerStop',
        'ManagerStart'  => 'onManagerStart',
        'WorkerStart'   => 'onWorkerStart',
        'WorkerStop'    => 'onWorkerStop',
        'WorkerError'   => 'onWorkerError',
        'Task'          => 'onTask',
        'Finish'        => 'onFinish',
        'PipeMessage'   => 'onPipeMessage',
        'Timer'         => 'onTimer',
    );

    public function onStart($server)
    {
        file_put_contents($this->sock, serialize($server));

        $this->setProcessName($this->getMasterName());

        $this->writeLog($this->getMasterName() . ' start');
    }

    public function onShutdown($server)
    {
        if (file_exists($this->sock)) {
            unlink($this->sock);
        }

        $this->writeLog($this->getMasterName() . ' shutdown');

        $server->shutdown();
    }

    public function onConnect($server, $fd, $from_id) {}
    public function onClose($server, $fd, $from_id){}
    public function onReceive($server, $fd, $from_id, $data){}
    public function onManagerStart($server){}
    public function onManagerStop($server){}

    public function onWorkerStart($server, $workId)
    {
        $this->writeLog('Worker ' . $workId . ' start');
    }

    public function onWorkerStop($server, $workId){}
    public function onWorkerError($server, $worker_id, $worker_pid, $exit_code){}
    public function onTask($server, $task_id, $from_id, $data){}
    public function onFinish($server, $task_id, $data){}
    public function onPipeMessage($server, $from_worker_id, $message){}
    public function onTimer($server, $interval){}

    /**
     * @return mixed
     */
    public function start()
    {
        $this->server->start();
    }

    /**
     * @return void
     */
    public function stop()
    {
        $manager = $this->getMaster();

        exec('kill -15 ' . $manager->master_pid);
    }

    /**
     * @return void
     */
    public function reload()
    {
        $manager = $this->getMaster();

        exec('kill -USR1 ' . $manager->master_pid);
    }

    public function getMasterPid()
    {
        return $this->getMaster()->master_pid;
    }

    /**
     * @param $host
     * @param $port
     * @param $mode
     * @param $flag
     * @return mixed
     */
    abstract public function createServer($host, $port, $mode, $flag = SWOOLE_SOCK_TCP);
}