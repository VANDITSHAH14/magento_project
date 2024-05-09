<?php
class Ccc_Manufacturer_Model_Resource_Manufacturer extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('manufacturer/manufacturer','entity_id');
    }

}       