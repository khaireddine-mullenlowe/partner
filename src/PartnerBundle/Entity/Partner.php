<?php

namespace PartnerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Mullenlowe\CommonBundle\Entity\Base\Date;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="PartnerBundle\Entity\Repository\PartnerRepository")
 * @ORM\Table(name="partner")
 */
class Partner extends Date
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Legacy id
     * @ORM\Column(type="integer", name="partner_id", unique=true, nullable=true)
     */
    protected $partnerId;

    /**
     * @var @ORM\Column(type="string", nullable=true)
     */
    protected $type;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $contractNumber;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $commercialName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $kvpsNumber;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $webSite;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isPartnerR8;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isTwinService;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isPartnerPlus;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isOccPlus;

    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isEtron;

    /**
     * One Partner have Many registryUsers.
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="PartnerRegistryUser", mappedBy="partner", cascade={"persist", "remove"})
     */
    protected $registryUsers;

    /**
     * One Partner have Many MyaudiUsers.
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="PartnerMyaudiUser", mappedBy="partner", cascade={"persist", "remove"})
     */
    protected $myaudiUsers;

    /**
     * One Partner have Many Addresses.
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="PartnerAddress", mappedBy="partner", cascade={"persist", "remove"})
     */
    protected $addresses;

    /**
     * Partner constructor.
     */
    public function __construct()
    {
        $this->myaudiUsers = new ArrayCollection();
        $this->registryUsers = new ArrayCollection();
        $this->addresses   = new ArrayCollection();
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
    public function isPartnerR8(): bool
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
    public function isTwinService(): bool
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
    public function isPartnerPlus(): bool
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
    public function isOccPlus(): bool
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
    public function isEtron(): bool
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
    public function getPartnerId()
    {
        return $this->partnerId;
    }

    /**
     * @param mixed $partnerId
     */
    public function setPartnerId($partnerId)
    {
        $this->partnerId = $partnerId;
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
     * @return ArrayCollection
     */
    public function getAddresses()
    {
        return $this->addresses;
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

        return $this;
    }
    /**
     * @param PartnerAddress $address
     * @return $this
     */
    public function addAddress(PartnerAddress $address)
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses->add($address);
        }

        return $this;
    }

    /**
     * @param PartnerAddress $address
     * @return $this
     */
    public function removeAddress(PartnerAddress $address)
    {
        if ($this->addresses->contains($address)) {
            $this->addresses->removeElement($address);
        }

        return $this;
    }
}
