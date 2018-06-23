<?php

namespace Tests\functional\PartnerBundle\Controller;

use Codeception\Test\Unit;
use Codeception\Util\HttpCode;

/**
 * Class PartnerMyaudiControllerCest
 * @package Tests\functional\PartnerBundle\Controller
 */
class PartnerMyaudiControllerCest
{
    public function tryToGetDefaultPartnerMyaudiCollectionWithPagination(\FunctionalTester $I)
    {
        $I->sendGet('/myaudi/');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerMyaudiUser']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
        $I->seeResponseJsonMatchesJsonPath('$..id');
        $I->seeResponseJsonMatchesJsonPath('$..partner');
        $I->seeResponseJsonMatchesJsonPath('$..myaudiUserId');
    }

    public function tryToGetDefaultPartnerMyaudiCollectionWithoutPagination(\FunctionalTester $I)
    {
        $I->sendGet('/myaudi/?paginate=0');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerMyaudiUser']);
        $I->seeResponseContains('data');
        $I->dontSeeResponseContains('pagination');
        $I->seeResponseJsonMatchesJsonPath('$..id');
        $I->seeResponseJsonMatchesJsonPath('$..partner');
        $I->seeResponseJsonMatchesJsonPath('$..myaudiUserId');
    }

    public function tryToGetAMyaudiUserIdFilteredAndNonEmptyPartnerMyaudiCollection(\FunctionalTester $I)
    {
        $I->sendGet('/myaudi/?myaudiUserId=1');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerMyaudiUser']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
        $I->seeResponseJsonMatchesJsonPath('$..id');
        $I->seeResponseJsonMatchesJsonPath('$..partner');
        $I->seeResponseJsonMatchesJsonPath('$..myaudiUserId');
    }

    public function tryToGetAMyaudiUserIdFilteredAndEmptyPartnerMyaudiCollection(\FunctionalTester $I)
    {
        $I->sendGet('/myaudi/?myaudiUserId=99999999');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerMyaudiUser']);
        $I->seeResponseContainsJson(['data' => []]);
        $I->seeResponseContains('pagination');
    }

