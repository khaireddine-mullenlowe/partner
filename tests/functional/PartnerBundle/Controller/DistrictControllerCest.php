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
        $I->seeResponseContainsJson(['context' => 'District']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
    }
}
