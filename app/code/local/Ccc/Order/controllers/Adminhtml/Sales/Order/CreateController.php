<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2018 Magento, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml sales orders creation process controller
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
// echo Mage::getModuleDir('controllers', 'Mage_Adminhtml') . '/Sales/Order/CreateController.php';
require_once Mage::getModuleDir('controllers', 'Mage_Adminhtml') . '\Sales\Order\CreateController.php';

class Ccc_Order_Adminhtml_Sales_Order_CreateController extends Mage_Adminhtml_Sales_Order_CreateController
{
    public function uploadFileAction()
    {
        $response = array();

        if (isset($_FILES["address_proof"]['name']) && $_FILES["address_proof"]['name'] != '') {

            try {
                $uploader = new Varien_File_Uploader("address_proof");
                $uploader->setAllowedExtensions(array('jpg', 'png'));
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(false);
                $uploader->save(Mage::getBaseDir('media') . DS . 'address_proof', $uploader->getCorrectFileName($_FILES["address_proof"]['name']));

                $image = $uploader->getUploadedFileName();

                // Success response
                $response['success'] = true;
                $response['path'] = $image;
            } catch (Exception $e) {
                $response['success'] = false;
                $response['error'] = "Please upload only jpeg and png file";
            }
        } else {
            $response['success'] = false;
            $response['error'] = "No file uploaded";
        }

        // Send the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function saveAction()
    {
        try {
            $this->_processActionData('save');
            $paymentData = $this->getRequest()->getPost('payment');
            if ($paymentData) {
                $paymentData['checks'] = Mage_Payment_Model_Method_Abstract::CHECK_USE_INTERNAL
                    | Mage_Payment_Model_Method_Abstract::CHECK_USE_FOR_COUNTRY
                    | Mage_Payment_Model_Method_Abstract::CHECK_USE_FOR_CURRENCY
                    | Mage_Payment_Model_Method_Abstract::CHECK_ORDER_TOTAL_MIN_MAX
                    | Mage_Payment_Model_Method_Abstract::CHECK_ZERO_TOTAL;
                $this->_getOrderCreateModel()->setPaymentData($paymentData);
                $this->_getOrderCreateModel()->getQuote()->getPayment()->addData($paymentData);
            }
            $delivery_note =$this->getRequest()->getPost('delivery_note');
            $delivery_note = $this->_getOrderCreateModel()->getQuote()->setData('delivery_note', $delivery_note);
            $delivery_note->save();
            $address_proof = $this->getRequest()->getPost('address_proof');
            $address_proof = $this->_getOrderCreateModel()->getQuote()->getBillingAddress()->setData('address_proof',$address_proof);
            $address_proof->save();

            $order = $this->_getOrderCreateModel()
                ->setIsValidate(true)
                ->importPostData($this->getRequest()->getPost('order'))
                ->createOrder();
            $this->_getSession()->clear();
            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The order has been created.'));
            if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
                $this->_redirect('*/sales_order/view', array('order_id' => $order->getId()));
            } else {
                $this->_redirect('*/sales_order/index');
            }
        } catch (Mage_Payment_Model_Info_Exception $e) {
            $this->_getOrderCreateModel()->saveQuote();
            $message = $e->getMessage();
            if( !empty($message) ) {
                $this->_getSession()->addError($message);
            }
            $this->_redirect('*/*/');
        } catch (Mage_Core_Exception $e){
            $message = $e->getMessage();
            if( !empty($message) ) {
                $this->_getSession()->addError($message);
            }
            $this->_redirect('*/*/');
        }
        catch (Exception $e){
            $this->_getSession()->addException($e, $this->__('Order saving error: %s', $e->getMessage()));
            $this->_redirect('*/*/');
        }
    }

}
