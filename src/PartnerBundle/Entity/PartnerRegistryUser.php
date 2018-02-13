<?php

namespace PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mullenlowe\CommonBundle\Entity\Base\BaseEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Relation One to Many between Partner and RegistryUser
 * Class PartnerRegistryUser
 * @package PartnerBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(
 *     name="partner_registry_user",
 *     indexes={
 *         @ORM\Index(name="PartnerRegistryUser_registry_user_idx", columns={"registry_user_id"})
 *     }
 * )
 * @UniqueEntity(
 *     fields={"partner", "registryUserId", "department", "position", "positionCode"},
 *     ignoreNull=false,
 *     errorPath="registryUserId",
 *     message="This RegistryUser is already bound to this Partner with the same Department and Position"
 * )
 */
class PartnerRegistryUser extends BaseEntity
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
     * @var Partner
     *
     * @ORM\ManyToOne(targetEntity="PartnerBundle\Entity\Partner", inversedBy="registryUsers")
     * @ORM\JoinColumn(name="partner_id", referencedColumnName="id", nullable=false)
     * @Groups({"amqp", "rest"})
     */
    private $partner;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @Assert\Range(min=1, max=null)
     * @Groups({"amqp", "rest"})
     */
    private $registryUserId;

    /**
     * @var CompanyDepartment
     *
     * @ORM\ManyToOne(targetEntity="PartnerBundle\Entity\CompanyDepartment")
     * @ORM\JoinColumn(name="department", referencedColumnName="id")
     * @Groups({"amqp", "rest"})
     */
    private $department;

    /**
     * @var CompanyPosition
     *
     * @ORM\ManyToOne(targetEntity="PartnerBundle\Entity\CompanyPosition")
     * @ORM\JoinColumn(name="position", referencedColumnName="id")
     * @Groups({"amqp", "rest"})
     */
    private $position;

    /**
     * @var CompanyPositionCode
     *
     * @ORM\ManyToOne(targetEntity="PartnerBundle\Entity\CompanyPositionCode")
     * @ORM\JoinColumn(name="position_code", referencedColumnName="id")
     * @Groups({"amqp", "rest"})
     */
    private $positionCode;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default":0})
     * @Groups({"amqp", "rest"})
     */
    private $isAdmin;

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
     * PartnerRegistryUser constructor.
     * @param Partner $partner
     * @param int     $registryUserId
     */
    public function __construct(Partner $partner = null, int $registryUserId = null)
    {
        $this->partner = $partner;
        $this->registryUserId = $registryUserId;
        $this->isAdmin = false;
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

    /**
     * @return CompanyDepartment|null
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param CompanyDepartment|null $department
     *
     * @return PartnerRegistryUser
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @return CompanyPosition|null
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param CompanyPosition|null $position
     *
     * @return PartnerRegistryUser
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return CompanyPositionCode|null
     */
    public function getPositionCode()
    {
        return $this->positionCode;
    }

    /**
     * @param CompanyPositionCode|null $positionCode
     *
     * @return PartnerRegistryUser|null
     */
    public function setPositionCode($positionCode)
    {
        $this->positionCode = $positionCode;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     *
     * @return PartnerRegistryUser
     */
    public function setIsAdmin(bool $isAdmin)
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }
}
