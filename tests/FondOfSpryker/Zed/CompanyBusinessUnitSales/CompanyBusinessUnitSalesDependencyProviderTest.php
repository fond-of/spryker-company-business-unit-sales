<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade\CompanyBusinessUnitSalesToPermissionFacadeBridge;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade\CompanyBusinessUnitSalesToSalesFacadeBridge;
use Spryker\Shared\Kernel\BundleProxy;
use Spryker\Zed\Kernel\Locator;
use Spryker\Zed\Permission\Business\PermissionFacadeInterface;
use Spryker\Zed\Sales\Business\SalesFacadeInterface;
use Spryker\Zed\Testify\Locator\Business\Container;

class CompanyBusinessUnitSalesDependencyProviderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Locator
     */
    protected $locatorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\BundleProxy
     */
    protected $bundleProxyMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Permission\Business\PermissionFacadeInterface
     */
    protected $permissionFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Sales\Business\SalesFacadeInterface
     */
    protected $salesFacadeMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitSales\CompanyBusinessUnitSalesDependencyProvider
     */
    protected $companyBusinessUnitSalesDependencyProvider;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->setMethodsExcept(['factory', 'set', 'offsetSet', 'get', 'offsetGet'])
            ->getMock();

        $this->locatorMock = $this->getMockBuilder(Locator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bundleProxyMock = $this->getMockBuilder(BundleProxy::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this->getMockBuilder(PermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesFacadeMock = $this->getMockBuilder(SalesFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitSalesDependencyProvider = new CompanyBusinessUnitSalesDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideBusinessLayerDependencies(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('getLocator')
            ->willReturn($this->locatorMock);

        $this->locatorMock->expects($this->atLeastOnce())
            ->method('__call')
            ->withConsecutive(['permission'], ['sales'])
            ->willReturn($this->bundleProxyMock);

        $this->bundleProxyMock->expects($this->atLeastOnce())
            ->method('__call')
            ->with('facade')
            ->willReturnOnConsecutiveCalls($this->permissionFacadeMock, $this->salesFacadeMock);

        $container = $this->companyBusinessUnitSalesDependencyProvider->provideBusinessLayerDependencies(
            $this->containerMock
        );

        $this->assertEquals($this->containerMock, $container);

        $this->assertInstanceOf(
            CompanyBusinessUnitSalesToPermissionFacadeBridge::class,
            $container[CompanyBusinessUnitSalesDependencyProvider::FACADE_PERMISSION]
        );

        $this->assertInstanceOf(
            CompanyBusinessUnitSalesToSalesFacadeBridge::class,
            $container[CompanyBusinessUnitSalesDependencyProvider::FACADE_SALES]
        );
    }
}
