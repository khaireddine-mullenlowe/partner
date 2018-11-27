<?php

namespace PartnerBundle\Entity;

use Mullenlowe\CommonBundle\Entity\Base\BaseEntity;
use PartnerBundle\Enum\OpeningHourDayEnum;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class OpeningHour
 * @package PartnerBundle\Entity
 *
 * @ORM\Entity(repositoryClass="PartnerBundle\Repository\OpeningHourRepository")
 * @ORM\Table(name="opening_hour")
 */
class OpeningHour extends BaseEntity
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
     * @var Partner
     *
     * @ORM\ManyToOne(targetEntity="PartnerBundle\Entity\Partner", inversedBy="openingHours")
     * @ORM\JoinColumn(name="partner_id", referencedColumnName="id", nullable=false)
     * @Groups({"rest"})
     * @Assert\NotNull(groups={"Default", "orchestrator"})
     */
    private $partner;

    /**
     * @ORM\Column(type="string")
     * @var string
     * @Assert\Choice(choices={
     *     OpeningHourDayEnum::MONDAY,
     *     OpeningHourDayEnum::TUESDAY,
     *     OpeningHourDayEnum::WEDNESDAY,
     *     OpeningHourDayEnum::THURSDAY,
     *     OpeningHourDayEnum::FRIDAY,
     *     OpeningHourDayEnum::SATURDAY,
     *     OpeningHourDayEnum::SUNDAY,
     * }, strict=true)
     * @Groups({"rest"})
     */
    protected $openingDay;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     * @Groups({"rest"})
     */
    protected $amStartHour;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     * @Groups({"rest"})
     */
    protected $amEndHour;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     * @Groups({"rest"})
     */
    protected $pmStartHour;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     * @Groups({"rest"})
     */
    protected $pmEndHour;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     * @Assert\Type("bool")
     * @Groups({"rest"})
     */
    protected $nox;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", options={"default":1})
     * @Groups({"rest"})
     */
    protected $status = 1;

    /**
     * @return Partner
     */
    public function getPartner()
    {
        return $this->partner;
    }

    /**
     * @param Partner $partner
     *
     * @return OpeningHour
     */
    public function setPartner(Partner $partner): OpeningHour
    {
        $this->partner = $partner;

        return $this;
    }

    /**
     * Set openingDay
     *
     * @param string $openingDay
     *
     * @return OpeningHour
     */
    public function setOpeningDay($openingDay)
    {
        $this->openingDay = $openingDay;

        return $this;
    }

    /**
     * Get openingDay
     *
     * @return string
     */
    public function getOpeningDay()
    {
        return $this->openingDay;
    }

    /**
     * Set amStartHour
     *
     * @param \DateTime $amStartHour
     *
     * @return OpeningHour
     */
    public function setAmStartHour($amStartHour)
    {
        $this->amStartHour = $amStartHour;

        return $this;
    }

    /**
     * Get amStartHour
     *
     * @return \DateTime
     */
    public function getAmStartHour()
    {
        return $this->amStartHour;
    }

    /**
     * Set amEndHour
     *
     * @param \DateTime $amEndHour
     *
     * @return OpeningHour
     */
    public function setAmEndHour($amEndHour)
    {
        $this->amEndHour = $amEndHour;

        return $this;
    }

    /**
     * Get amEndHour
     *
     * @return \DateTime
     */
    public function getAmEndHour()
    {
        return $this->amEndHour;
    }

    /**
     * Set pmStartHour
     *
     * @param \DateTime $pmStartHour
     *
     * @return OpeningHour
     */
    public function setPmStartHour($pmStartHour)
    {
        $this->pmStartHour = $pmStartHour;

        return $this;
    }

    /**
     * Get pmStartHour
     *
     * @return \DateTime
     */
    public function getPmStartHour()
    {
        return $this->pmStartHour;
    }

    /**
     * Set pmEndHour
     *
     * @param \DateTime $pmEndHour
     *
     * @return OpeningHour
     */
    public function setPmEndHour($pmEndHour)
    {
        $this->pmEndHour = $pmEndHour;

        return $this;
    }

    /**
     * Get pmEndHour
     *
     * @return \DateTime
     */
    public function getPmEndHour()
    {
        return $this->pmEndHour;
    }

    /**
     * Set nox
     *
     * @param boolean $nox
     *
     * @return OpeningHour
     */
    public function setNox($nox)
    {
        $this->nox = $nox;

        return $this;
    }

    /**
     * Get nox
     *
     * @return boolean
     */
    public function getNox()
    {
        return $this->nox;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return OpeningHour
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }
}
