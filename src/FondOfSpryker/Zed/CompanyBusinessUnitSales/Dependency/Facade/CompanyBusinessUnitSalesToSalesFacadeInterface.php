<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade;

use Generated\Shared\Transfer\OrderTransfer;

interface CompanyBusinessUnitSalesToSalesFacadeInterface
{
    /**
     * @param int $idSalesOrder
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function getOrderByIdSalesOrder(int $idSalesOrder): OrderTransfer;
}
