<?php
namespace PartnerBundle\Controller;

use Codeception\Util\HttpCode;

class PartnerRegistryUserControllerCest
{
    private $parterRegitryUserData = <<<HEREDOC
{
  "partner": 1,
  "registryUserId": 3
}
HEREDOC;

    public function tryToGetAnExistingPartnerRegistryUser(\FunctionalTester $I)
    {
        $I->sendGet('/registry/1');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerRegistryUser']);
        $I->seeResponseContains('data');
        $I->seeResponseJsonMatchesJsonPath('$..id');
        $I->seeResponseJsonMatchesJsonPath('$..partner');
        $I->seeResponseJsonMatchesJsonPath('$..registryUserId');
    }

    public function tryToGetANonExistingPartnerRegistryUser(\FunctionalTester $I)
    {
        $I->sendGet('/registry/10000');
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerRegistryUser']);
        $I->seeResponseContains('errors');
        $I->seeResponseContains('PartnerRegistryUser not found');
    }

    public function tryToPostANonExistingPartnerRegistryUser(\FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/registry/', $this->parterRegitryUserData);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerRegistryUser']);
        $I->seeResponseContains('data');
        $I->seeResponseJsonMatchesJsonPath('$..id');
        $I->seeResponseJsonMatchesJsonPath('$..partner');
        $I->seeResponseJsonMatchesJsonPath('$..registryUserId');
    }

    public function tryToPostAnExistingPartnerRegistryUser(\FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/registry/', $this->parterRegitryUserData);
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerRegistryUser']);
        $I->seeResponseContains('errors');
        $I->seeResponseContains('This RegistryUser is already bound to this Partner with the same Department and Position');
    }
}
