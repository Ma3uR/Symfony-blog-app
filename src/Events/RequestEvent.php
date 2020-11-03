<?php

declare(strict_types=1);

namespace App\Events;

use Symfony\Component\HttpFoundation\Request;

class RequestEvent extends Events {
    private Request $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request {
        return $this->request;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request): void {
        $this->request = $request;
    }
}