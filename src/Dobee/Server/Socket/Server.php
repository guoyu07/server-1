<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/5/16
 * Time: 下午8:59
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Server\Socket;

use Dobee\Server\Protocol;
use Dobee\Server\ServerAbstract;

class Server extends ServerAbstract
{
    public function initServer(Protocol $protocol)
    {
        return new \swoole_server(
            $protocol->getHost(),
            $protocol->getPort(),
            $protocol->getMode(),
            $protocol->getType()
        );
    }
}