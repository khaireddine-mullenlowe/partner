<?php

namespace PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mullenlowe\CommonBundle\Entity\Base\BaseEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Relation One to Many between Partner and RegistryUser
 * Class PartnerRegistryUser
 * @package PartnerBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(
 *     name="partner_registry_user",
 *     indexes={
 *         @ORM\Index(name="PartnerRegistryUser_registry_user_idx", columns={"registry_user_id"})
 *     }
 * )
 * @UniqueEntity(
 *     fields={"partner", "registryUserId", "department", "position", "positionCode"},
 *     ignoreNull=false,
 *     errorPath="registryUserId",
 *     message="This RegistryUser is already bound to this Partner with the same Department and Position"
 * )
 */
class PartnerRegistryUser extends BaseEntity
{
    /**
     * @var integer

     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"amqp", "rest"})
     */
    protected $id;

    /**
     * @var Partner
     *
     * @ORM\ManyToOne(targetEntity="PartnerBundle\Entity\Partner", inversedBy="registryUsers")
     * @ORM\JoinColumn(name="partner_id", referencedColumnName="id", nullable=false)
     * @Groups({"amqp", "rest"})
     * @Assert\NotNull(groups={"Default", "orchestrator"})
     */
    private $partner;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @Assert\Range(min=1, max=null, groups={"Default"})
     * @Assert\NotNull(groups={"Default"})
     * @Groups({"amqp", "rest"})
     */
    private $registryUserId;

    /**
     * @var CompanyDepartment
     *
     * @ORM\ManyToOne(targetEntity="PartnerBundle\Entity\CompanyDepartment")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id")
     * @Groups({"amqp", "rest"})
     * @Assert\NotNull(groups={"Default", "orchestrator"})
     */
    private $department;

    /**
     * @var CompanyPosition
     *
     * @ORM\ManyToOne(targetEntity="PartnerBundle\Entity\CompanyPosition")
     * @ORM\JoinColumn(name="position_id", referencedColumnName="id")
     * @Groups({"amqp", "rest"})
     * @Assert\NotNull(groups={"Default", "orchestrator"})
     */
    private $position;

    /**
     * @var CompanyPositionCode
     *
     * @ORM\ManyToOne(targetEntity="PartnerBundle\Entity\CompanyPositionCode")
     * @ORM\JoinColumn(name="position_code_id", referencedColumnName="id")
     * @Groups({"amqp", "rest"})
     */
    private $positionCode;

    /**
     * @var Region|null
     *
     * @ORM\ManyToOne(targetEntity="PartnerBundle\Entity\Region", inversedBy="partnerRegistryUsers")
     * @ORM\JoinColumn(name="region_id", nullable=true)
     * @Groups({"amqp", "rest"})
     */
    private $region;

    /**
     * @var District|null
     *
     * @ORM\ManyToOne(targetEntity="PartnerBundle\Entity\District", inversedBy="partnerRegistryUsers")
     * @ORM\JoinColumn(name="district_id", nullable=true)
     * @Groups({"amqp", "rest"})
     */
    private $district;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default":0})
     * @Groups({"amqp", "rest"})
     */
    private $isAdmin;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default":0})
     * @Groups({"amqp", "rest"})
     */
    private $vision;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default":0})
     * @Groups({"amqp", "rest"})
     */
    private $convention;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default":0})
     * @Groups({"amqp", "rest"})
     */
    private $dealersMeeting;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default":0})
     * @Groups({"amqp", "rest"})
     */
    private $brandDays;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @Groups({"amqp", "rest"})
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     * @Groups({"amqp", "rest"})
     */
    protected $updatedAt;

    /**
     * PartnerRegistryUser constructor.
     * @param Partner $partner
     * @param int     $registryUserId
     */
    public function __construct(Partner $partner = null, int $registryUserId = null)
    {
        $this->partner = $partner;
        $this->registryUserId = $registryUserId;
        $this->isAdmin = false;
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
     *
     * @return PartnerRegistryUser
     */
    public function setPartner(Partner $partner = null): PartnerRegistryUser
    {
        $this->partner = $partner;

        return $this;
    }

    /**
     * @return int
     */
    public function getRegistryUserId()
    {
        return $this->registryUserId;
    }

    /**
     * @param int $registryUserId
     *
     * @return PartnerRegistryUser
     */
    public function setRegistryUserId(int $registryUserId): PartnerRegistryUser
    {
        $this->registryUserId = $registryUserId;

        return $this;
    }

    /**
     * @return CompanyDepartment|null
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param CompanyDepartment|null $department
     *
     * @return PartnerRegistryUser
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @return CompanyPosition|null
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param CompanyPosition|null $position
     *
     * @return PartnerRegistryUser
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return CompanyPositionCode|null
     */
    public function getPositionCode()
    {
        return $this->positionCode;
    }

    /**
     * @param CompanyPositionCode|null $positionCode
     *
     * @return PartnerRegistryUser|null
     */
    public function setPositionCode($positionCode)
    {
        $this->positionCode = $positionCode;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     *
     * @return PartnerRegistryUser
     */
    public function setIsAdmin(bool $isAdmin)
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * Get isAdmin
     *
     * @return boolean
     */
    public function getIsAdmin()
    {
        return $this->isAdmin();
    }

    /**
     * @return bool
     */
    public function getVision()
    {
        return $this->vision;
    }

    /**
     * @param bool $vision
     *
     * @return PartnerRegistryUser
     */
    public function setVision($vision): PartnerRegistryUser
    {
        $this->vision = $vision;

        return $this;
    }

    /**
     * @return bool
     */
    public function getConvention()
    {
        return $this->convention;
    }

    /**
     * @param bool $convention
     *
     * @return PartnerRegistryUser
     */
    public function setConvention($convention): PartnerRegistryUser
    {
        $this->convention = $convention;

        return $this;
    }

    /**
     * @return bool
     */
    public function getDealersMeeting()
    {
        return $this->dealersMeeting;
    }

    /**
     * @param bool $dealersMeeting
     *
     * @return PartnerRegistryUser
     */
    public function setDealersMeeting($dealersMeeting): PartnerRegistryUser
    {
        $this->dealersMeeting = $dealersMeeting;

        return $this;
    }

    /**
     * @return bool
     */
    public function getBrandDays()
    {
        return $this->brandDays;
    }

    /**
     * @param bool $brandDays
     *
     * @return PartnerRegistryUser
     */
    public function setBrandDays($brandDays): PartnerRegistryUser
    {
        $this->brandDays = $brandDays;

        return $this;
    }

    /**
     * @return Region|null
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param Region|null $region
     *
     * @return PartnerRegistryUser
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return District|null
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * @param District|null $district
     *
     * @return PartnerRegistryUser
     */
    public function setDistrict($district)
    {
        $this->district = $district;

        return $this;
    }
}
