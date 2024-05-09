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

class Ccc_Order_Block_Adminhtml_Order_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Load Wysiwyg on demand and Prepare layout
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('ccc_order');

        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getUrl('*/*/save'), 'method' => 'post')
        );
        $form->setHtmlIdPrefix('order_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('order')->__('Status Information'), 'class' => 'fieldset-wide'));

        if ($model->getEntityId()) {
            $fieldset->addField(
                'entity_id',
                'hidden',
                array(
                    'name' => 'entity_id',
                )
            );
        }

        $fieldset->addField('status', 'select', array(
            'name' => 'status',
            'label' => Mage::helper('order')->__('Order status'),
            'title' => Mage::helper('order')->__('Order status'),
            'required' => true,
            'values' => $this->getStatusOptions(),
        )
        );


        $fieldset->addField(
            'short_order',
            'text',
            array(
                'name' => 'short_order',
                'label' => Mage::helper('order')->__('short order'),
                'title' => Mage::helper('order')->__('short order'),
                'required' => true,
            )
        );

        $fieldset->addField(
            'is_active',
            'select',
            array(
                'label' => Mage::helper('order')->__('Is Active'),
                'title' => Mage::helper('order')->__('Is Active'),
                'name' => 'is_active',
                'required' => true,
                'options' => array(
                    '1' => Mage::helper('order')->__('Enabled'),
                    '0' => Mage::helper('order')->__('Disabled'),
                ),
            )
        );
        if (!$model->getId()) {
            $model->setData('is_active', '1');
        }

        $fieldset->addField(
            'created_by',
            'text',
            array(
                'name' => 'created_by',
                'label' => Mage::helper('order')->__('Create By'),
                'title' => Mage::helper('order')->__('Create By'),
                'required' => true,
            )
        );

        $form->setValues($model->getData());
        // $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
    public function getStatusOptions()
    {
        $options = array();
        // Assuming your status values are stored in a table named 'status_table'
        $statusCollection = Mage::getModel('sales/order_status')->getCollection();
        foreach ($statusCollection as $status) {
            $options[] = array(
                'value' => $status->getStatus(), // Assuming id as value
                'label' => $status->getStatus() // Assuming name as label
            );
        }
        return $options;
    }
    public function getTabLabel()
    {
        return Mage::helper('order')->__('Status Information');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('order')->__('Status Information');
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
