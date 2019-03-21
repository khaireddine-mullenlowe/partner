<?php

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Mullenlowe\CommonBundle\Doctrine\Migration\AbstractMullenloweMigration;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190320164028 extends AbstractMullenloweMigration
{
    const IMPORT_FILENAME = 'online_quotation.xlsx';

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
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    private function updateOnlineQuotation()
    {
        $importPath = $this->getExcelPath();
        $spreadsheet = IOFactory::load($importPath);
        $data = $spreadsheet->getActiveSheet()->rangeToArray('A1:E40');

        foreach ($data as $datum) {
            if (!empty($datum[2])) {
                $qb = $this->connection->createQueryBuilder();
                $qb->update('partner', 'p')
                    ->set('p.online_quotation', 1)
                    ->andWhere('p.kvps_number = :kvps_number')
                    ->andWhere('p.type = :aftersales')
                    ->setParameters(['kvps_number' => $datum[2], 'aftersales' => 'aftersales'])
                    ->execute();
            }
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

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
