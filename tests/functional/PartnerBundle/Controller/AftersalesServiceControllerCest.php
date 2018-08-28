<?php

namespace Tests\functional\PartnerBundle\Controller;

use Codeception\Test\Unit;
use Codeception\Util\HttpCode;

/**
 * Class AftersalesServiceControllerCest
 * @package Tests\functional\PartnerBundle\Controller
 *
 * @codingStandardsIgnoreStart
 * @SuppressWarnings(PHPMD)
 */
class AftersalesServiceControllerCest
{
    /**
     * @param \FunctionalTester $I
     * @throws \Exception
     */
    public function testGetAftersalesServiceCollection(\FunctionalTester $I)
    {
        $I->sendGET('/service/');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('context');
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
        $data = $I->grabDataFromResponseByJsonPath('$.data')[0];
        Unit::assertGreaterThan(0, count($data));
    }

    public function testGetAnExistantAftersalesService(\FunctionalTester $I)
    {
        $I->sendGET('/service/1');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('context');
        $I->seeResponseContains('data');
        $I->seeResponseJsonMatchesJsonPath('$.data.id');
    }

    public function testGetANonExistantAftersalesService(\FunctionalTester $I)
    {
        $I->sendGET('/service/999999999');
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseContains('errors');
    }

    public function testPostAftersalesService(\FunctionalTester $I)
    {
        $data = [
            'type' => 'foo',
            'name' => 'bar',
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/service/', $data);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContains('context');
        $I->seeResponseContains('data');
        $I->seeResponseJsonMatchesJsonPath('$.data.id');
    }

    public function testFailPostAftersalesService(\FunctionalTester $I)
    {
        $data = [
            'type' => 'foo',
            'name' => 'bar',
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/service/', $data);
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
        $I->seeResponseContains('errors');
    }

    public function testPutAftersalesService(\FunctionalTester $I)
    {
        $data = [
            'type' => 'azerty',
            'name' => 'qwerty',
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPUT('/service/1', $data);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('context');
        $I->seeResponseContains('data');
        $I->seeResponseJsonMatchesJsonPath('$.data.id');
    }

    public function testFailPutAftersalesService(\FunctionalTester $I)
    {
        $data = [
            'type' => 'foo',
            'test' => 'bar',
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPUT('/service/1', $data);
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
        $I->seeResponseContains('errors');
    }

    public function testPatchAftersalesService(\FunctionalTester $I)
    {
        $data = [
            'name' => 'baz',
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPATCH('/service/1', $data);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('context');
        $I->seeResponseContains('data');
        $I->seeResponseJsonMatchesJsonPath('$.data.id');
    }

    public function testFailPatchAftersalesService(\FunctionalTester $I)
    {
        $data = [
            'test' => 'foo',
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPATCH('/service/1', $data);
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
        $I->seeResponseContains('errors');
    }

    public function testDeleteAnExistantAftersalesService(\FunctionalTester $I)
    {
        $I->sendDELETE('/service/1');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('context');
        $I->seeResponseContains('data');
        $I->seeResponseJsonMatchesJsonPath('$.data.message');
    }

    public function testDeleteANonExistantAftersalesService(\FunctionalTester $I)
    {
        $I->sendDELETE('/service/999999999');
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseContains('errors');
    }
}
