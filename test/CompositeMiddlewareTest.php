<?php
declare(strict_types = 1);

namespace MaximeGosselin\Messager\Test;

use MaximeGosselin\Messager\CompositeMiddleware;
use MaximeGosselin\Messager\MessageBus;

class CompositeMiddlewareTest extends TestCase
{
    public function testIsImmutable()
    {
        $c1 = new CompositeMiddleware();
        $c2 = $c1->withMiddleware(new TestMiddleware());
        $this->assertNotSame($c1, $c2);
    }

    public function testLastMiddlewareAddedIsFirstExecuted()
    {
        $core = new TestMessageHandler();
        $bus = new MessageBus($core);
        $mw1 = new TestMiddleware();
        $mw2 = new TestMiddleware();
        $mw3 = new TestMiddleware();
        $mw4 = new TestMiddleware();
        $message = new TestMessage();

        $cmw = new CompositeMiddleware();
        $cmw = $cmw->withMiddleware($mw1)->withMiddleware($mw2)->withMiddleware($mw3);

        $bus = $bus->withMiddleware($mw4)->withMiddleware($cmw);
        $bus->handle($message);

        $this->assertSame($mw3, $message->getRoute()[0]);
        $this->assertSame($mw2, $message->getRoute()[1]);
        $this->assertSame($mw4, $message->getRoute()[3]);
        $this->assertSame($mw1, $message->getRoute()[2]);
        $this->assertSame($core, $message->getRoute()[4]);
    }
}
