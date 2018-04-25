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
     * @param array $criteria
     *
     * @return mixed
     */
    public function findByCriteria(array $criteria = [])
    {
        $queryBuilder = $this->createQueryBuilder('company');

        if (isset($criteria['type'])) {
            $queryBuilder->andWhere('company.type = :type')->setParameter('type', $criteria['type']);
        }

        return $queryBuilder->getQuery()->execute();
    }
}
