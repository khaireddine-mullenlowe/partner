<?php

namespace PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mullenlowe\CommonBundle\Entity\Base\BaseEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Relation One to Many between Company and RegistryUser
 * Class CompanyRegistryUser
 * @package PartnerBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(
 *     name="company_registry_user",
 *     indexes={
 *         @ORM\Index(name="CompanyRegistryUser_registry_user_idx", columns={"registry_user_id"})
 *     }
 * )
 * @UniqueEntity(
 *     fields={"company", "registryUserId", "department", "position", "positionCode"},
 *     ignoreNull=false,
 *     errorPath="registryUserId",
 *     message="This RegistryUser is already bound to this Company with the same Department and Position"
 * )
 */
class CompanyRegistryUser extends BaseEntity
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
     * @var Company
     *
     * @ORM\ManyToOne(targetEntity="PartnerBundle\Entity\Company", inversedBy="companyRegistryUsers")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     * @Assert\NotNull(groups={"Default", "orchestrator"})
     * @Groups({"amqp", "rest"})
     */
    private $company;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @Assert\Range(min=1, max=null)
     * @Assert\NotNull(groups={"Default"})
     * @Groups({"amqp", "rest"})
     */
    private $registryUserId;

    /**
     * @var CompanyDepartment
     *
     * @ORM\ManyToOne(targetEntity="PartnerBundle\Entity\CompanyDepartment")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id")
     * @Groups({"amqp", "rest"})
     */
    private $department;

    /**
     * @var CompanyPosition
     *
     * @ORM\ManyToOne(targetEntity="PartnerBundle\Entity\CompanyPosition")
     * @ORM\JoinColumn(name="position_id", referencedColumnName="id")
     * @Groups({"amqp", "rest"})
     */
    private $position;

    /**
     * @var CompanyPositionCode
     *
     * @ORM\ManyToOne(targetEntity="PartnerBundle\Entity\CompanyPositionCode")
     * @ORM\JoinColumn(name="position_code_id", referencedColumnName="id")
     * @Groups({"amqp", "rest"})
     */
    private $positionCode;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=128, nullable=true)
     * @Groups({"amqp", "rest"})
     */
    private $positionDescription;

    /**
     * @var Region
     *
     * @ORM\ManyToOne(targetEntity="PartnerBundle\Entity\Region", inversedBy="companyRegistryUsers")
     * @ORM\JoinColumn(name="region_id", nullable=true)
     * @Groups({"amqp", "rest"})
     */
    private $region;

    /**
     * @var District
     *
     * @ORM\ManyToOne(targetEntity="PartnerBundle\Entity\District", inversedBy="companyRegistryUsers")
     * @ORM\JoinColumn(name="district_id", nullable=true)
     * @Groups({"amqp", "rest"})
     */
    private $district;

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
     * CompanyRegistryUser constructor.
     * @param Company $company
     * @param int     $registryUserId
     */
    public function __construct(Company $company = null, int $registryUserId = null)
    {
        $this->company = $company;
        $this->registryUserId = $registryUserId;
    }

    /**
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param Company $company
     *
     * @return CompanyRegistryUser
     */
    public function setCompany($company): CompanyRegistryUser
    {
        $this->company = $company;

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
     * @return CompanyRegistryUser
     */
    public function setRegistryUserId(int $registryUserId): CompanyRegistryUser
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
     * @return CompanyRegistryUser
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
     * @return CompanyRegistryUser
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
     * @return CompanyRegistryUser|null
     */
    public function setPositionCode($positionCode)
    {
        $this->positionCode = $positionCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPositionDescription()
    {
        return $this->positionDescription;
    }

    /**
     * @param string|null $positionDescription
     *
     * @return CompanyRegistryUser
     */
    public function setPositionDescription($positionDescription): CompanyRegistryUser
    {
        $this->positionDescription = $positionDescription;
        return $this;
    }

    /**
     * @return Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param Region $region
     * @return CompanyRegistryUser
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return District
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * @param District $district
     * @return CompanyRegistryUser
     */
    public function setDistrict($district)
    {
        $this->district = $district;

        return $this;
    }
}
