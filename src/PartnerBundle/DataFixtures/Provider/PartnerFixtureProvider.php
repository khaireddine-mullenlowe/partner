<?php

namespace PartnerBundle\DataFixtures\Provider;

use Faker\Provider\Base;
use Faker\Provider\Miscellaneous;

/**
 * Class ArrayRandomProvider
 * @package PartnerBundle\DataFixtures\Provider
 */
class PartnerFixtureProvider
{
    /**
     * Returns element indexed by $index in input array.
     *
     * @param array      $input
     * @param int|string $index
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public static function arrayAt(array $input, $index)
    {
        if (!is_int($index) && !is_string($index)) {
            throw new \InvalidArgumentException(
                sprintf('$index must be of integer or string type, %s given', gettype($index))
            );
        }

        return $input[$index];
    }

    /**
     * @param bool $isOccPlus
     * @return string|null
     */
    public static function setOccPlusContractNumber(bool $isOccPlus)
    {
        return true === $isOccPlus ? sprintf('0%d', Base::randomNumber(7, true)) : null;
    }

    /**
     * @param bool $isTrue
     * @return string|null
     */
    public static function setDigitallV12Id(bool $isTrue)
    {
        return true === $isTrue ? Miscellaneous::md5() : null;
    }
}
