<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Connection;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\DBAL\Migrations\AbortMigrationException;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180904142103 extends AbstractMigration implements ContainerAwareInterface
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
        return 'Binds registry user fraa01866@audi.com to its partner.';
    }

    /**
     * @param Schema $schema
     *
     * @throws AbortMigrationException
     */
    public function up(Schema $schema)
    {
        // get fraa01866@audi.com registry user
        $registryUser = $this->userConnection->fetchAll("SELECT r.id, r.username FROM registry_user r WHERE username = \"fraa01866@audi.com\";");

        $department = $this->connection->fetchAll("SELECT d.id FROM company_department d WHERE legacy_id = 427;");
        $this->abortIf(0 === count($department), '"Direction" department not found.');

        $position = $this->connection->fetchAll("SELECT d.id FROM company_position d WHERE legacy_id = 502;");
        $this->abortIf(0 === count($position), '"Directeur général" position not found.');

        $result = $this->connection->fetchAll('SELECT * FROM partner WHERE kvps_number = "fraa01866" AND type = "afterSales";');
        $this->abortIf(1 ==! count($department), 'Partner not found.');

        $this->connection->insert('partner_registry_user', [
            'registry_user_id' => $registryUser[0]['id'],
            'partner_id' => $result[0]['id'],
            'department_id' => $department[0]['id'],
            'position_id' => $position[0]['id'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
