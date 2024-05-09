<?php

class Ccc_Manufacturer_Block_Adminhtml_Manufacturer_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('manufacturer_form');
        $this->setTitle(Mage::helper('manufacturer')->__('Order Stock Information'));
    }

    /**
     * Load Wysiwyg on demand and Prepare layout
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        // if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
        //     $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        // }
    }

    protected function _prepareForm()
    {
        $model = Mage::registry('ccc_manufacturer');

        if($model && $model->getId())
        {
            $mfrBrandCollection = $this->getManufacturerBrandCollection();
            $brand = [];
            foreach($mfrBrandCollection->getData() as $_brand)
            {
                $brand[] = $_brand['brand_id'];
            }
            $model->setData('brand',$brand);
        }
        
        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post')
        );
        $form->setHtmlIdPrefix('manufacturer_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('manufacturer')->__('Order Stock Information'), 'class' => 'fieldset-wide'));

        if ($model->getEntityId()) {
            $fieldset->addField('entity_id', 'hidden', array(
                'name' => 'entity_id',
            ));
        }

        $fieldset->addField('manufacturer_name', 'text', array(
            'name'      => 'manufacturer_name',
            'label'     => Mage::helper('manufacturer')->__('Manufacturer Name'),
            'title'     => Mage::helper('manufacturer')->__('Manufacturer Name'),
            'required'  => true,
        ));

        $fieldset->addField('email', 'text', array(
            'name'      => 'email',
            'label'     => Mage::helper('manufacturer')->__('Email'),
            'title'     => Mage::helper('manufacturer')->__('Email'),
            'required'  => true,
        ));

        $fieldset->addField('street', 'text', array(
            'name'      => 'street',
            'label'     => Mage::helper('manufacturer')->__('Street'),
            'title'     => Mage::helper('manufacturer')->__('Street'),
            'required'  => true,
        ));

        $fieldset->addField('city', 'text', array(
            'name'      => 'city',
            'label'     => Mage::helper('manufacturer')->__('City'),
            'title'     => Mage::helper('manufacturer')->__('City'),
            'required'  => true,
        ));

        $fieldset->addField('state', 'text', array(
            'name'      => 'state',
            'label'     => Mage::helper('manufacturer')->__('State'),
            'title'     => Mage::helper('manufacturer')->__('State'),
            'required'  => true,
        ));

        $fieldset->addField('country', 'text', array(
            'name'      => 'country',
            'label'     => Mage::helper('manufacturer')->__('Country'),
            'title'     => Mage::helper('manufacturer')->__('Country'),
            'required'  => true,
        ));

        $fieldset->addField('zipcode', 'text', array(
            'name'      => 'zipcode',
            'label'     => Mage::helper('manufacturer')->__('Zipcode'),
            'title'     => Mage::helper('manufacturer')->__('Zipcode'),
            'required'  => true,
        ));

        $fieldset->addField('is_active', 'select', array(
            'label'     => Mage::helper('manufacturer')->__('Is Active'),
            'title'     => Mage::helper('manufacturer')->__('Is Active'),
            'name'      => 'is_active',
            'required'  => true,
            'options'   => array(
                '1' => Mage::helper('manufacturer')->__('Enabled'),
                '0' => Mage::helper('manufacturer')->__('Disabled'),
            ),
        ));
        if (!$model->getId()) {
            $model->setData('is_active', '1');
        }

        $fieldset->addField('brand', 'multiselect', array(
            'name' => 'brand',
            'label' => Mage::helper('order')->__('Order status'),
            'title' => Mage::helper('order')->__('Order status'),
            'required' => true,
            'values' => $this->getBrandOptions(),
        )
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
    public function getBrandOptions()
    {

        $brands = array();
        // $statusCollection = Mage::getModel('eav/entity_attribute_option')->getCollection()->addFieldToFilter('attribute_id',220);
        $brandCollection = Mage::getSingleton('eav/config')->getAttribute('catalog_product','brand')->getSource()->getAllOptions();
        foreach ($brandCollection as $_brand) {
            // print_r(Mage::getModel('manufacturer/brand')->load($_brand['value'],'brand_id')->getData());die;
            if(empty(Mage::getModel('manufacturer/brand')->load($_brand['value'],'brand_id')->getData())) {
                $brands[] = array(
                    'value' => $_brand['value'], // Assuming id as value
                    'label' => $_brand['label'] // Assuming name as label
                );
            }
            $mfrBrandCollection = $this->getManufacturerBrandCollection();
            foreach($mfrBrandCollection as $_mfrbrand)
            {
                if($_brand['value'] == $_mfrbrand['brand_id'])
                {
                    $brands[] = array(
                        'value' => $_brand['value'], // Assuming id as value
                        'label' => $_brand['label'] // Assuming name as label
                    );
                }
            }
                         
        }        
        return $brands;
    }
    protected function getManufacturerBrandCollection()
    {
        $model = Mage::registry('ccc_manufacturer');
        return Mage::getModel('manufacturer/brand')->getCollection()->addFieldToFilter('mfr_id',$model->getId());
    }

}