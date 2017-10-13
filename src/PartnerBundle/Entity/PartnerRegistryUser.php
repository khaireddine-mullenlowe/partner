<?php

namespace PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Many RegistryUser have One Partner.
     * @ORM\ManyToOne(targetEntity="Partner", inversedBy="registryUsers")
     * @ORM\JoinColumn(name="partner_id", referencedColumnName="id")
     */
    protected $partner;

    /**
     * @ORM\Column(type="integer")
     * @SWG\Property(format="int64")
     * @Assert\Range(min=1, max=null)
     * @var integer
     */
    protected $registryUserId;

    /**
     * PartnerRegistryUser constructor.
     * @param Partner $partner
     * @param integer $registryUserId
     */
    public function __construct(Partner $partner = null, $registryUserId = null)
    {
        $this->partner = $partner;
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
