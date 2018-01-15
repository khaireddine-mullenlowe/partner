<?php

namespace PartnerBundle\Entity\Base;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait BaseTempUserTrait
 * @package PartnerBundle\Entity\Base
 */
trait BaseTempUserTrait
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $userId;

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $legacyId;

    /**
     * TempRegistryUser constructor.
     * @param int $userId
     * @param int $leagcyId
     */
    public function __construct(int $userId = null, int $leagcyId = null)
    {
        $this->userId = $userId;
        $this->legacyId = $leagcyId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;
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
     */
    public function setLegacyId(int $legacyId)
    {
        $this->legacyId = $legacyId;
    }
}
