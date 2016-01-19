<?php
namespace Tests\Configuration\FluentPDOConfiguration;

use Spark\Project\Configuration\FluentPDOConfiguration;

/**
 * Class FluentPDOConfigurationTest
 */
class FluentPDOConfigurationTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {

    }

    public function testCreate()
    {
        $dataMapperConfiguration = new DataMapperConfiguration();
        $this->assertInstanceOf(
            'Spark\Project\Configuration\DataMapperConfiguration',
            $dataMapperConfiguration
        );
    }
}
