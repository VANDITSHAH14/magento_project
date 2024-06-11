<?php
class Ccc_Filemanager_Block_Adminhtml_File extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup = 'filemanager';
        $this->_controller = 'adminhtml_file';
        $this->_headerText = Mage::helper('filemanager')->__(' Manage file');
        // $this->_addButtonLabel = Mage::helper('filemanager')->__('Add New Banner');
        parent::__construct();
        $this->setTemplate('filemanager/grid/container.phtml');
    }

    public function _prepareLayout()
    {
        $this->removeButton('add');
        return parent::_prepareLayout();
    }

    public function getFilePath()
    {
        return Mage::getStoreConfig('filemanager/file/file_path');
    }

}
