<?php

namespace PartnerBundle\Service;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class MyaudiUserUpdatePartnerConsumer implements ConsumerInterface
{

    public function execute(AMQPMessage $msg)
    {
    }
}
