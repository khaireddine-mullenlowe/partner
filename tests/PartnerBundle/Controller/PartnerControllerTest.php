<?php

namespace PartnerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PartnerControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $this->markTestSkipped('Unused');

        $client = static::createClient();

        $crawler = $client->request('GET', '/partner/');

        $this->assertContains('Hello World', $client->getResponse()->getContent());
    }
}
