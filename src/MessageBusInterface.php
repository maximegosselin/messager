<?php
declare(strict_types=1);

namespace MaximeGosselin\Messager;

interface MessageBusInterface
{
    public function getCore(): MessageHandlerInterface;
}
