<?php

namespace PartnerBundle\Controller;

use Codeception\Util\HttpCode;

class RegionControllerCest
{
    public function tryToGetRegionCollection(\FunctionalTester $I)
    {
        $I->sendGet('/region/');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'Region']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
    }
}
