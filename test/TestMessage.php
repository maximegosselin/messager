<?php
declare(strict_types = 1);

namespace MaximeGosselin\Messager\Test;

class TestMessage
{
    /**
     * @var array
     */
    private $route = [];

    public function addDestination($destination): void
    {
        $this->route[] = $destination;
    }

    public function clearRoute(): void
    {
        $this->route = [];
    }

    public function getRoute(): array
    {
        return $this->route;
    }
}
