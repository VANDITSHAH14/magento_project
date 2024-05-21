<?php
class Ccc_Shipping_Adminhtml_ShippingController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('system/custom_setting/shipping_method')
            ->_addBreadcrumb(Mage::helper('shipping')->__('Shipping Methods'), Mage::helper('shipping')->__('Shipping Methods'))
            ->_addBreadcrumb(Mage::helper('shipping')->__('Manage Shipping Methods'), Mage::helper('shipping')->__('Manage Shipping Methods'))
        ;
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_title($this->__('Shipping Methods'))
             ->_title($this->__('Shipping Methods Summary'))
             ->_title($this->__('Manage Shipping Methods'));

        $this->_initAction();
        $this->renderLayout();
    }
   
}