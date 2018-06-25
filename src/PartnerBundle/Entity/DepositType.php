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
 * @ORM\Entity(repositoryClass="PartnerBundle\Repository\DepositTypeRepository")
 * @ORM\Table(name="deposit_type")
 */
class DepositType extends BaseEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     * @Groups({"rest"})
     */
    protected $id;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @Groups({"rest"})
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     * @Groups({"rest"})
     */
    protected $updatedAt;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true, options={"default":1})
     * @Assert\Type("bool")
     * @Groups({"rest"})
     */
    protected $depositVehicleWorkshop;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"rest"})
     */
    protected $depositVehicleWorkshopDaysBeforeFreeCalendar;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true, options={"default":0})
     * @Assert\Type("bool")
     * @Groups({"rest"})
     */
    protected $depositWaitOnSpot;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"rest"})
     */
    protected $depositWaitOnSpotDaysBeforeFreeCalendar;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true, options={"default":0})
     * @Assert\Type("bool")
     * @Groups({"rest"})
     */
    protected $depositReplacementVehicle;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"rest"})
     */
    protected $depositReplacementVehicleDaysBeforeFreeCalendar;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true, options={"default":0})
     * @Assert\Type("bool")
     * @Groups({"rest"})
     */
    protected $depositValetParking;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"rest"})
     */
    protected $depositValetParkingDaysBeforeFreeCalendar;

    /**
     * @var int
     *
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"rest"})
     */
    protected $depositValetParkingPrice;

    /**
     * Partner constructor.
     */
    public function __construct()
    {
        $this->depositVehicleWorkshop = true;
        $this->depositWaitOnSpot = false;
        $this->depositReplacementVehicle = false;
        $this->depositValetParking = false;
        $this->depositVehicleWorkshopDaysBeforeFreeCalendar = 5;
        $this->depositWaitOnSpotDaysBeforeFreeCalendar = 0;
        $this->depositReplacementVehicleDaysBeforeFreeCalendar = 0;
        $this->depositValetParkingDaysBeforeFreeCalendar = 0;
        $this->depositValetParkingPrice = 0;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set depositVehicleWorkshop
     *
     * @param boolean $depositVehicleWorkshop
     *
     * @return DepositType
     */
    public function setDepositVehicleWorkshop($depositVehicleWorkshop)
    {
        $this->depositVehicleWorkshop = $depositVehicleWorkshop;

        return $this;
    }

    /**
     * Get depositVehicleWorkshop
     *
     * @return boolean
     */
    public function getDepositVehicleWorkshop()
    {
        return $this->depositVehicleWorkshop;
    }

    /**
     * Set depositVehicleWorkshopDaysBeforeFreeCalendar
     *
     * @param integer $depositVehicleWorkshopDaysBeforeFreeCalendar
     *
     * @return DepositType
     */
    public function setDepositVehicleWorkshopDaysBeforeFreeCalendar($depositVehicleWorkshopDaysBeforeFreeCalendar)
    {
        $this->depositVehicleWorkshopDaysBeforeFreeCalendar = $depositVehicleWorkshopDaysBeforeFreeCalendar;

        return $this;
    }

    /**
     * Get depositVehicleWorkshopDaysBeforeFreeCalendar
     *
     * @return integer
     */
    public function getDepositVehicleWorkshopDaysBeforeFreeCalendar()
    {
        return $this->depositVehicleWorkshopDaysBeforeFreeCalendar;
    }

    /**
     * Set depositWaitOnSpot
     *
     * @param boolean $depositWaitOnSpot
     *
     * @return DepositType
     */
    public function setDepositWaitOnSpot($depositWaitOnSpot)
    {
        $this->depositWaitOnSpot = $depositWaitOnSpot;

        return $this;
    }

    /**
     * Get depositWaitOnSpot
     *
     * @return boolean
     */
    public function getDepositWaitOnSpot()
    {
        return $this->depositWaitOnSpot;
    }

    /**
     * Set depositWaitOnSpotDaysBeforeFreeCalendar
     *
     * @param integer $depositWaitOnSpotDaysBeforeFreeCalendar
     *
     * @return DepositType
     */
    public function setDepositWaitOnSpotDaysBeforeFreeCalendar($depositWaitOnSpotDaysBeforeFreeCalendar)
    {
        $this->depositWaitOnSpotDaysBeforeFreeCalendar = $depositWaitOnSpotDaysBeforeFreeCalendar;

        return $this;
    }

    /**
     * Get depositWaitOnSpotDaysBeforeFreeCalendar
     *
     * @return integer
     */
    public function getDepositWaitOnSpotDaysBeforeFreeCalendar()
    {
        return $this->depositWaitOnSpotDaysBeforeFreeCalendar;
    }

    /**
     * Set depositReplacementVehicle
     *
     * @param boolean $depositReplacementVehicle
     *
     * @return DepositType
     */
    public function setDepositReplacementVehicle($depositReplacementVehicle)
    {
        $this->depositReplacementVehicle = $depositReplacementVehicle;

        return $this;
    }

    /**
     * Get depositReplacementVehicle
     *
     * @return boolean
     */
    public function getDepositReplacementVehicle()
    {
        return $this->depositReplacementVehicle;
    }

    /**
     * Set depositReplacementVehicleDaysBeforeFreeCalendar
     *
     * @param integer $depositReplacementVehicleDaysBeforeFreeCalendar
     *
     * @return DepositType
     */
    public function setDepositReplacementVehicleDaysBeforeFreeCalendar($depositReplacementVehicleDaysBeforeFreeCalendar)
    {
        $this->depositReplacementVehicleDaysBeforeFreeCalendar = $depositReplacementVehicleDaysBeforeFreeCalendar;

        return $this;
    }

    /**
     * Get depositReplacementVehicleDaysBeforeFreeCalendar
     *
     * @return integer
     */
    public function getDepositReplacementVehicleDaysBeforeFreeCalendar()
    {
        return $this->depositReplacementVehicleDaysBeforeFreeCalendar;
    }

    /**
     * Set depositValetParking
     *
     * @param boolean $depositValetParking
     *
     * @return DepositType
     */
    public function setDepositValetParking($depositValetParking)
    {
        $this->depositValetParking = $depositValetParking;

        return $this;
    }

    /**
     * Get depositValetParking
     *
     * @return boolean
     */
    public function getDepositValetParking()
    {
        return $this->depositValetParking;
    }

    /**
     * Set depositValetParkingDaysBeforeFreeCalendar
     *
     * @param integer $depositValetParkingDaysBeforeFreeCalendar
     *
     * @return DepositType
     */
    public function setDepositValetParkingDaysBeforeFreeCalendar($depositValetParkingDaysBeforeFreeCalendar)
    {
        $this->depositValetParkingDaysBeforeFreeCalendar = $depositValetParkingDaysBeforeFreeCalendar;

        return $this;
    }

    /**
     * Get depositValetParkingDaysBeforeFreeCalendar
     *
     * @return integer
     */
    public function getDepositValetParkingDaysBeforeFreeCalendar()
    {
        return $this->depositValetParkingDaysBeforeFreeCalendar;
    }

    /**
     * Set depositValetParkingPrice
     *
     * @param float $depositValetParkingPrice
     *
     * @return DepositType
     */
    public function setDepositValetParkingPrice($depositValetParkingPrice)
    {
        $this->depositValetParkingPrice = $depositValetParkingPrice;

        return $this;
    }

    /**
     * Get depositValetParkingPrice
     *
     * @return float
     */
    public function getDepositValetParkingPrice()
    {
        return $this->depositValetParkingPrice;
    }
}
