<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use PartnerBundle\Entity\CompanyDepartment;
use PartnerBundle\Entity\CompanyPosition;
use PartnerBundle\Entity\Partner;
use PartnerBundle\Entity\PartnerRegistryUser;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Connection;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180911152025 extends AbstractMigration implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /** @var EntityManager $entityManager */
    private $entityManager;
    /** @var Connection $userConnection */
    private $userConnection;
    /** @var CompanyDepartment[] $departments */
    private $departments = [];
    /** @var CompanyPosition[] $positions */
    private $positions = [];

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
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function up(Schema $schema)
    {
        $this->connection->setAutoCommit(false);
        $this->connection->beginTransaction();

        try {
            $registryUserIdToDelete  = $this->getRegistryUserId('sebastien.mary@villers-services-center.com');
            $directorRegistryUserId  = $this->getRegistryUserId('jerome.lhoste@vgrf.fr');
            $secretaryRegistryUserId = $this->getRegistryUserId('marine.perraudin@villers-services-center.com');

            $region   = null;
            $district = null;

            $partner = $this->getPartner();

            /** @var PartnerRegistryUser[] $partnerRegistryUsersToDelete */
            $partnerRegistryUsersToDelete = $this->entityManager->getRepository('PartnerBundle:PartnerRegistryUser')->findBy([
                'partner'        => $partner,
                'registryUserId' => $registryUserIdToDelete,
            ]);

            foreach ($partnerRegistryUsersToDelete as $partnerRegistryUserToDelete) {
                $partner->removePartnerRegistryUser($partnerRegistryUserToDelete);

                if (is_null($region)) {
                    $region = $partnerRegistryUserToDelete->getRegion();
                }

                if (is_null($district)) {
                    $district = $partnerRegistryUserToDelete->getDistrict();
                }
            }

            $departmentNames = ['Commerce', 'Marketing'];

            foreach ($departmentNames as $departmentName) {
                $directorPartnerRegistryUser = new PartnerRegistryUser();
                $directorPartnerRegistryUser
                    ->setPartner($partner)
                    ->setRegistryUserId($directorRegistryUserId)
                    ->setDepartment($this->getDepartment($departmentName))
                    ->setPosition($this->getPosition('Directeur général'))
                    ->setRegion($region)
                    ->setDistrict($district)
                    ->setIsAdmin(false)
                    ->setVision(false)
                    ->setConvention(false)
                    ->setDealersMeeting(false)
                    ->setBrandDays(false)
                ;

                $secretaryPartnerRegistryUser = new PartnerRegistryUser();
                $secretaryPartnerRegistryUser
                    ->setPartner($partner)
                    ->setRegistryUserId($secretaryRegistryUserId)
                    ->setDepartment($this->getDepartment($departmentName))
                    ->setPosition($this->getPosition('Secrétaire commercial(e)'))
                    ->setRegion($region)
                    ->setDistrict($district)
                    ->setIsAdmin(false)
                    ->setVision(false)
                    ->setConvention(false)
                    ->setDealersMeeting(false)
                    ->setBrandDays(false)
                ;

                $this->entityManager->persist($directorPartnerRegistryUser);
                $this->entityManager->persist($secretaryPartnerRegistryUser);
            }

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
            'contractNumber' => '01002965'
        ]);

        if (!$partner instanceof Partner) {
            throw new \LogicException('Partner 01002965 must be defined');
        }

        return $partner;
    }

    /**
     * @param string $departmentName
     * @return CompanyDepartment
     */
    private function getDepartment(string $departmentName)
    {
        if (!array_key_exists($departmentName, $this->departments)) {
            $department = $this->entityManager->getRepository('PartnerBundle:CompanyDepartment')->findOneBy(['name' => $departmentName]);

            if (!$department instanceof CompanyDepartment) {
                throw new \LogicException(sprintf('Unable to find department %s', $departmentName));
            }

            $this->departments[$departmentName] = $department;
        }

        return $this->departments[$departmentName];
    }

    /**
     * @param string $positionName
     * @return CompanyPosition
     */
    private function getPosition(string $positionName)
    {
        if (!array_key_exists($positionName, $this->positions)) {
            $position = $this->entityManager->getRepository('PartnerBundle:CompanyPosition')->findOneBy(['name' => $positionName]);

            if (!$position instanceof CompanyPosition) {
                throw new \LogicException(sprintf('Unable to find position %s', $positionName));
            }

            $this->positions[$positionName] = $position;
        }

        return $this->positions[$positionName];
    }
}
