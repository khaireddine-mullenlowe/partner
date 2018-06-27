<?php

namespace PartnerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Mullenlowe\CommonBundle\Entity\Base\BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use PartnerBundle\Enum\PartnerTypeEnum;
use PartnerBundle\Enum\PartnerSiteTypeEnum;
use PartnerBundle\Enum\PartnerPrestigeTypeEnum;
use PartnerBundle\Enum\PartnerVariousEnum;

/**
 * @ORM\Entity(repositoryClass="PartnerBundle\Repository\PartnerRepository")
 * @ORM\Table(name="partner")
 * @UniqueEntity(
 *       fields={"contractNumber"},
 *       message="contractNumber already in use"
 * )
 * @UniqueEntity(
 *       fields={"occPlusContractNumber"},
 *       message="occPlusContractNumber already in use"
 * )
 * @UniqueEntity(
 *       fields={"legacyId"},
 *       message="legacyId already in use"
 * )
 */
class Partner extends BaseEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     * @Groups({"amqp", "rest"})
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     * @Assert\Choice({PartnerTypeEnum::TYPE_SALES, PartnerTypeEnum::TYPE_AFTERSALES}, strict=true)
     * @Groups({"amqp", "rest"})
     */
    protected $type;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", options={"default":1})
     * @Assert\NotNull()
     * @Groups({"amqp", "rest"})
     */
    protected $status = 1;

    /**
     * @ORM\Column(type="string", unique=true, nullable=true)
     * @var string
     * @Groups({"amqp", "rest"})
     */
    protected $contractNumber;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Groups({"amqp", "rest"})
     */
    protected $corporateName;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Groups({"amqp", "rest"})
     */
    protected $commercialName;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Groups({"amqp", "rest"})
     */
    protected $kvpsNumber;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Url()
     * @var string
     * @Groups({"amqp", "rest"})
     */
    protected $webSite;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     * @Assert\Type("boolean")
     * @Groups({"amqp", "rest"})
     */
    protected $isPartnerR8;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     * @Assert\Type("boolean")
     * @Groups({"amqp", "rest"})
     */
    protected $isTwinService;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     * @Assert\Type("boolean")
     * @Groups({"amqp", "rest"})
     */
    protected $isPartnerPlus;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     * @Assert\Type("boolean")
     * @Groups({"amqp", "rest"})
     */
    protected $isOccPlus;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true, nullable=true)
     * @Assert\Type("string")
     * @Groups({"amqp", "rest"})
     */
    protected $occPlusContractNumber;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     * @Assert\Type("boolean")
     * @Groups({"amqp", "rest"})
     */
    protected $isEtron;

    /**
     * @ORM\ManyToOne(targetEntity="PartnerBundle\Entity\Group", inversedBy="partners")
     * @ORM\JoinColumn(name="partner_group_id", referencedColumnName="id")
     * @var Group|null
     * @Groups({"amqp", "rest"})
     */
    protected $group;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Type("string")
     * @Assert\Choice(
     *     choices={PartnerSiteTypeEnum::SITE_TYPE_PRINCIPAL, PartnerSiteTypeEnum::SITE_TYPE_SECONDARY},
     *     strict=true
     * )
     * @Groups({"amqp", "rest"})
     */
    protected $siteType;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Type("string")
     * @Assert\Choice(
     *     choices=PartnerVariousEnum::PARTNER_CATEGORY_ENUM,
     *     strict=true
     * )
     * @Groups({"amqp", "rest"})
     */
    protected $category;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Type("string")
     * @Assert\Choice(
     *     choices=PartnerVariousEnum::PARTNER_REPRESENTATION_TYPE_ENUM,
     *     strict=true
     * )
     * @Groups({"amqp", "rest"})
     */
    protected $representationType;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Type("string")
     * @Assert\Choice(
     *     choices={
     *         PartnerPrestigeTypeEnum::PRESTIGE_TYPE_EXCLUSIVE,
     *         PartnerPrestigeTypeEnum::PRESTIGE_TYPE_SPECIALIZED
     *     },
     *     strict=true
     * )
     * @Groups({"amqp", "rest"})
     */
    protected $prestigeType;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default":0})
     * @Assert\Type("bool")
     * @Groups({"amqp", "rest"})
     */
    protected $dealersMeeting;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default":0})
     * @Assert\Type("bool")
     * @Groups({"amqp", "rest"})
     */
    protected $brandDays;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default":0})
     * @Assert\Type("bool")
     * @Groups({"amqp", "rest"})
     */
    protected $rent;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default":0})
     * @Assert\Type("bool")
     * @Groups({"amqp", "rest"})
     */
    protected $extraHour;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default":0})
     * @Assert\Type("bool")
     * @Groups({"amqp", "rest"})
     */
    protected $ferMembership;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default":0})
     * @Assert\Type("bool")
     * @Groups({"amqp", "rest"})
     */
    protected $onlineQuotation;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default":0})
     * @Assert\Type("bool")
     * @Groups({"amqp", "rest"})
     */
    protected $amexPayment;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default":0})
     * @Assert\Type("bool")
     * @Groups({"amqp", "rest"})
     */
    protected $isDigitAll;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Type("string")
     * @Groups({"amqp", "rest"})
     */
    protected $digitAllId;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default":0})
     * @Assert\Type("bool")
     * @Groups({"amqp", "rest"})
     */
    protected $isV12;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Type("string")
     * @Groups({"amqp", "rest"})
     */
    protected $v12Id;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type("int")
     * @Groups({"amqp", "rest"})
     */
    protected $sellingVolume;

    /**
     * @var Region|null
     *
     * @ORM\ManyToOne(targetEntity="PartnerBundle\Entity\Region", inversedBy="partners")
     * @ORM\JoinColumn(name="region_id", nullable=true)
     * @Groups({"amqp", "rest"})
     */
    private $region;

    /**
     * @var District|null
     *
     * @ORM\ManyToOne(targetEntity="PartnerBundle\Entity\District", inversedBy="partners")
     * @ORM\JoinColumn(name="district_id", nullable=true)
     * @Groups({"amqp", "rest"})
     */
    private $district;

    /**
     * Legacy id
     * @ORM\Column(type="integer", unique=true, nullable=true)
     * @var integer
     * @Groups({"amqp", "rest"})
     */
    protected $legacyId;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @Groups({"amqp", "rest"})
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     * @Groups({"amqp", "rest"})
     */
    protected $updatedAt;

    /**
     * One Partner have Many partnerRegistryUsers.
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="PartnerRegistryUser", mappedBy="partner", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $partnerRegistryUsers;

    /**
     * One Partner have Many MyaudiUsers.
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="PartnerMyaudiUser", mappedBy="partner", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    protected $myaudiUsers;

    /**
     * @ORM\OneToOne(targetEntity="PartnerBundle\Entity\DepositType", cascade={"persist"})
     * @ORM\JoinColumn(name="deposit_type_id", referencedColumnName="id", nullable=true)
     * @Assert\Valid()
     */
    protected $depositType;

    /**
     * Partner constructor.
     */
    public function __construct()
    {
        $this->myaudiUsers = new ArrayCollection();
        $this->partnerRegistryUsers = new ArrayCollection();
        $this->isTwinService = false;
        $this->isPartnerR8 = false;
        $this->isPartnerPlus = false;
        $this->isOccPlus = false;
        $this->isEtron = false;
    }

    /**
     * Set contractNumber.
     *
     * @param string $contractNumber
     *
     * @return Partner
     */
    public function setContractNumber($contractNumber)
    {
        $this->contractNumber = $contractNumber;

        return $this;
    }

    /**
     * Get contractNumber.
     *
     * @return string
     */
    public function getContractNumber()
    {
        return $this->contractNumber;
    }

    /**
     * Set corporateName.
     *
     * @param string $corporateName
     *
     * @return Partner
     */
    public function setCorporateName($corporateName)
    {
        $this->corporateName = $corporateName;

        return $this;
    }

    /**
     * Get corporateName.
     *
     * @return string
     */
    public function getCorporateName()
    {
        return $this->corporateName;
    }

    /**
     * Set commercialName.
     *
     * @param string $commercialName
     *
     * @return Partner
     */
    public function setCommercialName($commercialName)
    {
        $this->commercialName = $commercialName;

        return $this;
    }

    /**
     * Get commercialName.
     *
     * @return string
     */
    public function getCommercialName()
    {
        return $this->commercialName;
    }

    /**
     * Set kvpsNumber.
     *
     * @param string $kvpsNumber
     *
     * @return Partner
     */
    public function setKvpsNumber($kvpsNumber)
    {
        $this->kvpsNumber = $kvpsNumber;

        return $this;
    }

    /**
     * Get kvpsNumber.
     *
     * @return string
     */
    public function getKvpsNumber()
    {
        return $this->kvpsNumber;
    }

    /**
     * Set webSite.
     *
     * @param string $webSite
     *
     * @return Partner
     */
    public function setWebSite($webSite)
    {
        $this->webSite = $webSite;

        return $this;
    }

    /**
     * Get webSite.
     *
     * @return string
     */
    public function getWebSite()
    {
        return $this->webSite;
    }

    /**
     * @return bool
     */
    public function getIsPartnerR8()
    {
        return $this->isPartnerR8;
    }

    /**
     * @param bool $isPartnerR8
     * @return $this
     */
    public function setIsPartnerR8($isPartnerR8)
    {
        $this->isPartnerR8 = $isPartnerR8;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsTwinService()
    {
        return $this->isTwinService;
    }

    /**
     * @param bool $isTwinService
     * @return $this
     */
    public function setIsTwinService($isTwinService)
    {
        $this->isTwinService = $isTwinService;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsPartnerPlus()
    {
        return $this->isPartnerPlus;
    }

    /**
     * @param bool $isPartnerPlus
     * @return $this
     */
    public function setIsPartnerPlus($isPartnerPlus)
    {
        $this->isPartnerPlus = $isPartnerPlus;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsOccPlus()
    {
        return $this->isOccPlus;
    }

    /**
     * @param bool $isOccPlus
     * @return $this
     */
    public function setIsOccPlus($isOccPlus)
    {
        $this->isOccPlus = $isOccPlus;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOccPlusContractNumber()
    {
        return $this->occPlusContractNumber;
    }

    /**
     * @param string|null $occPlusContractNumber
     *
     * @return Partner
     */
    public function setOccPlusContractNumber($occPlusContractNumber): Partner
    {
        $this->occPlusContractNumber = $occPlusContractNumber;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsEtron()
    {
        return $this->isEtron;
    }

    /**
     * @param bool $isEtron
     * @return $this
     */
    public function setIsEtron($isEtron)
    {
        $this->isEtron = $isEtron;

        return $this;
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
     * @return int
     */
    public function getLegacyId()
    {
        return $this->legacyId;
    }

    /**
     * @param int $legacyId
     *
     * @return Partner
     */
    public function setLegacyId(int $legacyId)
    {
        $this->legacyId = $legacyId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return Group|null
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param Group|null $group
     *
     * @return Partner
     */
    public function setGroup($group): Partner
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSiteType()
    {
        return $this->siteType;
    }

    /**
     * @param string|null $siteType
     *
     * @return Partner
     */
    public function setSiteType($siteType): Partner
    {
        $this->siteType = $siteType;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param null|string $category
     *
     * @return Partner
     */
    public function setCategory($category): Partner
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getRepresentationType()
    {
        return $this->representationType;
    }

    /**
     * @param null|string $representationType
     *
     * @return Partner
     */
    public function setRepresentationType($representationType): Partner
    {
        $this->representationType = $representationType;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPrestigeType()
    {
        return $this->prestigeType;
    }

    /**
     * @param null|string $prestigeType
     *
     * @return Partner
     */
    public function setPrestigeType($prestigeType): Partner
    {
        $this->prestigeType = $prestigeType;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDealersMeeting()
    {
        return $this->dealersMeeting;
    }

    /**
     * @param bool $dealersMeeting
     *
     * @return Partner
     */
    public function setDealersMeeting($dealersMeeting): Partner
    {
        $this->dealersMeeting = $dealersMeeting;

        return $this;
    }

    /**
     * @return bool
     */
    public function isBrandDays()
    {
        return $this->brandDays;
    }

    /**
     * @param bool $brandDays
     *
     * @return Partner
     */
    public function setBrandDays($brandDays): Partner
    {
        $this->brandDays = $brandDays;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRent()
    {
        return $this->rent;
    }

    /**
     * @param bool $rent
     *
     * @return Partner
     */
    public function setRent($rent): Partner
    {
        $this->rent = $rent;

        return $this;
    }

    /**
     * @return bool
     */
    public function isExtraHour()
    {
        return $this->extraHour;
    }

    /**
     * @param bool $extraHour
     *
     * @return Partner
     */
    public function setExtraHour($extraHour): Partner
    {
        $this->extraHour = $extraHour;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFerMembership()
    {
        return $this->ferMembership;
    }

    /**
     * @param bool $ferMembership
     *
     * @return Partner
     */
    public function setFerMembership($ferMembership): Partner
    {
        $this->ferMembership = $ferMembership;

        return $this;
    }

    /**
     * @return bool
     */
    public function isOnlineQuotation()
    {
        return $this->onlineQuotation;
    }

    /**
     * @param bool $onlineQuotation
     *
     * @return Partner
     */
    public function setOnlineQuotation($onlineQuotation): Partner
    {
        $this->onlineQuotation = $onlineQuotation;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAmexPayment()
    {
        return $this->amexPayment;
    }

    /**
     * @param bool $amexPayment
     *
     * @return Partner
     */
    public function setAmexPayment($amexPayment): Partner
    {
        $this->amexPayment = $amexPayment;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDigitAll()
    {
        return $this->isDigitAll;
    }

    /**
     * @param bool $isDigitAll
     *
     * @return Partner
     */
    public function setIsDigitAll($isDigitAll): Partner
    {
        $this->isDigitAll = $isDigitAll;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDigitAllId()
    {
        return $this->digitAllId;
    }

    /**
     * @param null|string $digitAllId
     *
     * @return Partner
     */
    public function setDigitAllId($digitAllId): Partner
    {
        $this->digitAllId = $digitAllId;

        return $this;
    }

    /**
     * @return bool
     */
    public function isV12()
    {
        return $this->isV12;
    }

    /**
     * @param bool $isV12
     *
     * @return Partner
     */
    public function setIsV12($isV12): Partner
    {
        $this->isV12 = $isV12;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getV12Id()
    {
        return $this->v12Id;
    }

    /**
     * @param null|string $v12Id
     *
     * @return Partner
     */
    public function setV12Id($v12Id): Partner
    {
        $this->v12Id = $v12Id;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSellingVolume()
    {
        return $this->sellingVolume;
    }

    /**
     * @param int|null $sellingVolume
     *
     * @return Partner
     */
    public function setSellingVolume($sellingVolume): Partner
    {
        $this->sellingVolume = $sellingVolume;

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
     * @return Partner
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
     * @return Partner
     */
    public function setDistrict($district)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getMyaudiUsers()
    {
        return $this->myaudiUsers;
    }

    /**
     * @return Collection
     */
    public function getPartnerRegistryUsers()
    {
        return $this->partnerRegistryUsers;
    }

    /**
     * @param PartnerMyaudiUser $myaudiUser
     * @return $this
     */
    public function addMyaudiUser(PartnerMyaudiUser $myaudiUser)
    {
        if (!$this->myaudiUsers->contains($myaudiUser)) {
            $this->myaudiUsers->add($myaudiUser);
        }
        $myaudiUser->setPartner($this);

        return $this;
    }

    /**
     * @param PartnerMyaudiUser $myaudiUser
     * @return $this
     */
    public function removeMyaudiUser(PartnerMyaudiUser $myaudiUser)
    {
        $this->myaudiUsers->removeElement($myaudiUser);

        return $this;
    }

    /**
     * @param PartnerRegistryUser $partnerRegistryUser
     * @return $this
     */
    public function addPartnerRegistryUser(PartnerRegistryUser $partnerRegistryUser)
    {
        if (!$this->partnerRegistryUsers->contains($partnerRegistryUser)) {
            $this->partnerRegistryUsers->add($partnerRegistryUser);
        }
        $partnerRegistryUser->setPartner($this);

        return $this;
    }

    /**
     * @param PartnerRegistryUser $partnerRegistryUser
     * @return $this
     */
    public function removePartnerRegistryUser(PartnerRegistryUser $partnerRegistryUser)
    {
        $this->partnerRegistryUsers->removeElement($partnerRegistryUser);
        $partnerRegistryUser->setPartner(null);

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return Partner
     */
    public function setStatus(int $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Allows to call isser method for boolean attribute, like 'isEtron()'
     * Il calls the associated getter if exists, like getIsEtron()
     * @param string $name
     * @param array  $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (0 === strrpos($name, 'is') && method_exists($this, $getter = 'get'.ucfirst($name))) {
            return $this->$getter($arguments);
        }

        throw new \BadMethodCallException(sprintf('Method  "%s" does not exist', $name));
    }

    /**
     * Set depositType
     *
     * @param DepositType $depositType
     *
     * @return Partner
     */
    public function setDepositType(DepositType $depositType)
    {
        $this->depositType = $depositType;

        return $this;
    }

    /**
     * Get depositType
     *
     * @return DepositType
     */
    public function getDepositType()
    {
        return $this->depositType;
    }
}
