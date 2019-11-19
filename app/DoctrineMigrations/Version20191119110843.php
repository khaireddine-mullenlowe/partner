<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Mullenlowe\CommonBundle\Doctrine\Migration\AbstractMullenloweMigration;

/**
 * Update partner kvps, contractnumber, et commercial name
 */
class Version20191119110843 extends AbstractMullenloweMigration
{
    private $dataRegistryUsers = [[
        'originalContractNumber' => '01002926',
        'newContractNumber' => '01003557',
        'originalKvps' => 'FRAA02367',
        'newKvps' => 'FRAA02593',
        'comercialName' => 'SAS BYMYCAR BOURGOGNE'
    ], [
        'originalContractNumber' => '01002478',
        'newContractNumber' => '01003693',
        'originalKvps' => 'FRAA02142',
        'newKvps' => 'FRAA02613',
        'comercialName' => 'ALLIANCE AUTO'
    ], [
        'originalContractNumber' => '01000869',
        'newContractNumber' => '01003684',
        'originalKvps' => 'FRAA02527',
        'newKvps' => 'FRAA02609',
        'comercialName' => 'EXCEL AUTOMOBILES'
    ], [
        'originalContractNumber' => '01006290',
        'newContractNumber' => '01003830',
        'originalKvps' => 'FRAA02290',
        'newKvps' => 'FRAA02626',
        'comercialName' => 'HONORÉ SAS'
    ], [
        'originalContractNumber' => '01000737',
        'newContractNumber' => '01003604',
        'originalKvps' => 'FRAA06380',
        'newKvps' => 'FRAA02590',
        'comercialName' => 'BYmy)CAR'
    ], [
        'originalContractNumber' => '01001113',
        'newContractNumber' => '01003808',
        'originalKvps' => 'FRAA08460',
        'newKvps' => 'FRAA02630',
        'comercialName' => 'ALMA DIFFUSION AUTOMOBILES'
    ], [
        'originalContractNumber' => '01002369',
        'newContractNumber' => '01003811',
        'originalKvps' => 'FRAA02163',
        'newKvps' => 'FRAA02631',
        'comercialName' => 'ALMA DIFFUSION AUTOMOBILES'
    ], [
        'originalContractNumber' => '01002370',
        'newContractNumber' => '01003814',
        'originalKvps' => 'FRAA02079',
        'newKvps' => 'FRAA02632',
        'comercialName' => 'ALMA DIFFUSION AUTOMOBILES'
    ], [
        'originalContractNumber' => '01003320',
        'newContractNumber' => '01003320',
        'originalKvps' => 'FRAA05460',
        'newKvps' => 'FRAA02523',
        'comercialName' => 'CAR'
    ], [
        'originalContractNumber' => '01004900',
        'newContractNumber' => null,
        'originalKvps' => null,
        'newKvps' => 'FRAA04900',
        'comercialName' => 'AVENIR AUTOMOBILES'
    ], [
        'originalContractNumber' => '01000767',
        'newContractNumber' => null,
        'originalKvps' => null,
        'newKvps' => 'FRAA06490',
        'comercialName' => 'DUGAST'
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
            }

            if ($dataRegistryUser['newContractNumber'] !== NULL) {
                $partner->setContractNumber($dataRegistryUser['newContractNumber']);
            }

            if ($dataRegistryUser['newKvps'] !== NULL) {
                $partner->setKvpsNumber($dataRegistryUser['newKvps']);
            }
            
            if ($dataRegistryUser['comercialName'] !== NULL) {
                $partner->setCorporateName($dataRegistryUser['newKvps']);
                $partner->setCommercialName($dataRegistryUser['newKvps']);
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
