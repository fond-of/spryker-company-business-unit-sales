<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence;

use Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

interface CompanyBusinessUnitSalesRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer
     */
    public function searchOrders(
        CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequestTransfer
    ): CompanyBusinessUnitOrderListTransfer;

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequest
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function getActiveCompanyUserByCompanyBusinessUnitOrderListRequest(
        CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequest
    ): ?CompanyUserTransfer;

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequest
     *
     * @return string[]
     */
    public function getActiveCompanyUserReferencesByCompanyBusinessUnitOrderListRequest(
        CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequest
    ): array;
}
