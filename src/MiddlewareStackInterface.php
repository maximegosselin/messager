<?php
declare(strict_types = 1);

namespace MaximeGosselin\Messager;

interface MiddlewareStackInterface
{
    /**
     * @param MiddlewareInterface $middleware
     * @return MiddlewareStackInterface
     */
    public function withMiddleware(MiddlewareInterface $middleware): MiddlewareStackInterface;
}
