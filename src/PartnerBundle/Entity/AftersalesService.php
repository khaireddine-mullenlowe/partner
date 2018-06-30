<?php

namespace PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Mullenlowe\CommonBundle\Entity\Base\BaseEntity;
use Mullenlowe\CommonBundle\Entity\Traits\LegacyTrait;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class AftersalesService
 * @package PartnerBundle\Entity
 *
 * @ORM\Entity(repositoryClass="PartnerBundle\Repository\AftersalesServiceRepository")
 * @ORM\Table(
 *     name="aftersales_service",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="AftersalesService_unique_idx", columns={"type", "name"})
 *     },
 *     indexes={@ORM\Index(name="AftersalesService_LegacyId_idx", columns={"legacy_id"})}
 * )
 *
 * @UniqueEntity(
 *     fields={"type", "name"},
 *     errorPath="name",
 *     message="This AftersalesService name is already bound to this type"
 * )
 */
class AftersalesService extends BaseEntity
{
    use LegacyTrait;

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
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Groups({"rest"})
     */
    protected $type;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Groups({"rest"})
     */
    protected $name;

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
     */
    protected $legacyId;

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return AftersalesService
     */
    public function setType($type): AftersalesService
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return AftersalesService
     */
    public function setName($name): AftersalesService
    {
        $this->name = $name;

        return $this;
    }
}
