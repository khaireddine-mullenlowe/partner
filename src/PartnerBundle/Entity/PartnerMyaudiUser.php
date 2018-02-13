<?php

namespace PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mullenlowe\CommonBundle\Entity\Base\BaseEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Relation One to Many between Partner and MyaudiUser
 * Class PartnerMyaudiUser
 * @package PartnerBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(
 *     name="partner_myaudi_user",
 *     indexes={
 *         @ORM\Index(name="PartnerMyaudiUser_myaudi_user_idx", columns={"myaudi_user_id"})
 *     },
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="PartnerMyaudiUser_unique_idx", columns={"partner_id", "myaudi_user_id"})
 *     }
 * )
 * @UniqueEntity(
 *       fields={"partner", "myaudiUserId"},
 *       message="myaudiUserId already related to another partner"
 * )
 */
class PartnerMyaudiUser extends BaseEntity
{
    /**
     * @var integer

     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"amqp", "rest"})
     */
    protected $id;

    /**
     * Many MyaudiUser have One Partner.
     *
     * @ORM\ManyToOne(targetEntity="Partner", inversedBy="myaudiUsers")
     * @ORM\JoinColumn(name="partner_id", referencedColumnName="id", nullable=false)
     * @var Partner
     * @Groups({"amqp", "rest"})
     */
    protected $partner;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min=1, max=null)
     * @var int
     * @Groups({"amqp", "rest"})
     */
    protected $myaudiUserId;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @Groups({"amqp", "rest"})
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     * @Groups({"amqp", "rest"})
     */
    protected $updatedAt;

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
