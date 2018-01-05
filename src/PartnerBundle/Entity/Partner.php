<?php

namespace PartnerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Mullenlowe\CommonBundle\Entity\Base\Date;
use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @SWG\Definition()
 * @ORM\Entity(repositoryClass="PartnerBundle\Entity\Repository\PartnerRepository")
 * @ORM\Table(name="partner")
 * @UniqueEntity(
 *       fields={"legacyPartnerId"},
 *       message="legacyPartnerId already used"
 * )
 */
class Partner extends Date
{
    /**
     * @var string
     */
    const SALES_TYPE = 'sales';
    /**
     * @var string
     */
    const AFTERSALES_TYPE = 'aftersales';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @SWG\Property(format="int64")
     * @var integer
     */
    protected $id;

    /**
     * Legacy id
     * @ORM\Column(type="integer", unique=true, nullable=true)
     * @SWG\Property(format="int64")
     * @var integer
     */
    protected $legacyPartnerId;

    /**
     * @ORM\Column(type="string")
     * @SWG\Property
     * @var string
     * @Assert\Choice({Partner::SALES_TYPE, Partner::AFTERSALES_TYPE})
     */
    protected $type;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @SWG\Property
     * @var string
     */
    protected $contractNumber;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @SWG\Property
     * @var string
     */
    protected $commercialName;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @SWG\Property
     * @var string
     */
    protected $kvpsNumber;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @SWG\Property
     * @Assert\Url()
     * @var string
     */
    protected $webSite;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     * @SWG\Property
     * @Assert\Type("boolean")
     */
    protected $isPartnerR8;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     * @SWG\Property
     * @Assert\Type("boolean")
     */
    protected $isTwinService;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     * @SWG\Property
     * @Assert\Type("boolean")
     */
    protected $isPartnerPlus;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     * @SWG\Property
     * @Assert\Type("boolean")
     */
    protected $isOccPlus;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     * @SWG\Property
     * @Assert\Type("boolean")
     */
    protected $isEtron;

    /**
     * One Partner have Many registryUsers.
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="PartnerRegistryUser", mappedBy="partner", cascade={"persist", "remove"}, orphanRemoval=true)
     * @SWG\Property(type="array", @SWG\Items(ref="#/definitions/PartnerRegistryUser"))
     * @Assert\Valid()
     */
    private $registryUsers;

    /**
     * One Partner have Many MyaudiUsers.
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="PartnerMyaudiUser", mappedBy="partner", cascade={"persist", "remove"}, orphanRemoval=true)
     * @SWG\Property(type="array", @SWG\Items(ref="#/definitions/PartnerMyaudiUser"))
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
     * @return mixed
     */
    public function getLegacyPartnerId()
    {
        return $this->legacyPartnerId;
    }

    /**
     * @param mixed $legacyPartnerId
     */
    public function setLegacyPartnerId($legacyPartnerId)
    {
        $this->legacyPartnerId = $legacyPartnerId;
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
     * @return ArrayCollection
     */
    public function getMyaudiUsers()
    {
        return $this->myaudiUsers;
    }

    /**
     * @return ArrayCollection
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
        if ($this->myaudiUsers->contains($myaudiUser)) {
            $this->myaudiUsers->removeElement($myaudiUser);
        }

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
        if ($this->registryUsers->contains($registryUser)) {
            $this->registryUsers->removeElement($registryUser);
        }
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
