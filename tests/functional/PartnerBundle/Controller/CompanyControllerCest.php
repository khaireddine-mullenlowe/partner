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

    public function tryToPut(\FunctionalTester $I)
    {
        $I->sendPUT('/company/20', [
            "commercialName"=> "MULLENLOWE lola",
            "corporateName"=> "MULLENLOWE lola",
            "type"=> 4,
            "status"=> 1
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'Company']);
    }

    public function tryToPutKo(\FunctionalTester $I)
    {
        $I->sendPUT('/company/20', [
            "commercialName"=> "MULLENLOWE lola",
            "type"=> 4,
            "status"=> 1
        ]);
        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'Company']);
        $I->seeResponseContains('errors');
    }

    public function tryToPatch(\FunctionalTester $I)
    {
        $data = <<<HEREDOC
{
    "commercialName": "MULLENLOWE one",
    "type" : 5
}
HEREDOC;
        $I->sendPATCH('/company/20', $data);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'Company']);
    }

    public function tryToPatchKo(\FunctionalTester $I)
    {
        $data = <<<HEREDOC
{
    "commercialName": "MULLENLOWE one",
    "type" : 5
}
HEREDOC;
        $I->sendPATCH('/company/9999', $data);
        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
        $I->seeResponseContains('errors');
    }
}
