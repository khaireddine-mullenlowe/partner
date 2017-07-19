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
