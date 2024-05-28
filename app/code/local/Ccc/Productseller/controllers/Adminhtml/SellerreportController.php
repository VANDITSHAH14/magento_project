<?php
class Ccc_Productseller_Adminhtml_SellerreportController extends Mage_Adminhtml_Controller_Action
{
    
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('customers/sellerreport')
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

    protected function _isAllowed()
    {
        $action = strtolower($this->getRequest()->getActionName());
        switch ($action) {
            // $aclResource=null;
            case 'index':
                $aclResource = 'customers/sellerreoprt/actions/index';
                break;
            default:
                $aclResource = 'customers/sellerreoprt';
                break;
            }
            
        return Mage::getSingleton('admin/session')->isAllowed($aclResource);
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
        $this->_redirect('*/*/');

    }
    public function massAssignAction()
    {
        $productIds  = json_decode($this->getRequest()->getParam('product_ids'));
        $sellerId = $this->getRequest()->getParam('seller_id');

        try {
            foreach ($productIds as $productId) {
                $product = Mage::getModel('catalog/product')->load($productId);
                $product->setData('seller_id',$sellerId);
                $product->save();
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