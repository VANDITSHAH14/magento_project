<?php
class Ccc_Outlook_Block_Adminhtml_Configuration extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup='outlook';
        $this->_controller = 'adminhtml_configuration';
        $this->_headerText = Mage::helper('outlook')->__(' Manage Configuration');
        $this->_addButtonLabel = Mage::helper('outlook')->__('Add New Config');
        parent::__construct();
    }

}
