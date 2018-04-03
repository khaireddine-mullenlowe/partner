<?php

namespace PartnerBundle\Tests\Service;

use Codeception\Stub;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Mullenlowe\PluginsBundle\Service\Wega\WegaSoapClient;
use PartnerBundle\Entity\Partner;
use PartnerBundle\Entity\PartnerMyaudiUser;
use PartnerBundle\Entity\Repository\PartnerRepository;
use PartnerBundle\Service\Sync\SyncPartner;

/**
 * Class SyncPartnerTest
 * @package PartnerBundle\Tests\Service
 */
class SyncPartnerTest extends \Codeception\Test\Unit
{
    /**
     * Tests sync method
     */
    public function testSync()
    {
        /** @var WegaSoapClient $client */
        $client = Stub::makeEmpty(
            WegaSoapClient::class,
            [
                'getPartners' => function () {
                    return [
                        'CountryIsoId_CountryIsoId' => 'FR',
                        'Version_Comment' => '',
                        'Version_MetaFieldOrder' => '2',
                        'User_TokenId' => 'ld5D5r5dmDKJr2r2dfjxe32rt4fJ',
                        'User_UserId' => '',
                        'User_CorrespondenceLanguage' => 'fr',
                        'AfterSalesDealer_DealerId' => '12',
                        'Dealer_DealerId' => '15',
                    ];
                },
            ]
        );

        // mocks
        $mockedPartnerRepository = $this->getMockBuilder(PartnerRepository::class)->disableOriginalConstructor()->getMock();
        $mockedPartnerMyaudiUserRepository = $this->getMockBuilder(EntityRepository::class)->disableOriginalConstructor()->getMock();

        $mockedPartnerRepository->method('find')->willReturnOnConsecutiveCalls($this->getSalesPartner(), $this->getAfterSalesPartner());
        $mockedPartnerMyaudiUserRepository->method('findOneBy')->willReturnOnConsecutiveCalls(
            new PartnerMyaudiUser(),
            null
        );

        $mockedManager = $this->getMockBuilder(EntityManager::class)->disableOriginalConstructor()->getMock();
        $mockedManager->method('getRepository')->willReturnOnConsecutiveCalls(
            $mockedPartnerRepository,
            $mockedPartnerMyaudiUserRepository,
            $mockedPartnerRepository,
            $mockedPartnerMyaudiUserRepository
        );

        // only one of the two partners is synchronized
        $mockedManager->expects($this->once())->method('persist');

        $mockedManager->expects($this->exactly(1))->method('flush');
        $mockedManager->expects($this->exactly(1))->method('clear');

        $syncPartner = new SyncPartner($client, $mockedManager);

        $syncPartner->sync(1, 'ld5D5r5dmDKJr2r2dfjxe32rt4fJ');
    }

    /**
     * Returns a fake sales partner for testing
     *
     * @return Partner
     */
    private function getSalesPartner()
    {
        $partner = new Partner();
        $partner->setType('sales');

        return $partner;
    }

    /**
     * Returns a fake sales partner for testing
     *
     * @return Partner
     */
    private function getAfterSalesPartner()
    {
        $partner = new Partner();
        $partner->setType('aftersales');

        return $partner;
    }
}
