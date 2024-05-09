<?php
class Ccc_Catalog_Block_Adminhtml_Sales_Order_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('form');
        $this->setTitle(Mage::helper('sales')->__('order Information'));
    }
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
    }
    protected function _prepareForm()
    {
        
        $model = Mage::registry('sales_order');
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method'    => 'post',
        ));
        $form->setHtmlIdPrefix('order_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('sales')->__('General Information'), 'class' => 'fieldset-wide'));

        if ($model->getEntityId()) {
            $fieldset->addField('entity_id', 'hidden', array(
                'name' => 'entity_id',
            ));
        }

        $fieldset->addField('delivery_note', 'text', array(
            'name'      => 'delivery_note',
            'label'     => Mage::helper('sales')->__('Delivery Note'),
            'title'     => Mage::helper('sales')->__('Delivery Note'),
            'required'  => true,
        ));

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }   

}

