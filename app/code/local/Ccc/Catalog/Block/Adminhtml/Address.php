<?php

class Ccc_Catalog_Block_adminhtml_Address extends Mage_Adminhtml_Block_Sales_Order_View_Info
{
    public function getNoteEditLink($address, $label='')
    {
        if (empty($label)) {
            $label = $this->__('Edit');
        }
        $url = $this->getUrl('*/sales_order/edit', array('entity_id'=>$address->getId()));
        return '<a href="'.$url.'">' . $label . '</a>';
    }
    public function isAllowedDeliveryNote()
    {
        return Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/delivery_note');
    }
}
