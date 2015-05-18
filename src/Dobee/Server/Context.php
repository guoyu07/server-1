<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/5/16
 * Time: 下午10:20
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Server;

class Context
{
    protected $context;

    protected $name;

    protected $parameters;

    public function __construct($content)
    {
        $content = Formatter::unserialize($content);

        $this->name = $content['name'];

        $this->parameters = $content['parameters'];

        unset($content);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getParameters()
    {
        return $this->parameters;
    }
}