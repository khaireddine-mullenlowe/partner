<?php

namespace PartnerBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PartnerBundle\Entity\Partner;

/**
 * PartnerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PartnerRepository extends EntityRepository
{
    const CDV = 'CDV';

    /**
     * @param integer $myaudiUserId
     * @return null|Partner
     */
    public function findOneByMyaudiUserId($myaudiUserId)
    {
        $result = $this->createQueryBuilder('p')
            ->addSelect('p')
            ->innerJoin('p.myaudiUsers', 'u')
            ->add('where', 'u.myaudiUserId=:myaudi_user_id')
            ->setParameter('myaudi_user_id', $myaudiUserId)
            ->getQuery()
            ->getResult();

        if (isset($result[0])) {
            return $result[0];
        }

        return null;
    }

    /**
     * @param integer $registryUserId
     * @return null|Partner
     */
    public function findOneByRegistryUserId($registryUserId)
    {
        $result = $this->createQueryBuilder('p')
            ->addSelect('p')
            ->innerJoin('p.registryUsers', 'u')
            ->add('where', 'u.registryUserId=:registry_user_id')
            ->setParameter('registry_user_id', $registryUserId)
            ->getQuery()
            ->getResult();

        if (isset($result[0])) {
            return $result[0];
        }

        return null;
    }

    /**
     * @param int|null    $registryUserId
     * @param int|null    $myaudiUserId
     * @param string|null $partnerIds
     * @return \Doctrine\ORM\Query
     */
    public function findPartnersByCustomFilters(array $filters)
    {
        $queryBuilder = $this->createQueryBuilder('partner');

        if (isset($filters['registryUserId'])) {
            $queryBuilder
                ->join('partner.partnerRegistryUsers', 'partnerRegistryUsers')
                ->andWhere('partnerRegistryUsers.registryUserId = :registryUserId')
                ->setParameter('registryUserId', $filters['registryUserId']);

            $queryBuilder
                ->join('partner.companyRegistry')
        }

        if (isset($filters['contractNumber'])) {
            $queryBuilder
                ->andWhere('partner.contractNumber= :contractNumber')
                ->setParameter('contractNumber', $filters['contractNumber']);
        }

        if (isset($filters['myaudiUserId'])) {
            $queryBuilder
                ->join('partner.myaudiUsers', 'myaudiUsers')
                ->andWhere('myaudiUsers.myaudiUserId = :myaudiUserId')
                ->setParameter('myaudiUserId', $filters['myaudiUserId']);
        }

        if (isset($filters['partnerIds'])) {
            $ids = explode(',', $filters['partnerIds']);
            $queryBuilder
                ->andWhere('partner.id IN (:ids)')
                ->setParameter('ids', $ids);
        }

        if (isset($filters['region'])) {
            $queryBuilder
                ->andWhere('partner.region = :region')
                ->setParameter('region', $filters['region']);
        }

        if (isset($filters['district'])) {
            $queryBuilder
                ->andWhere('partner.district = :district')
                ->setParameter('district', $filters['district']);
        }

        return $queryBuilder->getQuery();
    }
}
