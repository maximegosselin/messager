<?php
declare(strict_types = 1);

use MaximeGosselin\Messager\MessageHandlerInterface;
use MaximeGosselin\Messager\MiddlewareInterface;

/**
 * This middleware wraps the message handling process in a PDO transaction.
 */
class PdoTransactionMiddleware implements MiddlewareInterface
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function handle($message, MessageHandlerInterface $next): void
    {
        try {
            $this->pdo->beginTransaction();
            $next->handle($message);
            $this->pdo->commit();
        } catch (Throwable $t) {
            $this->pdo->rollBack();
            throw $t;
        }
    }
}
