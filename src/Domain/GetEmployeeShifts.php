<?php
namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Adr\PayloadInterface;
use Psr\Http\Message\ServerRequestInterface;
use Spark\Project\DataMapper\ShiftMapper;

class GetEmployeeShifts implements DomainInterface
{
    /**
     * @var PayloadInterface
     */
    private $payload;

    private $shiftMapper;

    private $userId;
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

        //userId has already been verified by the AuthAdapter by this point
        $this->userId = (int) $request->getHeader('id')[0];
    }

    /**
     * @inheritDoc
     */
    public function __invoke(array $input)
    {
        $shifts = $this->shiftMapper->getFutureShiftsByEmployee($this->userId);

        $output = [];
        if (is_array($shifts) && !empty($shifts)) {
            foreach ($shifts as $shift) {
                $output[] = [
                    'id' => $shift->getId(),
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
