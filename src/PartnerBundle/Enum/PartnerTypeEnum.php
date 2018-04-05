<?php

namespace PartnerBundle\Enum;

class PartnerTypeEnum extends BaseEnum
{
    const TYPE_SALES = 'sales';
    const TYPE_AFTERSALES = 'aftersales';

    public static function getData()
    {
        return [
            self::TYPE_SALES => 'partner.type.sales',
            self::TYPE_AFTERSALES => 'partner.type.aftersales'
        ];
    }
}

