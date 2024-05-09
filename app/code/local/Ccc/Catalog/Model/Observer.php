<?php
class Ccc_Catalog_Model_Observer
{
    public function addCustomProductAttributes(Varien_Event_Observer $observer)
    {
        $item = $observer->getEvent()->getQuoteItem();
        $product = $observer->getEvent()->getProduct();

        if ($product->getShippingType()) {
            $item->setData('shipping_type', $product->getShippingType());
        }
        if ($product->getBrand()) {
            $item->setData('brand', $product->getBrand());
        }
    }
}