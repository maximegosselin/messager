<?php
declare(strict_types = 1);

namespace MaximeGosselin\Messager\Test;

use MaximeGosselin\Messager\MessageBus;

class MessageBusTest extends TestCase
{
    public function testLastMiddlewareAddedIsFirstExecuted()
    {
        $core = new TestMessageHandler();
        $bus = new MessageBus($core);
        $message = new TestMessage();
        $mw1 = new TestMiddleware();
        $mw2 = new TestMiddleware();
        $mw3 = new TestMiddleware();

        $bus = $bus->withMiddleware($mw1)->withMiddleware($mw2)->withMiddleware($mw3);
        $bus->handle($message);

        $this->assertSame($mw3, $message->getRoute()[0]);
        $this->assertSame($mw2, $message->getRoute()[1]);
        $this->assertSame($mw1, $message->getRoute()[2]);
        $this->assertSame($core, $message->getRoute()[3]);
    }

    public function testMessageBusAsCore()
    {
        $mw1 = new TestMiddleware();
        $mw2 = new TestMiddleware();
        $mw3 = new TestMiddleware();
        $mw4 = new TestMiddleware();

        $core = new TestMessageHandler();
        $bus1 = new MessageBus($core);
        $bus1 = $bus1->withMiddleware($mw1)->withMiddleware($mw2);

        $bus2 = new MessageBus($bus1);
        $bus2 = $bus2->withMiddleware($mw3)->withMiddleware($mw4);

        $message = new TestMessage();
        $bus2->handle($message);

        $this->assertSame($mw4, $message->getRoute()[0]);
        $this->assertSame($mw3, $message->getRoute()[1]);
        $this->assertSame($mw2, $message->getRoute()[2]);
        $this->assertSame($mw1, $message->getRoute()[3]);
        $this->assertSame($core, $message->getRoute()[4]);
    }

    public function testMiddlewareStackIsImmutable()
    {
        $bus1 = new MessageBus();
        $bus2 = $bus1->withMiddleware(new TestMiddleware());
        $this->assertNotSame($bus1, $bus2);
    }
}
