<?php

namespace PartnerBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use PartnerBundle\Enum\OperatorEnum;

class CompanyPositionCodeRepository extends EntityRepository
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param int $department
     * @param string $operator
     * @return QueryBuilder
     */
    public function applyFilterDepartment(QueryBuilder $queryBuilder, $department, $operator)
    {
        if (null === $department || null === OperatorEnum::getValue($operator)) {
            return $queryBuilder;
        }

        $condition = sprintf('cpc.department %s :parameter', OperatorEnum::getValue($operator));
        $queryBuilder->andWhere($condition)->setParameter('parameter', $department);

        return $queryBuilder;
    }
}
