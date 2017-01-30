<?php
declare(strict_types = 1);

namespace MaximeGosselin\Messager\Test;

use MaximeGosselin\Messager\MessageHandlerInterface;

class TestMessageHandler implements MessageHandlerInterface
{
    public function handle($message): void
    {
        $message->addDestination($this);
    }
}
