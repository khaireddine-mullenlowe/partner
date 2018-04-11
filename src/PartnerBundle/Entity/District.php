<?php

namespace PartnerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Mullenlowe\CommonBundle\Entity\Base\BaseEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * District
 *
 * @ORM\Table(name="district")
 * @ORM\Entity
 */
class District extends BaseEntity
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
     * @var Region
     *
     * @ORM\ManyToOne(targetEntity="PartnerBundle\Entity\Region", inversedBy="districts")
     */
    private $region;

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
     * @ORM\OneToMany(targetEntity="PartnerBundle\Entity\Partner", mappedBy="district")
     */
    private $partners;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="PartnerBundle\Entity\PartnerRegistryUser", mappedBy="district")
     */
    private $partnerRegistryUsers;


    /**
     * District constructor.
     */
    public function __construct()
    {
        $this->partners = new ArrayCollection();
        $this->partnerRegistryUsers = new ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return District
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
     * @return Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param Region $region
     *
     * @return District
     */
    public function setRegion(Region $region)
    {
        $this->region = $region;

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
     * @return District
     */
    public function setLegacyId(int $legacyId)
    {
        $this->legacyId = $legacyId;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPartners()
    {
        return $this->partners;
    }

    /**
     * @param ArrayCollection $partners
     *
     * @return District
     */
    public function setPartners(ArrayCollection $partners)
    {
        $this->partners = $partners;

        return $this;
    }

    /**
     * @param Partner $partner
     * @return District
     */
    public function addPartner(Partner $partner)
    {
        if (!$this->partners->contains($partner)) {
            $this->partners->add($partner);
            $partner->setDistrict($this);
        }

        return $this;
    }

    /**
     * @param Partner $partner
     * @return District
     */
    public function removePartner(Partner $partner)
    {
        $this->partners->removeElement($partner);

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
     * @return District
     */
    public function setPartnerRegistryUsers(ArrayCollection $partnerRegistryUsers)
    {
        $this->partnerRegistryUsers = $partnerRegistryUsers;

        return $this;
    }

    /**
     * @param PartnerRegistryUser $partnerRegistryUser
     * @return District
     */
    public function addPartnerRegistryUser(PartnerRegistryUser $partnerRegistryUser)
    {
        if (!$this->partnerRegistryUsers->contains($partnerRegistryUser)) {
            $this->partnerRegistryUsers->add($partnerRegistryUser);
            $partnerRegistryUser->setDistrict($this);
        }

        return $this;
    }

    /**
     * @param PartnerRegistryUser $partnerRegistryUser
     * @return District
     */
    public function removePartnerRegistryUser(PartnerRegistryUser $partnerRegistryUser)
    {
        $this->partnerRegistryUsers->removeElement($partnerRegistryUser);

        return $this;
    }
}

