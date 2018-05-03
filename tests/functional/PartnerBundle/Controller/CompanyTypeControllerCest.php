<?php

namespace PartnerBundle\Controller;

use Codeception\Util\HttpCode;

class CompanyTypeControllerCest
{
    public function tryToGetCompanyTypeCollection(\FunctionalTester $I)
    {
        $I->sendGet('/company/type');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'CompanyType']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
    }
}
