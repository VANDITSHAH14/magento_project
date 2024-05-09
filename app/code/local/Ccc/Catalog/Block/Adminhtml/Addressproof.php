<?php

class Ccc_Catalog_Block_adminhtml_Addressproof extends Mage_Adminhtml_Block_Sales_Order_View_Info
{
    public function getImage()
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'address_proof/'.$this->getOrder()->getBillingAddress()->getAddressProof();
    }
}
