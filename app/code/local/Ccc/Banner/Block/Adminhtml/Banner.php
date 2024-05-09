<?php
class Ccc_Banner_Block_Adminhtml_Banner extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup='banner';
        $this->_controller = 'adminhtml_banner';
        $this->_headerText = Mage::helper('banner')->__(' Manage Banner');
        $this->_addButtonLabel = Mage::helper('banner')->__('Add New Banner');
        parent::__construct();
        $this->setTemplate('banner/grid/container.phtml');
    }
    public function _prepareLayout()
    {
        if(!Mage::getSingleton('admin/session')->isAllowed('banner/banner/actions/show_Button'))
        {
            $this->removeButton('add');
        }
        return parent::_prepareLayout();
    }

}
