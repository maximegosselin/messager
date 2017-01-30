<?php
declare(strict_types = 1);

use MaximeGosselin\Messager\MessageHandlerInterface;

/**
 * Implementation of a Message Router.
 *
 * @see http://www.enterpriseintegrationpatterns.com/patterns/messaging/MessageRouter.html
 */
class MessageRouter implements MessageHandlerInterface
{
    /**
     * @var array
     */
    private $map;

    /**
     * @var callable
     */
    private $onUnhandledMessageCallable;

    public function handle($message): void
    {
        if (is_object($message)) {
            $this->route($message);
        }
    }

    /**
     * @param object $message
     */
    private function route($message): void
    {
        $name = get_class($message);

        if (isset($this->map[$name])) {
            $handler = $this->map[$name];
            $handler($message);
        } elseif ($this->onUnhandledMessageCallable) {
            $callable = $this->onUnhandledMessageCallable;
            $callable($message);
        }
    }

    /**
     * @param callable $callable
     */
    public function onUnhandledMessage(callable $callable): void
    {
        $this->onUnhandledMessageCallable = $callable;
    }

    /**
     * @param string $name The message name.
     * @param callable $handler
     */
    public function registerHandler(string $name, callable $handler): void
    {
        $this->map[$name] = $handler;
    }
}
