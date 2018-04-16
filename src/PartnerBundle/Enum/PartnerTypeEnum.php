<?php

namespace PartnerBundle\Enum;

/**
 * Class PartnerTypeEnum
 * @package PartnerBundle\Enum
 */
class PartnerTypeEnum extends BaseEnum
{
    const TYPE_SALES = 'sales';
    const TYPE_AFTERSALES = 'aftersales';

    /**
     * {@inheritdoc}
     */
    public static function getData()
    {
        // TODO : => i18n
        return [
            self::TYPE_SALES => 'Vente',
            self::TYPE_AFTERSALES => 'Service',
        ];
    }
}
