<?php

namespace PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Relation One to Many between Partner and RegistryUser
 * Class PartnerRegistryUser
 * @package PartnerBundle\Entity
 *
 * @SWG\Definition()
 * @ORM\Entity
 * @ORM\Table(name="partner_registry_user")
 * @UniqueEntity(
 *       fields={"registryUserId"},
 *       message="registryUserId already related to another partner"
 * )
 */
class PartnerRegistryUser
{
    /**
     * Many RegistryUser have One Partner.
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Partner", inversedBy="registryUsers")
     * @ORM\JoinColumn(name="partner_id", referencedColumnName="id")
     * @var Partner
     * @Groups({"amqp"})
     */
    protected $partner;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @SWG\Property(format="int64")
     * @Assert\Range(min=1, max=null)
     * @var int
     * @Groups({"amqp"})
     */
    protected $registryUserId;

    /**
     * PartnerRegistryUser constructor.
     * @param Partner $partner
     * @param int     $registryUserId
     */
    public function __construct(Partner $partner = null, int $registryUserId = null)
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
     *
     * @return PartnerRegistryUser
     */
    public function setPartner(Partner $partner): PartnerRegistryUser
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
}
