<?php

namespace PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PartnerBundle\Entity\Base\BaseCompany;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class CompanyPosition
 * @package PartnerBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="company_position")
 */
class CompanyPosition extends BaseCompany
{
    /**
     * @var CompanyDepartment
     *
     * @ORM\ManyToMany(targetEntity="PartnerBundle\Entity\CompanyDepartment", mappedBy="positions")
     */
    private $departments;

    public function __construct()
    {
        $this->departments = new ArrayCollection();
    }

    /**
     * @return Collection
     */
    public function getDepartments()
    {
        return $this->departments;
    }

    /**
     * @param ArrayCollection $departments
     *
     * @return CompanyPosition
     */
    public function setDepartments(ArrayCollection $departments)
    {
        $this->departments = $departments;
        foreach ($this->departments as $department) {
            $department->addPosition($this);
        }

        return $this;
    }

    /**
     * @param CompanyDepartment $department
     *
     * @return $this
     */
    public function addDepartment(CompanyDepartment $department)
    {
        if (!$this->departments->contains($department)) {
            $this->departments->add($department);
            $department->addPosition($this);
        }

        return $this;
    }

    /**
     * Remove department
     *
     * @param \PartnerBundle\Entity\CompanyDepartment $department
     */
    public function removeDepartment(\PartnerBundle\Entity\CompanyDepartment $department)
    {
        $this->departments->removeElement($department);
    }
}
