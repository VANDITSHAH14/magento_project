<?php
class Ccc_SimilarItems_Block_Adminhtml_Item_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('item_form');
        $this->setTitle(Mage::helper('items')->__('Item Information'));
    }

    /**
     * Load Wysiwyg on demand and Prepare layout
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
    }

    protected function _prepareForm()
    {
        $model = Mage::registry('ccc_similar_items');

        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post')
        );
        $form->setHtmlIdPrefix('item_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('items')->__('Item Information'), 'class' => 'fieldset-wide'));

        if ($model->getId()) {
            $fieldset->addField(
                'id',
                'hidden',
                array(
                    'name' => 'id',
                )
            );
        }

        $fieldset->addField(
            'main_product_id',
            'select',
            array(
                'name' => 'main_product_id',
                'label' => Mage::helper('items')->__('Main Product Id'),
                'title' => Mage::helper('items')->__('Main Product Id'),
                'required' => true,
                'options' => Mage::getModel('items/items')->getProduct()
            )
        );

        $fieldset->addField(
            'similar_product_id',
            'select',
            array(
                'name' => 'similar_product_id',
                'label' => Mage::helper('items')->__('Similar Product Id'),
                'title' => Mage::helper('items')->__('Similar Product Id'),
                'required' => true,
                'options' => Mage::getModel('items/items')->getProduct()
            )
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
