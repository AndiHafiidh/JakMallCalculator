#!/usr/bin/env php
<?php

use Illuminate\Console\Application;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

try {
    require_once __DIR__.'/vendor/autoload.php';

    $container = new Container();
    $dispatcher = new Dispatcher();
    $app = new Application($container, $dispatcher, '0.7');
    $app->setName('Calculator');
    $providers = [
        \Jakmall\Recruitment\Calculator\History\CommandHistoryServiceProvider::class,
    ];

    foreach ($providers as $provider) {
        $container->make($provider)->register($container);
    }

    $commands = require_once __DIR__.'/commands.php';
    $commands = collect($commands)
        ->map(
            function ($command) use ($app) {
                return $app->getLaravel()->make($command);
            }
        )
        ->all()
    ;

    $app->addCommands($commands);

    $app->run(new ArgvInput(), new ConsoleOutput());
} catch (Throwable $e) {
    echo sprintf("\e[0;31mError: %s\e[0m\n", $e->getMessage());
}
