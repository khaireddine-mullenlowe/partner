<?php
namespace PartnerBundle\Tests\Controller;
use Codeception\Util\HttpCode;

/**
 * Class CompanyControllerCest
 * @package PartnerBundle\Tests\Controller
 */
class CompanyControllerCest
{
    /**
     * @param \FunctionalTester $I
     */
    public function tryToGetCompanyCollection(\FunctionalTester $I)
    {
        $I->sendGet('/company/');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'Company']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
    }

    public function tryToPost(\FunctionalTester $I)
    {
        $I->sendPOST('/company/', [
            "corporateName"=> "MULLENLOWE",
            "commercialName"=> "MULLENLOWE",
            "type"=> 4,
            "status"=> 1
        ]);
        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'Company']);
        $I->seeResponseContains('data');
    }

    public function tryToPostKo(\FunctionalTester $I)
    {
        $I->sendPOST('/company/', [
            "commercialName"=> "MULLENLOWE",
            "type"=> 4,
            "status"=> 1
        ]);
        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'Company']);
        $I->seeResponseContains('errors');
    }
}
