<?php

namespace PartnerBundle\Controller;

use Codeception\Util\HttpCode;

class DepartmentControllerCest
{
    public function tryToGetDepartmentCollection(\FunctionalTester $I)
    {
        $I->sendGet('/company/department');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'Department']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
    }
}
