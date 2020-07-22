<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Communication\Plugin\PermissionExtension\SeeAllCompanyBusinessUnitOrdersPermissionPlugin;
use Spryker\Zed\Permission\Business\PermissionFacadeInterface;

class CompanyBusinessUnitSalesToPermissionFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Permission\Business\PermissionFacadeInterface
     */
    protected $permissionFacadeMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade\CompanyBusinessUnitSalesToPermissionFacadeBridge
     */
    protected $companyBusinessUnitSalesToPermissionFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->permissionFacadeMock = $this->getMockBuilder(PermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitSalesToPermissionFacadeBridge = new CompanyBusinessUnitSalesToPermissionFacadeBridge(
            $this->permissionFacadeMock
        );
    }

    /**
     * @return void
     */
    public function testCan(): void
    {
        $key = SeeAllCompanyBusinessUnitOrdersPermissionPlugin::KEY;
        $identifier = 1;

        $this->permissionFacadeMock->expects($this->atLeastOnce())
            ->method('can')
            ->with($key, $identifier, null)
            ->willReturn(true);

        $this->assertTrue($this->companyBusinessUnitSalesToPermissionFacadeBridge->can($key, $identifier));
    }
}
