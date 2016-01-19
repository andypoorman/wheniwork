<?php
namespace Tests\Configuration\AuthConfiguration;

use Spark\Project\Configuration\AuthConfiguration;

/**
 * Class AuthConfigurationTest
 */
class AuthConfigurationTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {

    }

    public function testCreate()
    {
        $authConfiguration = new AuthConfiguration();
        $this->assertInstanceOf(
            'Spark\Project\Configuration\AuthConfiguration',
            $authConfiguration
        );
    }
}
