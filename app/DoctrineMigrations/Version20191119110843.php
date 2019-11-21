<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Mullenlowe\CommonBundle\Doctrine\Migration\AbstractMullenloweMigration;

/**
 * Update partner kvps, contractnumber, and commercial name
 */
class Version20191119110843 extends AbstractMullenloweMigration
{
    private $dataRegistryUsers = [[
        'originalContractNumber' => '01002926',
        'newContractNumber' => '01003557',
        'originalKvps' => 'FRAA02367',
        'newKvps' => 'FRAA02593',
        'newCommercialName' => NULL
    ], [
        'originalContractNumber' => '01002478',
        'newContractNumber' => '01003693',
        'originalKvps' => 'FRAA02142',
        'newKvps' => 'FRAA02615',
        'newCommercialName' => NULL
    ], [
        'originalContractNumber' => '01000869',
        'newContractNumber' => '01003684',
        'originalKvps' => 'FRAA02527',
        'newKvps' => 'FRAA02609',
        'newCommercialName' => NULL
    ], [
        'originalContractNumber' => '01006290',
        'newContractNumber' => '01003830',
        'originalKvps' => 'FRAA02290',
        'newKvps' => 'FRAA02626',
        'newCommercialName' => NULL
    ], [
        'originalContractNumber' => '01000737',
        'newContractNumber' => '01003604',
        'originalKvps' => 'FRAA06380',
        'newKvps' => 'FRAA02590',
        'newCommercialName' => NULL
    ], [
        'originalContractNumber' => '01001113',
        'newContractNumber' => '01003808',
        'originalKvps' => 'FRAA08460',
        'newKvps' => 'FRAA02630',
        'newCommercialName' => 'ALMA DIFFUSION AUTOMOBILES'
    ], [
        'originalContractNumber' => '01002369',
        'newContractNumber' => '01003811',
        'originalKvps' => 'FRAA02163',
        'newKvps' => 'FRAA02631',
        'newCommercialName' => 'ALMA DIFFUSION AUTOMOBILES'
    ], [
        'originalContractNumber' => '01002370',
        'newContractNumber' => '01003814',
        'originalKvps' => 'FRAA02079',
        'newKvps' => 'FRAA02632',
        'newCommercialName' => 'ALMA DIFFUSION AUTOMOBILES'
    ], [
        'originalContractNumber' => '01003320',
        'newContractNumber' => NULL,
        'originalKvps' => 'FRAA05460',
        'newKvps' => 'FRAA02523',
        'newCommercialName' => 'CAR SA'
    ], [
        'originalContractNumber' => '01004900',
        'newContractNumber' => NULL,
        'originalKvps' => NULL,
        'newKvps' => 'FRAA04900',
        'newCommercialName' => 'AVENIR AUTOMOBILES'
    ], [
        'originalContractNumber' => '01000767',
        'newContractNumber' => NULL,
        'originalKvps' => NULL,
        'newKvps' => 'FRAA06490',
        'newCommercialName' => 'DUGAST'
    ]];

    /**
     * @param Schema $schema
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function up(Schema $schema)
    {
        foreach ($this->dataRegistryUsers as $dataRegistryUser) {

            $partner = $this->getEntityManager()
                ->getRepository('PartnerBundle:Partner')
                ->findOneByContractNumber($dataRegistryUser['originalContractNumber']);

            if (!$partner) {
                echo sprintf('partner %s not found', $dataRegistryUser['originalContractNumber']);
                continue;
            }

            if ($dataRegistryUser['newContractNumber'] !== NULL) {
                $partner->setContractNumber($dataRegistryUser['newContractNumber']);
            }

            if ($dataRegistryUser['newKvps'] !== NULL) {
                $partner->setKvpsNumber($dataRegistryUser['newKvps']);
            }

            if ($dataRegistryUser['newCommercialName'] !== NULL) {
                $partner->setCorporateName($dataRegistryUser['newCommercialName']);
                $partner->setCommercialName($dataRegistryUser['newCommercialName']);
            }
        }

        $this->getEntityManager()->flush();
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // no down yet acted ! cf ticket 2712
    }
}
