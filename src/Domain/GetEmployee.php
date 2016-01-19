<?php
namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Adr\PayloadInterface;
use Psr\Http\Message\ServerRequestInterface;
use Spark\Project\DataMapper\UserMapper;

class GetEmployee implements DomainInterface
{
    /**
     * @var PayloadInterface
     */
    private $payload;
    
    private $userMapper;

    /**
     * @param PayloadInterface $payload
     */
    public function __construct(
        PayloadInterface $payload,
        ServerRequestInterface $request,
        UserMapper $userMapper
    ) {
        $this->payload = $payload;
        $this->userMapper = $userMapper;

    }

    /**
     * @inheritDoc
     */
    public function __invoke(array $input)
    {
        $employee = $this->userMapper->find($input['employeeId']);

        $output = [];
        if ($employee) {
            $output = [
                'id' => $employee->getId(),
                'name' => $employee->getName(),
                'phone' => $employee->getPhone(),
                'email' => $employee->getEmail(),
             ];
        }
        return $this->payload
            ->withStatus(PayloadInterface::OK)
            ->withOutput([
                $output
            ]);
    }

}
