<?php

namespace PartnerBundle\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Mullenlowe\CommonBundle\Entity\Base\BaseEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class BaseCompany
 * @package PartnerBundle\Entity\Base
 */
class BaseCompany extends BaseEntity
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
     * @var string
     *
     * @ORM\Column(type="string")
     * @Groups({"rest"})
     */
    protected $name;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", options={"default":1})
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
     * @ORM\Column(type="integer")
     * @Groups({"rest"})
     */
    protected $legacyId;

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
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;

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
     * @return $this
     */
    public function setStatus(int $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return int
     */
    public function getLegacyId(): int
    {
        return $this->legacyId;
    }

    /**
     * @param int $legacyId
     *
     * @return $this
     */
    public function setLegacyId(int $legacyId)
    {
        $this->legacyId = $legacyId;

        return $this;
    }
}
