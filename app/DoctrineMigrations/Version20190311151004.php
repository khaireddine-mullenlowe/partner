<?php

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManager;
use Mullenlowe\CommonBundle\Doctrine\Migration\AbstractMullenloweMigration;
use PartnerBundle\Entity\Partner;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190311151004 extends AbstractMullenloweMigration
{
    const IMPORT_FILENAME = 'rcs_identification_tva.csv';

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param Schema $schema
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function up(Schema $schema)
    {
        $this->updateRcsNumberAndIdentificationTva();
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    private function updateRcsNumberAndIdentificationTva()
    {
        $importPath = $this->getExcelPath();
        $spreadsheet = IOFactory::load($importPath);
        $data = $spreadsheet->getActiveSheet()->rangeToArray('A1:C214');

        foreach ($data as $datum) {
            if (
                !empty($datum[0]) &&
                !empty($datum[1]) &&
                !empty($datum[2])
            ) {
                $kvpsNumber = sprintf('%s%s', 'FRAA', $datum[0]);
                $qb = $this->connection->createQueryBuilder();
                $qb->update('partner', 'p')
                    ->set('p.rcs_number', '"'.$datum[1].'"')
                    ->set('p.identification_tva', '"'.$datum[2].'"')
                    ->andWhere('p.kvps_number = :kvps_number')
                    ->andWhere('p.type = :aftersales')
                    ->setParameters(['kvps_number' => $kvpsNumber, 'aftersales' => 'aftersales'])
                    ->execute();
            }
        }
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
