<?php
namespace Tests\Configuration\AclConfiguration;

use Spark\Project\Configuration\AclConfiguration;

/**
 * Class AclConfigurationTest
 */
class AclConfigurationTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {

    }

    public function testCreate()
    {
        $aclConfiguration = new AclConfiguration();
        $this->assertInstanceOf(
            'Spark\Project\Configuration\AclConfiguration',
            $aclConfiguration
        );
    }
}
