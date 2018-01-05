<?php

namespace PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Relation One to Many between Partner and RegistryUser
 * Class TempPartnerRegistryUser
 * @package PartnerBundle\Entity
 *
 * @SWG\Definition()
 * @ORM\Entity
 * @ORM\Table(name="temp_partner_registry_user")
 * @UniqueEntity(
 *       fields={"legacyRegistryUserId"},
 *       message="legacyRegistryUserId already related to another partner"
 * )
 */
class TempPartnerRegistryUser
{
    /**
     * Many RegistryUser have One Partner.
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Partner", inversedBy="registryUsers")
     * @ORM\JoinColumn(name="partner_id", referencedColumnName="id")
     */
    protected $partner;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @SWG\Property(format="int64")
     * @Assert\Range(min=1, max=null)
     * @var integer
     */
    protected $legacyRegistryUserId;

    /**
     * PartnerRegistryUser constructor.
     * @param Partner $partner
     * @param integer $legacyRegistryUserId
     */
    public function __construct(Partner $partner = null, $legacyRegistryUserId = null)
    {
        $this->partner = $partner;
        $this->legacyRegistryUserId = $legacyRegistryUserId;
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
    public function setPartner(Partner $partner = null)
    {
        $this->partner = $partner;
    }

    /**
     * @return integer
     */
    public function getLegacyRegistryUserId()
    {
        return $this->legacyRegistryUserId;
    }

    /**
     * @param integer $legacyRegistryUserId
     */
    public function setLegacyRegistryUserId($legacyRegistryUserId)
    {
        $this->legacyRegistryUserId = $legacyRegistryUserId;
    }
}
