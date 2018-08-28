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
 * @ORM\Entity(repositoryClass="PartnerBundle\Repository\CompanyPositionRepository")
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

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="PartnerBundle\Entity\PartnerRegistryUser", mappedBy="position")
     */
    private $partnerRegistryUsers;

    /**
     * One CompanyPosition have Many companyRegistryUsers.
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="PartnerBundle\Entity\CompanyRegistryUser",
     *     mappedBy="position",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=true
     * )
     */
    private $companyRegistryUsers;

    public function __construct()
    {
        $this->departments = new ArrayCollection();
        $this->partnerRegistryUsers = new ArrayCollection();
        $this->companyRegistryUsers = new ArrayCollection();
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
     *
     * @return $this
     */
    public function removeDepartment(\PartnerBundle\Entity\CompanyDepartment $department)
    {
        $this->departments->removeElement($department);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPartnerRegistryUsers()
    {
        return $this->partnerRegistryUsers;
    }

    /**
     * @param ArrayCollection $partnerRegistryUsers
     *
     * @return CompanyPosition
     */
    public function setPartnerRegistryUsers(ArrayCollection $partnerRegistryUsers)
    {
        $this->partnerRegistryUsers = $partnerRegistryUsers;

        return $this;
    }

    /**
     * @param PartnerRegistryUser $partnerRegistryUser
     * @return CompanyPosition
     */
    public function addPartnerRegistryUser(PartnerRegistryUser $partnerRegistryUser)
    {
        if (!$this->partnerRegistryUsers->contains($partnerRegistryUser)) {
            $this->partnerRegistryUsers->add($partnerRegistryUser);
            $partnerRegistryUser->setPosition($this);
        }

        return $this;
    }

    /**
     * @param PartnerRegistryUser $partnerRegistryUser
     * @return CompanyPosition
     */
    public function removePartnerRegistryUser(PartnerRegistryUser $partnerRegistryUser)
    {
        $this->partnerRegistryUsers->removeElement($partnerRegistryUser);
        $partnerRegistryUser->setPosition(null);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCompanyRegistryUsers()
    {
        return $this->companyRegistryUsers;
    }

    /**
     * @param CompanyRegistryUser $companyRegistryUser
     *
     * @return CompanyPosition
     */
    public function addCompanyRegistryUser(CompanyRegistryUser $companyRegistryUser)
    {
        if (!$this->companyRegistryUsers->contains($companyRegistryUser)) {
            $this->companyRegistryUsers->add($companyRegistryUser);
        }
        $companyRegistryUser->setPosition($this);

        return $this;
    }

    /**
     * @param CompanyRegistryUser $companyRegistryUser
     *
     * @return CompanyPosition
     */
    public function removeCompanyRegistryUser(CompanyRegistryUser $companyRegistryUser)
    {
        $this->companyRegistryUsers->removeElement($companyRegistryUser);
        $companyRegistryUser->setPosition(null);

        return $this;
    }
}
