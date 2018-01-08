<?php

namespace PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Relation One to Many between Partner and MyaudiUser
 * Class PartnerMyaudiUser
 * @package PartnerBundle\Entity
 *
 * @SWG\Definition()
 * @ORM\Entity
 * @ORM\Table(name="partner_myaudi_user")
 * @UniqueEntity(
 *       fields={"myaudiUserId"},
 *       message="myaudiUserId already related to another partner"
 * )
 */
class PartnerMyaudiUser
{
    /**
     * Many MyaudiUser have One Partner.
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Partner", inversedBy="myaudiUsers")
     * @ORM\JoinColumn(name="partner_id", referencedColumnName="id")
     * @var Partner
     */
    protected $partner;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @SWG\Property(format="int64")
     * @Assert\Range(min=1, max=null)
     * @var int
     */
    protected $myaudiUserId;

    /**
     * PartnerMyaudiUser constructor.
     * @param Partner $partner
     * @param int     $myaudiUserId
     */
    public function __construct(Partner $partner = null, int $myaudiUserId = null)
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
     *
     * @return PartnerMyaudiUser
     */
    public function setPartner($partner): PartnerMyaudiUser
    {
        $this->partner = $partner;

        return $this;
    }

    /**
     * @return int
     */
    public function getMyaudiUserId()
    {
        return $this->myaudiUserId;
    }

    /**
     * @param int  $myaudiUserId
     *
     * @return PartnerMyaudiUser
     */
    public function setMyaudiUserId(int $myaudiUserId): PartnerMyaudiUser
    {
        $this->myaudiUserId = $myaudiUserId;

        return $this;
    }
}
