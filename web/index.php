<?php

// Include Composer autoloader
require __DIR__ . '/../vendor/autoload.php';

Spark\Application::build()->setConfiguration([
    Spark\Configuration\AurynConfiguration::class,
    Spark\Configuration\EnvConfiguration::class,
    Spark\Configuration\DiactorosConfiguration::class,
    Spark\Configuration\PayloadConfiguration::class,
    Spark\Configuration\RelayConfiguration::class,
    Spark\Configuration\WhoopsConfiguration::class,
    Spark\Project\Configuration\FluentPDOConfiguration::class,
    Spark\Project\Configuration\DataMapperConfiguration::class,
    Spark\Project\Configuration\AuthConfiguration::class,
    Spark\Project\Configuration\AclConfiguration::class,
])
    ->setMiddleware([
    Relay\Middleware\ResponseSender::class,
    Spark\Handler\ExceptionHandler::class,
    Spark\Handler\DispatchHandler::class,
    Spark\Handler\JsonContentHandler::class,
    Spark\Handler\FormContentHandler::class,
    Spark\Auth\AuthHandler::class,
    Spark\Project\Middleware\AclMiddleware::class,
    Spark\Handler\ActionHandler::class,
])
    ->setRouting(Spark\Project\Routing::class)
    ->run();
