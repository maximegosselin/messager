<?php
declare(strict_types = 1);

namespace MaximeGosselin\Messager\Test;

use MaximeGosselin\Messager\MessageHandlerInterface;
use MaximeGosselin\Messager\MiddlewareInterface;

class TestMiddleware implements MiddlewareInterface
{
    public function handle($message, MessageHandlerInterface $next): void
    {
        $message->addDestination($this);
        $next->handle($message);
    }
}
