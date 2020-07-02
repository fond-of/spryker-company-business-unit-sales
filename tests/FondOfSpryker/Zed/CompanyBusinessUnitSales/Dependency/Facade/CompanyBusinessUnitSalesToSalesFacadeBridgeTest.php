<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Zed\Sales\Business\SalesFacadeInterface;

class CompanyBusinessUnitSalesToSalesFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Sales\Business\SalesFacadeInterface
     */
    protected $salesFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\OrderTransfer
     */
    protected $orderTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade\CompanyBusinessUnitSalesToSalesFacadeBridge
     */
    protected $companyBusinessUnitSalesToSalesFacadeBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->salesFacadeMock = $this->getMockBuilder(SalesFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderTransferMock = $this->getMockBuilder(OrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitSalesToSalesFacadeBridge = new CompanyBusinessUnitSalesToSalesFacadeBridge(
            $this->salesFacadeMock
        );
    }

    /**
     * @return void
     */
    public function testGetOrderByIdSalesOrder(): void
    {
        $idSalesOrder = 1;

        $this->salesFacadeMock->expects($this->atLeastOnce())
            ->method('getOrderByIdSalesOrder')
            ->with($idSalesOrder)
            ->willReturn($this->orderTransferMock);

        $orderTransfer = $this->companyBusinessUnitSalesToSalesFacadeBridge->getOrderByIdSalesOrder($idSalesOrder);

        $this->assertEquals($this->orderTransferMock, $orderTransfer);
    }
}
