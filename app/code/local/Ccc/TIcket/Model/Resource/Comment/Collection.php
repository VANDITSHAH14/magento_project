<?php
class Ccc_Ticket_Model_Resource_Comment_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('ticket/comment');
        parent::_construct();
    }
}