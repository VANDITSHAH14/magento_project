<?php

class Ccc_Manufacturer_Block_Adminhtml_Manufacturer_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'entity_id';
        $this->_blockGroup = 'manufacturer';
        $this->_controller = 'adminhtml_manufacturer';

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('manufacturer')->__('Save Order Stock'));
        $this->_updateButton('delete', 'label', Mage::helper('manufacturer')->__('Delete Order Stock'));

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }
    public function getHeaderText()
    {
        if (Mage::registry('ccc_manufacturer')->getId()) {
            return Mage::helper('manufacturer')->__("Edit Order Stock '%s'", $this->escapeHtml(Mage::registry('ccc_manufacturer')->getTitle()));
        }
        else {
            return Mage::helper('manufacturer')->__('New Order Stock');
        }
    }
}