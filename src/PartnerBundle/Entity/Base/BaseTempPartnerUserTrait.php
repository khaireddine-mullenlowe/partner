<?php

namespace PartnerBundle\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use PartnerBundle\Entity\Partner;

/**
 * Trait BaseTempPartnerUserTrait
 * @package PartnerBundle\Entity\Base
 */
trait BaseTempPartnerUserTrait
{
    /**
     * Many Users have One Partner.
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Partner")
     * @ORM\JoinColumn(name="partner_id", referencedColumnName="id")
     * @var Partner
     */
    protected $partner;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @Assert\Range(min=1, max=null)
     * @var int
     */
    protected $legacyUserId;

    /**
     * @param Partner $partner
     * @param int     $legacyUserId
     */
    public function __construct(Partner $partner = null, int $legacyUserId = null)
    {
        $this->partner = $partner;
        $this->legacyUserId = $legacyUserId;
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
     * @return $this
     */
    public function setPartner(Partner $partner)
    {
        $this->partner = $partner;

        return $this;
    }

    /**
     * @return int
     */
    public function getLegacyUserId()
    {
        return $this->legacyUserId;
    }

    /**
     * @param int $legacyUserId
     *
     * @return $this
     */
    public function setLegacyUserId(int $legacyUserId)
    {
        $this->legacyUserId = $legacyUserId;

        return $this;
    }
}
