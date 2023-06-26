<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ResponseSubscriber implements EventSubscriberInterface
{
    public function onKernelEventsRESPONSE($event)
    {
        // ...
    }

    public static function getSubscribedEvents()
    {
        return [
            'KernelEvents::RESPONSE' => 'onKernelEventsRESPONSE',
        ];
    }
}
