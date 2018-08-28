<?php

namespace PartnerBundle\Service\Sync\AMQP;

use PartnerBundle\Service\Sync\SyncPartner;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

/**
 * Class SyncPartnerConsumer
 * @package PartnerBundle\Service\Sync\AMQP
 */
class SyncPartnerConsumer implements ConsumerInterface
{
    /**
     * @var SyncPartner
     */
    private $syncPartner;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * SyncPartnerConsumer constructor.
     *
     * @param SyncPartner     $syncPartner
     * @param LoggerInterface $logger
     */
    public function __construct(SyncPartner $syncPartner, LoggerInterface $logger)
    {
        $this->syncPartner = $syncPartner;
        $this->logger = $logger;
    }

    /**
     * @param AMQPMessage $msg
     *
     * @return int
     */
    public function execute(AMQPMessage $msg)
    {
        $message = json_decode($msg->getBody(), true);

        foreach (['token', 'myaudiUserId'] as $item) {
            if (!isset($message['data'][$item])) {
                return ConsumerInterface::MSG_REJECT;
            }
        }

        $data = $message['data'];

        try {
            $this->syncPartner->sync($data['myaudiUserId'], $data['token']);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return ConsumerInterface::MSG_REJECT;
        }

        return ConsumerInterface::MSG_ACK;
    }
}
