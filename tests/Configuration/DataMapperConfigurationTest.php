<?php
namespace Tests\Configuration\DataMapperConfiguration;

use Spark\Project\Configuration\DataMapperConfiguration;

/**
 * Class DataMapperConfigurationTest
 */
class DataMapperConfigurationTest extends \PHPUnit_Framework_TestCase
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
