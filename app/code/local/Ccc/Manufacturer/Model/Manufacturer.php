<?php
class Ccc_Manufacturer_Model_Manufacturer extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('manufacturer/manufacturer');
    }

    protected function _beforeSave() {
        if(!isset($this->getData()['created_at']))
        {
            $this->addData(['created_at' => date('Y-m-d H:i:s')])->addData(['created_by'=>Mage::getSingleton('admin/session')->getUser()->getUserId()]);
        }
    }
}