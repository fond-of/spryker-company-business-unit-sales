<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Business;

use Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;

interface CompanyBusinessUnitSalesFacadeInterface
{
    /**
     * Specifications:
     * - Returns a list of orders
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer
     */
    public function findOrders(
        CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequestTransfer
    ): CompanyBusinessUnitOrderListTransfer;
}
