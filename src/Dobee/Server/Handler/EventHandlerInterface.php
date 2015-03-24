<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/3/24
 * Time: 下午6:35
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Server\Handler;

/**
 * Interface EventHandlerInterface
 *
 * @package Dobee\Server\Handler
 */
interface EventHandlerInterface
{
    /**
     * @return string
     */
    public function event();

    /**
     * @return \Closure
     */
    public function handler();
}