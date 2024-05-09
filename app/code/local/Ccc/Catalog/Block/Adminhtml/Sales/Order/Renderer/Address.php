<?php

class Ccc_Catalog_Block_Adminhtml_Sales_Order_Renderer_Address extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value = $row->getData($this->getColumn()->getIndex());
        

        if($value == 0)
        {
            return Mage::helper('sales')->__("NA");
        }
        elseif ($value == 1)
        {
            $orderId =$row->getId();
            $url = $this->getUrl('*/sales_order/validateAddress',array('order_id' =>$orderId));
            return '<button onclick="window.location.href=\'' . $url . '\'">' . Mage::helper('sales')->__("Validate") . '</button>';
        }
        else{
            return Mage::helper('sales')->__("Validated");
        }

    }
}