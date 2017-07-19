<?php

namespace PartnerBundle\DataFixtures\ORM;

use Mullenlowe\CommonBundle\DataFixtures\BaseFixtureData;
use Doctrine\Common\Persistence\ObjectManager;
use PartnerBundle\Entity\Partner;
use PartnerBundle\Entity\PartnerAddress;
use PartnerBundle\Entity\PartnerMyaudiUser;
use PartnerBundle\Entity\PartnerRegistryUser;
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
        $fixturesPath = sprintf(__DIR__.'/../../../../app/config/%s', 'data_fixtures.yml');

        $fixtures = Yaml::parse(file_get_contents($fixturesPath));


        // part applications, pages, features
        foreach ($fixtures['partners'] as $kePartner => $partnerData) {
            $partner = new Partner();
            $partner->setContractNumber($partnerData['contract_number']);
            $partner->setCommercialName($partnerData['commercial_name']);
            $partner->setKvpsNumber($partnerData['kvps_number']);
            $partner->setWebSite($partnerData['web_site']);
            $partner->setIsEtron(false);
            $partner->setIsOccPlus(false);
            $partner->setIsPartnerPlus(false);
            $partner->setIsPartnerR8(false);
            $partner->setIsTwinService(false);

            foreach ($partnerData['myaudi_users'] as $myaudiUserId) {
                $partner->addMyaudiUser(new PartnerMyaudiUser($partner, $myaudiUserId));
            }

            foreach ($partnerData['registry_users'] as $registryUserId) {
                $partner->addRegistryUser(new PartnerRegistryUser($partner, $registryUserId));
            }

            foreach ($partnerData['addresses'] as $addressId) {
                $partner->addAddress(new PartnerAddress($partner, $addressId));
            }

            $manager->persist($partner);
        }
        $manager->flush();
    }
}
