<?php
class Ccc_Manufacturer_Block_Adminhtml_Manufacturer extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller ='adminhtml_manufacturer';
        $this->_blockGroup='manufacturer';
        $this->_headerText = Mage::helper('manufacturer')->__(' Manage Order Stock');
        $this->_addButtonLabel = Mage::helper('manufacturer')->__('Add New Order Stock');
        parent::__construct();
    }
}