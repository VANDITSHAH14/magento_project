<?php
class Ccc_Manufacturer_Model_Resource_Brand extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('manufacturer/brand','entity_id');
    }
}       