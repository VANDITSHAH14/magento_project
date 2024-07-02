<?php
class Ccc_SimilarItems_Block_Adminhtml_Item_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'items';
        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_item';

        parent::__construct();

        $this->_updateButton('save', 'label', Mage::helper('items')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('items')->__('Delete Item'));

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
        if (Mage::registry('ccc_similar_items')->getId()) {
            return Mage::helper('items')->__("Edit Item '%s'", $this->escapeHtml(Mage::registry('ccc_similar_items')->getId()));
        }
        else {
            return Mage::helper('items')->__('New Item');
        }
    }
    
}
