<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/4/16
 * Time: 下午4:33
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Server;

/**
 * Interface ServerInterface
 *
 * @package Dobee\Server
 */
interface ServerInterface
{
    /**
     * @param array $config
     * @return $this
     */
    public function setConfig(array $config);

    /**
     * @param bool $daemonize
     * @return $this
     */
    public function setDaemonize($daemonize = false);

    /**
     * @return void
     */
    public function start();

    /**
     * @return void
     */
    public function reload();

    /**
     * @return void
     */
    public function stop();

    /**
     * @param string
     * @param \Closure|HandlerInterface
     * @return $this
     */
    public function setHandler($event, $handler);

    /**
     * @return string
     */
    public function getMasterName();

    /**
     * @return string
     */
    public function getManagerName();

    /**
     * @return string
     */
    public function getWorkerName();
}