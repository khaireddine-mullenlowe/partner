<?php

namespace PartnerBundle\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use FOS\ElasticaBundle\Doctrine\Listener;
use PartnerBundle\Entity\Company;
use PartnerBundle\Entity\CompanyDepartment;
use PartnerBundle\Entity\CompanyPosition;
use PartnerBundle\Entity\CompanyPositionCode;

class ElasticaCompanyRegistryUserListener extends Listener implements EventSubscriber
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
        $this->syncRegistryUserIndex($args->getObject(), true);
    }

    /**
     * Synchronize RegistryUser Index on update / remove child.
     * @param mixed     $entity
     * @param boolean   $delete
     */
    private function syncRegistryUserIndex($entity, $delete = false)
    {
        if (
            in_array(
                get_class($entity),
                [
                    Company::class,
                    CompanyDepartment::class,
                    CompanyPosition::class,
                    CompanyPositionCode::class,
                ]
            )
        ) {
            $this->syncScheduled($entity->getCompanyRegistryUsers()->toArray(), $delete);
        }
    }

    /**
     * Record dependencies for update or remove from indexes.
     * @param array     $items
     * @param bool      $delete
     */
    private function syncScheduled(array $items, $delete = false)
    {
        if ($delete) {
            $this->scheduledForDeletion = array_merge($this->scheduledForDeletion, array_column($items, 'id'));
        } else {
            $this->scheduledForUpdate = array_merge($this->scheduledForUpdate, $items);
        }
    }
}
