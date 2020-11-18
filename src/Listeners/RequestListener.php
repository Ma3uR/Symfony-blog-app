<?php

declare(strict_types=1);

namespace App\Listeners;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class RequestListener {
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $homeChannelLogger) {
        $this->logger = $homeChannelLogger;
    }

    public function onRequest(RequestEvent $event): void {
        $request = $event->getRequest();
        $userAgent = $request->headers->get('User-Agent');
        if ($request->get('_route') === 'home') {

            $this->logger->info(sprintf('User agent:' . $userAgent));
        }
    }
}