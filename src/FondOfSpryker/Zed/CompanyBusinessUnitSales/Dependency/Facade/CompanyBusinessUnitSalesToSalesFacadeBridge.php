<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade;

use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Zed\Sales\Business\SalesFacadeInterface;

class CompanyBusinessUnitSalesToSalesFacadeBridge implements CompanyBusinessUnitSalesToSalesFacadeInterface
{
    /**
     * @var \Spryker\Zed\Sales\Business\SalesFacadeInterface
     */
    protected $salesFacade;

    /**
     * @param \Spryker\Zed\Sales\Business\SalesFacadeInterface $salesFacade
     */
    public function __construct(SalesFacadeInterface $salesFacade)
    {
        $this->salesFacade = $salesFacade;
    }

    /**
     * @param int $idSalesOrder
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function getOrderByIdSalesOrder(int $idSalesOrder): OrderTransfer
    {
        return $this->salesFacade->getOrderByIdSalesOrder($idSalesOrder);
    }
}
