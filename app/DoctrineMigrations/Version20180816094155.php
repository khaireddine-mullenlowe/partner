<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use PartnerBundle\Enum\PartnerTypeEnum;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Version20180816094155 extends AbstractMigration implements ContainerAwareInterface
{
    const PATTERN_CDV = '/Chef de District Vente/';
    const PATTERN_CRO = '/Chef de Region Operationnel/';

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $regions = $this->connection->fetchAll(sprintf("SELECT * 
            FROM region 
            WHERE partnerType = '%s';", PartnerTypeEnum::TYPE_SALES));
        $districts = $this->connection->fetchAll("SELECT d.* 
            FROM district d
            LEFT JOIN region r on d.region_id = r.id 
            WHERE r.partnerType = 'sales';");

        $result = $this->connection->fetchAll("SELECT * 
            FROM company_registry_user 
            where company_id = 5 
            and position_description regexp '[0-9]'
            and (lower(position_description) regexp 'région' or lower(position_description) regexp 'district');");

        foreach ($result as $companyRegistryUser) {
            $companyRegistryUser['position_description'] = str_replace('é', 'e', $companyRegistryUser['position_description']);
            if (preg_match(self::PATTERN_CDV, $companyRegistryUser['position_description'])) {

                $companyRegistryUser['district_id'] = $this->searchEntityId(
                    self::PATTERN_CDV,
                    $companyRegistryUser['position_description'],
                    $districts);
                if (null !== $companyRegistryUser['district_id']) {
                    $this->connection->update('company_registry_user',
                        ['district_id' => $companyRegistryUser['district_id']],
                        ['id' => $companyRegistryUser['id']]
                    );
                }
                continue;
            }

            if (preg_match(self::PATTERN_CRO, $companyRegistryUser['position_description'])) {

                $companyRegistryUser['region_id'] = $this->searchEntityId(
                    self::PATTERN_CRO,
                    $companyRegistryUser['position_description'],
                    $regions);
                if (null !== $companyRegistryUser['region_id']) {
                    $this->connection->update('company_registry_user',
                        ['region_id' => $companyRegistryUser['region_id']],
                        ['id' => $companyRegistryUser['id']]
                    );
                }
                continue;
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
     * @param string $pattern
     * @param string $description
     * @param array $data
     * @return null|int
     */
    private function searchEntityId($pattern, $description, $data)
    {
        $entityName = $this->formatName($pattern, $description);

        foreach ($data as $value) {
            if ($value['name'] != $entityName) { continue; }

            return $value['id'];
        }

        return null;
    }

    /**
     * @param string $pattern
     * @param string $description
     * @return string
     */
    private function formatName($pattern, $description)
    {
        $districtName = trim(preg_replace($pattern, '', $description));

        return str_pad($districtName, 2, "0", STR_PAD_LEFT);
    }
}
