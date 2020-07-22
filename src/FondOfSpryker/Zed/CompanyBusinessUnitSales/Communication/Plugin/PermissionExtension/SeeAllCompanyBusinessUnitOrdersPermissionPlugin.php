<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Communication\Plugin\PermissionExtension;

use Spryker\Shared\PermissionExtension\Dependency\Plugin\PermissionPluginInterface;

class SeeAllCompanyBusinessUnitOrdersPermissionPlugin implements PermissionPluginInterface
{
    public const KEY = 'SeeAllCompanyBusinessUnitOrdersPermissionPlugin';

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getKey(): string
    {
        return static::KEY;
    }
}
