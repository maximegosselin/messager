<?php
declare(strict_types = 1);

namespace MaximeGosselin\Messager;

interface MiddlewareInterface
{
    /**
     * @param mixed $message
     * @param MessageHandlerInterface $next
     */
    public function handle($message, MessageHandlerInterface $next): void;
}
