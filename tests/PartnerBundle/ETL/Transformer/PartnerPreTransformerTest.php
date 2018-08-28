<?php
/**
 * Created by PhpStorm.
 * User: florian.trouve
 * Date: 03/01/2018
 * Time: 13:52
 */

namespace PartnerBundle\Tests\ETL\Transformer;


use Mullenlowe\EtlBundle\Mapping\Column;
use Mullenlowe\EtlBundle\Mapping\Mapping;
use Mullenlowe\EtlBundle\Row;
use PartnerBundle\ETL\Transformer\PartnerPreTransformer;

/**
 * Class PartnerPreTransformerTest
 * @package PartnerBundle\Tests\ETL\Transformer
 */
class PartnerPreTransformerTest extends \Codeception\Test\Unit
{
    /**
     * @var PartnerPreTransformer
     */
    private $partnerPreTransformer;

    /**
     * Before
     */
    protected function _before()
    {
        $this->partnerPreTransformer = new PartnerPreTransformer();
    }

    /**
     * Tests createResponse method
     */
    public function testTransform()
    {
        $row = new Row([
            new Column(new Mapping('company_name', 'companyName'), 'mullenlowe'),
            new Column(new Mapping('ntw_contract_id', 'type'), '2270913'),
        ]);

        $this->partnerPreTransformer->transform($row);

        // make sure that company_name value has not been transformed
        $this->assertEquals('mullenlowe', $row->getPayload()[0]->getValue());

        // make sure that ntw_contract_id value has been transformed into 'sales'
        $this->assertEquals('sales', $row->getPayload()[1]->getValue());

        $row = new Row([
            new Column(new Mapping('company_name', 'companyName'), 'mullenlowe one'),
            new Column(new Mapping('ntw_contract_id', 'type'), '2270914'),
        ]);

        $this->partnerPreTransformer->transform($row);

        // make sure that company_name value has not been transformed
        $this->assertEquals('mullenlowe one', $row->getPayload()[0]->getValue());

        // make sure that ntw_contract_id value has been transformed into 'aftersales'
        $this->assertEquals('aftersales', $row->getPayload()[1]->getValue());
    }
}