<?php
namespace CompanyBundle\Controller;

use Codeception\Util\HttpCode;


class CompanyRegistryUserControllerCest
{
    public function tryToGetDefaultCompanyRegistryCollection(\FunctionalTester $I)
    {
        $I->sendGet('/company/registry/');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'CompanyRegistryUser']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
        $I->seeResponseJsonMatchesJsonPath('$..id');
        $I->seeResponseJsonMatchesJsonPath('$..company');
        $I->seeResponseJsonMatchesJsonPath('$..registryUserId');
    }

    public function tryToGetDefaultCompanyRegistryCollectionWithoutPagination(\FunctionalTester $I)
    {
        $I->sendGet('/company/registry/?paginate=0');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'CompanyRegistryUser']);
        $I->seeResponseContains('data');
        $I->dontSeeResponseContains('pagination');
        $I->seeResponseJsonMatchesJsonPath('$..id');
        $I->seeResponseJsonMatchesJsonPath('$..company');
        $I->seeResponseJsonMatchesJsonPath('$..registryUserId');
    }

    public function tryToGetARegistryUserIdFilteredAndNonEmptyCompanyRegistryCollection(\FunctionalTester $I)
    {
        $I->sendGet('/company/registry/?registryUserId=1');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'CompanyRegistryUser']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
        $I->seeResponseJsonMatchesJsonPath('$..id');
        $I->seeResponseJsonMatchesJsonPath('$..company');
        $I->seeResponseJsonMatchesJsonPath('$..registryUserId');
    }

    public function tryToGetARegistryUserIdFilteredAndEmptyCompanyRegistryCollection(\FunctionalTester $I)
    {
        $I->sendGet('/company/registry/?registryUserId=99999999');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'CompanyRegistryUser']);
        $I->seeResponseContainsJson(['data' => []]);
        $I->seeResponseContains('pagination');
    }

    public function tryToGetARegistryUserIdsFilteredAndNonEmptyCompanyRegistryCollection(\FunctionalTester $I)
    {
        $I->sendGet('/company/registry/?registryUserIds=1,2');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'CompanyRegistryUser']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].id');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].company');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].registryUserId');
        $I->seeResponseJsonMatchesJsonPath('$.data[1].id');
        $I->seeResponseJsonMatchesJsonPath('$.data[1].company');
        $I->seeResponseJsonMatchesJsonPath('$.data[1].registryUserId');
    }

    public function tryToGetARegistryUserIdsFilteredAndMixedEmptyCompanyRegistryCollection(\FunctionalTester $I)
    {
        $I->sendGet('/company/registry/?registryUserIds=1,99999999');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'CompanyRegistryUser']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].id');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].company');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].registryUserId');
        $I->dontSeeResponseJsonMatchesJsonPath('$.data[1].id');
        $I->dontSeeResponseJsonMatchesJsonPath('$.data[1].company');
        $I->dontSeeResponseJsonMatchesJsonPath('$.data[1].registryUserId');
    }

    public function tryValidateInvalidCompanyRegistryUser(\FunctionalTester $I)
    {
        $I->wantTo('get an error when trying to post an invalid company registry user');
        $I->sendPOST('/company/registry/validate/', ['company' => 0]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); // 400
        $I->seeResponseIsJson();
    }

    public function tryValidateCompanyRegistryUser(\FunctionalTester $I)
    {
        $I->wantTo('get a successful response when trying to validate a correct company registry user');
        $I->sendPOST('/company/registry/validate/', ['company' => 1, 'registryUserId' => 3, 'department' => 1, 'position' => 1]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::NO_CONTENT); // 204
        $I->seeResponseEquals('');
    }

    public function tryToPutCompanyRegistryUser(\FunctionalTester $I)
    {
        $I->wantTo('get a successful response when trying to edit a correct company registry user');
        $I->sendPUT('/company/registry/1', ['company' => 1, 'registryUserId' => 3, 'department' => 1, 'position' => 1]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'CompanyRegistryUser']);
        $I->seeResponseContains('data');
    }

    public function tryToDeleteCompanyRegistryUser(\FunctionalTester $I)
    {
        $I->wantTo('delete a company registry user');
        $I->sendDELETE('/company/registry/1');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('The resource has been deleted.');
    }
}
