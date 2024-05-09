<?php
class Ccc_Catalog_Block_Item_Configurable extends Mage_Checkout_Block_Cart_Item_Renderer_Configurable
{
    public function getBrandName($brandId)
    {
        return Mage::getModel('catalog/product')->getResource()->getAttribute('brand')->getSource()->getOptionText($brandId);
    }
    public function getShippingType($shippingId)
    {
        return Mage::getModel('catalog/product')->getResource()->getAttribute('shipping_type')->getSource()->getOptionText($shippingId);
    }
    public function isShowBrand()
    {
        return (int)Mage::getStoreConfig('sales/brand/show_brand_name');
    }
}