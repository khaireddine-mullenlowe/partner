<?php

namespace PartnerBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use PartnerBundle\Enum\OperatorEnum;

class RegionRepository extends EntityRepository
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param string $partnerType
     * @param string $operator
     * @return QueryBuilder
     */
    public function applyFilterPartnerType(QueryBuilder $queryBuilder, $partnerType, $operator)
    {
        if (null === $partnerType) {
            return $queryBuilder;
        }

        $condition = sprintf('r.partnerType %s :partnerType', OperatorEnum::getValue($operator));
        $queryBuilder->andWhere($condition)->setParameter('partnerType', $partnerType);

        return $queryBuilder;
    }
}
