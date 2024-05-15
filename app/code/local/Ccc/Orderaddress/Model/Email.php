<?php
class Ccc_Orderaddress_Model_Email extends Mage_Sales_Model_Order
{
    public function cancel()
    {
        if ($this->canCancel()) {
            $this->getPayment()->cancel();
            $this->registerCancellation();

            Mage::dispatchEvent('order_cancel', array('order' => $this));
        }

        return $this;
    }
}