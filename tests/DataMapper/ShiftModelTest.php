<?php

namespace Tests\DataMapper\ShiftModel;

use Spark\Project\DataMapper\ShiftModel;

/**
 * Class ShiftModelTest
 */
class ShiftModelTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {

    }

    public function testCreate()
    {
        $shiftModel = new ShiftModel();
        $this->assertInstanceOf('Spark\Project\DataMapper\ShiftModel', $shiftModel);
    }
}
