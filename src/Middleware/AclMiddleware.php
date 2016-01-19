<?php

namespace Spark\Project\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use Spark\Project\DataMapper\UserMapper;
use Spark\Directory;
use FastRoute;
use FastRoute\RouteCollector;

class AclMiddleware
{

    protected $userMapper;

    public function __construct(
        UserMapper $userMapper,
        Acl $acl,
        Directory $directory
    ) {
        $this->userMapper = $userMapper;
        $this->acl = $acl;
        $this->directory = $directory;

        $this->dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $collector) {
            foreach ($this->directory as $request => $action) {
                list($method, $path) = explode(' ', $request, 2);
                $collector->addRoute($method, $path, $action);
            }
        });

    }
    /**
     * @inheritDoc
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ) {
        $userId = $request->getHeader('id')[0];

        $resource = $this->getDomainByRoute($request);
        $this->checkAcl($userId, $resource);

        return $next($request, $response);
    }

    /**
     * todo: this shouldn't be a concern of this class and should be moved
     * either to the dispatcher or a somewhere more practical
     *
     * @param unknown $request
     */
    private function getDomainByRoute($request)
    {
        $route = $this
            ->dispatcher
            ->dispatch(
                $request->getMethod(),
                $request->getUri()->getPath()
            );

        $fullDomainName = $route[1]->getDomain();
        $domain = end(explode('\\', $fullDomainName));
        return $domain;

    }

    /**
     *
     * @param int $userId
     * @param string $resource
     * @throws \Exception
     */
    protected function checkAcl($userId, $resource)
    {
        $userRole = $this->userMapper
            ->find($userId)
            ->getRole();

        if (!$this->acl->isAllowed($userRole, $resource)) {
            throw new \Exception('Resource not allowed');
        }
    }
}
