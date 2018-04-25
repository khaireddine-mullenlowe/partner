<?php

namespace PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PartnerBundle\Entity\Base\BaseCompany;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class CompanyDepartment
 * @package PartnerBundle\Entity
 *
 * @ORM\Entity(repositoryClass="PartnerBundle\Repository\CompanyDepartmentRepository")
 * @ORM\Table(name="company_department")
 */
class CompanyDepartment extends BaseCompany
{
    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="PartnerBundle\Entity\CompanyType", mappedBy="departments")
     */
    private $companyTypes;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="PartnerBundle\Entity\CompanyPosition", inversedBy="departments")
     * @ORM\JoinTable(name="company_department_position")
     * @Groups("rest")
     */
    private $positions;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="PartnerBundle\Entity\CompanyPositionCode", mappedBy="department")
     * @Groups("rest")
     */
    private $positionCodes;

    /**
     * CompanyDepartment constructor.
     */
    public function __construct()
    {
        $this->companyTypes = new ArrayCollection();
        $this->positions = new ArrayCollection();
        $this->positionCodes = new ArrayCollection();
    }

    /**
     * @return Collection
     */
    public function getCompanyTypes()
    {
        return $this->companyTypes;
    }

    /**
     * @param ArrayCollection $companyTypes
     */
    public function setCompanyTypes(ArrayCollection $companyTypes)
    {
        $this->companyTypes = $companyTypes;
        foreach ($this->companyTypes as $companyType) {
            $companyType->addDepartment($this);
        }
    }

    /**
     * @param CompanyType $companyType
     *
     * @return $this
     */
    public function addCompanyType(CompanyType $companyType)
    {
        if (!$this->companyTypes->contains($companyType)) {
            $this->companyTypes->add($companyType);
            $companyType->addDepartment($this);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getPositions()
    {
        return $this->positions;
    }

    /**
     * @param ArrayCollection $positions
     */
    public function setPositions(ArrayCollection $positions)
    {
        $this->positions = $positions;
        foreach ($this->positions as $position) {
            $position->addDepartment($this);
        }
    }

    /**
     * @param CompanyPosition $position
     *
     * @return $this
     */
    public function addPosition(CompanyPosition $position)
    {
        if (!$this->positions->contains($position)) {
            $this->positions->add($position);
            $position->addDepartment($this);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getPositionCodes()
    {
        return $this->positionCodes;
    }

    /**
     * @param ArrayCollection $positionCodes
     */
    public function setPositionCodes(ArrayCollection $positionCodes)
    {
        $this->positionCodes = $positionCodes;
        foreach ($this->positionCodes as $positionCode) {
            $positionCode->addDepartment($this);
        }
    }

    /**
     * @param CompanyPositionCode $positionCode
     *
     * @return $this
     */
    public function addPositionCode(CompanyPositionCode $positionCode)
    {
        if (!$this->positionCodes->contains($positionCode)) {
            $this->positionCodes->add($positionCode);
            $positionCode->setDepartment($this);
        }

        return $this;
    }

    /**
     * Remove companyType
     *
     * @param \PartnerBundle\Entity\CompanyType $companyType
     *
     * @return $this
     */
    public function removeCompanyType(\PartnerBundle\Entity\CompanyType $companyType)
    {
        $this->companyTypes->removeElement($companyType);

        return $this;
    }

    /**
     * Remove position
     *
     * @param \PartnerBundle\Entity\CompanyPosition $position
     *
     * @return $this
     */
    public function removePosition(\PartnerBundle\Entity\CompanyPosition $position)
    {
        $this->positions->removeElement($position);

        return $this;
    }

    /**
     * Remove positionCode
     *
     * @param \PartnerBundle\Entity\CompanyPositionCode $positionCode
     *
     * @return $this
     */
    public function removePositionCode(\PartnerBundle\Entity\CompanyPositionCode $positionCode)
    {
        $this->positionCodes->removeElement($positionCode);

        return $this;
    }
}
