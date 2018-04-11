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

/**
 * @ORM\Entity(repositoryClass="PartnerBundle\Repository\PartnerRepository")
 * @ORM\Table(name="partner")
 * @UniqueEntity(
 *       fields={"legacyId"},
 *       message="legacyId already used"
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
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Groups({"amqp", "rest"})
     */
    protected $contractNumber;

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
     * @ORM\Column(type="integer", unique=true)
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
     * One Partner have Many registryUsers.
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="PartnerRegistryUser", mappedBy="partner", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $registryUsers;

    /**
     * One Partner have Many MyaudiUsers.
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="PartnerMyaudiUser", mappedBy="partner", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    protected $myaudiUsers;

    /**
     * Partner constructor.
     */
    public function __construct()
    {
        $this->myaudiUsers = new ArrayCollection();
        $this->registryUsers = new ArrayCollection();
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
    public function getIsPartnerR8(): bool
    {
        return $this->isPartnerR8;
    }

    /**
     * @param bool $isPartnerR8
     * @return $this
     */
    public function setIsPartnerR8(bool $isPartnerR8)
    {
        $this->isPartnerR8 = $isPartnerR8;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsTwinService(): bool
    {
        return $this->isTwinService;
    }

    /**
     * @param bool $isTwinService
     * @return $this
     */
    public function setIsTwinService(bool $isTwinService)
    {
        $this->isTwinService = $isTwinService;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsPartnerPlus(): bool
    {
        return $this->isPartnerPlus;
    }

    /**
     * @param bool $isPartnerPlus
     * @return $this
     */
    public function setIsPartnerPlus(bool $isPartnerPlus)
    {
        $this->isPartnerPlus = $isPartnerPlus;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsOccPlus(): bool
    {
        return $this->isOccPlus;
    }

    /**
     * @param bool $isOccPlus
     * @return $this
     */
    public function setIsOccPlus(bool $isOccPlus)
    {
        $this->isOccPlus = $isOccPlus;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsEtron(): bool
    {
        return $this->isEtron;
    }

    /**
     * @param bool $isEtron
     * @return $this
     */
    public function setIsEtron(bool $isEtron)
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
    public function getRegistryUsers()
    {
        return $this->registryUsers;
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
     * @param PartnerRegistryUser $registryUser
     * @return $this
     */
    public function addRegistryUser(PartnerRegistryUser $registryUser)
    {
        if (!$this->registryUsers->contains($registryUser)) {
            $this->registryUsers->add($registryUser);
        }
        $registryUser->setPartner($this);

        return $this;
    }

    /**
     * @param PartnerRegistryUser $registryUser
     * @return $this
     */
    public function removeRegistryUser(PartnerRegistryUser $registryUser)
    {
        $this->registryUsers->removeElement($registryUser);
        $registryUser->setPartner(null);

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
}
