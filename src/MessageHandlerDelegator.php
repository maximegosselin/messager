<?php
declare(strict_types=1);

namespace MaximeGosselin\Messager;

final class MessageHandlerDelegator implements MessageHandlerInterface
{
    /**
     * @var MiddlewareInterface
     */
    private $middleware;

    /**
     * @var MessageHandlerInterface|null
     */
    private $next;

    public function __construct(MiddlewareInterface $middleware, ?MessageHandlerInterface $next = null)
    {
        $this->middleware = $middleware;
        $this->next = $next;
    }

    public function handle($message): void
    {
        $this->middleware->handle($message, $this->next);
    }
}
