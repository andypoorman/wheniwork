<?php
namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Adr\PayloadInterface;
use Psr\Http\Message\ServerRequestInterface;
use Spark\Project\DataMapper\ShiftMapper;
use Spark\Project\DataMapper\UserMapper;

class GetShiftsByDate implements DomainInterface
{
    /**
     * @var PayloadInterface
     */
    private $payload;

    /**
     * @param PayloadInterface $payload
     */
    public function __construct(
        PayloadInterface $payload,
        ServerRequestInterface $request,
        ShiftMapper $shiftMapper,
        UserMapper $userMapper
    ) {
        $this->payload = $payload;
        $this->shiftMapper = $shiftMapper;
        $this->userMapper = $userMapper;
    }

    /**
     * @inheritDoc
     */
    public function __invoke(array $input)
    {

        $start = urldecode($input['startTime']);
        $end = urldecode($input['endTime']);

        $shifts = $this->shiftMapper->getShiftsBetween(
            $start,
            $end
        );

        $output = [];
        if ($shifts) {
            foreach ($shifts as $shift) {
                $employee = $this->userMapper->find($shift->getEmployeeId());
                $manager = $this->userMapper->find($shift->getManagerId());

                if (!$employee) {
                    $employee = '[No employee scheduled]';
                } else {
                    $employee = $employee->getName();
                }

                if (!$manager) {
                    $manager = '[No manager assigned]';
                } else {
                    $manager = $manager->getName();
                }

                $output[] =
                [
                    'employee' => $employee,
                    'manager' => $manager,
                    'start_time' => $shift->getStartTime(),
                    'end_time' => $shift->getEndTime(),
                ];
            }
        }

        return $this->payload
        ->withStatus(PayloadInterface::OK)
        ->withOutput([
            $output
        ]);
    }

}
