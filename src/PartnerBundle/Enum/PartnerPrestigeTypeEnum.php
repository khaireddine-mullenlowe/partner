<?php

namespace PartnerBundle\Enum;

/**
 * Class PartnerPrestigeTypeEnum
 * @package PartnerBundle\Enum
 */
class PartnerPrestigeTypeEnum
{
    const PRESTIGE_TYPE_EXCLUSIVE = 'exclusive';
    const PRESTIGE_TYPE_SPECIALIZED = 'specialized';

    /**
     * {@inheritdoc}
     */
    public static function getData()
    {
        return [
            self::PRESTIGE_TYPE_EXCLUSIVE => 'Exclusif',
            self::PRESTIGE_TYPE_SPECIALIZED => 'Spécialisé',
        ];
    }
}
