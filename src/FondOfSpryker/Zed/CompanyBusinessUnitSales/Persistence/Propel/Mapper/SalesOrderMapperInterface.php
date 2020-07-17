<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\Propel\Mapper;

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
