<?php

namespace PartnerBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class AftersalesServiceRepository
 * @package PartnerBundle\Repository
 */
class AftersalesServiceRepository extends EntityRepository
{
    /**
     * Get Aftersales Services types
     *
     * @return array
     */
    public function getTypes()
    {
        $result = $this->createQueryBuilder('aftersales_service')
            ->select('aftersales_service.type')
            ->distinct()
            ->getQuery()
            ->execute();

        return array_map(function ($item) {
            return $item['type'];
        }, $result);
    }
}
