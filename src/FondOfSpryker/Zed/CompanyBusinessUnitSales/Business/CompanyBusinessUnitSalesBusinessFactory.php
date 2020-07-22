<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Business;

use FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\Model\CompanyUserReader;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\Model\CompanyUserReaderInterface;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\Model\OrderReader;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\Model\OrderReaderInterface;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\CompanyBusinessUnitSalesDependencyProvider;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade\CompanyBusinessUnitSalesToPermissionFacadeInterface;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade\CompanyBusinessUnitSalesToSalesFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\CompanyBusinessUnitSalesRepositoryInterface getRepository()
 */
class CompanyBusinessUnitSalesBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\Model\OrderReaderInterface
     */
    public function createOrderReader(): OrderReaderInterface
    {
        return new OrderReader(
            $this->createCompanyUserReader(),
            $this->getRepository(),
            $this->getPermissionFacade(),
            $this->getSalesFacade()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyBusinessUnitSales\Business\Model\CompanyUserReaderInterface
     */
    protected function createCompanyUserReader(): CompanyUserReaderInterface
    {
        return new CompanyUserReader($this->getRepository());
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade\CompanyBusinessUnitSalesToPermissionFacadeInterface
     */
    protected function getPermissionFacade(): CompanyBusinessUnitSalesToPermissionFacadeInterface
    {
        return $this->getProvidedDependency(CompanyBusinessUnitSalesDependencyProvider::FACADE_PERMISSION);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyBusinessUnitSales\Dependency\Facade\CompanyBusinessUnitSalesToSalesFacadeInterface
     */
    protected function getSalesFacade(): CompanyBusinessUnitSalesToSalesFacadeInterface
    {
        return $this->getProvidedDependency(CompanyBusinessUnitSalesDependencyProvider::FACADE_SALES);
    }
}
