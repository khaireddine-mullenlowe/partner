<?php

namespace PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PartnerBundle\Entity\Base\BaseCompany;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Company
 * @package PartnerBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="company")
 */
class Company extends BaseCompany
{
    /**
     * @var CompanyType
     *
     * @ORM\ManyToOne(targetEntity="PartnerBundle\Entity\CompanyType", inversedBy="companies")
     * @ORM\JoinColumn(name="type", referencedColumnName="id")
     * @Groups({"rest"})
     */
    private $type;

    /**
     * One Company have Many registryUsers.
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="PartnerBundle\Entity\CompanyRegistryUser",
     *     mappedBy="company",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=true
     * )
     */
    private $registryUsers;

    /**
     * @return CompanyType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param CompanyType $type
     *
     * @return Company
     */
    public function setType(CompanyType $type)
    {
        $this->type = $type;
        $type->addCompany($this);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getRegistryUsers()
    {
        return $this->registryUsers;
    }

    /**
     * @param CompanyRegistryUser $registryUser
     *
     * @return Company
     */
    public function addRegistryUser(CompanyRegistryUser $registryUser)
    {
        if (!$this->registryUsers->contains($registryUser)) {
            $this->registryUsers->add($registryUser);
        }
        $registryUser->setCompany($this);

        return $this;
    }

    /**
     * @param CompanyRegistryUser $registryUser
     *
     * @return Company
     */
    public function removeRegistryUser(CompanyRegistryUser $registryUser)
    {
        if ($this->registryUsers->contains($registryUser)) {
            $this->registryUsers->removeElement($registryUser);
        }
        $registryUser->setCompany(null);

        return $this;
    }
}
