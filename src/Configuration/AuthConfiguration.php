<?php
namespace Spark\Project\Configuration;

use Auryn\Injector;
use Spark\Configuration\ConfigurationInterface;
use Spark\Auth\Credentials\BodyExtractor;
use Spark\Auth\Token\HeaderExtractor;
use Spark\Auth\Token\ExtractorInterface;
use Spark\Auth\AdapterInterface;
use Spark\Project\Auth\AuthAdapter;

class AuthConfiguration implements ConfigurationInterface
{

    /**
     *
     * {@inheritDoc}
     *
     * @see \Spark\Configuration\ConfigurationInterface::apply()
     */
    public function apply(Injector $injector)
    {
        $injector->alias(
            ExtractorInterface::class,
            HeaderExtractor::class
        );

        $injector->define(
            HeaderExtractor::class,
            [':header' => 'token']
        );

        $injector->alias(
            \Spark\Auth\Credentials\ExtractorInterface::class,
            BodyExtractor::class
        );

        $injector->alias(
            AdapterInterface::class,
            AuthAdapter::class
        );
    }
}
