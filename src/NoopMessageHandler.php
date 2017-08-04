<?php
declare(strict_types=1);

namespace MaximeGosselin\Messager;

final class NoopMessageHandler implements MessageHandlerInterface
{
    public function handle($message): void
    {
    }
}
