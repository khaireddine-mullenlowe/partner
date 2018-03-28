<?php

namespace PartnerBundle\Controller;

use Codeception\Util\HttpCode;

class CompanyPositionControllerCest
{
    public function tryToGetPositionCollection(\FunctionalTester $I)
    {
        $I->sendGet('/company/position');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'CompanyPosition']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
    }
}
