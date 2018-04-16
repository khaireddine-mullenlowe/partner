<?php

namespace PartnerBundle\Enum;

/**
 * Class OperatorEnum
 * @package PartnerBundle\Enum
 */
class OperatorEnum extends BaseEnum
{
    const EQUAL = 'equal';
    const DIFFERENT = 'different';

    /**
     * {@inheritdoc}
     */
    public static function getData()
    {
        return [
            self::EQUAL => '=',
            self::DIFFERENT => '<>',
        ];
    }

    /**
     * @param string $key
     * @return bool|mixed
     */
    public static function getDoctrineToArray($key)
    {
        $data = [
            self::EQUAL => 'IN',
            self::DIFFERENT => 'NOT IN',
        ];

        return $data[$key] ?? false;
    }

}
