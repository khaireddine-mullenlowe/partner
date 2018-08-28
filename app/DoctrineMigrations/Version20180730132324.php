<?php

namespace Application\Migrations;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Migrations\AbortMigrationException;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180730132324 extends AbstractMigration implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Connection
     */
    private $userConnection;

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
    public function preUp(Schema $schema)
    {
        $this->userConnection = $this->container->get('doctrine.dbal.user_connection');
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'Links partners with registry_user ids.';
    }

    /**
     * @param Schema $schema
     *
     * @throws AbortMigrationException
     */
    public function up(Schema $schema)
    {
        // get fraa prefixed users
        $registryUserPartners = $this->userConnection->fetchAll("SELECT r.id, r.username FROM registry_user r WHERE username REGEXP \"^FRAA[[:digit:]]+@audi.(fr|com|net)$\";");
        $department = $this->connection->fetchAll("SELECT d.id FROM company_department d WHERE legacy_id = 427;");
        $this->abortIf(0 === count($department), '"Direction" department not found.');

        $position = $this->connection->fetchAll("SELECT d.id FROM company_position d WHERE legacy_id = 502;");
        $this->abortIf(0 === count($position), '"Directeur général" position not found.');

        foreach ($registryUserPartners as $registryUserPartner) {
            // extract kvps and type number from username
            list($kvpsNumber, $domain) = explode('@', $registryUserPartner['username']);
            $type = $domain === 'audi.fr' ? 'sales' : 'afterSales';
            $result = $this->connection->fetchAll('SELECT * FROM partner WHERE kvps_number = "'.$kvpsNumber.'" AND type = "'.$type.'";');
            if (1 === count($result)) {
                $this->connection->insert('partner_registry_user', [
                    'registry_user_id' => $registryUserPartner['id'],
                    'partner_id' => $result[0]['id'],
                    'department_id' => $department[0]['id'],
                    'position_id' => $position[0]['id'],
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
