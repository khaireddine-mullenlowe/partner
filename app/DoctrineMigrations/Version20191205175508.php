<?php

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Mullenlowe\CommonBundle\Doctrine\Migration\AbstractMullenloweMigration;
use PartnerBundle\Entity\Partner;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191205175508 extends AbstractMullenloweMigration
{
    const IMPORT_FILENAME = 'LST_191204_MAG-ListeConcessionsAudiDeploiement.xlsx';

    /**
     * @param Schema $schema
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function up(Schema $schema)
    {
        $this->updateOnlineQuotation();
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function down(Schema $schema)
    {
        $this->updateOnlineQuotation();
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    private function updateOnlineQuotation()
    {
        $importPath = $this->getExcelPath();
        $spreadsheet = IOFactory::load($importPath);
        $data = $spreadsheet->getActiveSheet()->rangeToArray('A2:B63');

        foreach ($data as $dataPartner) {
            if (!empty($dataPartner[1])) {
                /** @var Partner $partner */
                $partner = $this->getEntityManager()->getRepository('PartnerBundle:Partner')->findOneBy([
                    'contractNumber' => $dataPartner[1],
                    'type' => 'aftersales'
                ]);

                if (!is_null($partner) && !$partner->isOnlineQuotation()) {
                    $partner->setOnlineQuotation(true);
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
