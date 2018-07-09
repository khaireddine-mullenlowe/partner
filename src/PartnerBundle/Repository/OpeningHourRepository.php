<?php

namespace PartnerBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class OpeningHourRepository
 * @package PartnerBundle\Repository
 */
class OpeningHourRepository extends EntityRepository
{
    /**
     * @param array $filters
     * @return QueryBuilder
     */
    public function applyFilters(array $filters)
    {
        $builder = $this->createQueryBuilder('oh');

        if (!empty($filters['partnerId'])) {
            $builder
                ->andWhere('oh.partner = :partnerId')
                ->setParameter('partnerId', $filters['partnerId'])
                ->orderBy('oh.id', 'ASC')
            ;
        }

        return $builder;
    }
}
