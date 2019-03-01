<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use PartnerBundle\Entity\CompanyDepartment;
use PartnerBundle\Entity\CompanyPosition;
use PartnerBundle\Entity\District;
use PartnerBundle\Entity\Partner;
use PartnerBundle\Entity\PartnerRegistryUser;
use PartnerBundle\Entity\Region;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Connection;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180921140737 extends AbstractMigration implements ContainerAwareInterface
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
     * @param Schema $schema
     * @throws \Doctrine\DBAL\ConnectionException|\Exception
     */
    public function up(Schema $schema)
    {
        $this->connection->setAutoCommit(false);
        $this->connection->beginTransaction();

        try {
            $directorRegistryUserId  = $this->getRegistryUserId('FRAA01866@audi.com');

            $region   = null;
            $district = null;
            $partner  = $this->getPartner();

            $directorPartnerRegistryUser = new PartnerRegistryUser();
            $directorPartnerRegistryUser
                ->setPartner($partner)
                ->setRegistryUserId($directorRegistryUserId)
                ->setDepartment($this->getDepartment('Direction'))
                ->setPosition($this->getPosition('Directeur général'))
                ->setRegion($this->getRegion())
                ->setDistrict($this->getDistrict())
                ->setIsAdmin(false)
                ->setVision(false)
                ->setConvention(false)
                ->setDealersMeeting(false)
                ->setBrandDays(false)
            ;

            $this->entityManager->persist($directorPartnerRegistryUser);
            $this->entityManager->flush();
            $this->connection->commit();
        } catch (\Exception $ex) {
            $this->connection->rollBack();
            throw $ex;
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // Unable to rollback
    }

    /**
     * @param string $email
     * @return int
     */
    private function getRegistryUserId(string $email)
    {
        $user = $this->userConnection->fetchAssoc(sprintf('SELECT `id` FROM `registry_user` WHERE `email` = \'%s\' LIMIT 1', $email));

        if (!isset($user['id'])) {
            throw new \LogicException(sprintf('No user found with email %s', $email));
        }

        return (int) $user['id'];
    }

    /**
     * @return Partner
     * @throws \LogicException
     */
    private function getPartner()
    {
        $partner = $this->entityManager->getRepository('PartnerBundle:Partner')->findOneBy([
            'contractNumber' => '01001988'
        ]);

        if (!$partner instanceof Partner) {
            throw new \LogicException('Partner 01001988 must be defined');
        }

        return $partner;
    }

    /**
     * @param string $departmentName
     * @return CompanyDepartment
     */
    private function getDepartment(string $departmentName)
    {
        $department = $this->entityManager->getRepository('PartnerBundle:CompanyDepartment')->findOneBy(['name' => $departmentName]);

        if (!$department instanceof CompanyDepartment) {
            throw new \LogicException(sprintf('Unable to find department %s', $departmentName));
        }

        return $department;
    }

    /**
     * @param string $positionName
     * @return CompanyPosition
     */
    private function getPosition(string $positionName)
    {
        $position = $this->entityManager->getRepository('PartnerBundle:CompanyPosition')->findOneBy(['name' => $positionName]);

        if (!$position instanceof CompanyPosition) {
            throw new \LogicException(sprintf('Unable to find position %s', $positionName));
        }

        return $position;
    }

    /**
     * @return Region
     */
    private function getRegion()
    {
        $region = $this->entityManager->getRepository('PartnerBundle:Region')->findOneBy(['name' => '08']);

        if (!$region instanceof Region) {
            throw new \LogicException('Unable to find region 08');
        }

        return $region;
    }

    /**
     * @return District
     */
    private function getDistrict()
    {
        $district = $this->entityManager->getRepository('PartnerBundle:District')->findOneBy(['name' => '82']);

        if (!$district instanceof District) {
            throw new \LogicException('Unable to find district 82');
        }

        return $district;
    }
}
