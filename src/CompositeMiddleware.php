<?php
declare(strict_types = 1);

namespace MaximeGosselin\Messager;

final class CompositeMiddleware implements MiddlewareInterface, MiddlewareStackInterface
{
    /**
     * @var MiddlewareInterface[]
     */
    private $middlewares = [];

    public function handle($message, MessageHandlerInterface $next): void
    {
        $messageBus = new MessageBus($next);
        foreach ($this->middlewares as $middleware) {
            $messageBus = $messageBus->withMiddleware($middleware);
        }
        $messageBus->handle($message);
    }

    public function withMiddleware(MiddlewareInterface $middleware): MiddlewareStackInterface
    {
        $clone = clone($this);
        $clone->middlewares[] = $middleware;

        return $clone;
    }
}
