<?php

namespace PartnerBundle\Controller;

use Codeception\Util\HttpCode;

class PartnerTypeControllerCest
{
    public function tryToGet(\FunctionalTester $I)
    {
        $I->sendGet('/type');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerType']);
        $I->seeResponseContains('data');
    }
}
