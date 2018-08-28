<?php

namespace PartnerBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class CompanyDepartmentRepository
 * @package PartnerBundle\Repository
 */
class CompanyDepartmentRepository extends EntityRepository
{
    /**
     * Finds CompanyDepartments by criteria
     *
     * @param array $criteria
     *
     * @return mixed
     */
    public function findByCriteria(array $criteria = [])
    {
        $qb = $this->createQueryBuilder('company_department');

        if (!empty($criteria['ids'])) {
            $ids = explode(',', $criteria['ids']);
            $qb->where('company_department.id IN (:departmentIds)')->setParameter('departmentIds', $ids);
        }

        if (isset($criteria['type'])) {
            $qb
                ->leftJoin('company_department.companyTypes', 'company_types')
                ->andWhere('company_types.name = :nameType')
                ->setParameter('nameType', $criteria['type']);
        }

        return $qb->getQuery()->execute();
    }
}
