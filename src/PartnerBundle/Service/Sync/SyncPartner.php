<?php

namespace PartnerBundle\Service\Sync;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Mullenlowe\PluginsBundle\Service\Wega\WegaSoapClient;
use PartnerBundle\Entity\Partner;
use PartnerBundle\Entity\PartnerMyaudiUser;

/**
 * Class SyncPartner
 * @package PartnerBundle\Service\Sync
 */
class SyncPartner
{
    /**
     * @var string
     */
    const WEGA_SALES_PARTNER_KEY = 'Dealer_DealerId';
    /**
     * @var string
     */
    const WEGA_AFTERSALES_PARTNER_KEY = 'AfterSalesDealer_DealerId';

    /**
     * @var WegaSoapClient
     */
    private $client;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * SyncPartner constructor.
     *
     * @param WegaSoapClient         $client
     * @param EntityManagerInterface $manager
     */
    public function __construct(
        WegaSoapClient $client,
        EntityManagerInterface $manager
    ) {
        $this->client = $client;
        $this->manager = $manager;
    }

    /**
     * Synchronizes wega partners with database
     *
     * @param int    $myaudiUserId
     * @param string $token
     */
    public function sync(int $myaudiUserId, string $token)
    {
        $partnersData = $this->client->getPartners($token);

        // sync sales partner
        if (!empty($partnersData[self::WEGA_SALES_PARTNER_KEY])) {
            $this->syncPartner($partnersData[self::WEGA_SALES_PARTNER_KEY], $myaudiUserId);
        }

        // sync afterSales partner
        if (!empty($partnersData[self::WEGA_AFTERSALES_PARTNER_KEY])) {
            $this->syncPartner($partnersData[self::WEGA_AFTERSALES_PARTNER_KEY], $myaudiUserId);
        }

        $this->manager->flush();
        $this->manager->clear();
    }

    /**
     * Synchronizes a partner with a myaudi user
     *
     * @param string $partnerId
     * @param int    $myaudiUserId
     *
     * @return void
     * @throws EntityNotFoundException
     */
    private function syncPartner($partnerId, int $myaudiUserId)
    {
        // get partner from database
        $partner = $this->manager->getRepository('PartnerBundle:Partner')->find($partnerId);

        if ($partner instanceof Partner) {
            $partnerMyaudiUser = $this->manager->getRepository('PartnerBundle:PartnerMyaudiUser')->findOneBy([
                'myaudiUserId' => $myaudiUserId,
                'partner' => $partner,
            ]);

            // create relation between partner and myaudi user if it does not exist
            if (null === $partnerMyaudiUser) {
                $partnerMyaudiUser = new PartnerMyaudiUser($partner, $myaudiUserId);
                $this->manager->persist($partnerMyaudiUser);
            }

            return;
        }

        throw new EntityNotFoundException(sprintf('Partner entity not found (id %s).', $partnerId));
    }
}
