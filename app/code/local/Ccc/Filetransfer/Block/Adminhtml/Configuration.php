<?php
class Ccc_Filetransfer_Block_Adminhtml_Configuration extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup='filetransfer';
        $this->_controller = 'adminhtml_configuration';
        $this->_headerText = Mage::helper('filetransfer')->__(' Manage Configuration');
        $this->_addButtonLabel = Mage::helper('filetransfer')->__('Add New Config');
        parent::__construct();
    }

}
