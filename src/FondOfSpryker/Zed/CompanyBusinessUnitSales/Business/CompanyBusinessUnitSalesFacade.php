<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Business;

use Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\CompanyBusinessUnitSalesRepositoryInterface getRepository()
 * @method \FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\CompanyBusinessUnitSalesBusinessFactory getFactory()
 */
class CompanyBusinessUnitSalesFacade extends AbstractFacade implements CompanyBusinessUnitSalesFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer
     */
    public function findOrders(
        CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequestTransfer
    ): CompanyBusinessUnitOrderListTransfer {
        return $this->getFactory()
            ->createOrderReader()
            ->findByCompanyBusinessUnitOrderListRequest($companyBusinessUnitOrderListRequestTransfer);
    }
}
