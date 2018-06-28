<?php

namespace Tests\ShoppingBundle\Controller;

use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

class DepositTypeControllerCest
{
    protected static $jsonDeposit = <<<HEREDOC
{
    "depositVehicleWorkshop": true,
    "depositVehicleWorkshopDaysBeforeFreeCalendar": 5,
    "depositWaitOnSpot": false,
    "depositWaitOnSpotDaysBeforeFreeCalendar": 0,
    "depositReplacementVehicle": false,
    "depositReplacementVehicleDaysBeforeFreeCalendar": 0,
    "depositValetParking": false,
    "depositValetParkingDaysBeforeFreeCalendar": 0,
    "depositValetParkingPrice": 89
}
HEREDOC;

    protected static $jsonDeposit2 = <<<HEREDOC
{
    "depositVehicleWorkshop": false,
    "depositVehicleWorkshopDaysBeforeFreeCalendar": 0,
    "depositWaitOnSpot": true,
    "depositWaitOnSpotDaysBeforeFreeCalendar": 5,
    "depositReplacementVehicle": false,
    "depositReplacementVehicleDaysBeforeFreeCalendar": 5,
    "depositValetParking": false,
    "depositValetParkingDaysBeforeFreeCalendar": 6,
    "depositValetParkingPrice": 99
}
HEREDOC;

    protected $partnerId = 10;

    public function testPostDeposit(FunctionalTester $I)
    {
        $this->requestJson($I,Response::HTTP_CREATED, 'POST', '/'.$this->partnerId.'/deposit/', [], [], [], static::$jsonDeposit);
        $I->seeResponseContainsJson(['context' => 'DepositType']);
        $I->seeResponseContains('data');
    }

    /**
     * @depends testPostDeposit
     */
    public function testPutDeposit(FunctionalTester $I)
    {
        $this->requestJson($I,Response::HTTP_OK, 'PUT', '/'.$this->partnerId.'/deposit/', [], [], [], static::$jsonDeposit2);
        $I->seeResponseContainsJson(['context' => 'DepositType']);
        $I->seeResponseContains('data');
    }

    /**
     * @depends testPutDeposit
     */
    public function testGetDeposit(FunctionalTester $I)
    {
        $this->requestJson($I,Response::HTTP_OK, 'GET', '/'.$this->partnerId.'/deposit/');
        $I->seeResponseContainsJson(['context' => 'DepositType']);
        $I->seeResponseContains('data');
    }

    /**
     * @depends testGetDeposit
     */
    public function testRemoveDeposit(FunctionalTester $I)
    {
        $this->requestJson($I, Response::HTTP_OK, 'DELETE', '/'.$this->partnerId.'/deposit/');
        $I->seeResponseContainsJson(['context' => 'DepositType']);
    }

    /**
     * @depends testRemoveDeposit
     */
    public function testGetDepositWhenNotFound(FunctionalTester $I)
    {
        $this->requestJson($I,Response::HTTP_NOT_FOUND, 'GET', '/'.$this->partnerId.'/deposit/');
        $I->seeResponseContainsJson(["message" => "Deposit Type not found"]);
    }

    protected function requestJson(FunctionalTester $I, $expectedStatusCode, $method, $uri, $parameters = [], $files = [], $server = [], $content = [])
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->{"send".$method}($uri, $content, $parameters);
        $I->seeResponseCodeIs($expectedStatusCode);
        $I->seeResponseIsJson();
    }
}
