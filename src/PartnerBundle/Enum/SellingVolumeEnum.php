<?php

namespace PartnerBundle\Enum;

/**
 * Class PartnerPrestigeTypeEnum
 * @package PartnerBundle\Enum
 */
class SellingVolumeEnum
{
    const VOLUME_120 = '0-120';
    const VOLUME_240 = '121-240';
    const VOLUME_360 = '241-360';
    const VOLUME_480 = '361-480';
    const VOLUME_600 = '481-600';
    const VOLUME_720 = '601-720';
    const VOLUME_840 = '721-840';
    const VOLUME_960 = '841-960';
    const VOLUME_961 = '>961';

    /**
     * {@inheritdoc}
     */
    public static function getData()
    {
        return [
            self::VOLUME_120,
            self::VOLUME_240,
            self::VOLUME_360,
            self::VOLUME_480,
            self::VOLUME_600,
            self::VOLUME_720,
            self::VOLUME_840,
            self::VOLUME_960,
            self::VOLUME_961,
        ];
    }
}
