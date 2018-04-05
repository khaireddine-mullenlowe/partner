<?php

namespace PartnerBundle\ETL\Transformer;

use Doctrine\DBAL\Connection;
use Mullenlowe\EtlBundle\Exception\TransformerException;
use Mullenlowe\EtlBundle\Row;

/**
 * Class MyaudiUserTransformer
 * @package PartnerBundle\ETL\Transformer
 */
class MyaudiUserTransformer extends UserTransformer
{
    /**
     * @var string
     */
    const QUERY = 'SELECT id FROM myaudi_user WHERE legacy_id = :legacyId';
}
