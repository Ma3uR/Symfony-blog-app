<?php

declare(strict_types=1);

namespace App\Listeners;

use RuntimeException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;


class ExceptionListener {
    public function onKernelException(ExceptionEvent $event) {
        $url = $event->getRequest()->attributes->get('_route');
        if ($url === null || !strpos($url, "api") === 0) {
            throw new RuntimeException('Url  ' . $event->getRequest()->getPathInfo() . '  not found');
        }
        $exception = $event->getThrowable();
        $event->setResponse(new JsonResponse([
            'code' => $exception->getCode(),
            'message' => $exception->getMessage()
        ]));
    }
}