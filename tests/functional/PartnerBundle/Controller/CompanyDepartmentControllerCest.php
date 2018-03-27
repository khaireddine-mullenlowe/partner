<?php

namespace PartnerBundle\Controller;

use Codeception\Util\HttpCode;

class CompanyDepartmentControllerCest
{
    public function tryToGetDepartmentCollection(\FunctionalTester $I)
    {
        $I->sendGet('/company/department');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'CompanyDepartment']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
    }
}
