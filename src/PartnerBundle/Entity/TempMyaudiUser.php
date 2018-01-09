<?php

namespace PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PartnerBundle\Entity\Base\BaseTempUserTrait;

/**
 * Class TempMyaudiUser
 * @package PartnerBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="temp_myaudi_user")
 */
class TempMyaudiUser
{
    use BaseTempUserTrait;
}
