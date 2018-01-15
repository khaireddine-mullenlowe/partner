<?php

namespace PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PartnerBundle\Entity\Base\BaseTempUserTrait;

/**
 * Class TempRegistryUser
 * @package PartnerBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="temp_registry_user")
 */
class TempRegistryUser
{
    use BaseTempUserTrait;
}
