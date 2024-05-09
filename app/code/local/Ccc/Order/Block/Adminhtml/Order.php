<?php
class Ccc_Order_Block_Adminhtml_Order extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup='order';
        $this->_controller = 'adminhtml_order';
        $this->_headerText = Mage::helper('order')->__(' Manage Status');
        $this->_addButtonLabel = Mage::helper('order')->__('Add New Status');
        parent::__construct();
    }
}