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
        $em = static::getEntityManager();
        $metadatas = $em->getMetadataFactory()->getAllMetadata();

        $schema = new SchemaTool($em);
        $schema->dropDatabase();
        $schema->createSchema($metadatas);

        $loader = new DataFixturesLoader(self::$kernel->getContainer());
        $loader->loadFromFile(self::$kernel->getBundle('PartnerBundle')->getPath().'/DataFixtures/ORM/LoadAppsData.php');
        $fixtures = $loader->getFixtures();
        $purger = new ORMPurger($em);
        $executor = new ORMExecutor($em, $purger);
        $executor->execute($fixtures);
    }

    public function testGetPartnerByRegistryUserId()
    {
        static::$client->request('GET', '/api/v1/partner/user/47');
        $response = static::$client->getResponse();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(1, $responseData['id']);
    }

    /**
     * @return EntityManager
     */
    protected static function getEntityManager()
    {
        return static::getService('doctrine.orm.entity_manager');
    }

    protected static function getService($id)
    {
        return self::$kernel->getContainer()->get($id);
    }
}




