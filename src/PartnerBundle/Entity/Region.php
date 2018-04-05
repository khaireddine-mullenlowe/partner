<?php

namespace PartnerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Mullenlowe\CommonBundle\Entity\Base\BaseEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Region
 *
 * @ORM\Table(name="region")
 * @ORM\Entity
 */
class Region extends BaseEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"rest"})
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="partnerType", type="string", length=25)
     * @Assert\Choice(choices={Partner::SALES_TYPE, Partner::AFTERSALES_TYPE}, strict=true)
     */
    private $partnerType;

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
     * Legacy id
     * @ORM\Column(type="integer", unique=true)
     * @var integer
     * @Groups({"rest"})
     */
    protected $legacyId;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="PartnerBundle\Entity\District", mappedBy="region", cascade={"persist", "remove"})
     * @Groups({"rest"})
     */
    private $districts;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="PartnerBundle\Entity\PartnerRegistryUser", mappedBy="region")
     */
    private $partnerRegistryUsers;


    /**
     * Region constructor.
     */
    public function __construct()
    {
        $this->districts = new ArrayCollection();
        $this->partnerRegistryUsers = new ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Region
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set partnerType
     *
     * @param string $partnerType
     *
     * @return Region
     */
    public function setPartnerType($partnerType)
    {
        $this->partnerType = $partnerType;

        return $this;
    }

    /**
     * Get partnerType
     *
     * @return string
     */
    public function getPartnerType()
    {
        return $this->partnerType;
    }

    /**
     * @return ArrayCollection
     */
    public function getDistricts()
    {
        return $this->districts;
    }

    /**
     * @param ArrayCollection $districts
     *
     * @return Region
     */
    public function setDistricts(ArrayCollection $districts)
    {
        $this->districts = $districts;

        return $this;
    }

    /**
     * @param District $district
     * @return Region
     */
    public function addDistrict(District $district)
    {
        if (!$this->districts->contains($district)) {
            $this->districts->add($district);
            $district->setRegion($this);
        }

        return $this;
    }

    /**
     * @param District $district
     * @return Region
     */
    public function removeDistrict(District $district)
    {
        $this->districts->removeElement($district);

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
     * @return Region
     */
    public function setLegacyId(int $legacyId)
    {
        $this->legacyId = $legacyId;

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
     * @return Region
     */
    public function setPartnerRegistryUsers(ArrayCollection $partnerRegistryUsers)
    {
        $this->partnerRegistryUsers = $partnerRegistryUsers;

        return $this;
    }

    /**
     * @param PartnerRegistryUser $partnerRegistryUser
     * @return Region
     */
    public function addPartnerRegistryUser(PartnerRegistryUser $partnerRegistryUser)
    {
        if (!$this->partnerRegistryUsers->contains($partnerRegistryUser)) {
            $this->partnerRegistryUsers->add($partnerRegistryUser);
            $partnerRegistryUser->setRegion($this);
        }

        return $this;
    }

    /**
     * @param PartnerRegistryUser $partnerRegistryUser
     * @return Region
     */
    public function removePartnerRegistryUser(PartnerRegistryUser $partnerRegistryUser)
    {
        $this->partnerRegistryUsers->removeElement($partnerRegistryUser);

        return $this;
    }
}

