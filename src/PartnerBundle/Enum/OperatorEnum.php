<?php

namespace PartnerBundle\Enum;

/**
 * Class OperatorEnum
 * @package PartnerBundle\Enum
 */
class OperatorEnum extends BaseEnum
{
    const EQUAL = 'eq';
    const NOT_EQUAL = 'neq';

    /**
     * {@inheritdoc}
     */
    public static function getData()
    {
        return [
            self::EQUAL => '=',
            self::NOT_EQUAL => '<>',
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
            self::NOT_EQUAL => 'NOT IN',
        ];

        return $data[$key] ?? false;
    }

}
