<?php
class Ccc_Productseller_Model_Option extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    public function getAllOptions()
    {
        $seller = Mage::getSingleton('seller/seller')->getCollection();
        $options = [];
        foreach ($seller as $_seller) {
            $options[] = [
                'value' => $_seller->getId(),
                'label' => $_seller->getSellerName()
            ];
        }
        return $options;
    }
    
}