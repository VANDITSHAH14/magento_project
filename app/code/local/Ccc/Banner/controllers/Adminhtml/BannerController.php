<?php
class Ccc_Banner_Adminhtml_BannerController extends Mage_Adminhtml_Controller_Action
{
    
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('banner/banner')
            ->_addBreadcrumb(Mage::helper('banner')->__('Banner'), Mage::helper('banner')->__('Banner'))
            ->_addBreadcrumb(Mage::helper('banner')->__('Manage Banner'), Mage::helper('banner')->__('Manage Banner'))
        ;
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_title($this->__('Banner'))
             ->_title($this->__('Banner'))
             ->_title($this->__('Manage Banner'));

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
        $this->_title($this->__('Banner'))
             ->_title($this->__('Banner'))
             ->_title($this->__('Manage Banner'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('banner_id');
        $model = Mage::getModel('banner/banner');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('banner')->__('This page no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Page'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (! empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('ccc_banner', $model);

        // 5. Build edit form
        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('banner')->__('Edit banner')
                    : Mage::helper('banner')->__('New banner'),
                $id ? Mage::helper('banner')->__('Edit banner')
                    : Mage::helper('banner')->__('New banner'));

        $this->renderLayout();
    }
    public function saveAction()
    {
            
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {
            $type = 'banner_image';

            if (isset($data[$type]['delete'])) {
                Mage::helper('banner')->deleteImageFile($data[$type]['value']);
            }
            $image = Mage::helper('banner')->uploadBannerImage($type);
            if ($image || (isset($data[$type]['delete']) && $data[$type]['delete'])) {
                $data[$type] = $image;
            } else {
                unset($data[$type]);
            }

            $id = $this->getRequest()->getParam('banner_id');
            $model = Mage::getModel('banner/banner')->load($id);
            if (!$model->getId() && $id) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('banner')->__('This banner no longer exists.'));
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
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('banner')->__('The banner has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('banner_id' => $model->getId()));
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
                $this->_redirect('*/*/edit', array('banner_id' => $this->getRequest()->getParam('banner_id')));
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
        if ($id = $this->getRequest()->getParam('banner_id')) {
            $title = "";
            try {
                // init model and delete
                $model = Mage::getModel('banner/banner');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('banner')->__('The banner has been deleted.'));
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('banner_id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('banner')->__('Unable to find a banner to delete.'));
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
                $aclResource = 'banner/banner/actions/index';
                break;
            case 'show_Button':
                $aclResource = 'banner/banner/actions/show_Button';
                break;
            case 'show_title':
                $aclResource = 'banner/banner/actions/show_title';
                break;
            case 'show_all':
                $aclResource = 'banner/banner/actions/show_all';
                break;
            case 'new':
                $aclResource = 'banner/banner/actions/new';
                break;
            case 'edit':
                $aclResource = 'banner/banner/actions/edit';
                break;
            case 'save':
                $aclResource = 'banner/banner/actions/save';
                break;
            default:
                $aclResource = 'banner/banner';
                break;
            }
            
        return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    }


}