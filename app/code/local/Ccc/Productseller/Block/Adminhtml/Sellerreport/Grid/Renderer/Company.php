<?php
class Ccc_Productseller_Block_Adminhtml_Sellerreport_Grid_Renderer_Company extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $SellerId = Mage::getModel('catalog/product')->load($row->getId())->getSellerId();
        if($SellerId)
        {
            $seller = Mage::getModel('seller/seller')->load($SellerId);
            return $seller->getCompanyName();
        }
        else{
            return "";
        }
    }
}