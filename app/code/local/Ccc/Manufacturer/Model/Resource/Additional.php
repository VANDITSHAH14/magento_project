<?php
class Ccc_Manufacturer_Model_Resource_Additional extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('manufacturer/additional','entity_id');
    }
}