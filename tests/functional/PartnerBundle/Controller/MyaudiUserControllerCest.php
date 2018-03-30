<?php

namespace PartnerBundle\Tests\Controller;

use Codeception\Util\HttpCode;

class MyaudiUserControllerCest
{
    public function duplicateRuleWithEmptyInputData(\FunctionalTester $I)
    {
        $I->wantToTest('Partner duplicate rule returns error when input data are empty');
        $I->sendPOST('/myaudi-user/552233/check_duplicate', []);
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Input data are empty');
    }

    public function duplicateRuleWithInvalidInputData(\FunctionalTester $I)
    {
        $I->wantToTest('Partner duplicate rule returns error when input data are not valid');
        $I->sendPOST('/myaudi-user/552233/check_duplicate', ['foo' => 'bar']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Input data are not valid');
    }

    public function duplicateRuleWithNonExistingPartner(\FunctionalTester $I)
    {
        $I->wantToTest('Partner duplicate rule returns error when lead ID does not exist');
        $I->sendPOST('/myaudi-user/552233/check_duplicate',
            ['partnerName' => 'foo']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"PartnerMyaudiUser not found');
    }

    /**
     * @dataprovider duplicateRuleProvider
     */
    public function duplicateRule(\FunctionalTester $I, \Codeception\Example $input)
    {
        $I->wantToTest('Partner duplicate rule');
        $I->sendPOST('/myaudi-user/'.$input['myaudiUserId'].'/check_duplicate', $input['data']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['isDuplicate' => $input['expected']]);
    }

    protected function duplicateRuleProvider()
    {
        return [
            [
                'myaudiUserId' => 212,
                'data' => ['partnerName' => 'Foo'],
                'expected' => false,
            ],[
                'myaudiUserId' => 212,
                'data' => ['partnerName' => "Maury Morel SARL"],
                'expected' => true,
            ],
        ];
    }

}