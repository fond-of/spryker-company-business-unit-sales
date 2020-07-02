<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\Model;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade\CompanyBusinessUnitSalesToSalesFacadeInterface;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\CompanyBusinessUnitSalesRepositoryInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\OrderTransfer;

class OrderReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\Model\CompanyUserReaderInterface
     */
    protected $companyUserReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\CompanyBusinessUnitSalesRepositoryInterface
     */
    protected $repositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade\CompanyBusinessUnitSalesToSalesFacadeInterface
     */
    protected $salesFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer
     */
    protected $companyBusinessUnitOrderListRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer
     */
    protected $companyBusinessUnitOrderListTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\OrderTransfer
     */
    protected $orderTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\Model\OrderReader
     */
    protected $orderReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyUserReaderMock = $this->getMockBuilder(CompanyUserReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(CompanyBusinessUnitSalesRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesFacadeMock = $this->getMockBuilder(CompanyBusinessUnitSalesToSalesFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitOrderListRequestTransferMock = $this->getMockBuilder(CompanyBusinessUnitOrderListRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitOrderListTransferMock = $this->getMockBuilder(CompanyBusinessUnitOrderListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderTransferMock = $this->getMockBuilder(OrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderReader = new OrderReader(
            $this->companyUserReaderMock,
            $this->repositoryMock,
            $this->salesFacadeMock
        );
    }

    /**
     * @return void
     */
    public function testFindByCompanyBusinessUnitOrderList(): void
    {
        $companyUserReference = 'REFERENCE';
        $idSalesOrder = 1;

        $this->companyUserReaderMock->expects($this->atLeastOnce())
            ->method('getActiveByCompanyBusinessUnitOrderListRequest')
            ->with($this->companyBusinessUnitOrderListRequestTransferMock)
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyUserReference')
            ->willReturn($companyUserReference);

        $this->companyBusinessUnitOrderListRequestTransferMock->expects($this->atLeastOnce())
            ->method('setCompanyUserReferences')
            ->with([$companyUserReference])
            ->willReturn($this->companyBusinessUnitOrderListRequestTransferMock);

        $this->repositoryMock->expects($this->atLeastOnce())
            ->method('searchOrders')
            ->with($this->companyBusinessUnitOrderListRequestTransferMock)
            ->willReturn($this->companyBusinessUnitOrderListTransferMock);

        $this->companyBusinessUnitOrderListTransferMock->expects($this->atLeastOnce())
            ->method('getOrders')
            ->willReturn(new ArrayObject([$this->orderTransferMock]));

        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('getIdSalesOrder')
            ->willReturn($idSalesOrder);

        $this->salesFacadeMock->expects($this->atLeastOnce())
            ->method('getOrderByIdSalesOrder')
            ->with($idSalesOrder)
            ->willReturn($this->orderTransferMock);

        $self = $this;

        $this->companyBusinessUnitOrderListTransferMock->expects($this->atLeastOnce())
            ->method('setOrders')
            ->with($this->callback(
                static function (ArrayObject $orderTransfers) use ($self) {
                    return $orderTransfers->count() === 1
                        && $orderTransfers->offsetGet(0) === $self->orderTransferMock;
                }
            ))->willReturn($this->companyBusinessUnitOrderListTransferMock);

        $companyBusinessUnitOrderListTransfer = $this->orderReader->findByCompanyBusinessUnitOrderList(
            $this->companyBusinessUnitOrderListRequestTransferMock
        );

        $this->assertEquals($this->companyBusinessUnitOrderListTransferMock, $companyBusinessUnitOrderListTransfer);
    }

    /**
     * @return void
     */
    public function testFindByCompanyBusinessUnitOrderListWithoutCompanyUser(): void
    {
        $this->companyUserReaderMock->expects($this->atLeastOnce())
            ->method('getActiveByCompanyBusinessUnitOrderListRequest')
            ->with($this->companyBusinessUnitOrderListRequestTransferMock)
            ->willReturn(null);

        $this->companyUserTransferMock->expects($this->never())
            ->method('getCompanyUserReference');

        $this->companyBusinessUnitOrderListRequestTransferMock->expects($this->never())
            ->method('setCompanyUserReferences');

        $this->repositoryMock->expects($this->atLeastOnce())
            ->method('searchOrders')
            ->with($this->companyBusinessUnitOrderListRequestTransferMock)
            ->willReturn($this->companyBusinessUnitOrderListTransferMock);

        $this->companyBusinessUnitOrderListTransferMock->expects($this->atLeastOnce())
            ->method('getOrders')
            ->willReturn(new ArrayObject());

        $this->salesFacadeMock->expects($this->never())
            ->method('getOrderByIdSalesOrder');

        $this->companyBusinessUnitOrderListTransferMock->expects($this->atLeastOnce())
            ->method('setOrders')
            ->with($this->callback(
                static function (ArrayObject $orderTransfers) {
                    return $orderTransfers->count() === 0;
                }
            ))->willReturn($this->companyBusinessUnitOrderListTransferMock);

        $companyBusinessUnitOrderListTransfer = $this->orderReader->findByCompanyBusinessUnitOrderList(
            $this->companyBusinessUnitOrderListRequestTransferMock
        );

        $this->assertEquals($this->companyBusinessUnitOrderListTransferMock, $companyBusinessUnitOrderListTransfer);
    }
}
