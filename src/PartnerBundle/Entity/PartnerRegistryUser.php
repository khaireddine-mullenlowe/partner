<?php

namespace PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;

/**
 * Relation One to Many between Partner and RegistryUser
 * Class PartnerRegistryUser
 * @package PartnerBundle\Entity
 *
 * @SWG\Definition()
 * @ORM\Entity
 * @ORM\Table(name="partner_registryuser")
 */
class PartnerRegistryUser
{
    /**
     * Many RegistryUser have One Partner.
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Partner", inversedBy="registryUsers")
     * @ORM\JoinColumn(name="partner_id", referencedColumnName="id")
     * @SWG\Property(format="int64", type="integer")
     */
    protected $partner;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @SWG\Property(format="int64")
     * @var integer
     */
    protected $registryUserId;

    /**
     * PartnerRegistryUser constructor.
     * @param Partner $partner
     * @param integer $registryUserId
     */
    public function __construct(Partner $partner, $registryUserId)
    {
        $this->partner = $partner;
        $this->registryUserId = $registryUserId;
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
     */
    public function setPartner($partner)
    {
        $this->partner = $partner;
    }

    /**
     * @return integer
     */
    public function getRegistryUserId()
    {
        return $this->registryUserId;
    }

    /**
     * @param integer $registryUserId
     */
    public function setRegistryUserId($registryUserId)
    {
        $this->registryUserId = $registryUserId;
    }
}
