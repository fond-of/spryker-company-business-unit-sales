<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\Model\OrderReaderInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;

class CompanyBusinessUnitSalesFacadeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\CompanyBusinessUnitSalesBusinessFactory
     */
    protected $companyBusinessUnitSalesBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\Model\OrderReaderInterface
     */
    protected $orderReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer
     */
    protected $companyBusinessUnitOrderListRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer
     */
    protected $companyBusinessUnitOrderListTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\CompanyBusinessUnitSalesFacadeInterface
     */
    protected $companyBusinessUnitSalesFacade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyBusinessUnitSalesBusinessFactoryMock = $this->getMockBuilder(CompanyBusinessUnitSalesBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderReaderMock = $this->getMockBuilder(OrderReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitOrderListRequestTransferMock = $this->getMockBuilder(CompanyBusinessUnitOrderListRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitOrderListTransferMock = $this->getMockBuilder(CompanyBusinessUnitOrderListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitSalesFacade = new CompanyBusinessUnitSalesFacade();
        $this->companyBusinessUnitSalesFacade->setFactory($this->companyBusinessUnitSalesBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testFindOrders(): void
    {
        $this->companyBusinessUnitSalesBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createOrderReader')
            ->willReturn($this->orderReaderMock);

        $this->orderReaderMock->expects($this->atLeastOnce())
            ->method('findByCompanyBusinessUnitOrderList')
            ->with($this->companyBusinessUnitOrderListRequestTransferMock)
            ->willReturn($this->companyBusinessUnitOrderListTransferMock);

        $companyBusinessUnitOrderListTransfer = $this->companyBusinessUnitSalesFacade
            ->findOrders($this->companyBusinessUnitOrderListRequestTransferMock);

        $this->assertEquals($this->companyBusinessUnitOrderListTransferMock, $companyBusinessUnitOrderListTransfer);
    }
}
