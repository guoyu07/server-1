<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/3/24
 * Time: 下午2:38
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 */

include __DIR__ . '/../vendor/autoload.php';


class StartHandler implements \Dobee\Server\Handler\EventHandlerInterface
{
    /**
     * @return string
     */
    public function event()
    {
        return 'start';
    }

    /**
     * @return \Closure
     */
    public function handler()
    {
        return function ($server) {
//            echo 'start';
        };
    }
}

class RequestHandler implements \Dobee\Server\Handler\EventHandlerInterface
{
    /**
     * @return string
     */
    public function event()
    {
        return 'request';
    }

    /**
     * @return \Closure
     */
    public function handler()
    {
        return function (\swoole_http_request $request, \swoole_http_response $response) {
            $httpRequest = \Dobee\Http\Request::createGlobalRequest();
            foreach ($request->server as $name => $value) {
                $httpRequest->server->set(strtoupper($name), $value);
            }

            foreach ($request->header as $name => $value) {
                $httpRequest->headers->set(strtoupper($name), $value);
            }
            // match routes

            $response->write($httpRequest->getPathInfo());

            unset($httpRequest);
            $response->end();
        };
    }
}

class TaskHandler implements \Dobee\Server\Handler\EventHandlerInterface
{
    /**
     * @return string
     */
    public function event()
    {
        return 'task';
    }

    /**
     * @return \Closure
     */
    public function handler()
    {
        return function () {};
    }
}

$http = new \Dobee\Server\HttpServer([
    'host' => '127.0.0.1',
    'port' => '1680',
    'mode' => SWOOLE_BASE,
]);

$http->setEventHandler(new StartHandler());
$http->setEventHandler(new RequestHandler());
$http->setEventHandler(new TaskHandler());

$http->start();



