<?php
namespace PartnerBundle\Controller;

use Codeception\Util\HttpCode;

class PartnerRegistryUserControllerCest
{
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
}
