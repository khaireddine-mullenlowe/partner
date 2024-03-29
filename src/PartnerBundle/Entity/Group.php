<?php

namespace PartnerBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Mullenlowe\CommonBundle\Entity\Base\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Group
 * @package PartnerBundle\Entity
 *
 * @ORM\Entity(repositoryClass="PartnerBundle\Repository\GroupRepository")
 * @ORM\Table(name="partner_group")
 */
class Group extends BaseEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"rest"})
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     * @Groups({"rest"})
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     * @var string
     * @Groups({"rest"})
     */
    private $websiteUrl;

    /**
     * @ORM\Column(type="smallint", options={"default":1})
     * @var int
     * @Groups({"rest"})
     */
    private $status;

    /**
     * One Group has Many Partners.
     * @ORM\OneToMany(targetEntity="PartnerBundle\Entity\Partner", mappedBy="group")
     * @var ArrayCollection
     */
    private $partners;

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
     * Group constructor.
     */
    public function __construct()
    {
        $this->partners = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Group
     */
    public function setName(string $name): Group
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getWebsiteUrl(): string
    {
        return $this->websiteUrl;
    }

    /**
     * @param string $websiteUrl
     *
     * @return Group
     */
    public function setWebsiteUrl(string $websiteUrl): Group
    {
        $this->websiteUrl = $websiteUrl;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     *
     * @return Group
     */
    public function setStatus(int $status): Group
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getPartners(): Collection
    {
        return $this->partners;
    }

    /**
     * @param ArrayCollection $partners
     *
     * @return Group
     */
    public function setPartners(ArrayCollection $partners): Group
    {
        $this->partners = $partners;

        return $this;
    }

    /**
     * @param Partner $partner
     *
     * @return Group
     */
    public function addPartner(Partner $partner): Group
    {
        $this->partners->add($partner);

        return $this;
    }

    /**
     * Remove partner
     *
     * @param \PartnerBundle\Entity\Partner $partner
     *
     * @return Group
     */
    public function removePartner(\PartnerBundle\Entity\Partner $partner)
    {
        $this->partners->removeElement($partner);

        return $this;
    }
}
