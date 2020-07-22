<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade;

use Spryker\Zed\Permission\Business\PermissionFacadeInterface;

class CompanyBusinessUnitSalesToPermissionFacadeBridge implements CompanyBusinessUnitSalesToPermissionFacadeInterface
{
    /**
     * @var \Spryker\Zed\Permission\Business\PermissionFacadeInterface
     */
    protected $permissionFacade;

    /**
     * @param \Spryker\Zed\Permission\Business\PermissionFacadeInterface $permissionFacade
     */
    public function __construct(PermissionFacadeInterface $permissionFacade)
    {
        $this->permissionFacade = $permissionFacade;
    }

    /**
     * @param string $permissionKey
     * @param int|string $identifier
     * @param int|string|array|null $context
     *
     * @return bool
     */
    public function can($permissionKey, $identifier, $context = null): bool
    {
        return $this->permissionFacade->can($permissionKey, $identifier, $context);
    }
}
