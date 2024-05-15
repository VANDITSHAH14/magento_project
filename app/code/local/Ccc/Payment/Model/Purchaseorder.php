<?php
class Ccc_Payment_Model_PurchaseOrder
{
    public function toOptionArray($isMultiselect=false)
    {
        $options = array();
       
        $brandCollection = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'brand')->getSource()->getAllOptions();
        foreach ($brandCollection as $status) {
                $options[] = array(
                    'value' => $status['value'], // Assuming id as value
                    'label' => $status['label'] // Assuming name as label
                );
        }
        return $options;
    }
}