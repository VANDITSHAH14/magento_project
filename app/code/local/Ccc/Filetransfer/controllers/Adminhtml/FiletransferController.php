<?php
class Ccc_Filetransfer_Adminhtml_FiletransferController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('filetransfer')
            ->_addBreadcrumb(Mage::helper('filetransfer')->__('Config'), Mage::helper('filetransfer')->__('Config'))
            ->_addBreadcrumb(Mage::helper('filetransfer')->__('Manage Config'), Mage::helper('filetransfer')->__('Manage Config'))
        ;
        return $this;
    }

    public function indexAction()
    {
        $this->_title($this->__('Config'))
             ->_title($this->__('Config'))
             ->_title($this->__('Manage Config'));

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
        $this->_title($this->__('Config'))
             ->_title($this->__('Config'))
             ->_title($this->__('Manage Config'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('config_id');
        $model = Mage::getModel('filetransfer/configuration');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (! $model->getConfigId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('filetransfer')->__('This Config no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getConfigId() ? $model->getUserName() : $this->__('New Config'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (! empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('ccc_filetransfer', $model);

        // 5. Build edit form
        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('filetransfer')->__('Edit config')
                    : Mage::helper('filetransfer')->__('New config'),
                $id ? Mage::helper('filetransfer')->__('Edit config')
                    : Mage::helper('filetransfer')->__('New config'));

        $this->renderLayout();
    }
    public function saveAction()
    {
            
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {
            $id = $this->getRequest()->getParam('config_id');
            $model = Mage::getModel('filetransfer/configuration')->load($id);
            if (!$model->getConfigId() && $id) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('filetransfer')->__('This config no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }

            // init model and set data

            $model->setData($data);

            // try to save it
            try {
                // save the data
                $model->save();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('filetransfer')->__('The config has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('config_id' => $model->getConfigId()));
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
                $this->_redirect('*/*/edit', array('config_id' => $this->getRequest()->getParam('config_id')));
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
        if ($id = $this->getRequest()->getParam('config_id')) {
            $name='';
            try {
                // init model and delete
                $model = Mage::getModel('filetransfer/configuration');
                $model->load($id);
                $name = $model->getUserName();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('filetransfer')->__('The config has been deleted.'));
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('config_id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('filetransfer')->__('Unable to find a config to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }
}