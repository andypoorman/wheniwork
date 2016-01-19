<?php
namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Adr\PayloadInterface;
use Psr\Http\Message\ServerRequestInterface;
use Spark\Project\DataMapper\ShiftMapper;
use Spark\Project\DataMapper\UserMapper;

class GetShiftDetail implements DomainInterface
{
    /**
     * @var PayloadInterface
     */
    private $payload;

    private $userMapper;

    private $shiftMapper;

    /**
     * @param PayloadInterface $payload
     */
    public function __construct(
        PayloadInterface $payload,
        ServerRequestInterface $request,
        UserMapper $userMapper,
        ShiftMapper $shiftMapper
    ) {
        $this->payload = $payload;
        $this->userMapper = $userMapper;
        $this->shiftMapper = $shiftMapper;
    }

    /**
     * @inheritDoc
     */
    public function __invoke(array $input)
    {
        $output = [];
        $shift = $this->shiftMapper->find($input['shiftId']);

        // I was going to add a check here to make sure the employee
        // requesting the shift was the employee on the shift but wasn't
        // sure if that was supposed to be allowed or not.
        if (!$shift) {
            return $this->payload
            ->withStatus(PayloadInterface::ERROR)
            ->withOutput([
                'error' => 'Requested shift does not exist',
            ]);
        }
        //echo 'Manager ID:'.$shift->getManagerId();
        $manager = $this->userMapper->find($shift->getManagerId());
        $output['manager_info'] = [
            'id' => $manager->getId(),
            'name' => $manager->getName(),
            'phone' => $manager->getPhone(),
            'email' => $manager->getEmail(),
        ];

        $overlappingShifts = $this->shiftMapper->getShiftsBetween(
            $shift->getStartTime(),
            $shift->getEndTime()
        );

        if ($overlappingShifts) {
            foreach ($overlappingShifts as $overlappingShift) {
                if ($overlappingShift->getId() != $shift->getId()) {
                    $coworker = $this->
                        userMapper->
                        find($overlappingShift->getEmployeeId());

                    if (!$coworker) {
                        $coworker = '[No employee scheduled]';
                    } else {
                        $coworker = $coworker->getName();
                    }

                    $output['overlapping_shifts'][] =
                    [
                        'name' => $coworker,
                        'start_time' => $overlappingShift->getStartTime(),
                        'end_time' => $overlappingShift->getEndTime(),
                    ];
                }
            }
        }

        return $this->payload
        ->withStatus(PayloadInterface::OK)
        ->withOutput([
            $output
        ]);
    }
}
