<?php

namespace PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PartnerBundle\Entity\Base\BaseCompany;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class CompanyType
 * @package PartnerBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="company_type")
 */
class CompanyType extends BaseCompany
{
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="PartnerBundle\Entity\Company", mappedBy="type")
     */
    private $companies;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="PartnerBundle\Entity\CompanyDepartment", inversedBy="companyTypes")
     * @ORM\JoinTable(name="company_type_department")
     */
    private $departments;

    /**
     * CompanyType constructor.
     */
    public function __construct()
    {
        $this->companies = new ArrayCollection();
        $this->departments = new ArrayCollection();
    }

    /**
     * @return Collection
     */
    public function getCompanies()
    {
        return $this->companies;
    }

    /**
     * @param ArrayCollection $companies
     *
     * @return CompanyType
     */
    public function setCompanies(ArrayCollection $companies)
    {
        $this->companies = $companies;
        foreach ($this->companies as $company) {
            $company->setType($this);
        }

        return $this;
    }

    /**
     * @param Company $company
     *
     * @return CompanyType
     */
    public function addCompany(Company $company)
    {
        if (!$this->companies->contains($company)) {
            $this->companies->add($company);
            $company->setType($this);
        }

        return $this;
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
     * @return CompanyType
     */
    public function setDepartments(ArrayCollection $departments)
    {
        $this->departments = $departments;
        foreach ($this->departments as $department) {
            $department->addCompanyType($this);
        }

        return $this;
    }

    /**
     * @param CompanyDepartment $department
     *
     * @return CompanyType
     */
    public function addDepartment(CompanyDepartment $department)
    {
        if (!$this->departments->contains($department)) {
            $this->departments->add($department);
            $department->addCompanyType($this);
        }

        return $this;
    }
}
