<?php
declare(strict_types = 1);

namespace MaximeGosselin\Messager;

final class MessageBus implements MessageHandlerInterface, MiddlewareStackInterface
{
    /**
     * @var MessageHandlerInterface
     */
    private $core;

    /**
     * @var MiddlewareInterface[]
     */
    private $middlewares = [];

    /**
     * @var MessageHandlerDelegator
     */
    private $chain = null;

    /**
     * @param MessageHandlerInterface|null $core
     */
    public function __construct(?MessageHandlerInterface $core = null)
    {
        $this->core = $core ?? new NoopMessageHandler();
    }

    public function handle($message): void
    {
        if (!$this->chain) {
            $this->chainMiddlewares();
        }
        $this->chain->handle($message);
    }

    public function withMiddleware(MiddlewareInterface $middleware): MiddlewareStackInterface
    {
        $clone = clone($this);
        $clone->middlewares[] = $middleware;
        $clone->chain = null;

        return $clone;
    }

    private function chainMiddlewares(): void
    {
        $this->chain = array_reduce($this->middlewares, function (MessageHandlerInterface $carry, $item): MessageHandlerInterface {
            return new MessageHandlerDelegator($item, $carry);
        }, $this->core);
    }
}
