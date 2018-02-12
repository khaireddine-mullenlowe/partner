<?php
namespace PartnerBundle\Controller;

use Codeception\Util\HttpCode;


class CompanyRegistryUserControllerCest
{
    public function tryToGetAnExistingCompanyRegistryUser(\FunctionalTester $I)
    {
        $I->sendGet('/company/registry/1');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'CompanyRegistryUser']);
        $I->seeResponseContains('data');
        $I->seeResponseJsonMatchesJsonPath('$..id');
        $I->seeResponseJsonMatchesJsonPath('$..company');
        $I->seeResponseJsonMatchesJsonPath('$..registryUserId');
    }

    public function tryToGetANonExistingCompanyRegistryUser(\FunctionalTester $I)
    {
        $I->sendGet('/company/registry/10000');
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'CompanyRegistryUser']);
        $I->seeResponseContains('errors');
        $I->seeResponseContains('CompanyRegistryUser not found');
    }
}
