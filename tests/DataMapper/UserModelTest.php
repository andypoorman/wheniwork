<?php

namespace Tests\DataMapper\UserModel;

use Spark\Project\DataMapper\UserModel;

/**
 * Class UserModelTest
 */
class UserModelTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {

    }

    public function testCreate()
    {
        $userModel = new UserModel();
        $this->assertInstanceOf('Spark\Project\DataMapper\UserModel', $userModel);
    }
}
