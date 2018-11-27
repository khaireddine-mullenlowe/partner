<?php

namespace Tests\ShoppingBundle\Controller;

use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

class DepositTypeControllerCest
{
    protected static $jsonDeposit = <<<HEREDOC
{
    "vehicleWorkshop": true,
    "vehicleWorkshopDaysBeforeFreeCalendar": 5,
    "waitOnSpot": false,
    "waitOnSpotDaysBeforeFreeCalendar": 0,
    "replacementVehicle": false,
    "replacementVehicleDaysBeforeFreeCalendar": 0,
    "valetParking": false,
    "valetParkingDaysBeforeFreeCalendar": 0,
    "valetParkingPrice": 89
}
HEREDOC;

    protected static $jsonDeposit2 = <<<HEREDOC
{
    "vehicleWorkshop": false,
    "vehicleWorkshopDaysBeforeFreeCalendar": 0,
    "waitOnSpot": true,
    "waitOnSpotDaysBeforeFreeCalendar": 5,
    "replacementVehicle": false,
    "replacementVehicleDaysBeforeFreeCalendar": 5,
    "valetParking": false,
    "valetParkingDaysBeforeFreeCalendar": 6,
    "valetParkingPrice": 99
}
HEREDOC;

    protected $partnerId = 10;

    const DEPOSIT_PATH = '/deposit/';
    const TYPE_PATH = '/type/';

    public function testPostDeposit(FunctionalTester $I)
    {
        $this->requestJson(
            $I,
            Response::HTTP_CREATED,
            'POST',
            self::DEPOSIT_PATH.$this->partnerId.self::TYPE_PATH,
            [],
            [],
            [],
            static::$jsonDeposit
        );
        $I->seeResponseContainsJson(['context' => 'DepositType']);
        $I->seeResponseContains('data');
    }

    /**
     * @depends testPostDeposit
     */
    public function testPutDeposit(FunctionalTester $I)
    {
        $this->requestJson(
            $I,
            Response::HTTP_OK,
            'PUT',
            self::DEPOSIT_PATH.$this->partnerId.self::TYPE_PATH,
            [],
            [],
            [],
            static::$jsonDeposit2
        );
        $I->seeResponseContainsJson(['context' => 'DepositType']);
        $I->seeResponseContains('data');
    }

    /**
     * @depends testPutDeposit
     */
    public function testGetDeposit(FunctionalTester $I)
    {
        $this->requestJson(
            $I,
            Response::HTTP_OK,
            'GET',
            self::DEPOSIT_PATH.$this->partnerId.self::TYPE_PATH
        );
        $I->seeResponseContainsJson(['context' => 'DepositType']);
        $I->seeResponseContains('data');
    }

    /**
     * @depends testGetDeposit
     */
    public function testRemoveDeposit(FunctionalTester $I)
    {
        $this->requestJson(
            $I,
            Response::HTTP_OK,
            'DELETE',
            self::DEPOSIT_PATH.$this->partnerId.self::TYPE_PATH
        );
        $I->seeResponseContainsJson(['context' => 'DepositType']);
    }

    /**
     * @depends testRemoveDeposit
     */
    public function testGetDepositWhenNotFound(FunctionalTester $I)
    {
        $this->requestJson(
            $I,
            Response::HTTP_NOT_FOUND,
            'GET',
            self::DEPOSIT_PATH.$this->partnerId.self::TYPE_PATH
        );
        $I->seeResponseContainsJson(["message" => "Deposit Type not found"]);
    }

    protected function requestJson(
        FunctionalTester $I,
        $expectedStatusCode,
        $method,
        $uri,
        $parameters = [],
        $files = [],
        $server = [],
        $content = []
    ) {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->{"send".$method}($uri, $content, $parameters);
        $I->seeResponseCodeIs($expectedStatusCode);
        $I->seeResponseIsJson();
    }
}
