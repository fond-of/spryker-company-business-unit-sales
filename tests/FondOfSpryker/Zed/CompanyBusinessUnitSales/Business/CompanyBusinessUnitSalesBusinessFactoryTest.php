<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\Model\OrderReader;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\CompanyBusinessUnitSalesDependencyProvider;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade\CompanyBusinessUnitSalesToPermissionFacadeInterface;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade\CompanyBusinessUnitSalesToSalesFacadeInterface;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\CompanyBusinessUnitSalesRepository;
use Spryker\Zed\Kernel\Container;

class CompanyBusinessUnitSalesBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade\CompanyBusinessUnitSalesToPermissionFacadeInterface
     */
    protected $permissionFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade\CompanyBusinessUnitSalesToSalesFacadeInterface
     */
    protected $salesFacadeMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\CompanyBusinessUnitSalesBusinessFactory
     */
    protected $companyBusinessUnitSalesBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\CompanyBusinessUnitSalesRepository
     */
    protected $repositoryMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(CompanyBusinessUnitSalesRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->permissionFacadeMock = $this->getMockBuilder(CompanyBusinessUnitSalesToPermissionFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesFacadeMock = $this->getMockBuilder(CompanyBusinessUnitSalesToSalesFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitSalesBusinessFactory = new CompanyBusinessUnitSalesBusinessFactory();
        $this->companyBusinessUnitSalesBusinessFactory->setContainer($this->containerMock);
        $this->companyBusinessUnitSalesBusinessFactory->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testCreateOrderReader(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [CompanyBusinessUnitSalesDependencyProvider::FACADE_PERMISSION],
                [CompanyBusinessUnitSalesDependencyProvider::FACADE_SALES]
            )->willReturnOnConsecutiveCalls(
                $this->permissionFacadeMock,
                $this->salesFacadeMock
            );

        $orderReader = $this->companyBusinessUnitSalesBusinessFactory->createOrderReader();

        $this->assertInstanceOf(OrderReader::class, $orderReader);
    }
}
