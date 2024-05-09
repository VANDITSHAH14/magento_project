<?php
class Ccc_Manufacturer_Adminhtml_OrderstockController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('manufacturer')
            ->_addBreadcrumb(Mage::helper('manufacturer')->__('Order Stock'), Mage::helper('manufacturer')->__('Order Stock'))
            ->_addBreadcrumb(Mage::helper('manufacturer')->__('Manage Order Stock'), Mage::helper('manufacturer')->__('Manage Order Stock'))
        ;
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->_title($this->__('Manufacturer'))
             ->_title($this->__('Order Stock'))
             ->_title($this->__('Manage Order Stock'));

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
        $this->_title($this->__('Manufacturer'))
             ->_title($this->__('Order Stock'))
             ->_title($this->__('Manage Order Stock'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('entity_id');
        $model = Mage::getModel('manufacturer/manufacturer');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('manufacturer')->__('This Order Stock no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Order Stock'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (! empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('ccc_manufacturer', $model);

        // 5. Build edit form
        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('manufacturer')->__('Edit Order Stock')
                    : Mage::helper('manufacturer')->__('New Order Stock'),
                $id ? Mage::helper('manufacturer')->__('Edit Order Stock')
                    : Mage::helper('manufacturer')->__('New Order Stock'));

        $this->renderLayout();
    }
    public function saveAction()
    {
            
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {
                        
            $id = $this->getRequest()->getParam('entity_id');
            $model = Mage::getModel('manufacturer/manufacturer')->load($id);
            $brandModel = Mage::getModel('manufacturer/brand');
            $brandCollection = $brandModel->getCollection();
            if (!$model->getId() && $id) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('manufacturer')->__('This manufacturer no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
            $brandArr = [];
            if ($id) {
                $model->load($id);
                $brandCollection->addFieldToFilter('mfr_id', $model->getId());
                foreach ($brandCollection->getData() as $_brand) {
                    array_push($brandArr, $_brand['brand_id']);
                }
            }
            // init model and set data
            
            $model->setData($data);
            $model->save();

            if ($id) {
                foreach (array_diff($brandArr, $data['brand']) as $_deletedBrand) {
                    $brandModel->load($_deletedBrand, 'brand_id');
                    $brandModel->delete();
                }
                foreach (array_diff($data['brand'], $brandArr) as $_saveBrand) {
                    $brandModel->setData([
                        'mfr_id' => $model->getId(),
                        'brand_id' => $_saveBrand,
                    ]);
                    $brandModel->save();
                }
            } else {
                foreach ($data['brand'] as $value) {
                    $brandModel->setData([
                        'mfr_id' => $model->getId(),
                        'brand_id' => $value,
                    ]);
                    $brandModel->save();
                }
            }
            // try to save it
            try {
                // save the data
                 
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('manufacturer')->__('The manufacturer has been saved.'));
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
                $model = Mage::getModel('manufacturer/manufacturer');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('manufacturer')->__('The Order Stock has been deleted.'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('manufacturer')->__('Unable to find a Order Stock to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }

    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    public function updateAction(){
        // echo '<pre>';
        $data=$this->getRequest()->getPost();
        $itemsToUpdate = json_decode($data['value'], true);
        // print_r($itemsToUpdate);die;
        foreach ($itemsToUpdate as $item) {
            $itemValue = $item['id'];
            $selectedValue = $item['stock'];
            $model=Mage::getModel('manufacturer/additional');
            $data=$model->load($itemValue,'item_id');   
            if($selectedValue==1){
                $data['is_discontinued']=$selectedValue; 
            }
            else{
                $data['is_discontinued']=0; 
                $data['stock_date']=$selectedValue;
            }
            $model->setData($data->getData())->save();
        }
    }

    public function sendemailAction()
    {
        // echo 123;
        $data = $this->getRequest()->getParam('data');
        $itemsToUpdate = json_decode($data, true);
        foreach ($itemsToUpdate as $_itemid) {
            //item data
            $data = Mage::getModel('sales/order_item')->load($_itemid);

            //brand data
            $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'brand');
            if ($attribute->usesSource()) {
                $brandOptionText = $attribute->getSource()->getOptionText($data->getBrand());
            }
            
            //mfr brand data
            $brandData = Mage::getModel('manufacturer/brand')->load($data->getBrand(), 'brand_id');

            //mfr data
            $mfrData = Mage::getModel('manufacturer/manufacturer')->load($brandData->getMfrId());

            $senderName = Mage::getStoreConfig('trans_email/ident_general/name');
            $senderEmail = Mage::getStoreConfig('trans_email/ident_general/email');

            // Set recipient information
            $recipientEmail = $mfrData->getEmail();
            $recipientName = $mfrData->getManufacturerName();
            // Set email template variables
            $emailTemplateVariables = array(
                'product_name' => $data->getName(),
                'sku' => $data->getSku(),
                'qty' => $data->getQtyOrdered(),
                'brand' => $brandOptionText,
            );
            // Load and send the email
            $emailTemplate = Mage::getModel('core/email_template')->load('mfr_email','template_code');
            $emailTemplate->setSenderName($senderName);
            $emailTemplate->setSenderEmail($senderEmail);
            $emailTemplate->send($recipientEmail, $recipientName, $emailTemplateVariables);
        }
    }

}