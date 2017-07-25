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

        $responseData = $this->requestJson(200, 'POST', '/api/v1/partner', [], [], [], $data);
        $this->assertEquals('ESPACE PREMIUM', $responseData['commercialName']);
        $this->assertListContainsArrayWithKeyValue(1673, 'myaudiUserId', $responseData['myaudiUsers']);
        $this->assertListContainsArrayWithKeyValue(1674, 'myaudiUserId', $responseData['myaudiUsers']);
        $this->assertArrayHasKey('id', $responseData);

        return $responseData['id'];
    }

    /**
     * @depends testPostPartner
     */
    public function testGetPartnerByRegistryUserId()
    {
        $responseData = $this->requestJson(200, 'GET', '/api/v1/partner/user/673');
        $this->assertEquals('ESPACE PREMIUM', $responseData['commercialName']);
        $this->assertListContainsArrayWithKeyValue(673, 'registryUserId', $responseData['registryUsers']);
    }

    /**
     * @depends testGetPartnerByRegistryUserId
     */
    public function testGetPartnerByMyaudiUserId()
    {
        $responseData = $this->requestJson(200, 'GET', '/api/v1/partner/myaudiuser/1673');
        $this->assertEquals('ESPACE PREMIUM', $responseData['commercialName']);
        $this->assertListContainsArrayWithKeyValue(1673, 'myaudiUserId', $responseData['myaudiUsers']);
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

        $responseData = $this->requestJson(200, 'PUT', '/api/v1/partner/'.$partnerId, [], [], [], $data);
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
        $responseData = $this->requestJson(200, 'GET', '/api/v1/partner/'.$partnerId);
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
        $responseData = $this->requestJson(200, 'DELETE', '/api/v1/partner/'.$partnerId);
        $this->assertEquals(true, $responseData['success']);

        return $partnerId;
    }

    /**
     * @depends testRemovePartner
     */
    public function testGetParnterWhenNotFound($partnerId)
    {
        $responseData = $this->requestJson(404, 'GET', '/api/v1/partner/'.$partnerId);
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

    protected function requestJson($expectedStatusCode, $method, $uri, $parameters = [], $files = [], $server = [], $content = null)
    {
        static::$client->request($method, $uri, $parameters, $files, $server, $content);
        $response =  static::$client->getResponse();
        $this->assertSame($expectedStatusCode, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());

        return json_decode($response->getContent(), true);
    }
}
