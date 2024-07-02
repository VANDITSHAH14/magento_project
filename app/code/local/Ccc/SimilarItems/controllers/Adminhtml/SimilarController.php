<?php
class Ccc_SimilarItems_Adminhtml_SimilarController extends Mage_Adminhtml_Controller_Action
{

    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('catalog/items')
            ->_addBreadcrumb(Mage::helper('items')->__('Simillar Items'), Mage::helper('items')->__('Simillar Items'))
            ->_addBreadcrumb(Mage::helper('items')->__('Manage Simillar Items'), Mage::helper('items')->__('Manage Simillar Items'))
        ;
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_title($this->__('Simillar Items'))
            ->_title($this->__('Simillar Items'))
            ->_title($this->__('Manage Simillar Items'));

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
        $this->_title($this->__('Simillar Items'))
            ->_title($this->__('Simillar Items'))
            ->_title($this->__('Manage Simillar Items'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('items/items');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('items')->__('This Simillar Items no longer exists.')
                );
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getId() : $this->__('New Simillar Items'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('ccc_similar_items', $model);

        // 5. Build edit form
        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('items')->__('Edit Simillar Items')
                : Mage::helper('items')->__('New Simillar Items'),
                $id ? Mage::helper('items')->__('Edit Simillar Items')
                : Mage::helper('items')->__('New Simillar Items')
            );

        $this->renderLayout();
    }
    public function saveAction()
    {

        // check if data sent
        if ($data = $this->getRequest()->getPost()) {

            $id = $this->getRequest()->getParam('id');
            $model = Mage::getModel('items/items')->load($id);
            if (!$model->getId() && $id) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('items')->__('This items no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
            // init model and set data
            $model->setData($data);

            if ($data['similar_product_id']) {
                $productId = $data['main_product_id'];
                $catalog = Mage::getModel('catalog/product')->load($productId);
                $catalog->setHasSimilarItems(255);
                $catalog->save(); 
            }

            // try to save it
            try {
                // save the data
                $model->save();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('items')->__('The items has been saved.'));
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
                $model = Mage::getModel('items/items');
                $model->load($id);
                $model->setIsDeleted(0);
                $model->setDeletedAt(date('Y-m-d')); 
                $model->save();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('items')->__('The items flag has been changed to yes.'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('items')->__('Unable to find a items to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }

    public function massUpdateDeletedAction()
    {
        $itemIds = (array) $this->getRequest()->getParam('item_ids');
        $IsDelete = (int) $this->getRequest()->getParam('is_deleted');

        try {
            foreach ($itemIds as $itemId) {
                $item = Mage::getModel('items/items')->load($itemId);
                $item->setIsDeleted($IsDelete);
                if($item->getIsDeleted() == 0)
                {
                    $item->setDeletedAt(date('Y-m-d')); 
                }
                else
                {
                    $item->setDeletedAt(NULL);
                }
                $item->save();
            }
        } catch (Mage_Core_Model_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            $this->_getSession()
                ->addException($e, $this->__('An error occurred while updating the product(s) status.'));
        }

        $this->_redirect('*/*/');
    }

}