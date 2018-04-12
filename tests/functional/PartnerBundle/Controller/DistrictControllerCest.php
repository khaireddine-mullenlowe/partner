<?php

namespace PartnerBundle\Controller;

use Codeception\Util\HttpCode;

class DistrictControllerCest
{
    public function tryToGetDistrictCollection(\FunctionalTester $I)
    {
        $I->sendGet('/district/');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerDistrict']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
    }
}
