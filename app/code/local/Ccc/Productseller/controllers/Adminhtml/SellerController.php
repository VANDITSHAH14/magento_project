<?php
class Ccc_Productseller_Adminhtml_SellerController extends Mage_Adminhtml_Controller_Action
{

    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('customers/seller')
            ->_addBreadcrumb(Mage::helper('seller')->__('Seller'), Mage::helper('seller')->__('Seller'))
            ->_addBreadcrumb(Mage::helper('seller')->__('Manage Seller'), Mage::helper('seller')->__('Manage Seller'))
        ;
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_title($this->__('Seller'))
            ->_title($this->__('Seller'))
            ->_title($this->__('Manage Seller'));

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
        $this->_title($this->__('Seller'))
            ->_title($this->__('Seller'))
            ->_title($this->__('Manage Seller'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('seller/seller');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('seller')->__('This Seller no longer exists.')
                );
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getSellerName() : $this->__('New Seller'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('ccc_productseller', $model);

        // 5. Build edit form
        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('seller')->__('Edit seller')
                : Mage::helper('seller')->__('New seller'),
                $id ? Mage::helper('seller')->__('Edit seller')
                : Mage::helper('seller')->__('New seller')
            );

        $this->renderLayout();
    }
    public function saveAction()
    {

        // check if data sent
        if ($data = $this->getRequest()->getPost()) {

            $id = $this->getRequest()->getParam('id');
            $model = Mage::getModel('seller/seller')->load($id);
            if (!$model->getId() && $id) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('seller')->__('This seller no longer exists.'));
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
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('seller')->__('The seller has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
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
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
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
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                // init model and delete
                $model = Mage::getModel('seller/seller');
                $model->load($id);
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('seller')->__('The seller has been deleted.'));
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('seller')->__('Unable to find a seller to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }

    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        // $aclResource=null;
        $action = strtolower($this->getRequest()->getActionName());
        switch ($action) {
            case 'index':
                $aclResource = 'customers/seller/actions/index';
                break;
            default:
                $aclResource = 'customers/seller';
                break;
        }

        return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    }

    public function massUpdateIsActiveAction()
    {
        $sellerIds = (array) $this->getRequest()->getParam('seller_ids');
        $IsActive = (int) $this->getRequest()->getParam('is_active');

        try {
            foreach ($sellerIds as $sellerId) {
                $sellerId = Mage::getModel('seller/seller')->load($sellerId);
                $sellerId->setIsActive($IsActive);
                $sellerId->save();
            }
        } catch (Mage_Core_Model_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            $this->_getSession()
                ->addException($e, $this->__('An error occurred while updating the product(s) status.'));
        }

        // $this->_redirect('*/*/', array('store'=> $storeId));
        $this->_redirect('*/*/');
    }
}