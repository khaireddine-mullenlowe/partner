<?php

namespace  PartnerBundle\Enum;

/**
 * Classe abstraite permettant de gérer les énumerations.
 */
abstract class BaseEnum
{
    /**
     * @return array
     */
    abstract public static function getData();

    /**
     * @param mixed $key
     * @return mixed
     */
    public static function getValue($key)
    {
        $data = self::getData();

        return isset($data[$key]) ? $data[$key] : null;
    }
}
