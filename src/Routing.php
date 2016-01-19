<?php

namespace Spark\Project;

use Spark\Project\Domain;
use Spark\Directory;

class Routing
{
    public function __invoke(Directory $directory)
    {
        return $directory
        ->get('/shifts', Domain\GetEmployeeShifts::class)
        ->get('/shifts/summary/{date}', Domain\GetEmployeeShiftsSummary::class)
        ->get('/shifts/{shiftId}', Domain\GetShiftDetail::class)
        ->post('/shifts', Domain\ModifyShift::class)
        ->put('/shifts', Domain\ModifyShift::class)
        ->get('/shifts/search/date/{startTime}/{endTime}', Domain\GetShiftsByDate::class)
        ->get('/employees/{employeeId}', Domain\GetEmployee::class)
        ; // End of routing
    }
}
