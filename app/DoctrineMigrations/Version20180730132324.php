<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\Yaml\Yaml;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180730132324 extends AbstractMigration
{
    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'Links partners with registry_user ids.';
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $partners = Yaml::parseFile(__DIR__.'/data/partners.yml');

        foreach ($partners as $registryUserId => $partnerUsername) {
            // extract kvps and type number from username
            list($kvpsNumber, $domain) = explode('@', $partnerUsername);
            $type = $domain === 'audi.fr' ? 'sales' : 'afterSales';
            $result = $this->connection->fetchAll('SELECT * FROM partner WHERE kvps_number = "'.$kvpsNumber.'" AND type = "'.$type.'";');
            if (1 === count($result)) {
                $this->connection->insert('partner_registry_user', [
                    'registry_user_id' => $registryUserId,
                    'partner_id' => $result[0]['id'],
                    'department_id' => 14,
                    'position_id' => 17,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
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
}
