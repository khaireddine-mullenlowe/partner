<?php

namespace PartnerBundle\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use FOS\ElasticaBundle\Doctrine\Listener;
use PartnerBundle\Entity\CompanyDepartment;
use PartnerBundle\Entity\CompanyPosition;
use PartnerBundle\Entity\CompanyPositionCode;
use PartnerBundle\Entity\District;
use PartnerBundle\Entity\Partner;
use PartnerBundle\Entity\Region;

class ElasticaPartnerRegistryUserListener extends Listener implements EventSubscriber
{
    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return ['postUpdate', 'preRemove', 'postFlush'];
    }

    /**
     * Force update indexes post Update.
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->syncRegistryUserIndex($args->getObject());
    }

    /**
     * Force update indexes preRemove.
     * @param LifecycleEventArgs $args
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $this->syncRegistryUserIndex($args->getObject());
    }

    /**
     * Synchronize RegistryUser Index on update / remove child.
     * @param mixed $entity
     */
    private function syncRegistryUserIndex($entity)
    {
        if (
            in_array(
                get_class($entity),
                [
                    Region::class, District::class,
                    CompanyDepartment::class,
                    CompanyPosition::class,
                    CompanyPositionCode::class,
                    Partner::class,
                ]
            )
        ) {
            $this->scheduledForUpdate = array_merge($this->scheduledForUpdate, $entity->getPartnerRegistryUsers()->toArray());
        }
    }
}
