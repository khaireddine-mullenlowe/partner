<?php

namespace PartnerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Mullenlowe\CommonBundle\Entity\Base\Date;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="PartnerBundle\Entity\Repository\PartnerRepository")
 * @ORM\Table(name="partner_partner")
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
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isPartnerR8;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isTwinService;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isPartnerPlus;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isOccPlus;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $isEtron;

    /**
     * @ORM\Column(type="integer", name="registry_user_id", unique=true, nullable=true)
     */
    protected $registryUserId;

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
     * Set isPartnerR8.
     *
     * @param bool $isPartnerR8
     *
     * @return Partner
     */
    public function setIsPartnerR8($isPartnerR8)
    {
        $this->isPartnerR8 = $isPartnerR8;

        return $this;
    }

    /**
     * Get isPartnerR8.
     *
     * @return bool
     */
    public function getIsPartnerR8()
    {
        return $this->isPartnerR8;
    }

    /**
     * Set isTwinService.
     *
     * @param bool $isTwinService
     *
     * @return Partner
     */
    public function setIsTwinService($isTwinService)
    {
        $this->isTwinService = $isTwinService;

        return $this;
    }

    /**
     * Get isTwinService.
     *
     * @return bool
     */
    public function getIsTwinService()
    {
        return $this->isTwinService;
    }

    /**
     * Set isPartnerPlus.
     *
     * @param bool $isPartnerPlus
     *
     * @return Partner
     */
    public function setIsPartnerPlus($isPartnerPlus)
    {
        $this->isPartnerPlus = $isPartnerPlus;

        return $this;
    }

    /**
     * Get isPartnerPlus.
     *
     * @return bool
     */
    public function getIsPartnerPlus()
    {
        return $this->isPartnerPlus;
    }

    /**
     * Set isOccPlus.
     *
     * @param bool $isOccPlus
     *
     * @return Partner
     */
    public function setIsOccPlus($isOccPlus)
    {
        $this->isOccPlus = $isOccPlus;

        return $this;
    }

    /**
     * Get isOccPlus.
     *
     * @return bool
     */
    public function getIsOccPlus()
    {
        return $this->isOccPlus;
    }

    /**
     * Set isEtron.
     *
     * @param bool $isEtron
     *
     * @return Partner
     */
    public function setIsEtron($isEtron)
    {
        $this->isEtron = $isEtron;

        return $this;
    }

    /**
     * Get isEtron.
     *
     * @return bool
     */
    public function getIsEtron()
    {
        return $this->isEtron;
    }

    /**
     * @return mixed
     */
    public function getRegistryUserId()
    {
        return $this->registryUserId;
    }

    /**
     * @param mixed $registryUserId
     */
    public function setRegistryUserId($registryUserId)
    {
        $this->registryUserId = $registryUserId;
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