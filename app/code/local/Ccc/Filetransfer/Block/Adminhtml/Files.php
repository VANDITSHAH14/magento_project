<?php
class Ccc_Filetransfer_Block_Adminhtml_Files extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup='filetransfer';
        $this->_controller = 'adminhtml_files';
        $this->_headerText = Mage::helper('filetransfer')->__(' Manage Files');
        $this->_addButtonLabel = Mage::helper('filetransfer')->__('Add New Files');
        parent::__construct();
    }

    public function _prepareLayout()
    {
        $this->removeButton('add');
        return parent::_prepareLayout();
    }
}
