<?php
class Ccc_Catalog_Adminhtml_Sales_OrderController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout();
        $this->_setActiveMenu('sales/order');
        return $this;
    }
    public function indexAction()
    {
        $this->_initAction();

        $this->renderLayout();
    }
    public function updatedAction(){

        $id = $this->getRequest()->getParam('order_id');
        $order = Mage::getModel('sales/order')->load($id);
        $delivery_note=$this->getRequest()->getParam('newValue');
        $order->setData('delivery_note',$delivery_note)->save();
        $this->_redirect('*/*/index');
    }
    public function editAction()
    {

        $id = $this->getRequest()->getParam('entity_id');
        $model = Mage::getModel('sales/order');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('sales')->__('This block no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }



        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('sales_order', $model);

        // 5. Build edit form
        $this->_initAction()
            ->renderLayout();
    }
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            // echo "123";
            $id = $this->getRequest()->getParam('entity_id');
            $model = Mage::getModel('sales/order')->load($id);
            if (!$model->getId() && $id) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('sales')->__('This block no longer exists.'));
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
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('sales')->__('The block has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/sales_order/edit', array('entity_id' => $model->getId()));
                    return;
                }
                // go to grid
                $this->_redirect('*/sales_order/');
                return;

            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // save data in session
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                // redirect to edit form
                $this->_redirect('*/sales_order/edit', array('entity_id' => $this->getRequest()->getParam('entity_id')));
                return;
            }
        }
        $this->_redirect('*/sales_order/');
    }
    public function massSendEmailAction()
    {
        $orderIds = $this->getRequest()->getPost('order_ids', array());
        foreach ($orderIds as $orderId) {
            $order = Mage::getModel('sales/order')->load($orderId);
            $customerId = $order->getCustomerId();
            $data = Mage::getModel('sales/order')->load($customerId, 'customer_id');
            $customerData = Mage::getModel('customer/customer')->load($customerId);

            $senderName = Mage::getStoreConfig('trans_email/ident_general/name');
            $senderEmail = Mage::getStoreConfig('trans_email/ident_general/email');

            $recipientEmail = $customerData->getEmail();
            $recipientName = $customerData->getName();
            $emailTemplateVariables = array(
                'order_number' => $data->getIncrementId(),
                'customer_name' => $customerData->getName()
            );

            $emailTemplate = Mage::getModel('core/email_template')->load('address_varification_mail', 'template_code');
            $emailTemplate->setSenderName($senderName);
            $emailTemplate->setSenderEmail($senderEmail);
            $emailTemplate->send($recipientEmail, $recipientName, $emailTemplateVariables);

        }
        $this->_redirect('*/*/');
    }
    protected function _isAllowed()
    {
        $aclResource=null;
        $action = strtolower($this->getRequest()->getActionName());
        switch ($action) {
            case 'delivery_note':
                $aclResource = 'sales/order/actions/delivery_note';
                break;
            case 'send_email':
                $aclResource = 'sales/order/actions/sendemail';
                break;
            default:
                $aclResource = 'sales/order';
                break;
            }
            
        return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    }
    public function validateAddressAction()
    {
        $id = $this->getRequest()->getParam('order_id');
        $data = Mage::getModel('sales/order')->load($id);
        $data['address_validation_required'] = '2';
        $data->setData($data->getData())->save();
        $this->_redirect('*/*/index');
    }
}