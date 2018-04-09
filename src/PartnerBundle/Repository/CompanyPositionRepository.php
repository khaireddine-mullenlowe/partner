<?php

namespace PartnerBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use PartnerBundle\Enum\OperatorEnum;

class CompanyPositionRepository extends EntityRepository
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param array|int$departments
     * @param string $operator
     * @return QueryBuilder
     */
    public function applyFilterDepartment(QueryBuilder $queryBuilder, $departments, $operator)
    {
        $queryBuilder->innerJoin('cp.departments', 'd');
        if (is_array($departments)) {
            $condition = sprintf('d.id %s (:parameter)', OperatorEnum::getDoctrineToArray($operator));
        } else {
            $condition = sprintf('d.id %s :parameter', OperatorEnum::getValue($operator));
        }

        $queryBuilder->andWhere($condition)->setParameter('parameter', $departments);

        return $queryBuilder;
    }
}
