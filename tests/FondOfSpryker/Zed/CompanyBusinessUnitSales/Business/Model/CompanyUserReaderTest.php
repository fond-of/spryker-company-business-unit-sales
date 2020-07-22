<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\Model;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\CompanyBusinessUnitSalesRepositoryInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUserReaderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\CompanyBusinessUnitSalesRepositoryInterface
     */
    protected $repositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer
     */
    protected $companyBusinessUnitOrderListRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected $companyUserTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\Model\CompanyUserReader
     */
    protected $companyUserReader;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->repositoryMock = $this->getMockBuilder(CompanyBusinessUnitSalesRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitOrderListRequestTransferMock = $this->getMockBuilder(CompanyBusinessUnitOrderListRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserReader = new CompanyUserReader($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testGetActiveByCompanyBusinessUnitOrderListRequest(): void
    {
        $this->companyBusinessUnitOrderListRequestTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyBusinessUnit')
            ->willReturn(1);

        $this->companyBusinessUnitOrderListRequestTransferMock->expects($this->atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(1);

        $this->repositoryMock->expects($this->atLeastOnce())
            ->method('getActiveCompanyUserByCompanyBusinessUnitOrderListRequest')
            ->with($this->companyBusinessUnitOrderListRequestTransferMock)
            ->willReturn($this->companyUserTransferMock);

        $companyUser = $this->companyUserReader->getActiveByCompanyBusinessUnitOrderListRequest(
            $this->companyBusinessUnitOrderListRequestTransferMock
        );

        $this->assertEquals($this->companyUserTransferMock, $companyUser);
    }

    /**
     * @return void
     */
    public function testGetActiveByCompanyBusinessUnitOrderListRequestWithoutCompanyBusinessUnitId(): void
    {
        $this->companyBusinessUnitOrderListRequestTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyBusinessUnit')
            ->willReturn(null);

        $this->companyBusinessUnitOrderListRequestTransferMock->expects($this->atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(1);

        $this->repositoryMock->expects($this->never())
            ->method('getActiveCompanyUserByCompanyBusinessUnitOrderListRequest')
            ->with($this->companyBusinessUnitOrderListRequestTransferMock);

        $companyUser = $this->companyUserReader->getActiveByCompanyBusinessUnitOrderListRequest(
            $this->companyBusinessUnitOrderListRequestTransferMock
        );

        $this->assertEquals(null, $companyUser);
    }

    /**
     * @return void
     */
    public function testGetActiveCompanyUserReferencesByCompanyBusinessUnitOrderListRequest(): void
    {
        $companyUserReferences = ['CU1', 'CU2'];

        $this->companyBusinessUnitOrderListRequestTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyBusinessUnit')
            ->willReturn(1);

        $this->repositoryMock->expects($this->atLeastOnce())
            ->method('getActiveCompanyUserReferencesByCompanyBusinessUnitOrderListRequest')
            ->with($this->companyBusinessUnitOrderListRequestTransferMock)
            ->willReturn($companyUserReferences);

        $this->assertEquals(
            $companyUserReferences,
            $this->companyUserReader->getActiveCompanyUserReferencesByCompanyBusinessUnitOrderListRequest(
                $this->companyBusinessUnitOrderListRequestTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testGetActiveCompanyUserReferencesByCompanyBusinessUnitOrderListRequestWithoutCompanyBusinessUnitId(): void
    {
        $this->companyBusinessUnitOrderListRequestTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyBusinessUnit')
            ->willReturn(null);

        $this->repositoryMock->expects($this->never())
            ->method('getActiveCompanyUserReferencesByCompanyBusinessUnitOrderListRequest')
            ->with($this->companyBusinessUnitOrderListRequestTransferMock);

        $companyUserReferences = $this->companyUserReader->getActiveCompanyUserReferencesByCompanyBusinessUnitOrderListRequest(
            $this->companyBusinessUnitOrderListRequestTransferMock
        );

        $this->assertCount(0, $companyUserReferences);
    }
}
