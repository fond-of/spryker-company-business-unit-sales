<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\Model;

use Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

interface CompanyUserReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function getActiveByCompanyBusinessUnitOrderListRequest(
        CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequestTransfer
    ): ?CompanyUserTransfer;
}
