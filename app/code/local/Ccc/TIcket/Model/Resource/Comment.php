<?php
class Ccc_Ticket_Model_Resource_Comment extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('ticket/comment','comment_id');
    }
}