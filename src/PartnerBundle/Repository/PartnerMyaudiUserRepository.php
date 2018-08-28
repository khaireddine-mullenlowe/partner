<?php

namespace PartnerBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class PartnerMyaudiUserRepository
 * @package PartnerBundle\Repository
 */
class PartnerMyaudiUserRepository extends EntityRepository
{
    /**
     * @param int $myaudiUserId
     * @param string $partnerType
     * @return array|null
     */
    public function getSingleResult(int $myaudiUserId, string $partnerType)
    {
        return $this
            ->createQueryBuilder('pmu')
            ->andWhere('pmu.myaudiUserId = :myaudiUserId')
            ->setParameter('myaudiUserId', $myaudiUserId)
            ->innerJoin('pmu.partner', 'p')
            ->andWhere('p.type = :partnerType')
            ->setParameter('partnerType', $partnerType)
            ->getQuery()
            ->execute();
    }

    /**
     * @param array $filters
     * @return QueryBuilder
     */
    public function applyFilters(array $filters)
    {
        $builder = $this->createQueryBuilder('pmu');

        if (!empty($filters['myaudiUserId'])) {
            $builder
                ->andWhere('pmu.myaudiUserId = :myaudiUserId')
                ->setParameter('myaudiUserId', $filters['myaudiUserId']);
        } elseif (!empty($filters['myaudiUserIds'])) {
            $myaudiUserIds = explode(',', $filters['myaudiUserIds']);
            $builder
                ->andWhere($builder->expr()->in('pmu.myaudiUserId', ':myaudiUserIds'))
                ->setParameter('myaudiUserIds', $myaudiUserIds);
        }

        if (!empty($filters['partnerType'])) {
            $builder
                ->innerJoin('pmu.partner', 'p')
                ->andWhere('p.type = :partnerType')
                ->setParameter('partnerType', $filters['partnerType']);
        }

        return $builder;
    }
}
