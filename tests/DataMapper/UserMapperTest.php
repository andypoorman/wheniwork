<?php
namespace Tests\DataMapper\UserMapper;

use Spark\Project\DataMapper\UserMapper;
use Spark\Project\DataMapper\UserModel;

/**
 * Class UserMapperTest
 */
class UserMapperTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        $this->pdo = $this->getMockBuilder('PDO')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testCreate()
    {
        $userMapper = new UserMapper(new \FluentPDO($this->pdo));
        $this->assertInstanceOf(
            'Spark\Project\DataMapper\UserMapper',
            $userMapper
        );
    }

    public function testPopulate()
    {
        $userMapper = new UserMapper(new \FluentPDO($this->pdo));
        $user = [
            'id' => 1,
            'name' => 'someone',
            'role' => 'employee',
            'email' => 'someone@example.com',
            'phone' => '1235551234',
            'created_at' => '2016-01-19 00:00:00',
            'updated_at' => '2016-01-19 00:00:01',
            'token' => 'someonestoken'
        ];

        // populate() is protected but we need it public
        $class = new \ReflectionClass('Spark\Project\DataMapper\UserMapper');
        $method = $class->getMethod('populate');
        $method->setAccessible(true);

        $model = $method->invokeArgs($userMapper, array(new UserModel(), $user));
        $this->assertEquals($model->getId(), $user['id']);
        $this->assertEquals($model->getName(), $user['name']);
        $this->assertEquals($model->getRole(), $user['role']);
        $this->assertEquals($model->getEmail(), $user['email']);
        $this->assertEquals($model->getPhone(), $user['phone']);
        $this->assertEquals($model->getCreatedAt(), $user['created_at']);
        $this->assertEquals($model->getUpdatedAt(), $user['updated_at']);
        $this->assertEquals($model->getToken(), $user['token']);

    }
}
