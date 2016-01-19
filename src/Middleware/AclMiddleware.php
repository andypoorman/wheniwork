<?php

namespace Spark\Project\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use Spark\Project\DataMapper\UserMapper;
use Spark\Directory;
use Spark\Handler\DispatchHandler;
use FastRoute;
use FastRoute\RouteCollector;

class AclMiddleware
{

    protected $fpdo;

    public function __construct(
        \FluentPDO $fpdo,
        Acl $acl,
        Directory $directory
    ) {
        $this->fpdo = $fpdo;
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
     * Sort of a hacky method but I wanted to be able to get the domain class
     * name from this middleware and couldn't find a super elegant way to do it
     * Previously I didn't have the middleware file and just hid all the acl
     * logic in an abstract all of the domains extended. At least now there is
     * more of a separation of concerns
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
        $userMapper = new UserMapper($this->fpdo);

        $userRole = $userMapper
            ->find($userId)
            ->getRole();

        if (!$this->acl->isAllowed($userRole, $resource)) {
            throw new \Exception('Resource not allowed');
        }
    }
}
