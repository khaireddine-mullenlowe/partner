<?php

namespace PartnerBundle\ETL\Transformer;

use Mullenlowe\EtlBundle\Row;
use Mullenlowe\EtlBundle\Transformer\TransformerInterface;
use PartnerBundle\Entity\Partner;

/**
 * Class PartnerPreTransformer
 * @package PartnerBundle\ETL\Transformer
 */
class PartnerPreTransformer implements TransformerInterface
{
    /**
     * @var string the contract id field name
     */
    const CONTRACT_ID_FIELD_NAME = 'ntw_contract_id';
    /**
     * @var string old aftersales contract id
     */
    const SALES_CONTRACT_ID = "2270913";
    /**
     * @var string old aftersales contract id
     */
    const AFTERSALES_CONTRACT_ID = "2270914";

    /**
     * @var array mapping between old contract id's and types
     */
    const CONTRACT_TYPE_MAPPING = [
        self::SALES_CONTRACT_ID => Partner::SALES_TYPE,
        self::AFTERSALES_CONTRACT_ID => Partner::AFTERSALES_TYPE,
    ];

    /**
     * Transforms a Partner row
     *
     * @param Row $row
     *
     * @return Row
     */
    public function transform(Row $row): Row
    {
        $column = $row->getColumn(self::CONTRACT_ID_FIELD_NAME);
        $contractType = $this->getMappedType($column->getValue());
        if (null === $contractType) {
            throw new \InvalidArgumentException(sprintf(
                "Invalid partner contract number '%s'\n%s",
                $column->getValue(),
                json_encode($row->getPayload())
            ));
        }
        $column->setValue($contractType);

        return $row;
    }

    /**
     * Returns the correct mapped value for 'type' field
     *
     * @param string $contractId
     *
     * @return string|null
     */
    private function getMappedType(string $contractId)
    {
        return array_key_exists($contractId, self::CONTRACT_TYPE_MAPPING)
            ? self::CONTRACT_TYPE_MAPPING[$contractId]
            : null;
    }
}
