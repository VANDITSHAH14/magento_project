<?php
class Ccc_Shipping_Block_Adminhtml_Shippingmethod extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup='ccc_shipping';
        $this->_controller = 'adminhtml_shippingmethod';
        $this->_headerText = Mage::helper('order')->__(' Manage Shipping Method');
        // $this->_addButtonLabel = Mage::helper('order')->__('Add New Shipping Method');
        parent::__construct();
    }
    public function _prepareLayout()
    {
        $this->removeButton('add');
        return parent::_prepareLayout();
    }
}