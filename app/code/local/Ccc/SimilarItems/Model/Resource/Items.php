<?php
class Ccc_SimilarItems_Model_Resource_Items extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('items/items','id');
    }
}       