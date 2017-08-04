<?php
declare(strict_types=1);

namespace MaximeGosselin\Messager;

interface MessageHandlerInterface
{
    /**
     * Handle a message.
     *
     * @param mixed $message
     */
    public function handle($message): void;
}
