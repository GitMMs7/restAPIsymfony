<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ResponseListener
{
    public function onKernelResponse(ResponseEvent $event)
    {
        if (!extension_loaded('newrelic')) {
            return;
        }

        if ($event->getRequest()->getMethod() === 'OPTIONS') {
            $event->setResponse(
                new Response('', 204, [
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Credentials' => 'true',
                    'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
                    'Access-Control-Allow-Headers' => 'DNT, X-User-Token, Keep-Alive, User-Agent, X-Requested-With, If-Modified-Since, Cache-Control, Content-Type',
                    'Access-Control-Max-Age' => 1728000,
                    'Content-Type' => 'text/plain charset=UTF-8',
                    'Content-Length' => 0
                ])
            );
            return ;
        }
    }
}