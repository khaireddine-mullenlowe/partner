<?php

namespace PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use PartnerBundle\Entity\Base\BaseTempPartnerUserTrait;

/**
 * Relation One to Many between Partner and MyaudiUser
 * Class TempPartnerMyaudiUser
 * @package PartnerBundle\Entity
 *
 * @SWG\Definition()
 * @ORM\Entity
 * @ORM\Table(name="temp_partner_myaudi_user")
 * @UniqueEntity(
 *       fields={"legacyRegistryUserId"},
 *       message="legacyRegistryUserId already related to another partner"
 * )
 */
class TempPartnerMyaudiUser
{
    use BaseTempPartnerUserTrait;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return TempPartnerMyaudiUser
     */
    public function setCreatedAt(\DateTime $createdAt): TempPartnerMyaudiUser
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
