<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/5/16
 * Time: 下午10:21
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Server;

class ClientAbstract
{
    /**
     * @var array
     */
    private $remotes = [];

    private $protocol;

    public function __construct(Protocol $protocol)
    {
        $this->protocol = $protocol;
    }

    /**
     * @return array
     */
    public function getRemotes()
    {
        return $this->remotes;
    }

    /**
     * @param string $name
     * @param array  $parameters
     * @return array
     */
    public function invoke($name, array $parameters = [])
    {
        $client = new \swoole_client(SWOOLE_TCP | SWOOLE_KEEP);

        $client->connect($this->protocol->getHost(), $this->protocol->getPort(), 1);

        $client->send(Formatter::serialize(['name' => $name, 'parameters' => $parameters]));

        $result = $client->recv();

        $client->close();

        unset($client);

        return Formatter::unserialize($result);
    }
}