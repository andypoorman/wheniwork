<?php
namespace Tests\DataMapper\ShiftMapper;

use Spark\Project\DataMapper\ShiftMapper;
use Spark\Project\DataMapper\ShiftModel;


/**
 * Class ShiftMapperTest
 */
class ShiftMapperTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        $this->pdo = $this->getMockBuilder('PDO')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testCreate()
    {
        $shiftMapper = new ShiftMapper(new \FluentPDO($this->pdo));
        $this->assertInstanceOf(
            'Spark\Project\DataMapper\ShiftMapper',
            $shiftMapper
        );
    }

    public function testPopulate()
    {
        $shiftMapper = new ShiftMapper(new \FluentPDO($this->pdo));
        $shift = [
            'id' => 1,
            'manager_id' => 2,
            'employee_id' => 3,
            'break' => 0.75,
            'start_time' => '2016-01-19 09:00:00',
            'end_time' => '2016-01-19 17:00:00',
            'created_at' => '2016-01-19 00:00:00',
            'updated_at' => '2016-01-19 00:00:10',
        ];

        // populate() is protected but we need it public
        $class = new \ReflectionClass('Spark\Project\DataMapper\ShiftMapper');
        $method = $class->getMethod('populate');
        $method->setAccessible(true);

        $model = $method->invokeArgs($shiftMapper, array(new ShiftModel(), $shift));
        $this->assertEquals($model->getId(), $shift['id']);
        $this->assertEquals($model->getManagerId(), $shift['manager_id']);
        $this->assertEquals($model->getEmployeeId(), $shift['employee_id']);
        $this->assertEquals($model->getBreak(), $shift['break']);
        $this->assertEquals($model->getStartTime(), $shift['start_time']);
        $this->assertEquals($model->getEndTime(), $shift['end_time']);
        $this->assertEquals($model->getCreatedAt(), $shift['created_at']);
        $this->assertEquals($model->getUpdatedAt(), $shift['updated_at']);

    }
}
