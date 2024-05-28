<?php
class Ccc_Productseller_Block_Adminhtml_Seller_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * Init form
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('seller_form');
        $this->setTitle(Mage::helper('seller')->__('Seller Information'));
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
        $model = Mage::registry('ccc_productseller');

        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post')
        );
        $form->setHtmlIdPrefix('seller_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('seller')->__('Seller Information'), 'class' => 'fieldset-wide'));

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
            'seller_name',
            'text',
            array(
                'name' => 'seller_name',
                'label' => Mage::helper('seller')->__('Seller Name'),
                'title' => Mage::helper('seller')->__('Seller Name'),
                'required' => true,
            )
        );

        $fieldset->addField(
            'company_name',
            'text',
            array(
                'name' => 'company_name',
                'label' => Mage::helper('seller')->__('Company Name'),
                'title' => Mage::helper('seller')->__('Company Name'),
                'required' => true,
            )
        );

        $fieldset->addField(
            'address',
            'text',
            array(
                'name' => 'address',
                'label' => Mage::helper('seller')->__('Address'),
                'title' => Mage::helper('seller')->__('Address'),
                'required' => true,
            )
        );

        $fieldset->addField(
            'city',
            'text',
            array(
                'name' => 'city',
                'label' => Mage::helper('seller')->__('City'),
                'title' => Mage::helper('seller')->__('City'),
                'required' => true,
            )
        );

        $fieldset->addField(
            'state',
            'text',
            array(
                'name' => 'state',
                'label' => Mage::helper('seller')->__('State'),
                'title' => Mage::helper('seller')->__('State'),
                'required' => true,
            )
        );

        $fieldset->addField(
            'country',
            'text',
            array(
                'name' => 'country',
                'label' => Mage::helper('seller')->__('Country'),
                'title' => Mage::helper('seller')->__('Country'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'is_active',
            'select',
            array(
                'label' => Mage::helper('seller')->__('Is Active'),
                'title' => Mage::helper('seller')->__('Is Active'),
                'name' => 'is_active',
                'required' => true,
                'options' => array(
                    '1' => Mage::helper('seller')->__('Yes'),
                    '0' => Mage::helper('seller')->__('No'),
                ),
            )
        );
        if (!$model->getId()) {
            $model->setData('is_active', '1');
        }

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
