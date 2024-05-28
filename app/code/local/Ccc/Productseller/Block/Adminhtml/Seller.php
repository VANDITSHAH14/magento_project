<?php
class Ccc_Productseller_Block_Adminhtml_Seller extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup='seller';
        $this->_controller = 'adminhtml_seller';
        $this->_headerText = Mage::helper('seller')->__(' Manage Sellers');
        $this->_addButtonLabel = Mage::helper('seller')->__('Add New Seller');
        parent::__construct();
    }

}
