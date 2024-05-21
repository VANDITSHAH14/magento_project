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
    public function newAction()
    {
        // the same form is used to create and edit
        $this->_forward('edit');
    }
    public function editAction()
    {
        $this->_title($this->__('Shipping Methods'))
             ->_title($this->__('Shipping Methods Summary'))
             ->_title($this->__('Manage Shipping Methods'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('entity_id');
        $model = Mage::getModel('order/order');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('order')->__('This page no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getStatus() : $this->__('New Status'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (! empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('ccc_order', $model);

        // 5. Build edit form
        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('order')->__('Edit order')
                    : Mage::helper('order')->__('New order'),
                $id ? Mage::helper('order')->__('Edit order')
                    : Mage::helper('order')->__('New order'));

        $this->renderLayout();
    }
    public function saveAction()
    {
            
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {

            $id = $this->getRequest()->getParam('entity_id');
            $model = Mage::getModel('order/order')->load($id);
            if (!$model->getId() && $id) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('order')->__('This order no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
            // init model and set data
            if (isset($data['option']) && !empty($data['option'])) {
                $result = [];

                // Iterate over the 'value' and 'order' arrays
                foreach ($data['option']['value'] as $key => $value) {
                    if ($data['option']['delete'][$key] != 1) {
                        // Check if the corresponding key exists in the 'order' array
                        if (isset($data['option']['order'][$key])) {
                            // Concatenate the value from 'value' and 'order' arrays with a hyphen
                            $result[] = $value . '-' . $data['option']['order'][$key];
                        }
                    }
                }

                // Join the concatenated values with commas to form the final string
                $output = implode(',', $result);
                $data['total_range'] = $output;

                unset($data['option']);
            }
            $model->setData($data);

            // try to save it
            try {
                // save the data
                $model->save();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('order')->__('The order has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('entity_id' => $model->getId()));
                    return;
                }
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // save data in session
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                // redirect to edit form
                $this->_redirect('*/*/edit', array('entity_id' => $this->getRequest()->getParam('entity_id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * Delete action
     */
    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('entity_id')) {
            $title = "";
            try {
                // init model and delete
                $model = Mage::getModel('order/order');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('order')->__('The order has been deleted.'));
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('entity_id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('order')->__('Unable to find a order to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }

}