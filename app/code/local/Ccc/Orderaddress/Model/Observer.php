<?php
class Ccc_Orderaddress_Model_Observer
{
    public function addressVarification(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        Mage::log('hi',null,'abc.log',true);
        Mage::log($order->getBillingAddress(),null,'abc.log',true);
    }
}