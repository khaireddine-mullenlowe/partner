<?php
namespace PartnerBundle\Tests\Controller;

class PartnerControllerCest
{
    protected static $jsonPartner = <<<HEREDOC
{
    "isTwinService": false,
    "commercialName": "ESPACE PREMIUM",
    "webSite": "http://www.espace-premium-lorient.fr/",
    "contractNumber": "01002047",
    "legacyId": 123456,
    "kvpsNumber": "FRAA01931",
    "isOccPlus": true,
    "isPartnerR8": false,
    "registryUsers": [
        {
            "registryUserId": 6736666
        },
        {
            "registryUserId": 6746666
        }
    ],
    "isEtron": true,
    "myaudiUsers": [
        {
            "myaudiUserId": 16739999
        },
        {
            "myaudiUserId": 16749999
        }
    ],
    "type": "sales",
    "isPartnerPlus": false
}
HEREDOC;


    protected static $jsonPartner2  = <<<HEREDOC
{
    "isTwinService": false,
    "commercialName": "NEW ESPACE PREMIUM",
    "webSite": "http://www.espace-premium-lorient.fr/",
    "legacyId": 1234567,
    "contractNumber": "01002047",
    "kvpsNumber": "FRAA01931",
    "isOccPlus": true,
    "isPartnerR8": false,
    "registryUsers": [
        {
            "registryUserId": 9996730
        },
        {
            "registryUserId": 9996740
        }
    ],
    "isEtron": true,
    "myaudiUsers": [
        {
            "myaudiUserId": 9916730
        },
        {
            "myaudiUserId": 9991674
        }
    ],
    "type": "sales",
    "isPartnerPlus": false
}
HEREDOC;

    protected $createdPartnerId;

    public function testPostPartner(\FunctionalTester $I)
    {
        $this->requestJson($I,201, 'POST', '/', [], [], [], static::$jsonPartner);
        $I->seeResponseContainsJson(['context' => 'partner']);
        $I->seeResponseContains('data');
        $this->createdPartnerId = $I->grabDataFromResponseByJsonPath('$..id')[0];
    }

    /**
     * @depends testPostPartner
     */
    public function testPutPartner(\FunctionalTester $I)
    {
        $this->requestJson($I,200, 'PUT', '/'.$this->createdPartnerId, [], [], [], static::$jsonPartner2);
        $I->seeResponseContainsJson(['context' => 'partner']);
        $I->seeResponseContains('data');
    }

    /**
     * @depends testPutPartner
     */
    public function testGetPartner(\FunctionalTester $I)
    {
        $this->requestJson($I,200, 'GET', '/'.$this->createdPartnerId);
        $I->seeResponseContainsJson(['context' => 'partner']);
        $I->seeResponseContains('data');
    }

    /**
     * @depends testGetPartner
     */
    public function testRemovePartner(\FunctionalTester $I)
    {
        $this->requestJson($I, 200, 'DELETE', '/'.$this->createdPartnerId);
        $I->seeResponseContainsJson(['context' => 'partner']);
    }

    /**
     * @depends testRemovePartner
     */
    public function testGetParnterWhenNotFound(\FunctionalTester $I)
    {
        $this->requestJson($I,404, 'GET', '/'.$this->createdPartnerId);
        $I->seeResponseContainsJson(["message" => "Partner not found"]);
    }

    protected function requestJson(\FunctionalTester $I, $expectedStatusCode, $method, $uri, $parameters = [], $files = [], $server = [], $content = [])
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->{"send".$method}($uri, $content, $parameters);
        $I->seeResponseCodeIs($expectedStatusCode);
        $I->seeResponseIsJson();
    }
}
