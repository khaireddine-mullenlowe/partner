<?php

namespace PartnerBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use PartnerBundle\Enum\OperatorEnum;

class DistrictRepository extends EntityRepository
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param string $regionId
     * @param string $operator
     * @return QueryBuilder
     */
    public function applyFilterRegion(QueryBuilder $queryBuilder, $regionId, $operator)
    {
        if (null === $regionId) {
            return $queryBuilder;
        }

        $condition = sprintf('d.region %s :region', OperatorEnum::getValue($operator));
        $queryBuilder->andWhere($condition)->setParameter('region', $regionId);

        return $queryBuilder;
    }
}
