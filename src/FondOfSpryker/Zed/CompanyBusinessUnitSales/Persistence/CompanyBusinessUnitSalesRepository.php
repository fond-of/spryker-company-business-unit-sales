<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence;

use ArrayObject;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\FilterTransfer;
use Generated\Shared\Transfer\PaginationTransfer;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;
use Spryker\Zed\Propel\PropelFilterCriteria;

/**
 * @method \FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\CompanyBusinessUnitSalesPersistenceFactory getFactory()
 */
class CompanyBusinessUnitSalesRepository extends AbstractRepository implements CompanyBusinessUnitSalesRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer
     */
    public function searchOrders(
        CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequestTransfer
    ): CompanyBusinessUnitOrderListTransfer {
        $companyBusinessUnitOrderListTransfer = new CompanyBusinessUnitOrderListTransfer();
        $companyUserReferences = $companyBusinessUnitOrderListRequestTransfer->getCompanyUserReferences();
        $orderReference = $companyBusinessUnitOrderListRequestTransfer->getOrderReference();

        if (count($companyUserReferences) === 0) {
            return $companyBusinessUnitOrderListTransfer->setPagination(
                (new PaginationTransfer())->setNbResults(0)
            );
        }

        $spySalesOrderQuery = $this->getFactory()
            ->getSalesOrderQuery()
            ->filterByCompanyUserReference_In($companyUserReferences);

        if ($orderReference !== null) {
            $spySalesOrderQuery->filterByOrderReference($orderReference);
        }

        $salesOrdersCount = $spySalesOrderQuery->count();

        $spySalesOrderQuery = $this->applyFilterToQuery(
            $spySalesOrderQuery,
            $companyBusinessUnitOrderListRequestTransfer->getFilter()
        );

        $orderTransfers = $this->getFactory()
            ->createSalesOrderMapper()
            ->mapSalesOrderEntityCollectionToOrderTransfers($spySalesOrderQuery->find());

        return $companyBusinessUnitOrderListTransfer->setOrders(new ArrayObject($orderTransfers))
            ->setPagination((new PaginationTransfer())->setNbResults($salesOrdersCount));
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\ModelCriteria $query
     * @param \Generated\Shared\Transfer\FilterTransfer|null $filterTransfer
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    protected function applyFilterToQuery(
        ModelCriteria $query,
        ?FilterTransfer $filterTransfer
    ): ModelCriteria {
        if ($filterTransfer === null) {
            return $query;
        }

        return $query->mergeWith((new PropelFilterCriteria($filterTransfer))->toCriteria());
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequest
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function getActiveCompanyUserByCompanyBusinessUnitOrderListRequest(
        CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequest
    ): ?CompanyUserTransfer {
        $companyBusinessUnitOrderListRequest->requireIdCustomer()
            ->requireIdCompanyBusinessUnit();

        $spyCompanyUserQuery = $this->getFactory()->getCompanyUserQuery()
            ->filterByFkCompanyBusinessUnit($companyBusinessUnitOrderListRequest->getIdCompanyBusinessUnit())
            ->filterByFkCustomer($companyBusinessUnitOrderListRequest->getIdCustomer())
            ->filterByIsActive(true)
            ->findOne();

        if ($spyCompanyUserQuery === null) {
            return null;
        }

        return $this->getFactory()
            ->createCompanyUserMapper()
            ->mapCompanyUserEntityToCompanyUserTransfer($spyCompanyUserQuery);
    }
}
