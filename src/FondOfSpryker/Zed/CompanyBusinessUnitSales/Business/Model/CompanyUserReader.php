<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\Model;

use FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\CompanyBusinessUnitSalesRepositoryInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUserReader implements CompanyUserReaderInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\CompanyBusinessUnitSalesRepositoryInterface
     */
    protected $repository;

    /**
     * @param \FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\CompanyBusinessUnitSalesRepositoryInterface $repository
     */
    public function __construct(CompanyBusinessUnitSalesRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function getActiveByCompanyBusinessUnitOrderListRequest(
        CompanyBusinessUnitOrderListRequestTransfer $companyBusinessUnitOrderListRequestTransfer
    ): ?CompanyUserTransfer {
        if (
            $companyBusinessUnitOrderListRequestTransfer->getIdCustomer() === null
            || $companyBusinessUnitOrderListRequestTransfer->getIdCompanyBusinessUnit() === null
        ) {
            return null;
        }

        return $this->repository->getActiveCompanyUserByCompanyBusinessUnitOrderListRequest(
            $companyBusinessUnitOrderListRequestTransfer
        );
    }
}
