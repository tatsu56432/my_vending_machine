<?php

require_once dirname(__FILE__) . '/common/Generic_Tests_DatabaseTestCase.php';

class YamlDrinkInfoTest extends Generic_Tests_DatabaseTestCase
{
    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    protected function getDataSet()
    {
        return new PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            dirname(__FILE__)."/_files/data.yml"
        );
    }

    public function testGetRowCount()
    {
        $this->assertEquals(2, $this->getConnection()->getRowCount('drink_info'));
    }
}