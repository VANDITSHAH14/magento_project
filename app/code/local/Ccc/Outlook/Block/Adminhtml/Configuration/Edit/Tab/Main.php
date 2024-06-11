<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2018 Magento, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Cms page edit form main tab
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Ccc_Outlook_Block_Adminhtml_Configuration_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Load Wysiwyg on demand and Prepare layout
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('ccc_outlook');

        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post')
        );
        $form->setHtmlIdPrefix('outlook_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('outlook')->__('Configuration Information'), 'class' => 'fieldset-wide'));

        if ($model->getConfigId()) {
            $fieldset->addField('config_id', 'hidden', array(
                'name' => 'config[config_id]',
            ));
        }

        $fieldset->addField('client_id', 'text', array(
            'name' => 'config[client_id]',
            'label' => Mage::helper('outlook')->__('Client Id'),
            'title' => Mage::helper('outlook')->__('Client Id'),
            'required' => true,
        ));

        $fieldset->addField('secret_value', 'text', array(
            'name' => 'config[secret_value]',
            'label' => Mage::helper('outlook')->__('Client Secret Value'),
            'title' => Mage::helper('outlook')->__('Client Secret Value'),
            'required' => true,
        ));
        
        $fieldset->addField('access_token', 'text', array(
            'name' => 'config[access_token]',
            'label' => Mage::helper('outlook')->__('Access Token'),
            'title' => Mage::helper('outlook')->__('Access Token'),
        ));

        $fieldset->addField('is_active', 'select', array(
            'name' => 'config[is_active]',
            'label' => Mage::helper('outlook')->__('Is Active'),
            'title' => Mage::helper('outlook')->__('Is Active'),
            'options' => Mage::getModel('outlook/configuration')->getIsActiveArray(),
            'required' => true,
        ));

        if (!$model->getConfigId()) {
            $model->setData('is_active', '1');
        }


        $configId = null;
        $clientId = null;
        if(!empty($model->getClientId())){
            $configId = $model->getConfigId();
            $clientId = $model->getClientId();
        }
        
        $authorizationUrl = Mage::getModel('outlook/api')->getAuthorizationUrl($clientId, $configId);
        $fieldset->addField(
            'outlook_login',
            'note',
            array(
                'text' => $this->getButtonHtml(
                    Mage::helper('outlook')->__('Login'),
                    "window.location.href='{$authorizationUrl}'",
                    'ms-login-button',
                    'outlook_login'
                )
            )
        );

        $form->setValues($model->getData());
        // $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
   
    public function getButtonHtml($label, $onclick, $class = '', $id = '')
    {
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'label' => $label,
                'onclick' => $onclick,
                'class' => $class,
                'id' => $id
            ));
        return $button->toHtml();
    }
    public function getTabLabel()
    {
        return Mage::helper('outlook')->__('Configuration Information');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('outlook')->__('Configuration Information');
    }

    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
    }

}
