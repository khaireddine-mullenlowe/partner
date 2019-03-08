<?php

namespace PartnerBundle\Entity;

use Mullenlowe\CommonBundle\Entity\Base\BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class DepositType
 * @package PartnerBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="deposit_type")
 */
class DepositType extends BaseEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     * @Groups({"rest", "amqp"})
     */
    protected $id;

    /**
     * @var Partner
     *
     * @ORM\OneToOne(targetEntity="PartnerBundle\Entity\Partner", mappedBy="depositType")
     */
    protected $partner;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @Groups({"rest", "amqp"})
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     * @Groups({"rest", "amqp"})
     */
    protected $updatedAt;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false, options={"default":1})
     * @Assert\Type("bool")
     * @Groups({"rest", "amqp"})
     */
    protected $vehicleWorkshop = true;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"rest", "amqp"})
     */
    protected $vehicleWorkshopDaysBeforeFreeCalendar = 5;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false, options={"default":0})
     * @Assert\Type("bool")
     * @Groups({"rest", "amqp"})
     */
    protected $waitOnSpot = false;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"rest", "amqp"})
     */
    protected $waitOnSpotDaysBeforeFreeCalendar = 0;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false, options={"default":0})
     * @Assert\Type("bool")
     * @Groups({"rest", "amqp"})
     */
    protected $replacementVehicle = false;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"rest", "amqp"})
     */
    protected $replacementVehicleDaysBeforeFreeCalendar = 0;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false, options={"default":0})
     * @Assert\Type("bool")
     * @Groups({"rest", "amqp"})
     */
    protected $valetParking = false;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"rest", "amqp"})
     */
    protected $valetParkingDaysBeforeFreeCalendar = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"rest", "amqp"})
     */
    protected $valetParkingPrice = 0;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Partner
     */
    public function getPartner()
    {
        return $this->partner;
    }

    /**
     * @param Partner $partner
     * @return DepositType
     */
    public function setPartner($partner)
    {
        $this->partner = $partner;

        return $this;
    }

    /**
     * Set vehicleWorkshop
     *
     * @param boolean $vehicleWorkshop
     *
     * @return DepositType
     */
    public function setVehicleWorkshop($vehicleWorkshop)
    {
        $this->vehicleWorkshop = $vehicleWorkshop;

        return $this;
    }

    /**
     * Get vehicleWorkshop
     *
     * @return boolean
     */
    public function getVehicleWorkshop()
    {
        return $this->vehicleWorkshop;
    }

    /**
     * Set vehicleWorkshopDaysBeforeFreeCalendar
     *
     * @param integer $vehicleWorkshopDaysBeforeFreeCalendar
     *
     * @return DepositType
     */
    public function setVehicleWorkshopDaysBeforeFreeCalendar($vehicleWorkshopDaysBeforeFreeCalendar)
    {
        $this->vehicleWorkshopDaysBeforeFreeCalendar = $vehicleWorkshopDaysBeforeFreeCalendar;

        return $this;
    }

    /**
     * Get vehicleWorkshopDaysBeforeFreeCalendar
     *
     * @return integer
     */
    public function getVehicleWorkshopDaysBeforeFreeCalendar()
    {
        return $this->vehicleWorkshopDaysBeforeFreeCalendar;
    }

    /**
     * Set waitOnSpot
     *
     * @param boolean $waitOnSpot
     *
     * @return DepositType
     */
    public function setWaitOnSpot($waitOnSpot)
    {
        $this->waitOnSpot = $waitOnSpot;

        return $this;
    }

    /**
     * Get waitOnSpot
     *
     * @return boolean
     */
    public function getWaitOnSpot()
    {
        return $this->waitOnSpot;
    }

    /**
     * Set waitOnSpotDaysBeforeFreeCalendar
     *
     * @param integer $waitOnSpotDaysBeforeFreeCalendar
     *
     * @return DepositType
     */
    public function setWaitOnSpotDaysBeforeFreeCalendar($waitOnSpotDaysBeforeFreeCalendar)
    {
        $this->waitOnSpotDaysBeforeFreeCalendar = $waitOnSpotDaysBeforeFreeCalendar;

        return $this;
    }

    /**
     * Get waitOnSpotDaysBeforeFreeCalendar
     *
     * @return integer
     */
    public function getWaitOnSpotDaysBeforeFreeCalendar()
    {
        return $this->waitOnSpotDaysBeforeFreeCalendar;
    }

    /**
     * Set replacementVehicle
     *
     * @param boolean $replacementVehicle
     *
     * @return DepositType
     */
    public function setReplacementVehicle($replacementVehicle)
    {
        $this->replacementVehicle = $replacementVehicle;

        return $this;
    }

    /**
     * Get replacementVehicle
     *
     * @return boolean
     */
    public function getReplacementVehicle()
    {
        return $this->replacementVehicle;
    }

    /**
     * Set replacementVehicleDaysBeforeFreeCalendar
     *
     * @param integer $replacementVehicleDaysBeforeFreeCalendar
     *
     * @return DepositType
     */
    public function setReplacementVehicleDaysBeforeFreeCalendar($replacementVehicleDaysBeforeFreeCalendar)
    {
        $this->replacementVehicleDaysBeforeFreeCalendar = $replacementVehicleDaysBeforeFreeCalendar;

        return $this;
    }

    /**
     * Get replacementVehicleDaysBeforeFreeCalendar
     *
     * @return integer
     */
    public function getReplacementVehicleDaysBeforeFreeCalendar()
    {
        return $this->replacementVehicleDaysBeforeFreeCalendar;
    }

    /**
     * Set valetParking
     *
     * @param boolean $valetParking
     *
     * @return DepositType
     */
    public function setValetParking($valetParking)
    {
        $this->valetParking = $valetParking;

        return $this;
    }

    /**
     * Get valetParking
     *
     * @return boolean
     */
    public function getValetParking()
    {
        return $this->valetParking;
    }

    /**
     * Set valetParkingDaysBeforeFreeCalendar
     *
     * @param integer $valetParkingDaysBeforeFreeCalendar
     *
     * @return DepositType
     */
    public function setValetParkingDaysBeforeFreeCalendar($valetParkingDaysBeforeFreeCalendar)
    {
        $this->valetParkingDaysBeforeFreeCalendar = $valetParkingDaysBeforeFreeCalendar;

        return $this;
    }

    /**
     * Get valetParkingDaysBeforeFreeCalendar
     *
     * @return integer
     */
    public function getValetParkingDaysBeforeFreeCalendar()
    {
        return $this->valetParkingDaysBeforeFreeCalendar;
    }

    /**
     * Set valetParkingPrice
     *
     * @param float $valetParkingPrice
     *
     * @return DepositType
     */
    public function setValetParkingPrice($valetParkingPrice)
    {
        $this->valetParkingPrice = $valetParkingPrice;

        return $this;
    }

    /**
     * Get valetParkingPrice
     *
     * @return float
     */
    public function getValetParkingPrice()
    {
        return $this->valetParkingPrice;
    }
}
