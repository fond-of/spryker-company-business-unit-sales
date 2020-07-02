<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\CompanyBusinessUnitOrderListTransfer;
use Propel\Runtime\Collection\Collection;

interface SalesOrderMapperInterface
{
    /**
     * @param \Propel\Runtime\Collection\Collection|\Orm\Zed\Sales\Persistence\SpySalesOrder[] $salesOrderEntityCollection
     *
     * @return \Generated\Shared\Transfer\OrderTransfer[]
     */
    public function mapSalesOrderEntityCollectionToOrderTransfers(
        Collection $salesOrderEntityCollection
    ): array;
}
