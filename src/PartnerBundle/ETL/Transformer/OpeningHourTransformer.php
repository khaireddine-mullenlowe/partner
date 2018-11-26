<?php

namespace PartnerBundle\ETL\Transformer;

use Doctrine\DBAL\Connection;
use Faker\Provider\DateTime;
use Mullenlowe\EtlBundle\Exception\TransformerException;
use Mullenlowe\EtlBundle\Row;
use Mullenlowe\EtlBundle\Transformer\TransformerInterface;
use PartnerBundle\Entity\DepositType;
use PartnerBundle\Repository\PartnerRepository;

/**
 * Class DepositPartnerTransformer
 * @package PartnerBundle\ETL\Transformer
 */
class OpeningHourTransformer implements TransformerInterface
{
    const QUERY = 'SELECT id FROM partner WHERE legacy_id = :legacyId';

    /**
     * @var Connection
     */
    private $conn;

    /**
     * @var \PDOStatement
     */
    private $stmt = null;

    /**
     * @param Connection $conn
     */
    public function setConnection(Connection $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Transforms current data row by inner and/or custom mechanisms.
     *
     * @param Row $row
     *
     * @return Row
     * @throws \Doctrine\DBAL\DBALException
     */
    public function transform(Row $row): Row
    {
        if (is_null($this->stmt)) {
            $this->stmt = $this->conn->prepare(static::QUERY);
        }

        $noxColumn = $row->getColumn('nox');
        $noxColumnValue = (bool)$noxColumn->getValue();

        if (is_bool($noxColumnValue)) {
            $noxColumn->setValue($noxColumnValue);
        } else {
            $row->setSkipFlag(true)
                ->setSkipComment(sprintf('Nox value %d is not a boolean', $noxColumnValue));
        }

        $createdAtColumn = $row->getColumn('created_at');
        $createdAtColumnValue = new \DateTime($createdAtColumn->getValue());
        $createdAtColumn->setValue($createdAtColumnValue);

        $updatedAtColumn = $row->getColumn('updated_at');
        $updatedAtColumnValue = new \DateTime($updatedAtColumn->getValue());
        $updatedAtColumn->setValue($updatedAtColumnValue);

        return $row;
    }
}
