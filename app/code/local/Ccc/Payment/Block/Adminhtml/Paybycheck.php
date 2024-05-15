<?php
class Ccc_Payment_Block_Adminhtml_Paybycheck extends Mage_Adminhtml_Block_Sales_Order_View_Info
{
    public function getChekInfo()
    {
        return $this->getOrder()->getPayment()->getPoNumber();
    }
}