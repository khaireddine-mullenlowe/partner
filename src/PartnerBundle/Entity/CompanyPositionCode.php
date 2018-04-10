<?php

namespace PartnerBundle\Entity;

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
     * @return CompanyDepartment
     */
    public function getDepartment()
    {
        return $this->department;
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
}
