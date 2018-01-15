<?php

namespace PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use PartnerBundle\Entity\Base\BaseTempPartnerUserTrait;

/**
 * Relation One to Many between Partner and RegistryUser
 * Class TempPartnerRegistryUser
 * @package PartnerBundle\Entity
 *
 * @SWG\Definition()
 * @ORM\Entity
 * @ORM\Table(name="temp_partner_registry_user")
 * @UniqueEntity(
 *       fields={"legacyRegistryUserId"},
 *       message="legacyRegistryUserId already related to another partner"
 * )
 */
class TempPartnerRegistryUser
{
    use BaseTempPartnerUserTrait;
}
