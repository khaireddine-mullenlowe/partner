<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Connection;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180911093309 extends AbstractMigration implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /** @var EntityManager $entityManager */
    private $entityManager;
    /** @var Connection $userConnection */
    private $userConnection;

    /**
     * @param Schema $schema
     * @throws \LogicException
     */
    public function preUp(Schema $schema)
    {
        $this->configure();
    }

    /**
     * @param Schema $schema
     * @throws \LogicException
     */
    public function preDown(Schema $schema)
    {
        $this->configure();
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->execute('christophebonet@autosudbernabeu.com', 'abremond.autosudbernabeu@gmail.com');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->execute('abremond.autosudbernabeu@gmail.com', 'christophebonet@autosudbernabeu.com');
    }

    /**
     * Configure required parameters
     */
    private function configure()
    {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('Doctrine is required for this migration');
        }

        $this->entityManager = $this->container->get('doctrine')->getManager();

        if (!$this->container->has('doctrine.dbal.user_connection')) {
            throw new \LogicException('User connection is required for this migration');
        }

        $this->userConnection = $this->container->get('doctrine.dbal.user_connection');
    }

    /**
     * Execute the up or down queries
     *
     * @param string $newUserEmail
     * @param string $oldUserEmail
     */
    private function execute(string $newUserEmail, string $oldUserEmail)
    {
        $newUserId = $this->getUser($newUserEmail);
        $oldUserId = $this->getUser($oldUserEmail);

        $partner = $this->connection->fetchAssoc('SELECT `id` FROM `partner` WHERE `contract_number` = \'01000877\'');
        if (!isset($partner['id'])) {
            throw new \LogicException('Unable to find a Partner using below contract number: 01000877');
        }

        $this->addSql($this->getUpdateQuery($newUserId, $oldUserId, (int) $partner['id']));
    }

    /**
     * @param string $email
     * @return int
     */
    private function getUser(string $email)
    {
        $user = $this->userConnection->fetchAssoc(sprintf('SELECT `id` FROM `registry_user` WHERE `email` = \'%s\' LIMIT 1', $email));
        if (!isset($user['id'])) {
            throw new \LogicException(sprintf('No user found with email %s', $email));
        }

        return (int) $user['id'];
    }

    /**
     * @param int $newUserId
     * @param int $oldUserId
     * @param int $partnerId
     * @return string
     */
    private function getUpdateQuery(int $newUserId, int $oldUserId, int $partnerId)
    {
        return sprintf('
            UPDATE `partner_registry_user`
            SET `registry_user_id` = %s
            WHERE `partner_id` = %s
            AND`registry_user_id` = %s
            AND `position_id` IN (39, 40)
        ', $newUserId, $partnerId, $oldUserId);
    }
}
