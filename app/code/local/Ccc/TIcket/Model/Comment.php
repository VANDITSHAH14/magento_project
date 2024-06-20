<?php
class Ccc_Ticket_Model_Comment extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('ticket/comment');
    }

    protected function _beforeSave() {
        if($this->isObjectNew())
        {
            $this->addData(['created_at' => date('Y-m-d H:i:s')]);
        }
        $this->setData('updated_at',date('Y-m-d H:i:s'));
    }
}