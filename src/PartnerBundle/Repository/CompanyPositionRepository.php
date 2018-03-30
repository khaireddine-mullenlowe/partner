<?php

namespace PartnerBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;

class CompanyPositionRepository extends EntityRepository
{
    public function applyFilterDepartment(QueryBuilder $queryBuilder, $departmentId)
    {
        $queryBuilder
            ->innerJoin('cp.departments', 'd')
            ->andWhere('d.id = :departmentId')
            ->setParameter('departmentId', $departmentId);

        return $queryBuilder;
    }
}
