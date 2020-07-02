<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\OrderTransfer;
use Propel\Runtime\Collection\Collection;

class SalesOrderMapper implements SalesOrderMapperInterface
{
    /**
     * @param \Propel\Runtime\Collection\Collection|\Orm\Zed\Sales\Persistence\SpySalesOrder[] $salesOrderEntityCollection
     *
     * @return \Generated\Shared\Transfer\OrderTransfer[]
     */
    public function mapSalesOrderEntityCollectionToOrderTransfers(Collection $salesOrderEntityCollection): array
    {
        $orderTransfers = [];

        foreach ($salesOrderEntityCollection as $salesOrderEntity) {
            $orderTransfers[] = (new OrderTransfer())->fromArray($salesOrderEntity->toArray(), true);
        }

        return $orderTransfers;
    }
}
