<?php
class Ccc_Orderaddress_Model_Observer
{
    public function addressVarification(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        // Mage::log('hi',null,'abc.log',true);
        if (
            $order->getBillingAddress()->getStreet() !== $order->getShippingAddress()->getStreet()
            || $order->getBillingAddress()->getCity() !== $order->getShippingAddress()->getCity()
            || $order->getBillingAddress()->getRegion() !== $order->getShippingAddress()->getRegion()
            || $order->getBillingAddress()->getPostcode() !== $order->getShippingAddress()->getPostcode()
            || $order->getBillingAddress()->getCountryId() !== $order->getShippingAddress()->getCountryId()
        ) {
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

            $order->setAddressValidationRequired(1);
            $order->setValidationEmailSentCount(1);
            // Mage::log($order->getCustomerId(),null,'xyz.log',true);
        }

    }
    public function cancelOrder(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $items = $order->getAllItems();
        $item = [];
        foreach ($items as $_item) {
            $item[] = 'name:' . $_item->getName() . '<br>Qty : ' . $_item->getQtyOrdered();

        }
        $item = implode('<br>', $item);
        $customerId = $order->getCustomerId();
        $customerData = Mage::getModel('customer/customer')->load($customerId);


        $senderName = Mage::getStoreConfig('trans_email/ident_general/name');
        $senderEmail = Mage::getStoreConfig('trans_email/ident_general/email');

        $recipientEmail = $customerData->getEmail();
        $recipientName = $customerData->getName();

        $emailTemplateVariables = array(
            'order_number' => $order->getIncrementId(),
            'customer_name' => $customerData->getName(),
            'payment' => $order->getGrandTotal(),
            'items' => $item
        );

        $emailTemplate = Mage::getModel('core/email_template')->load('order_cancel', 'template_code');
        $emailTemplate->setSenderName($senderName);
        $emailTemplate->setSenderEmail($senderEmail);
        $emailTemplate->send($recipientEmail, $recipientName, $emailTemplateVariables);
    }

    public function sendValidationEmail()
    {
        $order = Mage::getModel('sales/order')->getCollection()
                ->addFieldToFilter('status', ['neq' => 'canceled'])
                ->addFieldToFilter('status', ['neq' => 'complete'])
                ->addFieldToFilter('address_validation_required', 1);
        foreach ($order as $_order) {
            $count = $_order->getValidationEmailSentCount();
            if ($count < 3) {
                $customerId = $_order->getCustomerId();
                // $data = Mage::getModel('sales/order')->load($customerId, 'customer_id');
                $customerData = Mage::getModel('customer/customer')->load($customerId);

                $senderName = Mage::getStoreConfig('trans_email/ident_general/name');
                $senderEmail = Mage::getStoreConfig('trans_email/ident_general/email');

                $recipientEmail = $customerData->getEmail();
                $recipientName = $customerData->getName();
                $emailTemplateVariables = array(
                    'order_number' => $_order->getIncrementId(),
                    'customer_name' => $customerData->getName()
                );

                $emailTemplate = Mage::getModel('core/email_template')->load('address_varification_mail', 'template_code');
                $emailTemplate->setSenderName($senderName);
                $emailTemplate->setSenderEmail($senderEmail);
                $emailTemplate->send($recipientEmail, $recipientName, $emailTemplateVariables);

                $count++;

                // Mage::log($count, null, 'dd.log', true);
                $_order->setValidationEmailSentCount($count)->save();
            } else {
                // $this->cancelOrder();
                $_order->setData('status','canceled')->save();
            }
        }
    }
}