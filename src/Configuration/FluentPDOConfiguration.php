<?php
namespace Spark\Project\Configuration;

use Auryn\Injector;
use Spark\Configuration\ConfigurationInterface;
use Spark\Env;

class FluentPDOConfiguration implements ConfigurationInterface
{

    /**
     *
     * @param Env $env
     */
    public function __construct(Env $env)
    {
        $this->env = $env;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Spark\Configuration\ConfigurationInterface::apply()
     */
    public function apply(Injector $injector)
    {
        $host = $this->env['DB_HOST'];
        $username = $this->env['DB_USERNAME'];
        $password = $this->env['DB_PASSWORD'];
        $name = $this->env['DB_DBNAME'];
        $port = $this->env['DB_PORT'];
        $dsn = "mysql:dbname={$name};host={$host};port={$port}";
        

        $injector->define(
            'PDO',
            [
                ':dsn' => $dsn,
                ':username' => $username,
                ':passwd' => $password,
            ]
        );
        
        $injector->define(
            'FluentPDO',
            [
                ':pdo' => $injector->make('PDO'),
            ]
            );
    }
}
