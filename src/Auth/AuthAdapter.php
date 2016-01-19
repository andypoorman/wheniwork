<?php
namespace Spark\Project\Auth;

use Spark\Auth\AdapterInterface;
use Spark\Auth\Credentials;
use Spark\Auth\Token;
use Psr\Http\Message\ServerRequestInterface;
use Spark\Project\DataMapper\UserMapper;

class AuthAdapter implements AdapterInterface
{

    protected $userMapper;

    protected $userId;

    /**
     *
     * @param \FluentPDO $fpdo
     * @param ServerRequestInterface $request
     */
    public function __construct(
        ServerRequestInterface $request,
        UserMapper $userMapper
    ) {
        $this->userMapper = $userMapper;
        $this->userId = $request->getHeader('id');
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Spark\Auth\AdapterInterface::validateToken()
     */
    public function validateToken($token)
    {

        // not the most secure thing I've ever written but it works for this.
        if (empty($this->userId) || empty($token)) {
            throw new \InvalidArgumentException('Invalid Token');
        }

        if (!is_array($this->userId) || count($this->userId) != 1) {
            throw new \InvalidArgumentException('Invalid Token');
        }

        $userId = $this->userId[0];
        if (!is_numeric($userId)) {
            throw new \InvalidArgumentException('Invalid Token');
        }

        $user = $this->userMapper->findByIdToken($userId, $token);

        if (!$user) {
            throw new \InvalidArgumentException('Invalid Token');
        }

        $token = new Token($token, []);
        return $token;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Spark\Auth\AdapterInterface::validateCredentials()
     */
    public function validateCredentials(Credentials $credentials)
    {
        // todo: make this validate real credentials.
        return $credentials;
    }
}
