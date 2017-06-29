<?php

namespace PartnerBundle\Entity;
use Mullenlowe\CommonBundle\Entity\Base\Date;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="partner_partner")
 */
class Partner extends Date
{
    /**
     * @ORM\Column(type="string")
     */
    protected $contractNumber;

    /**
     * @ORM\Column(type="string")
     */
    protected $commercialName;

    /**
     * @ORM\Column(type="string")
     */
    protected $kvpsNumber;

    /**
     * @ORM\Column(type="string")
     */
    protected $webSite;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isPartnerR8;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isTwinService;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isPartnerPlus;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isOccPlus;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isEtron;


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
}
