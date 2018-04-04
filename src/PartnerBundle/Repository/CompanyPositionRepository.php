<?php

namespace PartnerBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;

class CompanyPositionRepository extends EntityRepository
{
    public function applyFilterDepartment(QueryBuilder $queryBuilder, $departments)
    {
        $queryBuilder->innerJoin('cp.departments', 'd');
        if (is_array($departments)) {
            $queryBuilder->andWhere('d.id IN (:departments)')->setParameter('departments', $departments);
        } else {
            $queryBuilder->andWhere('d.id = :departmentId')->setParameter('departmentId', $departments);
        }

        return $queryBuilder;
    }
}
