<?php
class Ccc_Outlook_Adminhtml_ConfigurationController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('outlook')
            ->_addBreadcrumb(Mage::helper('outlook')->__('Configuration'), Mage::helper('outlook')->__('Configuration'))
            ->_addBreadcrumb(Mage::helper('outlook')->__('Manage Configuration'), Mage::helper('outlook')->__('Manage Configuration'))
        ;
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_title($this->__('Configuration'))
            ->_title($this->__('Configuration'))
            ->_title($this->__('Manage Configuration'));

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
        $this->_title($this->__('Configuration'))
            ->_title($this->__('Configuration'))
            ->_title($this->__('Manage Configuration'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('config_id');
        $model = Mage::getModel('outlook/configuration');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getConfigId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('outlook')->__('This config no longer exists.')
                );
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getConfigId() ? $model->getConfigId() : $this->__('New config'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('ccc_outlook', $model);

        $eventModel = Mage::getModel('outlook/events');
        $collection = $eventModel->getCollection()
            ->addFieldToFilter('config_id', $model->getId())
            ->setOrder('group_id', 'Asc')->getData();


        if (!empty($collection)) {
            $eventModel->setData($collection);
        }
        Mage::register('events_data', $eventModel);

        // 5. Build edit form
        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('outlook')->__('Edit config')
                : Mage::helper('outlook')->__('New config'),
                $id ? Mage::helper('outlook')->__('Edit config')
                : Mage::helper('outlook')->__('New config')
            );

        $this->renderLayout();
    }
    public function saveAction()
    {

        // check if data sent
        if ($data = $this->getRequest()->getPost()) {

            $id = $this->getRequest()->getParam('config_id');
            $model = Mage::getModel('outlook/configuration')->load($id);
            if (!$model->getConfigId() && $id) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('outlook')->__('This config no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }

            // init model and set data

            $model->setData($data['config']);

            // try to save it
            try {
                // save the data
                $model->save();

                if (!empty($data['events'])){
                    Mage::getModel('outlook/events')->saveEvents($data['events'], $model);
                }
                
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('outlook')->__('The config has been saved.'));
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
                Mage::getSingleton('adminhtml/session')->setFormData($data['config']);
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
            try {
                // init model and delete
                $model = Mage::getModel('outlook/configuration');
                $model->load($id);
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('outlook')->__('The config has been deleted.'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('outlook')->__('Unable to find a outlook to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }

    public function removeForEventsAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $group =Mage::helper('core')->jsonDecode($this->getRequest()->getPost('group'));
            $event =Mage::helper('core')->jsonDecode($this->getRequest()->getPost('event'));

            $eventModel = Mage::getModel('outlook/events');
            if (!empty($group)){
                $collection = $eventModel->getCollection()->addFieldToFilter('group_id', $group);
                foreach ($collection as $_event) {
                    $eventId = $_event->getEventId();
                    $eventModel->load($eventId);
                    $eventModel->delete();
                }
            }
            if (!empty($event)) {
                print_r($event);
                $eventModel->load($event);
                $eventModel->delete();
            }
            $response = array(
                'success' => true,
                'message' => 'Data Deleted successfully'
            );
            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody(json_encode($response));
        }
    }

}