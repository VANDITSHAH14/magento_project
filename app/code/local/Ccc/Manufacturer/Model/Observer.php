<?php
class Ccc_Manufacturer_Model_Observer
{
    public function orderItemAddtional(Varien_Event_Observer $observer)
    {
        $data = [];
        $order = $observer->getEvent()->getOrder();
        $items = $order->getAllItems();
        $data['order_id'] = $order->getId();
        foreach ($items as $item) {
            // Get your values for the fields
            $data['item_id'] = $item->getId();
            $data['brand_id'] = $item->getBrand(); // Assuming you have a custom attribute for brand
            $manufacturerBrand = Mage::getModel('manufacturer/brand')->load($item->getBrand(), 'brand_id');
            $data['mfr_id'] = $manufacturerBrand->getMfrId();
            
            $data['created_at'] = date('Y-m-d H:i:s'); // Current datetime
            Mage::log($data,null,'vandit.log',true);

            // Save data to the additional table
            $additionalData = Mage::getModel('manufacturer/additional');
            $additionalData->setData($data)
                           ->save();
        }
    }
}