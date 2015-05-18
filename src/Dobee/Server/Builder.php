<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/5/16
 * Time: 下午8:14
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Server;

class Builder
{
    /**
     * @param $url
     * @param $mode
     * @return \Dobee\Server\Protocol
     * @throws \ErrorException
     */
    protected static function parseProtocol($url, $mode = SWOOLE_PROCESS)
    {
        if (empty($url)) {
            throw new \ErrorException(sprintf('Can\'t parse this url or url is empty. : %s', $url));
        }

        return new Protocol($url, $mode);
    }

    /**
     * @param $protocol
     * @param $mode
     * @return \Dobee\Server\ServerAbstract
     * @throws \ErrorException
     * @throws \Exception
     */
    public static function createServer($protocol, $mode = SWOOLE_PROCESS)
    {
        $protocol = Builder::parseProtocol($protocol, $mode);

        switch ($protocol->getScheme()) {
            case 'ws':
            case 'wss':
                return new \Dobee\Server\WebSocket\Server($protocol);
                break;
            case 'http':
            case 'https':
                return new \Dobee\Server\Http\Server($protocol);
                break;
            case 'tcp':
            case 'tcp4':
            case 'tcp6':
            case 'unix':
                return new \Dobee\Server\Socket\Server($protocol);
                break;
            default:
                throw new \Exception("Only support ws, wss, http, https, tcp, tcp4, tcp6 or unix scheme");
        }
    }

    /**
     * @param $protocol
     * @return \Dobee\Server\ClientAbstract
     * @throws \ErrorException
     * @throws \Exception
     */
    public static function createClient($protocol)
    {
        $protocol = Builder::parseProtocol($protocol);

        switch ($protocol->getScheme()) {
            case 'ws':
            case 'wss':
                return new \Dobee\Server\WebSocket\Client($protocol);
                break;
            case 'http':
            case 'https':
                return new \Dobee\Server\Http\Client($protocol);
                break;
            case 'tcp':
            case 'tcp4':
            case 'tcp6':
            case 'unix':
                return new \Dobee\Server\Socket\Client($protocol);
                break;
            default:
                throw new \Exception("Only support ws, wss, http, https, tcp, tcp4, tcp6 or unix scheme");
        }
    }
}