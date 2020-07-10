<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\Model;

use ArrayObject;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade\CompanyBusinessUnitSalesToSalesFacadeInterface;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\CompanyBusinessUnitSalesRepositoryInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;
use Generated\Shared\Transfer\OrderTransfer;

class OrderReader implements OrderReaderInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\Model\CompanyUserReaderInterface
     */
    protected $companyUserReader;

    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\CompanyBusinessUnitSalesRepositoryInterface
     */
    protected $repository;

    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade\CompanyBusinessUnitSalesToSalesFacadeInterface
     */
    protected $salesFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\Model\CompanyUserReaderInterface $companyUserReader
     * @param \FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\CompanyBusinessUnitSalesRepositoryInterface $repository
     * @param \FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade\CompanyBusinessUnitSalesToSalesFacadeInterface $salesFacade
     */
    public function __construct(
        CompanyUserReaderInterface $companyUserReader,
        CompanyBusinessUnitSalesRepositoryInterface $repository,
        CompanyBusinessUnitSalesToSalesFacadeInterface $salesFacade
    ) {
        $this->companyUserReader = $companyUserReader;
        $this->repository = $repository;
        $this->salesFacade = $salesFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer
     */
    public function findByCompanyBusinessUnitOrderList(
        CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequestTransfer
    ): CompanyBusinessUnitOrderListTransfer {
        $companyUserTransfer = $this->companyUserReader->getActiveByCompanyBusinessUnitOrderListRequest(
            $companyBusinessUnitOrderListRequestTransfer
        );

        if ($companyUserTransfer !== null) {
            $companyBusinessUnitOrderListRequestTransfer->setCompanyUserReferences(
                [$companyUserTransfer->getCompanyUserReference()]
            );
        }

        $companyBusinessUnitOrderListTransfer = $this->repository->searchOrders(
            $companyBusinessUnitOrderListRequestTransfer
        );

        return $this->expandOrderTransfersInCompanyBusinessUnitOrderListTransfer($companyBusinessUnitOrderListTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer $companyBusinessUnitOrderListTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer
     */
    protected function expandOrderTransfersInCompanyBusinessUnitOrderListTransfer(
        CompanyBusinessUnitOrderListTransfer $companyBusinessUnitOrderListTransfer
    ): CompanyBusinessUnitOrderListTransfer {
        $orderTransfers = new ArrayObject();

        foreach ($companyBusinessUnitOrderListTransfer->getOrders() as $orderTransfer) {
            $orderTransfers->append($this->expandOrderTransfer($orderTransfer));
        }

        return $companyBusinessUnitOrderListTransfer->setOrders($orderTransfers);
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    protected function expandOrderTransfer(OrderTransfer $orderTransfer): OrderTransfer
    {
        $idSalesOrder = $orderTransfer->getIdSalesOrder();

        /*if ($this->omsFacade->isOrderFlaggedExcludeFromCustomer($idSalesOrder)) {
            continue;
        }*/

        return $this->salesFacade->getOrderByIdSalesOrder($idSalesOrder);
    }
}
