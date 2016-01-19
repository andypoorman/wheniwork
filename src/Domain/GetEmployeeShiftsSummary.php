<?php
namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Adr\PayloadInterface;
use Psr\Http\Message\ServerRequestInterface;
use Spark\Project\DataMapper\ShiftMapper;

class GetEmployeeShiftsSummary implements DomainInterface
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
        ShiftMapper $shiftMapper
    ) {
        $this->payload = $payload;
        $this->shiftMapper = $shiftMapper;
        $this->userId = (int) $request->getHeader('id')[0];
    }

    /**
     * @inheritDoc
     */
    public function __invoke(array $input)
    {
        $date = urldecode($input['date']);
        $shifts = $this->shiftMapper->getWeeklySummary(
            $this->userId,
            $date
        );

        $output = [];
        $hoursWorked = 0;
        $minutesWorked = 0;
        // todo: not error if they haven't worked
        foreach ($shifts as $shift) {
            $output['shifts'][] = [
                'id' => $shift->getid(),
                'start_time' => $shift->getStartTime(),
                'end_time' => $shift->getEndTime(),
            ];

            // I'm just going to care about hours and minutes
            // your seconds mean nothing to me. Maybe later.
            $start = new \DateTime($shift->getStartTime());
            $end = new \DateTime($shift->getEndTime());
            $interval = $start->diff($end);
            $hoursWorked += $interval->h;
            $minutesWorked += $interval->i;
        }

        if ($minutesWorked) {
            $output['hours_worked'] = $hoursWorked + ($minutesWorked / 60);
        } else {
            $output['hours_worked'] = $hoursWorked;
        }

        return $this->payload
            ->withStatus(PayloadInterface::OK)
            ->withOutput([
                $output
            ]);
    }

}
