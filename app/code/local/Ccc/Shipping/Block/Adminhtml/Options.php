<?php 
class Ccc_Shipping_Block_Adminhtml_Options extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    public function __construct()
    {
        $this->addColumn('from', array(
            'label' => Mage::helper('adminhtml')->__('From'),
            'style' => 'width:120px',
        ));
        $this->addColumn('to', array(
            'label' => Mage::helper('adminhtml')->__('To'),
            'style' => 'width:120px',
        ));
        $this->addColumn('price', array(
            'label' => Mage::helper('adminhtml')->__('Price'),
            'style' => 'width:120px',
        ));
        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('adminhtml')->__('Add Range');
        parent::__construct();
    }
}
