<?php

namespace PartnerBundle\Controller;

use Codeception\Util\HttpCode;

class PartnerOptionControllerCest
{
    public function tryToGetTypes(\FunctionalTester $I)
    {
        $I->sendGet('/option/type');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerOption']);
        $I->seeResponseContains('data');
    }

    public function tryToGetSites(\FunctionalTester $I)
    {
        $I->sendGet('/option/site');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerOption']);
        $I->seeResponseContains('data');
    }

    public function tryToGetSellingVolume(\FunctionalTester $I)
    {
        $I->sendGet('/option/selling-volume');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerOption']);
        $I->seeResponseContains('data');
    }

    public function tryToGetPrestige(\FunctionalTester $I)
    {
        $I->sendGet('/option/prestige');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'PartnerOption']);
        $I->seeResponseContains('data');
    }
}
