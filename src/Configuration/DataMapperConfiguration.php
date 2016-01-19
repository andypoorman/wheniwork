<?php
namespace Spark\Project\Configuration;

use Auryn\Injector;
use Spark\Configuration\ConfigurationInterface;
use Spark\DataMapper\UserMapper;
use Spark\DataMapper\ShiftMapper;

class DataMapperConfiguration implements ConfigurationInterface
{

    /**
     *
     * {@inheritDoc}
     *
     * @see \Spark\Configuration\ConfigurationInterface::apply()
     */
    public function apply(Injector $injector)
    {
        $injector->define(
            'UserMapper',
            [
                ':fpdo' => $injector->make('FluentPDO'),
            ]
        );

        $injector->define(
            'ShiftMapper',
            [
                ':fpdo' => $injector->make('FluentPDO'),
            ]
        );
    }
}
