<?php

namespace PartnerBundle\DataFixtures\Provider;

/**
 * Class ArrayRandomProvider
 * @package PartnerBundle\DataFixtures\Provider
 */
class PartnerFixtureProvider
{
    /**
     * Returns element indexed by $index in input array.
     *
     * @param array $input
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
}
