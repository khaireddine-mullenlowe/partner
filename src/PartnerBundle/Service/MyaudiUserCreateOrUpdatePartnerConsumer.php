<?php

namespace PartnerBundle\Service;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PartnerBundle\Entity\Partner;
use PhpAmqpLib\Message\AMQPMessage;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;

/**
 * Class MyaudiUserUpdatePartnerConsumer
 *
 * @package PartnerBundle\Service
 */
class MyaudiUserCreateOrUpdatePartnerConsumer implements ConsumerInterface
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var $logger
     */
    protected $logger;

    /**
     * MyaudiUserUpdateProfileConsumer constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->em = $em;
    }

    public function execute(AMQPMessage $msg)
    {
        $SerializedData = $msg->getBody();
        // unserialize
        $jsonData = unserialize($SerializedData);
        // json decode
        $data = json_decode($jsonData);

        if ($data) {
            if (isset($data->partner_response)) {
                // contains sales and aftersales partner information
                $partnerDatas = $data->partner_response;

                foreach ($partnerDatas as $typePartner => $partnerData) {
                    $this->logger->info(sprintf("[Consumer] Reading messages to update partner %s (__CLASS__): %s", $typePartner, json_encode($data)));

                    if ($typePartner == 'partner_response') {
                        $type = Partner::SALES_TYPE;
                    } else {
                        $type = Partner::AFTERSALES_TYPE;
                    }

                    $partner = $this->em
                        ->getRepository("PartnerBundle:Partner")
                        ->findOneBy(["legacyPartnerId" => $partnerData->id_partner]);

                    // create partner user
                    if (!$partner) {
                        $partner = new Partner();
                    }

                    $partner->setType($type);
                    $partner->setCommercialName($partnerData->commercial_name);
                    $partner->setContractNumber($partnerData->contract_number);
                    $partner->setLegacyPartnerId($partnerData->id_partner);

                    $partner->setIsEtron($partnerData->etron);
                    $partner->setIsOccPlus($partnerData->occ_plus);
                    $partner->setIsPartnerR8($partnerData->partner_r8);
                    $partner->setIsTwinService($partnerData->twin_service);
                    $partner->setWebSite($partnerData->website);

                    if (isset($partnerData->kvps_number)) {
                        $partner->setKvpsNumber($partnerData->kvps_number);
                    }

                    $this->em->persist($partner);
                    $this->em->flush();
                }
            } else {
                $this->logger->info(sprintf("[Consumer] No data to update partner (__CLASS__)"));
            }
        } else {
            throw new \InvalidArgumentException("[Consumer] Update Profile Data is empty and can't be processed (__CLASS__)");
        }
    }
}
