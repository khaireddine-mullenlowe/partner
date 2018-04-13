<?php
namespace PartnerBundle\Controller;

use Codeception\Util\HttpCode;

class PartnerRegistryUserControllerCest
{
    private $parterRegitryUserData = <<<HEREDOC
{
  "partner": 1,
  "registryUserId": 3,
  "department": 1,
  "position": 1
}
HEREDOC;

    public function tryToGetDefaultPartnerRegistryCollection(\FunctionalTester $I)
    {
        $I->sendGet('/registry/');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerRegistryUser']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
        $I->seeResponseJsonMatchesJsonPath('$..id');
        $I->seeResponseJsonMatchesJsonPath('$..partner');
        $I->seeResponseJsonMatchesJsonPath('$..registryUserId');
    }

    public function tryToGetDefaultPartnerRegistryCollectionWithoutPagination(\FunctionalTester $I)
    {
        $I->sendGet('/registry/?paginate=0');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerRegistryUser']);
        $I->seeResponseContains('data');
        $I->dontSeeResponseContains('pagination');
        $I->seeResponseJsonMatchesJsonPath('$..id');
        $I->seeResponseJsonMatchesJsonPath('$..partner');
        $I->seeResponseJsonMatchesJsonPath('$..registryUserId');
    }

    public function tryToGetARegistryUserIdFilteredAndNonEmptyPartnerRegistryCollection(\FunctionalTester $I)
    {
        $I->sendGet('/registry/?registryUserId=1');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerRegistryUser']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
        $I->seeResponseJsonMatchesJsonPath('$..id');
        $I->seeResponseJsonMatchesJsonPath('$..partner');
        $I->seeResponseJsonMatchesJsonPath('$..registryUserId');
    }

    public function tryToGetARegistryUserIdFilteredAndEmptyPartnerRegistryCollection(\FunctionalTester $I)
    {
        $I->sendGet('/registry/?registryUserId=99999999');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerRegistryUser']);
        $I->seeResponseContainsJson(['data' => []]);
        $I->seeResponseContains('pagination');
    }

    public function tryToGetARegistryUserIdsFilteredAndNonEmptyPartnerRegistryCollection(\FunctionalTester $I)
    {
        $I->sendGet('/registry/?registryUserIds=1,2');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerRegistryUser']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].id');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].partner');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].registryUserId');
        $I->seeResponseJsonMatchesJsonPath('$.data[1].id');
        $I->seeResponseJsonMatchesJsonPath('$.data[1].partner');
        $I->seeResponseJsonMatchesJsonPath('$.data[1].registryUserId');
    }

    public function tryToGetARegistryUserIdsFilteredAndMixedEmptyPartnerRegistryCollection(\FunctionalTester $I)
    {
        $I->sendGet('/registry/?registryUserIds=1,99999999');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerRegistryUser']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].id');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].partner');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].registryUserId');
        $I->dontSeeResponseJsonMatchesJsonPath('$.data[1].id');
        $I->dontSeeResponseJsonMatchesJsonPath('$.data[1].partner');
        $I->dontSeeResponseJsonMatchesJsonPath('$.data[1].registryUserId');
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

    public function tryToPutPartnerRegistryUser(\FunctionalTester $I)
    {
        $data = <<<HEREDOC
{
  "partner": 1,
  "registryUserId": 3,
  "department": 1,
  "position": 1,
  "positionCode": 1,
  "isAdmin": 0,
  "vision": 0,
  "convention": 0,
  "dealersMeeting": 0,
  "brandDays": 0
}
HEREDOC;
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPUT('/registry/1', $data);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerRegistryUser']);
        $I->seeResponseContains('data');
    }

    public function CantPutPartnerRegistryUser(\FunctionalTester $I)
    {
        $data = <<<HEREDOC
{
  "partner": 1,
  "registryUserId": 3,
  "department": 1,
  "position": 1,
  "positionCode": 1,
  "isAdmin": 0,
  "vision": 0,
  "convention": 0,
  "dealersMeeting": 0,
  "brandDays": 0
}
HEREDOC;
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPUT('/registry/9999', $data);
        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
        $I->seeResponseContains('error');
    }

    public function tryValidateInvalidPartnerRegistryUser(\FunctionalTester $I)
    {
        $I->wantTo('get an error when trying to post an invalid partner registry user');
        $I->sendPOST('/registry/validate/', ['partner' => 1]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); // 400
        $I->seeResponseIsJson();
    }

    public function tryValidatePartnerRegistryUser(\FunctionalTester $I)
    {
        $I->wantTo('get a successful response when trying to validate a correct partner registry user');
        $I->sendPOST('/registry/validate/', ['partner' => 1, 'registryUserId' => 3, 'department' => 1, 'position' => 1]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::NO_CONTENT); // 200
        $I->seeResponseEquals('');
    }
}
