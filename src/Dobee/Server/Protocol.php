<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/5/16
 * Time: 下午8:31
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Server;

/**
 * Class Protocol
 *
 * @package Dobee\Server
 */
class Protocol
{
    /**
     * @var int
     */
    private $mode = SWOOLE_PROCESS;

    /**
     * @var array
     */
    private $types = [
        'tcp'   => SWOOLE_TCP,
        'tcp4'  => SWOOLE_TCP,
        'tcp6'  => SWOOLE_TCP6,
        'unix'  => SWOOLE_UNIX_STREAM,
    ];

    /**
     * @var int
     */
    private $type;

    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $scheme = 'tcp';

    /**
     * @param $url
     * @param $mode
     */
    public function __construct($url, $mode = SWOOLE_PROCESS)
    {
        $uri = parse_url($url);
        $this->setHost($uri['host']);
        $this->setPort($uri['port']);
        $this->setScheme($uri['scheme']);
        $this->setType(isset($this->types[$uri['scheme']]) ? $this->types[$uri['scheme']] : SWOOLE_TCP);
        $this->setMode($mode);
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * @param string $scheme
     * @return $this
     */
    public function setScheme($scheme)
    {
        $this->scheme = $scheme;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param int $mode
     * @return $this
     */
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param mixed $port
     * @return $this
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return $this
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}