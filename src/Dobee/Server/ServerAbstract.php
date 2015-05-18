<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/5/16
 * Time: 下午8:20
 * Github: https://www.github.com/janhuang 
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

namespace Dobee\Server;

abstract class ServerAbstract
{
    protected $server;

    private $functions = [];

    protected $config = [
//        'open_length_check'     => true,
//        'package_length_type'   => 'N',
//        'package_length_offset' => 0,
//        'package_body_offset'   => 4,
//        'open_eof_check'        => false,
    ];

    public function __construct(Protocol $protocol)
    {
        $this->server = $this->initServer($protocol);
    }

    public function setConfig(array $config)
    {
        $this->config = array_merge($this->config, $config);
    }

    /**
     * @param Protocol $protocol
     * @return \swoole_server
     */
    abstract public function initServer(Protocol $protocol);

    public function start()
    {
        $this->handle();

        $this->server->start();
    }

    protected function send(\swoole_server $server, $fd, Context $context)
    {
        $result = call_user_func_array($this->functions[$context->getName()], $context->getParameters());

        $server->send($fd, Formatter::serialize($result));

        $server->close($fd);
    }

    public function handle()
    {
        $this->server->set($this->config);

        $self = $this;

        $this->server->on('receive', function ($server, $fd, $from_id, $data) use ($self) {

            $context = new Context($data);

            $self->send($server, $fd, $context);

            unset($context);
        });
    }

    public function addFunction($name, $function)
    {
        $this->functions[$name] = $function;

        return $this;
    }
}