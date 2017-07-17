<?php

namespace Tests\unit;

use PhpAmqpLib\Message\AMQPMessage;

class MyaudiUserCreateOrUpdatePartnerConsumerTest extends \Codeception\Test\Unit
{
    protected function _before()
    {

    }

    /**
     * @dataProvider myaudiDataProvider
     */
    public function testExecute($myaudiDataProviders)
    {
        $this->container = $this->getModule('Symfony2')->_getContainer();

        $myaudiDataProviderObject = json_decode($myaudiDataProviders);
        $partnerInfos = $myaudiDataProviderObject->partner_response;
        $consumer = $this->container->get('PartnerBundle\Service\MyaudiUserCreateOrUpdatePartnerConsumer');

        foreach($partnerInfos as $partnerType => $partnerInfo){

            $amqpMessage = new AMQPMessage();
            $amqpMessage->setBody(serialize($myaudiDataProviders));

            if ($partnerType == 'partner_response') {
                $type = 'sales';
            } else {
                $type = 'aftersales';
            }

            $consumer->execute($amqpMessage);

            $em = $this->container->get('doctrine.orm.entity_manager');;

            $partner = $em->getRepository("PartnerBundle:Partner")->findOneBy(['partnerId' => $partnerInfo->id_partner]);

            $this->assertNotEmpty($partner);

            $this->assertEquals($partnerInfo->commercial_name, $partner->getCommercialName());
            $this->assertEquals($partnerInfo->contract_number, $partner->getContractNumber());
            $this->assertEquals($partnerInfo->etron, $partner->getIsEtron());
            $this->assertEquals($partnerInfo->occ_plus, $partner->getIsOccPlus());
            $this->assertEquals($partnerInfo->partner_r8, $partner->getIsPartnerR8());
            $this->assertEquals($partnerInfo->twin_service, $partner->getIsTwinService());
            $this->assertEquals($partnerInfo->website, $partner->getWebSite());
            $this->assertEquals($type, $partner->getType());

            if(isset($partnerInfo->kvps_number)){
                $this->assertEquals($partnerInfo->kvps_number, $partner->getKvpsNumber());
            }

        }
    }

    public function myaudiDataProvider()
    {
        return [
            ['{
            "login_response": {
                "session_key": "149804822123819290000x273f8be1112023968d82d4624cfaac58",
                "user_id": "393061",
                "contact_id": "406779",
                "profile_id": "11",
                "device_type_id": "792",
                "language_id": "1",
                "remindme": "0",
                "logged": "1",
                "civility": "Monsieur",
                "last_name": "BERTUCCI",
                "first_name": "GABRIEL",
                "user_registration_type_id": "534",
                "home_page_ref": "profile",
                "partners": null,
                "events": null
            },
            "profile_response": {
                    "personal_info": {
                    "id_contact": "406779",
                    "civility_id": "819",
                    "civility": "Monsieur",
                    "last_name": "BERTUCCI",
                    "first_name": "GABRIEL",
                    "email": "gabriel.bertucci@lowestrateus.com",
                    "email2": "gabriel.bertucci@gmail.com",
                    "born_date": "1987-03-26"
                },
                "address": {
                    "postal_code": "",
                    "city_id": null,
                    "city": "",
                    "street_id": "0",
                    "street": "",
                    "number": "",
                    "comp1": "",
                    "entry": "",
                    "number_apartment": "",
                    "country_id": "1",
                    "street_type": ""
                },
                "phones": {
                    "id_phone_personal": "707542",
                    "phone_personal": "0603574648",
                    "id_phone_professional": null,
                    "phone_professional": null,
                    "id_phone_mobile": "781863",
                    "phone_mobile": "0625592666",
                    "id_phone_fax": null,
                    "phone_fax": null
                },
                "user": {
                    "login": "gabriel.bertucci@lowestrateus.com"
                }
            },
            "partner_response": {
                    "sales_partner": {
                    "id_partner": "1515",
                    "contract_number": "01002681",
                    "commercial_name": "AUDI CITY PARIS",
                    "website": "http://www.audibauerparis.fr",
                    "city_id": "92982",
                    "city": "PARIS 01",
                    "street_id": "0",
                    "street": "48 PL DU MARCHE ST HONORE",
                    "number": "",
                    "postal_code": "75001",
                    "lat": "48.86726389",
                    "lng": "2.3321222219999527",
                    "phone": "0155353000",
                    "fax": "0155353001",
                    "kvps_number": "FRAA02681",
                    "partner_r8": "1",
                    "twin_service": "0",
                    "partner_plus": "0",
                    "occ_plus": "0",
                    "etron": "0",
                    "id_contact_form": null,
                    "contact_form_name": null
                },
                "aftersales_partner": {
                    "id_partner": "1679",
                    "contract_number": "01003232",
                    "commercial_name": "BAUER PARIS WAGRAM",
                    "website": "",
                    "city_id": "0",
                    "city": "PARIS 17",
                    "street_id": "0",
                    "street": "21 Rue Cardinet",
                    "postal_code": "75017 ",
                    "partner_r8": "0",
                    "twin_service": "0",
                    "partner_plus": "0",
                    "occ_plus": "0",
                    "etron": "1",
                    "lat": "48.8818227",
                    "lng": "2.302463100000068",
                    "phone": "0142123000",
                    "fax": "0142123001"
                }
            },
            "cars": [{
                "id_owned_car": "798668",
                "chassis_number": "WAUZZZ8T3GA041126",
                "order_number": "",
                "km": null,
                "km_average": null,
                "last_service_date": null,
                "fiscal_horse_power": null,
                "model_id": "275",
                "model": "Audi A5 Sportback",
                "brand_id": "73",
                "brand": "Audi",
                "range_id": "222",
                "range": "A5",
                "model_code_label": "8TA0HY",
                "label_detailed": "Audi A5 Sportback V6 3.0 TDi DPF quattro",
                "model_body_type": "Break",
                "model_engine_type": "V6",
                "model_gearbox_type": "BVA",
                "model_transmission_type": "quattro",
                "model_fuel_type": "GO",
                "fer_model_id": "67",
                "fer_engine_type_id": "3",
                "fer_engine_type_label": "Diesel 6 cylindres",
                "fer_fuel_id": "2",
                "fer_fuel_label": "ESSENCE",
                "fer_partner": "362",
                "model_year": "2016",
                "purchase_date": null,
                "purchase_type_id": "1158",
                "purchase_type": "Neuf",
                "ctc_owned_car_status": "1",
                "cowai_status": null,
                "cowai_order_status": null,
                "do_not_delete": null,
                "images": []
            }],
            "desired_cars": [{
                 "id_desired_car": "686426",
                "model_id": "267",
                "information_requested": "0",
                "model": "Audi A3",
                "purchase_type": null,
                "purchase_delay": null,
                "purchase_mode": null,
                "usage": null,
                "purchase_type_id": null,
                "purchase_delay_id": null,
                "purchase_mode_id": null,
                "usage_id": null,
                "model_catalog": "A3_733.1150.32_41_22_17_Doppel.pdf",
                "id_configurated_product": "49232",
                "contact_id": "406779",
                "configuration_code": "AX0PFBLS",
                "model_code": "",
                "configuration_date": "",
                "title": "",
                "price": "",
                "currency": "",
                "picture_url": "",
                "detail_url": "",
                "creation_time": "2017-04-13 12:29:44.263",
                "rank": "32",
                "status": "0"
            }]
        }']
        ];
    }

    protected function _after()
    {
    }
}