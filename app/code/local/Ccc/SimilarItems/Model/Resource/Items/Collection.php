<?php
class Ccc_SimilarItems_Model_Resource_Items_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('items/items');
        parent::_construct();
    }
}