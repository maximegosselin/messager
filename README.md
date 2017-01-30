# Messager

[![Latest Version](https://img.shields.io/github/release/maximegosselin/messager.svg)](https://github.com/maximegosselin/messager/releases)
[![Build Status](https://img.shields.io/travis/maximegosselin/messager.svg)](https://travis-ci.org/maximegosselin/messager)
[![Software License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

*Messager* is a lightweight and unrestrictive internal messaging framework for PHP 7.

It can be used in Event-Driven applications to build more specialized components like *Command Bus* or *Event Dispatcher*.


## System Requirements

PHP 7.1 or later.


## Install

Install using [Composer](https://getcomposer.org/):

```
$ composer require maximegosselin/messager
```

*Messager* is registered under the `MaximeGosselin\Messager` namespace.


## Documentation

### Basics

- A `MessageBus` handles a `$message` and delgates it to its `$core` message handler through middlewares.
- A `$message` can be anything but in most cases, it is an object.
- A `MiddlewareInterface` object

### Quick example

```php
use MaximeGosselin\Messager\MessageBus;

// Create a message bus with a core message handler
$bus = new MessageBus(new MyApp\MyMessageHandler());

// Push a middleware to the stack
$bus = $bus->withMiddleware(new MyApp\MyMiddleware());

// Send a message
$bus->handle(new MyApp\MyMessage());
```

### Other examples

See [/examples](examples/) for real-world implementation examples.


## Tests

Run the following command from the project folder.
```
$ vendor/bin/phpunit
```


## License

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.