    public function tryToGetAMyaudiUserIdsFilteredAndNonEmptyPartnerMyaudiCollection(\FunctionalTester $I)
    {
        $I->sendGet('/myaudi/?myaudiUserIds=1,2');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerMyaudiUser']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].id');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].partner');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].myaudiUserId');
        $I->seeResponseJsonMatchesJsonPath('$.data[1].id');
        $I->seeResponseJsonMatchesJsonPath('$.data[1].partner');
        $I->seeResponseJsonMatchesJsonPath('$.data[1].myaudiUserId');
    }

    public function tryToGetAMyaudiUserIdsFilteredAndMixedEmptyPartnerMyaudiCollection(\FunctionalTester $I)
    {
        $I->sendGet('/myaudi/?myaudiUserIds=2,99999999');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerMyaudiUser']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].id');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].partner');
        $I->seeResponseJsonMatchesJsonPath('$.data[0].myaudiUserId');
        $I->dontSeeResponseJsonMatchesJsonPath('$.data[1].id');
        $I->dontSeeResponseJsonMatchesJsonPath('$.data[1].partner');
        $I->dontSeeResponseJsonMatchesJsonPath('$.data[1].myaudiUserId');
    }

    /**
     * @param \FunctionalTester $I
     * @throws \Exception
     */
    public function tryToGetAMyaudiUserIdFilteredBySalesPartnerTypeAndNonEmptyPartnerMyaudiCollection(\FunctionalTester $I)
    {
        $I->sendGet('/myaudi/?myaudiUserId=1&partnerType=sales');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerMyaudiUser']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
        $I->seeResponseJsonMatchesJsonPath('$..id');
        $I->seeResponseJsonMatchesJsonPath('$..partner');
        $I->seeResponseJsonMatchesJsonPath('$..myaudiUserId');
        $I->seeResponseJsonMatchesJsonPath('$..partner..type');
        Unit::assertEquals('sales', $I->grabDataFromResponseByJsonPath('$..partner..type')[0]);
    }

    /**
     * @param \FunctionalTester $I
     * @throws \Exception
     */
    public function tryToGetAMyaudiUserIdFilteredByAftersalesPartnerTypeAndNonEmptyPartnerMyaudiCollection(\FunctionalTester $I)
    {
        $I->sendGet('/myaudi/?myaudiUserId=1&partnerType=aftersales');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerMyaudiUser']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
        $I->seeResponseJsonMatchesJsonPath('$..id');
        $I->seeResponseJsonMatchesJsonPath('$..partner');
        $I->seeResponseJsonMatchesJsonPath('$..myaudiUserId');
        $I->seeResponseJsonMatchesJsonPath('$..partner..type');
        Unit::assertEquals('aftersales', $I->grabDataFromResponseByJsonPath('$..partner..type')[0]);
    }

    /**
     * @param \FunctionalTester $I
     * @throws \Exception
     */
    public function tryToGetAMyaudiUserIdFilteredByPartnerTypeAndEmptyPartnerMyaudiCollection(\FunctionalTester $I)
    {
        $I->sendGet('/myaudi/?myaudiUserId=2&partnerType=aftersales');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerMyaudiUser']);
        $I->seeResponseContainsJson(['data' => []]);
        $I->seeResponseContains('pagination');
    }

    public function tryToPostANonExistingPartnerMyaudiUser(\FunctionalTester $I)
    {
        $parterMyaudiUserData = '{"partner":1,"myaudiUserId":3}';

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/myaudi/', $parterMyaudiUserData);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerMyaudiUser']);
        $I->seeResponseContains('data');
        $I->seeResponseJsonMatchesJsonPath('$..id');
        $I->seeResponseJsonMatchesJsonPath('$..partner');
        $I->seeResponseJsonMatchesJsonPath('$..myaudiUserId');
    }

    /**
     * @param \FunctionalTester $I
     * @throws \Exception
     */
    public function tryToPostAnExistingPartnerMyaudiUser(\FunctionalTester $I)
    {
        $parterMyaudiUserData = '{"partner":3,"myaudiUserId":1}';

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/myaudi/', $parterMyaudiUserData);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerMyaudiUser']);
        $I->seeResponseContains('data');
        $I->seeResponseJsonMatchesJsonPath('$..id');
        $I->seeResponseJsonMatchesJsonPath('$..partner');
        $I->seeResponseJsonMatchesJsonPath('$..myaudiUserId');
        Unit::assertEquals(1, $I->grabDataFromResponseByJsonPath('$..id')[0]);
        Unit::assertEquals(1, $I->grabDataFromResponseByJsonPath('$..myaudiUserId')[0]);
        Unit::assertEquals(3, $I->grabDataFromResponseByJsonPath('$..partner..id')[0]);
    }

    /**
     * @param \FunctionalTester $I
     * @throws \Exception
     */
    public function tryToPutAnExistingPartnerMyaudiUser(\FunctionalTester $I)
    {
        $parterMyaudiUserData = '{"partner":4,"myaudiUserId":1}';

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPUT('/myaudi/1', $parterMyaudiUserData);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerMyaudiUser']);
        $I->seeResponseContains('data');
        $I->seeResponseJsonMatchesJsonPath('$..id');
        $I->seeResponseJsonMatchesJsonPath('$..partner');
        $I->seeResponseJsonMatchesJsonPath('$..myaudiUserId');
        Unit::assertEquals(1, $I->grabDataFromResponseByJsonPath('$..id')[0]);
        Unit::assertEquals(1, $I->grabDataFromResponseByJsonPath('$..myaudiUserId')[0]);
        Unit::assertEquals(4, $I->grabDataFromResponseByJsonPath('$..partner..id')[0]);
    }

    public function cantPutPartnerMyaudiUser(\FunctionalTester $I)
    {
        $parterMyaudiUserData = '{"myaudiUserId":100}';

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPUT('/myaudi/999999999', $parterMyaudiUserData);
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerMyaudiUser']);
        $I->seeResponseContains('error');
    }

    public function tryToDeletePartnerMyaudiUser(\FunctionalTester $I)
    {
        $I->wantTo('delete a partner myaudi user');
        $I->sendDELETE('/myaudi/1');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('The resource has been deleted.');
    }
}
