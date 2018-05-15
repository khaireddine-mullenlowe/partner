<?php

namespace PartnerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use PartnerBundle\Entity\Base\BaseCompany;

/**
 * Class CompanyPositionCode
 * @package PartnerBundle\Entity
 *
 * @ORM\Entity(repositoryClass="PartnerBundle\Repository\CompanyPositionCodeRepository")
 * @ORM\Table(name="company_position_code")
 */
class CompanyPositionCode extends BaseCompany
{
    /**
     * @var CompanyDepartment
     *
     * @ORM\ManyToOne(targetEntity="PartnerBundle\Entity\CompanyDepartment", inversedBy="positionCodes")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id")
     */
    private $department;

    /**
     * One PositionCode have Many registryUsers.
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="PartnerRegistryUser", mappedBy="positionCode", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $partnerRegistryUsers;

    /**
     * One CompanyPositionCode have Many companyRegistryUsers.
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="PartnerBundle\Entity\CompanyRegistryUser",
     *     mappedBy="positionCode",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=true
     * )
     */
    private $companyRegistryUsers;

    /**
     * @return CompanyDepartment
     */
    public function getDepartment()
    {
        return $this->department;
        $this->partnerRegistryUsers = new ArrayCollection();
        $this->companyRegistryUsers = new ArrayCollection();
    }

    /**
     * @param CompanyDepartment $department
     *
     * @return CompanyPositionCode
     */
    public function setDepartment(CompanyDepartment $department)
    {
        $this->department = $department;
        $department->addPositionCode($this);

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
     * @return CompanyPositionCode
     */
    public function setPartnerRegistryUsers(ArrayCollection $partnerRegistryUsers)
    {
        $this->partnerRegistryUsers = $partnerRegistryUsers;

        return $this;
    }

    /**
     * @param PartnerRegistryUser $partnerRegistryUser
     * @return CompanyPositionCode
     */
    public function addPartnerRegistryUser(PartnerRegistryUser $partnerRegistryUser)
    {
        if (!$this->partnerRegistryUsers->contains($partnerRegistryUser)) {
            $this->partnerRegistryUsers->add($partnerRegistryUser);
            $partnerRegistryUser->setPositionCode($this);
        }

        return $this;
    }

    /**
     * @param PartnerRegistryUser $partnerRegistryUser
     * @return CompanyPositionCode
     */
    public function removePartnerRegistryUser(PartnerRegistryUser $partnerRegistryUser)
    {
        $this->partnerRegistryUsers->removeElement($partnerRegistryUser);
        $partnerRegistryUser->setPositionCode(null);

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
     * @return CompanyPositionCode
     */
    public function addCompanyRegistryUser(CompanyRegistryUser $companyRegistryUser)
    {
        if (!$this->companyRegistryUsers->contains($companyRegistryUser)) {
            $this->companyRegistryUsers->add($companyRegistryUser);
        }
        $companyRegistryUser->setPositionCode($this);

        return $this;
    }

    /**
     * @param CompanyRegistryUser $companyRegistryUser
     *
     * @return CompanyPositionCode
     */
    public function removeCompanyRegistryUser(CompanyRegistryUser $companyRegistryUser)
    {
        $this->companyRegistryUsers->removeElement($companyRegistryUser);
        $companyRegistryUser->setPositionCode(null);

        return $this;
    }
}
