<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/3/30
 * Time: 下午2:18
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Server\Handlers;

/**
 * Class Handler
 *
 * @package Dobee\Server\Handlers
 */
class Handler
{
    protected $log = 'swoole.log';

    /**
     * @var string
     */
    protected $sock = '/tmp/swoole.sock';

    protected $masterName;

    protected $managerName;

    protected $workerName;

    public function setMasterName($name)
    {
        $this->managerName = $name;

        return $this;
    }

    public function getMasterName()
    {
        return $this->masterName;
    }

    public function setManagerName($name)
    {
        $this->managerName = $name;

        return $this;
    }

    public function getManagerName()
    {
        return $this->managerName;
    }

    public function setWorkerName($name)
    {
        $this->workerName = $name;

        return $this;
    }

    public function getWorkerName()
    {
        return $this->workerName;
    }

    public function renameProcess($name)
    {
        if ('win' == strtolower(substr(PHP_OS, -3))) {
            return $name;
        }

        if (function_exists('cli_set_process_title')) {
            cli_set_process_title($name);
        }
        else if(function_exists('swoole_set_process_name')) {
            swoole_set_process_name($name);
        }
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
     * @return mixed
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * @param mixed $log
     * @return $this
     */
    public function setLog($log)
    {
        $this->log = $log;

        return $this;
    }

    public function writeLog($message)
    {
        file_put_contents($this->log, $message . ' in date: ' . date('Y-m-d H:i:s') . PHP_EOL, FILE_APPEND);
    }

    public function start($server)
    {
        file_put_contents($this->sock, serialize($server));

        $this->writeLog($this->getMasterName() . ' start');

        $this->renameProcess($this->getMasterName());
    }

    public function shutdown($server)
    {
        if (file_exists($this->sock)) {
            unlink($this->sock);
        }

        $this->writeLog('server shutdown');

        $server->shutdown();
    }

    public function workerStart($server, $workerId)
    {
        $this->writeLog('worker : ' . $this->getWorkerName() . $workerId . ' start');

        $this->renameProcess($this->getWorkerName() . $workerId);
    }

    public function workerStop($server, $workerId)
    {
        $this->writeLog('worker ' . $workerId . ' shutdown');
    }

    public function workerError($server, $workerId, $workerPid, $code)
    {
        $this->writeLog('worker ' . $workerId . ' error. Pid : ' . $workerPid . ' Error code: ' . $code);
    }

    public function connect($server) {}
    public function receive($server) {}
    public function close($server) {}
    public function task($server) {}
    public function finish($server) {}

    public function managerStart($server)
    {
        $this->writeLog($this->getManagerName() . ' start');

        $this->renameProcess($this->getManagerName());
    }

    public function managerStop($server)
    {
        $this->writeLog('manager shutdown');
    }

    public function getMasterPid()
    {
        $server = null;

        if (file_exists($this->sock)) {
            $server = file_get_contents($this->sock);
            $server = unserialize($server);
        }

        if (null === $server) {
            return false;
        }

        return $server->master_pid;
    }
}