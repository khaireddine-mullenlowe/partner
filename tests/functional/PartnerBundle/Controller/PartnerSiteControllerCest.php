<?php

namespace PartnerBundle\Controller;

use Codeception\Util\HttpCode;

class PartnerSiteControllerCest
{
    public function tryToGet(\FunctionalTester $I)
    {
        $I->sendGet('/site');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerSite']);
        $I->seeResponseContains('data');
    }
}
