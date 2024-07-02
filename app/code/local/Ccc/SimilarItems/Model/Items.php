<?php
class Ccc_SimilarItems_Model_Items extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('items/items');
    }

    protected function _beforeSave()
    {
        $this->addData(['created_at' => date('Y-m-d H:i:s')]);
    }

    public function getProduct() {
        $options = [];
        $productCollection = Mage::getModel('catalog/product')->getCollection();

        foreach($productCollection as $_prd) {
            $product = Mage::getModel('catalog/product')->load($_prd->getId());
            $options[$product->getId()] = $product->getName();
        }

        return $options;
    }
}