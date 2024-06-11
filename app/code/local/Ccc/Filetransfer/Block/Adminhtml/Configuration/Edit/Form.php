<?php
class Ccc_Filetransfer_Block_Adminhtml_Configuration_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * Init form
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('edit_form');
        $this->setTitle(Mage::helper('filetransfer')->__('Configuration Information'));
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
        $model = Mage::registry('ccc_filetransfer');

        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post')
        );
        $form->setHtmlIdPrefix('filetransfer');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('filetransfer')->__('Configuration Information'), 'class' => 'fieldset-wide'));

        if ($model->getConfigId()) {
            $fieldset->addField('config_id', 'hidden', array(
                'name' => 'config_id',
            ));
        }

        $fieldset->addField('user_name', 'text', array(
            'name' => 'user_name',
            'label' => Mage::helper('filetransfer')->__('User Name'),
            'title' => Mage::helper('filetransfer')->__('User Name'),
            'required' => true,
        ));

        $fieldset->addField('password', 'text', array(
            'name' => 'password',
            'label' => Mage::helper('filetransfer')->__('Password'),
            'title' => Mage::helper('filetransfer')->__('Password'),
            'required' => true,
        ));
        
        $fieldset->addField('host', 'text', array(
            'name' => 'host',
            'label' => Mage::helper('filetransfer')->__('Host'),
            'title' => Mage::helper('filetransfer')->__('Host'),
        ));

        $fieldset->addField('port', 'text', array(
            'name' => 'port',
            'label' => Mage::helper('filetransfer')->__('Port'),
            'title' => Mage::helper('filetransfer')->__('Port'),
        ));


        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
