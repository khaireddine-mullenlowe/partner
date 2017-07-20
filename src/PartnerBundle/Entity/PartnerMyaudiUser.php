<?php

namespace PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;

/**
 * Relation One to Many between Partner and MyaudiUser
 * Class PartnerMyaudiUser
 * @package PartnerBundle\Entity
 *
 * @SWG\Definition()
 * @ORM\Entity
 * @ORM\Table(name="partner_myaudiuser")
 */
class PartnerMyaudiUser
{
    /**
     * Many MyaudiUser have One Partner.
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Partner", inversedBy="myaudiUsers")
     * @ORM\JoinColumn(name="partner_id", referencedColumnName="id")
     * @SWG\Property(format="int64", type="integer")
     * @var Partner
     */
    protected $partner;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @SWG\Property(format="int64")
     * @var integer
     */
    protected $myaudiUserId;

    /**
     * PartnerMyaudiUser constructor.
     * @param Partner $partner
     * @param integer $myaudiUserId
     */
    public function __construct(Partner $partner, $myaudiUserId)
    {
        $this->partner = $partner;
        $this->myaudiUserId = $myaudiUserId;
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
    public function getMyaudiUserId()
    {
        return $this->myaudiUserId;
    }

    /**
     * @param integer $myaudiUserId
     */
    public function setMyaudiUserId($myaudiUserId)
    {
        $this->myaudiUserId = $myaudiUserId;
    }
}
