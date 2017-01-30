<?php
declare(strict_types = 1);

use MaximeGosselin\Messager\MessageHandlerInterface;
use MaximeGosselin\Messager\MiddlewareInterface;
use Psr\Log\LoggerInterface;

/**
 * This middleware logs exceptions to a provided LoggerInterface.
 */
class ExceptionLoggingMiddleware implements MiddlewareInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var bool
     */
    private $release;

    public function __construct(LoggerInterface $logger, bool $release = true)
    {
        $this->logger = $logger;
    }

    public function handle($message, MessageHandlerInterface $next): void
    {
        try {
            $next->handle($message);
        } catch (Throwable $t) {
            $message = sprintf('Exception of type %s with message "%s" occured.', gettype($t), $t->getMessage());
            $this->logger->error($message);
            if ($this->release) {
                throw $t;
            }
        }
    }
}
