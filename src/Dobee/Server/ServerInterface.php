<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/3/24
 * Time: 下午2:26
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Server;

use Dobee\Server\Handler\EventHandlerInterface;

/**
 * Interface ServerInterface
 *
 * @package Dobee\Server
 */
interface ServerInterface
{
    /**
     * @return void
     */
    public function configure();

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
    public function status();

    /**
     * @return void
     */
    public function restart();

    /**
     * @return void
     */
    public function stop();

    /**
     * @param EventHandlerInterface $eventHandlerInterface
     * @return $this
     */
    public function setEventHandler(EventHandlerInterface $eventHandlerInterface);

    /**
     * @return EventHandlerInterface[]
     */
    public function getEventHandler();
}