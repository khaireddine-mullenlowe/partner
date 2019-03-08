<?php

namespace Application\Migrations;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use PartnerBundle\Entity\DepositType;
use PartnerBundle\Entity\Partner;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\ORM\EntityManager;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181115173102 extends AbstractMigration implements ContainerAwareInterface
{
    /**@var ContainerInterface $container*/
    private $container;

    /**@var Connection $agcv4Connection*/
    private $agcv4Connection;

    /**@var Connection $defaultConnection*/
    private $defaultConnection;

    /** @var EntityManager $entityManager */
    private $entityManager;

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
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('Doctrine is required for this migration');
        }

        $this->entityManager = $this->container->get('doctrine')->getManager();

        if (!$this->container->has('doctrine.dbal.agcv4_connection')) {
            throw new \LogicException('AGCV4 connection is required for this migration');
        }

        $this->agcv4Connection = $this->container->get('doctrine.dbal.agcv4_connection');
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->connection->setAutoCommit(false);
        $this->connection->beginTransaction();

        try {
            $deposits = self::getDepositLegacyData();

            foreach ($deposits as $deposit) {
                $partner = self::getPartner($deposit['legacy_id']);
                $depositPartner = self::setDepositPartner($deposit);
                $partner->setDepositType($depositPartner);
                $this->entityManager->persist($partner);
            }

            $this->entityManager->flush();
            $this->connection->commit();
        } catch (\Exception $ex) {
            $this->connection->rollBack();
            $this->connection->close();
            throw $ex;
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
     * @param string $email
     * @return int
     */
    private function getDepositLegacyData()
    {
        $query = "SELECT DISTINCT
                        a.createdAt AS created_at,
                        a.updatedAt AS updated_at,
                        CASE WHEN
                        ISNULL((
                            SELECT d.ecom_additional_service_id
                            FROM [ecom_service_by_partner] d
                            WHERE ecom_aftersales_dealer_id = a.ecom_aftersales_dealer_id AND d.ecom_additional_service_id = 1
                        ), 0) > 0 THEN 1 ELSE 0 END AS vehicle_workshop,
                        ISNULL((
                            SELECT e.nb_date_before
                            FROM [ecom_service_by_partner] e
                            WHERE ecom_aftersales_dealer_id = a.ecom_aftersales_dealer_id AND e.ecom_additional_service_id = 1
                        ), 0) AS vehicle_workshop_days_before_free_calendar,
                        CASE WHEN
                        ISNULL((
                            SELECT f.ecom_additional_service_id
                            FROM [ecom_service_by_partner] f
                            WHERE ecom_aftersales_dealer_id = a.ecom_aftersales_dealer_id AND f.ecom_additional_service_id = 2
                        ), 0) > 0 THEN 1 ELSE 0 END AS wait_on_spot,
                        ISNULL((
                            SELECT g.nb_date_before
                            FROM [ecom_service_by_partner] g
                            WHERE ecom_aftersales_dealer_id = a.ecom_aftersales_dealer_id AND g.ecom_additional_service_id = 2
                        ), 0) AS wait_on_spot_days_before_free_calendar,
                        CASE WHEN
                        ISNULL((
                            SELECT h.ecom_additional_service_id
                            FROM [ecom_service_by_partner] h
                            WHERE ecom_aftersales_dealer_id = a.ecom_aftersales_dealer_id AND h.ecom_additional_service_id = 3
                        ), 0) > 0 THEN 1 ELSE 0 END AS replacement_vehicle,
                        ISNULL((
                            SELECT i.nb_date_before
                            FROM [ecom_service_by_partner] i
                            WHERE ecom_aftersales_dealer_id = a.ecom_aftersales_dealer_id AND i.ecom_additional_service_id = 3
                        ), 0) AS replacement_vehicle_days_before_free_calendar,
                        CASE WHEN
                        ISNULL((
                            SELECT j.ecom_additional_service_id
                            FROM [ecom_service_by_partner] j
                            WHERE ecom_aftersales_dealer_id = a.ecom_aftersales_dealer_id AND j.ecom_additional_service_id = 4
                        ), 0) > 0 THEN 1 ELSE 0 END AS valet_parking,
                        ISNULL((
                            SELECT k.nb_date_before
                            FROM [ecom_service_by_partner] k
                            WHERE ecom_aftersales_dealer_id = a.ecom_aftersales_dealer_id AND k.ecom_additional_service_id = 4
                        ), 0) AS valet_parking_days_before_free_calendar,
                        ISNULL((
                            SELECT l.price_voiturier
                            FROM [ecom_service_by_partner] l
                            WHERE ecom_aftersales_dealer_id = a.ecom_aftersales_dealer_id AND l.ecom_additional_service_id = 4
                        ), 0) AS valet_parking_price,
                        c.company_id AS legacy_id
                    FROM [ecom_service_by_partner] a
                    INNER JOIN ecom_aftersales_dealer b ON b.id = a.ecom_aftersales_dealer_id
                    INNER JOIN ntw_company_business c ON c.contract_number = b.contract_number";

        $deposits = $this->agcv4Connection->fetchAll($query);
        $this->agcv4Connection->close();

        if (empty($deposits)) {
            throw new \LogicException('No deposit found with in AGCV4 data base');
        }

        return (array) $deposits;
    }

    /**
     * @return Partner
     * @throws \LogicException
     */
    private function getPartner(int $legacyId)
    {
        $partner = $this->entityManager->getRepository('PartnerBundle:Partner')->findOneBy([
            'legacyId' => $legacyId
        ]);

        if (!$partner instanceof Partner) {
            throw new \LogicException(sprintf('Partner with legacyId %s must be defined', $legacyId));
        }

        return $partner;
    }

    /**
     * @param int $legacyId
     * @return mixed
     */
    private function setDepositPartner(array $deposit)
    {
        $depositPartner = new DepositType();
        $depositPartner->setCreatedAt(new \DateTime($deposit['created_at']));
        $depositPartner->setUpdatedAt(new \DateTime($deposit['updated_at']));
        $depositPartner->setVehicleWorkshop((bool) $deposit['vehicle_workshop']);
        $depositPartner
            ->setVehicleWorkshopDaysBeforeFreeCalendar((int) $deposit['vehicle_workshop_days_before_free_calendar']);
        $depositPartner->setWaitOnSpot((bool) $deposit['wait_on_spot']);
        $depositPartner->setWaitOnSpotDaysBeforeFreeCalendar((int) $deposit['wait_on_spot_days_before_free_calendar']);
        $depositPartner->setReplacementVehicle((bool) $deposit['replacement_vehicle']);
        $depositPartner
            ->setReplacementVehicleDaysBeforeFreeCalendar(
                (int) $deposit['replacement_vehicle_days_before_free_calendar']
            );
        $depositPartner->setValetParking((bool) $deposit['valet_parking']);
        $depositPartner
            ->setVehicleWorkshopDaysBeforeFreeCalendar((int) $deposit['valet_parking_days_before_free_calendar']);
        $depositPartner->setValetParkingPrice((float) $deposit['valet_parking_price']);

        try {
            $this->entityManager->persist($depositPartner);
        } catch (\Exception $exception) {
            $this->entityManager->rollback();
            throw $exception;
        }

        return $depositPartner;
    }
}
