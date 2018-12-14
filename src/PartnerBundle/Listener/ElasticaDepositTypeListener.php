<?php

namespace PartnerBundle\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use FOS\ElasticaBundle\Doctrine\Listener;
use PartnerBundle\Entity\DepositType;
use PartnerBundle\Entity\Partner;

/**
 * Class ElasticaDepositTypeListener
 * @package PartnerBundle\Listener
 */
class ElasticaDepositTypeListener extends Listener implements EventSubscriber
{
    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return ['prePersist', 'postUpdate', 'postFlush'];
    }

    /**
     * Force update indexes pre Persist.
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!($entity instanceof DepositType) || !(($partner = $entity->getPartner()) instanceof Partner)
        ) {
            return;
        }

        $partner->setDepositType($entity);
    }

    /**
     * Force update indexes post Update.
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->syncIndex($args->getObject());
    }

    /**
     * Synchronize RegistryUser Index on update / remove child.
     * @param mixed $entity
     */
    private function syncIndex($entity)
    {
        if ($entity instanceof DepositType) {
            $this->scheduledForUpdate = array_merge($this->scheduledForUpdate, [$entity->getPartner()]);
        }
    }
}
