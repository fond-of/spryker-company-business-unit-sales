<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\Model;

use ArrayObject;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Communication\Plugin\PermissionExtension\SeeAllCompanyBusinessUnitOrdersPermissionPlugin;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade\CompanyBusinessUnitSalesToPermissionFacadeInterface;
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
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade\CompanyBusinessUnitSalesToPermissionFacadeInterface
     */
    protected $permissionFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade\CompanyBusinessUnitSalesToSalesFacadeInterface
     */
    protected $salesFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\Model\CompanyUserReaderInterface $companyUserReader
     * @param \FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\CompanyBusinessUnitSalesRepositoryInterface $repository
     * @param \FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade\CompanyBusinessUnitSalesToPermissionFacadeInterface $permissionFacade
     * @param \FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade\CompanyBusinessUnitSalesToSalesFacadeInterface $salesFacade
     */
    public function __construct(
        CompanyUserReaderInterface $companyUserReader,
        CompanyBusinessUnitSalesRepositoryInterface $repository,
        CompanyBusinessUnitSalesToPermissionFacadeInterface $permissionFacade,
        CompanyBusinessUnitSalesToSalesFacadeInterface $salesFacade
    ) {
        $this->companyUserReader = $companyUserReader;
        $this->repository = $repository;
        $this->permissionFacade = $permissionFacade;
        $this->salesFacade = $salesFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer
     */
    public function findByCompanyBusinessUnitOrderListRequest(
        CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequestTransfer
    ): CompanyBusinessUnitOrderListTransfer {
        $companyBusinessUnitOrderListRequestTransfer = $this->expandCompanyBusinessUnitOrderListRequestWithCompanyUserReferences(
            $companyBusinessUnitOrderListRequestTransfer
        );

        $companyBusinessUnitOrderListTransfer = $this->repository->searchOrders(
            $companyBusinessUnitOrderListRequestTransfer
        );

        return $this->expandOrderTransfersInCompanyBusinessUnitOrderListTransfer($companyBusinessUnitOrderListTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer
     */
    protected function expandCompanyBusinessUnitOrderListRequestWithCompanyUserReferences(
        CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequestTransfer
    ): CompanyBusinessUnitOrderListRequestTransfer {
        $companyUserTransfer = $this->companyUserReader->getActiveByCompanyBusinessUnitOrderListRequest(
            $companyBusinessUnitOrderListRequestTransfer
        );

        if ($companyUserTransfer === null) {
            return $companyBusinessUnitOrderListRequestTransfer;
        }

        $canSeeAllCompanyBusinessUnitOrders = $this->permissionFacade->can(
            SeeAllCompanyBusinessUnitOrdersPermissionPlugin::KEY,
            $companyUserTransfer->getIdCompanyUser()
        );

        if (!$canSeeAllCompanyBusinessUnitOrders) {
            return $companyBusinessUnitOrderListRequestTransfer->setCompanyUserReferences([
                $companyUserTransfer->getCompanyUserReference(),
            ]);
        }

        return $companyBusinessUnitOrderListRequestTransfer->setCompanyUserReferences(
            $this->companyUserReader->getActiveCompanyUserReferencesByCompanyBusinessUnitOrderListRequest(
                $companyBusinessUnitOrderListRequestTransfer
            )
        );
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
