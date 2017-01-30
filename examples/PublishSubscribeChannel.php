<?php
declare(strict_types = 1);

use MaximeGosselin\Messager\MessageHandlerInterface;
use MaximeGosselin\Messager\NoopMessageHandler;

/**
 * Implementation of a Publish-Subscribe Channel with an Invalid Message Channel.
 *
 * @see http://www.enterpriseintegrationpatterns.com/patterns/messaging/PublishSubscribeChannel.html
 * @see http://www.enterpriseintegrationpatterns.com/patterns/messaging/InvalidMessageChannel.html
 */
class PublishSubscribeChannel implements MessageHandlerInterface
{
    /**
     * @var SplObjectStorage[]
     */
    private $subscribers;

    /**
     * @var MessageHandlerInterface
     */
    private $invalidMessageChannel;

    public function __construct(?MessageHandlerInterface $invalidMessageChannel = null)
    {
        $this->invalidMessageChannel = $invalidMessageChannel ?? new NoopMessageHandler();
    }

    public function handle($message): void
    {
        if (is_object($message)) {
            $this->notifySubscribers($message);
        } else {
            $this->invalidMessageChannel->handle($message);
        }
    }

    /**
     * @param object $message
     */
    private function notifySubscribers($message): void
    {
        $subscribers = $this->resolveSubscribers($message);
        foreach ($subscribers as $subscriber) {
            $subscriber($message);
        }
    }

    /**
     * @param object $message
     * @return callable[]
     */
    private function resolveSubscribers($message): array
    {
        $name = get_class($message);
        if (!isset($this->subscribers[$name])) {
            return [];
        }

        $subscribers = [];
        foreach ($this->subscribers[$name] as $subscriber) {
            $subscribers[] = $subscriber;
        }

        return $subscribers;
    }

    /**
     * @param string $name The message name.
     * @param callable $subscriber
     */
    public function subscribe(string $name, callable $subscriber): void
    {
        if (!isset($this->subscribers[$name])) {
            $this->subscribers[$name] = new SplObjectStorage();
        }
        $this->subscribers[$name]->attach((object)$subscriber);
    }
}
