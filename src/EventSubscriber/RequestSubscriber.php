<?php

namespace App\EventSubscriber;

use App\Service\CreatorDefaultValue;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestSubscriber implements EventSubscriberInterface
{

    private CreatorDefaultValue $creatorDefaultValue;

    public function __construct(CreatorDefaultValue $creatorDefaultValue)
    {
        $this->creatorDefaultValue = $creatorDefaultValue;
    }


    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest'],
        ];
    }

    public function onKernelRequest(KernelEvent $event): void
    {
        $this->creatorDefaultValue->createDefaultCustomisationIfNotExist();
    }



}

