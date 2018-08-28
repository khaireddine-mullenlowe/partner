<?php

namespace PartnerBundle\ETL\Transformer;

/**
 * Class RegistryUserTransformer
 * @package PartnerBundle\ETL\Transformer
 */
class RegistryUserTransformer extends UserTransformer
{
    /**
     * @var string
     */
    const QUERY = 'SELECT id FROM registry_user WHERE legacy_id = :legacyId';
}
