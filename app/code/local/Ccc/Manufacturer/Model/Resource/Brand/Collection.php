<?php
class Ccc_Manufacturer_Model_Resource_Brand_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('manufacturer/brand');
        parent::_construct();
    }
}