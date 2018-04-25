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
}
