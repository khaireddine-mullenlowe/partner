<?php

namespace PartnerBundle\Controller;

use Codeception\Util\HttpCode;

class CompanyPositionCodeControllerCest
{
    public function tryToGePositionCodeCollection(\FunctionalTester $I)
    {
        $I->sendGet('/company/position/code');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'CompanyPositionCode']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
    }
}
