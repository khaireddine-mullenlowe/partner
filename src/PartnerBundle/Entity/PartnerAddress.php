<?php

namespace PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;

/**
 * Relation One to Many between Partner and Address
 * Class PartnerAddress
 * @package PartnerBundle\Entity
 *
 * @SWG\Definition()
 * @ORM\Entity
 * @ORM\Table(name="partner_address")
 */
class PartnerAddress
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Many Addresses have One Partner.
     * @ORM\ManyToOne(targetEntity="Partner", inversedBy="addresses")
     * @ORM\JoinColumn(name="partner_id", referencedColumnName="id")
     */
    protected $partner;

    /**
     * @ORM\Column(type="integer")
     * @SWG\Property(format="int64")
     * @var integer
     */
    protected $addressId;

    /**
     * PartnerAddress constructor.
     * @param Partner $partner
     * @param integer $addressId
     */
    public function __construct(Partner $partner = null, $addressId = null)
    {
        $this->partner = $partner;
        $this->addressId = $addressId;
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
    public function setPartner($partner)
    {
        $this->partner = $partner;
    }

    /**
     * @return integer
     */
    public function getAddressId()
    {
        return $this->addressId;
    }

    /**
     * @param integer $addressId
     */
    public function setAddressId($addressId)
    {
        $this->addressId = $addressId;
    }
}
