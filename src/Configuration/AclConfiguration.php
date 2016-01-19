<?php
namespace Spark\Project\Configuration;

use Auryn\Injector;
use Spark\Configuration\ConfigurationInterface;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

class AclConfiguration implements ConfigurationInterface
{

    /**
     *
     * {@inheritDoc}
     *
     * @see \Spark\Configuration\ConfigurationInterface::apply()
     */
    public function apply(Injector $injector)
    {
        $acl = new Acl();
        $acl->addRole(new Role('manager'))->addRole(new Role('employee'));

        $acl->addResource(new Resource('GetEmployeeShifts'));
        $acl->addResource(new Resource('GetEmployeeShiftsSummary'));
        $acl->addResource(new Resource('GetShiftDetail'));
        $acl->addResource(new Resource('ModifyShift'));
        $acl->addResource(new Resource('GetShiftsByDate'));
        $acl->addResource(new Resource('GetEmployee'));

        $acl->allow('employee', 'GetEmployeeShifts');
        $acl->allow('employee', 'GetEmployeeShiftsSummary');
        $acl->allow('employee', 'GetShiftDetail');
        $acl->allow('manager', 'GetEmployee');
        $acl->allow('manager', 'ModifyShift');
        $acl->allow('manager', 'GetShiftsByDate');

        $injector->share($acl);
    }
}
