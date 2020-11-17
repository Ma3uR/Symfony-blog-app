<?php

declare(strict_types=1);

namespace App\Listeners;

use RuntimeException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;


class ExceptionListener {
    public function onKernelException(ExceptionEvent $event) {
        $routeName = $event->getRequest()->attributes->get('_route');
        if (!$routeName || !(strpos($routeName, "api") === 0)) {
            return;
        }

        $exception = $event->getThrowable();
        $event->setResponse(new JsonResponse([
            'code' => $exception->getCode(),
            'message' => $exception->getMessage()
        ]));
    }
}