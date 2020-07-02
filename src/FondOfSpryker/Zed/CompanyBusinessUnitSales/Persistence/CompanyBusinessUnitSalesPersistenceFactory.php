<?php

namespace FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence;

use FondOfSpryker\Zed\CompanyBusinessUnitSales\CompanyBusinessUnitSalesDependencyProvider;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\Propel\Mapper\CompanyUserMapper;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\Propel\Mapper\CompanyUserMapperInterface;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\Propel\Mapper\SalesOrderMapper;
use FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\Propel\Mapper\SalesOrderMapperInterface;
use Orm\Zed\CompanyUser\Persistence\Base\SpyCompanyUserQuery;
use Orm\Zed\Sales\Persistence\Base\SpySalesOrderQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\CompanyBusinessUnitSalesRepositoryInterface getRepository()
 */
class CompanyBusinessUnitSalesPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\CompanyUser\Persistence\Base\SpyCompanyUserQuery
     */
    public function getCompanyUserQuery(): SpyCompanyUserQuery
    {
        return $this->getProvidedDependency(
            CompanyBusinessUnitSalesDependencyProvider::PROPEL_QUERY_COMPANY_USER
        );
    }

    /**
     * @return \Orm\Zed\Sales\Persistence\Base\SpySalesOrderQuery
     */
    public function getSalesOrderQuery(): SpySalesOrderQuery
    {
        return $this->getProvidedDependency(
            CompanyBusinessUnitSalesDependencyProvider::PROPEL_QUERY_SALES_ORDER
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\Propel\Mapper\SalesOrderMapperInterface
     */
    public function createSalesOrderMapper(): SalesOrderMapperInterface
    {
        return new SalesOrderMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyBusinessUnitSales\Persistence\Propel\Mapper\CompanyUserMapperInterface
     */
    public function createCompanyUserMapper(): CompanyUserMapperInterface
    {
        return new CompanyUserMapper();
    }
}
