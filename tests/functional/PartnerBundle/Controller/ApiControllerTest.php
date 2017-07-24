<?php
namespace PartnerBundle\Tests\Controller;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader as DataFixturesLoader;
use Doctrine\ORM\Tools\SchemaTool;

class ApiControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    protected static $client;

    public static function setUpBeforeClass()
    {
        static::$client = static::createClient();
    }

    public function testGetPartnerByRegistryUserId()
    {
        static::$client->request('GET', '/api/v1/partner/user/47');
        $response = static::$client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals('GARAGE CLERFOND SARL', $responseData['commercialName']);
        $this->assertListContainsArrayWithKeyValue(47, 'registryUserId', $responseData['registryUsers']);
    }

    public function testGetPartnerByMyaudiUserId()
    {
        static::$client->request('GET', '/api/v1/partner/myaudiuser/55');
        $response = static::$client->getResponse();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals('GARAGE CLERFOND SARL', $responseData['commercialName']);
        $this->assertListContainsArrayWithKeyValue(55, 'myaudiUserId', $responseData['myaudiUsers']);
    }

    public function testPostPartner()
    {
        $data = <<<HEREDOC
{
    "isTwinService": false,
    "commercialName": "ESPACE PREMIUM",
    "webSite": "http://www.espace-premium-lorient.fr/",
    "partnerId": 123456,
    "contractNumber": "01002047",
    "kvpsNumber": "FRAA01931",
    "isOccPlus": true,
    "isPartnerR8": false,
    "registryUsers": [
        {
            "registryUserId": 673
        },
        {
            "registryUserId": 674
        }
    ],
    "isEtron": true,
    "myaudiUsers": [
        {
            "myaudiUserId": 1673
        },
        {
            "myaudiUserId": 1674
        }
    ],
    "type": "sales",
    "isPartnerPlus": false,
    "addresses": [
        {
            "addressId": 2
        }
    ]
}
HEREDOC;

        static::$client->request('POST', '/api/v1/partner', [], [], [], $data);
        $response = static::$client->getResponse();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals('ESPACE PREMIUM', $responseData['commercialName']);
        $this->assertListContainsArrayWithKeyValue(1673, 'myaudiUserId', $responseData['myaudiUsers']);
        $this->assertListContainsArrayWithKeyValue(1674, 'myaudiUserId', $responseData['myaudiUsers']);
        $this->assertArrayHasKey('id', $responseData);

        return $responseData['id'];
    }

    /**
     * @depends testPostPartner
     */
    public function testPutPartner($partnerId)
    {
        $data = <<<HEREDOC
{
    "isTwinService": false,
    "commercialName": "NEW ESPACE PREMIUM",
    "webSite": "http://www.espace-premium-lorient.fr/",
    "partnerId": 1234567,
    "contractNumber": "01002047",
    "kvpsNumber": "FRAA01931",
    "isOccPlus": true,
    "isPartnerR8": false,
    "registryUsers": [
        {
            "registryUserId": 6730
        },
        {
            "registryUserId": 6740
        }
    ],
    "isEtron": true,
    "myaudiUsers": [
        {
            "myaudiUserId": 16730
        },
        {
            "myaudiUserId": 1674
        }
    ],
    "type": "sales",
    "isPartnerPlus": false,
    "addresses": [
        {
            "addressId": 2
        }
    ]
}
HEREDOC;

        static::$client->request('PUT', '/api/v1/partner/'.$partnerId, [], [], [], $data);
        $response = static::$client->getResponse();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals('NEW ESPACE PREMIUM', $responseData['commercialName']);
        $this->assertListContainsArrayWithKeyValue(16730, 'myaudiUserId', $responseData['myaudiUsers']);
        $this->assertListContainsArrayWithKeyValue(1674, 'myaudiUserId', $responseData['myaudiUsers']);

        return $partnerId;
    }

    /**
     * @depends testPutPartner
     */
    public function testGetPartner($partnerId)
    {
        static::$client->request('GET', '/api/v1/partner/'.$partnerId);
        $response = static::$client->getResponse();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals('NEW ESPACE PREMIUM', $responseData['commercialName']);
        $this->assertListContainsArrayWithKeyValue(16730, 'myaudiUserId', $responseData['myaudiUsers']);
        $this->assertListContainsArrayWithKeyValue(1674, 'myaudiUserId', $responseData['myaudiUsers']);

        return $partnerId;
    }


    /**
     * @depends testGetPartner
     */
    public function testRemovePartner($partnerId)
    {
        static::$client->request('DELETE', '/api/v1/partner/'.$partnerId);
        $response = static::$client->getResponse();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(true, $responseData['success']);

        return $partnerId;
    }

    /**
     * @depends testRemovePartner
     */
    public function testGetParnterWhenNotFound($partnerId)
    {
        static::$client->request('GET', '/api/v1/partner/'.$partnerId);
        $response = static::$client->getResponse();

        $this->assertSame(404, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals('Partner not found', $responseData['message']);

        return $partnerId;
    }

    /**
     * @param mixed  $value
     * @param string $key
     * @param array  $list
     */
    protected function assertListContainsArrayWithKeyValue($value, string $key, array $list)
    {
        foreach ($list as $array) {
            if (isset($array[$key]) && $value == $array[$key]) {
                return $this->assertEquals($value, $array[$key]);
            }
        }
        $this->fail(sprintf("Fail asserting that a list contains an array with [%s => %s]", $key, $value));
    }
}
