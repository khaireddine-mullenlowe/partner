<?php

namespace PartnerBundle\Enum;

/**
 * Class PartnerSiteTypeEnum
 * @package PartnerBundle\Enum
 */
class PartnerSiteTypeEnum extends BaseEnum
{
    const SITE_TYPE_PRINCIPAL = 'principal';
    const SITE_TYPE_SECONDARY = 'secondary';

    /**
     * {@inheritdoc}
     */
    public static function getData()
    {
        return [
            self::SITE_TYPE_PRINCIPAL => 'Principal',
            self::SITE_TYPE_SECONDARY => 'Secondaire',
        ];
    }
}
