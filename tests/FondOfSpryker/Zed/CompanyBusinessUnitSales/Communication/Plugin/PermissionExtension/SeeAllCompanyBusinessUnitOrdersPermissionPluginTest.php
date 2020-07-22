<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Communication\Plugin\PermissionExtension;

use Codeception\Test\Unit;

class SeeAllCompanyBusinessUnitOrdersPermissionPluginTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitSales\Communication\Plugin\PermissionExtension\SeeAllCompanyBusinessUnitOrdersPermissionPlugin
     */
    protected $seeAllCompanyBusinessUnitOrdersPermissionPlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->seeAllCompanyBusinessUnitOrdersPermissionPlugin = new SeeAllCompanyBusinessUnitOrdersPermissionPlugin();
    }

    /**
     * @return void
     */
    public function testGetKey(): void
    {
        $this->assertEquals(
            SeeAllCompanyBusinessUnitOrdersPermissionPlugin::KEY,
            $this->seeAllCompanyBusinessUnitOrdersPermissionPlugin->getKey()
        );
    }
}
