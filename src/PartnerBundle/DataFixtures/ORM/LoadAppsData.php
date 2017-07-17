<?php

namespace PartnerBundle\DataFixtures\ORM;

use Mullenlowe\CommonBundle\DataFixtures\BaseFixtureData;
use Doctrine\Common\Persistence\ObjectManager;
use PartnerBundle\Entity\Partner;
use Symfony\Component\Yaml\Yaml;

/**
 * Class LoadAppsData
 *
 * @package AdminBundle\DataFixtures\ORM
 */
class LoadAppsData extends BaseFixtureData
{
    /**
     * @param ObjectManager $manager
     */
    public function loadData(ObjectManager $manager)
    {
        $fixturesPath = sprintf(__DIR__ . '/../../../../app/config/%s', 'data_fixtures.yml');

        $fixtures = Yaml::parse(file_get_contents($fixturesPath));


        // part applications, pages, features
        foreach ($fixtures['partners'] as $kePartner => $partnerData) {
            $partner = new Partner();
            $partner->setContractNumber($partnerData['contract_number']);
            $partner->setCommercialName($partnerData['commercial_name']);
            $partner->setRegistryUserId($partnerData['registry_user_id']);
            $partner->setKvpsNumber($partnerData['kvps_number']);
            $partner->setWebSite($partnerData['web_site']);
            $partner->setIsEtron(false);
            $partner->setIsOccPlus(false);
            $partner->setIsPartnerPlus(false);
            $partner->setIsPartnerR8(false);
            $partner->setIsTwinService(false);
            $manager->persist($partner);
        }
        $manager->flush();
    }
}