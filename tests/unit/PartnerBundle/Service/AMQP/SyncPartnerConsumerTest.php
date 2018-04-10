<?php

namespace PartnerBundle\Tests\Service\AMQP;

use Codeception\Stub;
use PartnerBundle\Service\Sync\AMQP\SyncPartnerConsumer;
use PartnerBundle\Service\Sync\SyncPartner;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\NullLogger;

/**
 * Class SyncPartnerConsumerTest
 * @package PartnerBundle\Tests\Service\AMQP
 */
class SyncPartnerConsumerTest extends \Codeception\Test\Unit
{
    /**
     * Tests execute method
     */
    public function testExecute()
    {
        /** @var SyncPartner $syncPartner */
        $syncPartner = Stub::makeEmpty(SyncPartner::class);
        $syncPartnerConsumer = new SyncPartnerConsumer($syncPartner, new NullLogger());

        $message = new AMQPMessage('invalid message');

        $this->assertEquals(-1, $syncPartnerConsumer->execute($message));

        // valid message with token included
        $message = new AMQPMessage(json_encode([
            'data' => [
                'token' => 'a5DmldF8e5Fjdcs',
                'myaudiUserId' => '1',
            ],
        ]));

        $this->assertEquals(1, $syncPartnerConsumer->execute($message));
    }
}