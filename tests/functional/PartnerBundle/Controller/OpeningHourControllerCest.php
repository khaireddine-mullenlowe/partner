<?php
namespace PartnerBundle\Controller;

use Codeception\Util\HttpCode;

class OpeningHourControllerCest
{
    private $openingHourPayload = <<<HEREDOC
{
    "partner": 2,
    "openingDay": "friday",
    "amStartHour": "08:00",
    "amEndHour": "12:00",
    "pmStartHour": "14:00",    
    "pmEndHour": "19:00",
    "nox": true,
    "status": 1
}
HEREDOC;

    private $openingHourPayload2 = <<<HEREDOC
{
    "partner": 2,
    "openingDay": "monday",
    "amStartHour": "08:00",
    "amEndHour": "12:00",
    "pmStartHour": "14:00",    
    "pmEndHour": "17:00",
    "nox": false,
    "status": 1
}
HEREDOC;

    private $openingHourId;

    public function tryToGetDefaultOpeningHourCollection(\FunctionalTester $I)
    {
        $I->sendGet('/opening/hour/');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'OpeningHour']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
    }

    public function tryToGetDefaultOpeningHourCollectionWithoutPagination(\FunctionalTester $I)
    {
        $I->sendGet('/opening/hour/?paginate=0');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'OpeningHour']);
        $I->seeResponseContains('data');
        $I->dontSeeResponseContains('pagination');
    }

    public function tryToGetAnOpeningHourFilteredByPartnerAndNonEmptyCollection(\FunctionalTester $I)
    {
        $I->sendGet('/opening/hour/?partnerId=1');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'OpeningHour']);
        $I->seeResponseContains('data');
        $I->seeResponseContains('pagination');
    }

    public function tryToGetAnOpeningHourFilteredByPartnerAndEmptyCollection(\FunctionalTester $I)
    {
        $I->sendGet('/opening/hour/?partnerId=999999999');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'OpeningHour']);
        $I->seeResponseContainsJson(['data' => []]);
        $I->seeResponseContains('pagination');
    }

    public function tryToPostAPartnerOpeningHour(\FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/opening/hour/', $this->openingHourPayload);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'OpeningHour']);
        $I->seeResponseContains('data');
        $I->seeResponseJsonMatchesJsonPath('$..id');
        $I->seeResponseJsonMatchesJsonPath('$..partner');
        $this->openingHourId = $I->grabDataFromResponseByJsonPath('$..id')[0];
    }

    /**
     * @depends tryToPostAPartnerOpeningHour
     */
    public function tryToPutAPartnerOpeningHour(\FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPUT('/opening/hour/'.$this->openingHourId, $this->openingHourPayload2);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'OpeningHour']);
        $I->seeResponseContains('data');
        $I->seeResponseJsonMatchesJsonPath('$..id');
        $I->seeResponseJsonMatchesJsonPath('$..partner');
    }

    /**
     * @depends tryToPutAPartnerOpeningHour
     */
    public function tryToDeletePartnerOpeningHour(\FunctionalTester $I)
    {
        $I->wantTo('delete a partner opening hour');
        $I->sendDELETE('/opening/hour/'.$this->openingHourId);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('The resource has been deleted.');
    }

    public function tryToPutAnExistingPartnerOpeningHour(\FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPUT('/opening/hour/9999', $this->openingHourPayload2);
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseContains('error');
    }
}
