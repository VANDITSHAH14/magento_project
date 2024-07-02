<?php
class Ccc_SimilarItems_Model_Observer
{
    public function updateHasSimilarItem(Varien_Event_Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();
        $productId = $product->getId();

        $similarItem = Mage::getModel('items/items')->getCollection()
            ->addFieldToFilter('main_product_id',$productId)
            ->addFieldToFilter('is_deleted',1);

        $hasSimilarItem = $similarItem->getSize() > 0 ? 255 : 258;

        $product->setHasSimilarItems($hasSimilarItem);
        $product->getResource()->saveAttribute($product, 'has_similar_items');
        
    }
}