<?php
/**
 * Created by PhpStorm.
 * User: florian.trouve
 * Date: 03/01/2018
 * Time: 11:28
 */

namespace PartnerBundle\ETL\Transformer;

use Mullenlowe\EtlBundle\Mapping\Column;
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
        $payload = $row->getPayload();

        foreach ($payload as $item) {
            if (self::CONTRACT_ID_FIELD_NAME === $item->getName()) {
                $item->setValue($this->getMappedType($item));
            }
        }

        return $row;
    }

    /**
     * Returns the correct mapped value for 'type' field
     *
     * @param Column $column
     *
     * @return mixed|null
     */
    private function getMappedType(Column $column)
    {
        if (array_key_exists($column->getValue(), self::CONTRACT_TYPE_MAPPING)) {
            return self::CONTRACT_TYPE_MAPPING[$column->getValue()];
        }

        return null;
    }
}
