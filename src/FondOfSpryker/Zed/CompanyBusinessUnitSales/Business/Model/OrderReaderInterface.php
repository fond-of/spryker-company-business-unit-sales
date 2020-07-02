<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\Model;

use Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;

interface OrderReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer
     */
    public function findByCompanyBusinessUnitOrderList(
        CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequestTransfer
    ): CompanyBusinessUnitOrderListTransfer;
}
