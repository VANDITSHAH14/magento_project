<?php
class Ccc_Productseller_Model_Seller extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('seller/seller');
    }

    protected function _beforeSave() {
        if($this->isObjectNew())
        {
            $this->addData(['created_at' => date('Y-m-d H:i:s')]);
        }
        $this->setData('update_date',date('Y-m-d'));
    }
}