<?php
namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Adr\PayloadInterface;
use Psr\Http\Message\ServerRequestInterface;
use Spark\Project\DataMapper\ShiftMapper;

class ModifyShift implements DomainInterface
{

    /**
     *
     * @var PayloadInterface
     */
    private $payload;

    private $shiftMapper;

    private $userId;

    /**
     *
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
        // this method assumes that when you're modifying a shift,
        // all of the data is being reposted.
        if (empty($input['shift_id'])) {
            $shift = $this->shiftMapper->create();
        } else {
            $shift = $this->shiftMapper->find($input['shift_id']);
        }

        // if manager id has been provided, let's use it.
        if (!empty($input['manager_id'])) {
            $shift->setManagerId($input['manager_id']);
        } else {
            $shift->setManagerId($this->userId);
        }

        if (!empty($input['employee_id'])) {
            $shift->setEmployeeId($input['employee_id']);
        }

        $shift->setBreak($input['break']);
        $shift->setStartTime($input['start_time']);
        $shift->setEndTime($input['end_time']);

        if ($this->shiftMapper->save($shift)) {
            $status = PayloadInterface::OK;
            $output = ['status' => 'Successfully saved'];
        } else {
            $status = PayloadInterface::ERROR;
            $output = ['status' => 'Failed to save'];
        }

        return $this->payload
            ->withStatus($status)
            ->withOutput([
                $output
            ]);
    }
}
