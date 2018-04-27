<?php

namespace PartnerBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class CompanyRepository
 * @package PartnerBundle\Repository
 */
class CompanyRepository extends EntityRepository
{
    /**
     * Finds companies by criteria
     *
     * @param int $type
     *
     * @return mixed
     */
    public function findByCustomFilters(int $type = null)
    {
        $queryBuilder = $this->createQueryBuilder('company');

        if (isset($type)) {
            $queryBuilder->andWhere('company.type = :type')->setParameter('type', $type);
        }

        return $queryBuilder->getQuery()->execute();
    }
}
