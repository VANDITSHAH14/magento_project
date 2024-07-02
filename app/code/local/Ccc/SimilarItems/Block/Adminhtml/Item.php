<?php
class Ccc_SimilarItems_Block_Adminhtml_Item extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup='items';
        $this->_controller = 'adminhtml_item';
        $this->_headerText = Mage::helper('items')->__(' Manage Items');
        $this->_addButtonLabel = Mage::helper('items')->__('Add New Items');
        parent::__construct();
    }
}
