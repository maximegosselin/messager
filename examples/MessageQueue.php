<?php
declare(strict_types = 1);

use MaximeGosselin\Messager\MessageHandlerInterface;
use MaximeGosselin\Messager\MiddlewareInterface;

/**
 * This middleware adds incoming messages to a queue.
 */
class MessageQueue implements MiddlewareInterface
{
    /**
     * @var array
     */
    private $queue = [];

    /**
     * @var bool
     */
    private $isHandling = false;

    public function handle($message, MessageHandlerInterface $next): void
    {
        $this->queue[] = $message;

        if (!$this->isHandling) {
            $this->isHandling = true;

            while ($message = array_shift($this->queue)) {
                try {
                    $next->handle($message);
                } catch (Throwable $t) {
                    $this->isHandling = false;
                    throw $t;
                }
            }
            $this->isHandling = false;
        }
    }
}
