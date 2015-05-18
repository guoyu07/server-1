<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/5/17
 * Time: 下午9:19
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Server;

class Formatter
{
    public static function unserialize($serialized)
    {
        return unserialize($serialized);
    }

    public static function serialize($values)
    {
        return serialize($values);
    }
}