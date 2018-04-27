<?php

namespace PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mullenlowe\CommonBundle\Entity\Base\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Company
 * @package PartnerBundle\Entity
 *
 * @ORM\Entity(repositoryClass="PartnerBundle\Repository\CompanyRepository")
 * @ORM\Table(name="company")
 */
class Company extends BaseEntity
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"rest"})
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotNull()
     * @var string
     * @Groups({"rest"})
     */
    protected $corporateName;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotNull()
     * @var string
     * @Groups({"rest"})
     */
    protected $commercialName;

    /**
     * @var CompanyType
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity="PartnerBundle\Entity\CompanyType", inversedBy="companies")
     * @ORM\JoinColumn(name="type", referencedColumnName="id")
     * @Groups({"rest"})
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", options={"default":1})
     * @Assert\NotNull()
     * @Groups({"rest"})
     */
    protected $status = 1;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @Groups({"rest"})
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     * @Groups({"rest"})
     */
    protected $updatedAt;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"rest"})
     */
    protected $legacyId;

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
     * Constructor
     */
    public function __construct()
    {
        $this->registryUsers = new ArrayCollection();
    }

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
     * Set corporateName.
     *
     * @param string $corporateName
     *
     * @return Company
     */
    public function setCorporateName($corporateName)
    {
        $this->corporateName = $corporateName;

        return $this;
    }

    /**
     * Get corporateName.
     *
     * @return string
     */
    public function getCorporateName()
    {
        return $this->corporateName;
    }

    /**
     * Set commercialName.
     *
     * @param string $commercialName
     *
     * @return Company
     */
    public function setCommercialName($commercialName)
    {
        $this->commercialName = $commercialName;

        return $this;
    }

    /**
     * Get commercialName.
     *
     * @return string
     */
    public function getCommercialName()
    {
        return $this->commercialName;
    }

    /**
     * @return Collection
     */
    public function getRegistryUsers()
    {
        return $this->registryUsers;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return int
     */
    public function getLegacyId()
    {
        return $this->legacyId;
    }

    /**
     * @param int $legacyId
     *
     * @return $this
     */
    public function setLegacyId($legacyId)
    {
        $this->legacyId = $legacyId;

        return $this;
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
        $this->registryUsers->removeElement($registryUser);
        $registryUser->setCompany(null);

        return $this;
    }
}
