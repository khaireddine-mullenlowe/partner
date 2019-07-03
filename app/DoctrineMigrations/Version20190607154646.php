<?php

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Mullenlowe\CommonBundle\Doctrine\Migration\AbstractMullenloweMigration;
use PartnerBundle\Entity\Partner;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190607154646 extends AbstractMullenloweMigration
{
    const IMPORT_FILENAME = 'partners_fer_membership.xlsx';
    const TYPE_AFTER_SALES = 'aftersales';
    const FER_MEMBERSHIP = [
        'Oui' => true,
        'Non' => false
    ];

    /**
     * @param Schema $schema
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function up(Schema $schema)
    {
        $this->updateFerMembership();
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function down(Schema $schema)
    {
        $this->updateFerMembership();
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    private function updateFerMembership()
    {
        $importPath = $this->getExcelPath();
        $spreadsheet = IOFactory::load($importPath);
        $data = $spreadsheet->getActiveSheet()->rangeToArray('A2:I212');

        foreach ($data as $dataPartner) {
            if (!empty($dataPartner[5])) {
                /** @var Partner $partner */
                $partner = $this->getEntityManager()->getRepository('PartnerBundle:Partner')->findOneBy([
                    'kvpsNumber' => $dataPartner[5],
                    'type' => self::TYPE_AFTER_SALES
                ]);

                if (!is_null($partner) && !empty($dataPartner[8]) && isset(self::FER_MEMBERSHIP[$dataPartner[8]])) {
                    $partner->setFerMembership(self::FER_MEMBERSHIP[$dataPartner[8]]);
                    $this->getEntityManager()->persist($partner);
                }
            }
        }

        $this->getEntityManager()->flush();
    }

    /**
     * @return string
     */
    private function getExcelPath(): string
    {
        $rootDir = $this->container->getParameter('kernel.root_dir');
        
        return $rootDir . '/../src/PartnerBundle/Resources/dataMigration/' . self::IMPORT_FILENAME;
    }
}
