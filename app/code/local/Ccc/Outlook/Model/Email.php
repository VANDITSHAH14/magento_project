<?php

class Ccc_Outlook_Model_Email extends Mage_Core_Model_Abstract
{
    private $_configObject = null;
    protected function _construct()
    {
        $this->_init('outlook/email');
    }

    public function setConfigObject($configObj)
    {
        $this->_configObject = $configObj;
        return $this;
    }

    public function dispatchEvents(){

        $configId = $this->_configObject->getConfigId();
        $eventModel = Mage::getModel('outlook/events');
        $eventCollection = $eventModel->getCollection()
            ->addFieldToFilter('config_id', $configId);
        
        $groupCollection = [];
        foreach ($eventCollection as $_event){
            $groupCollection[$_event->getGroupId()][] = $_event;
        }

        foreach ($groupCollection as $_group) {
            $dispatchFlag = true;
            foreach ($_group as $_rule) {
                $condition = $_rule->getConditionOn();
                $operator = $_rule->getOperator();
                $value = $_rule->getValue();

                if($condition == 'from'){
                    $checkValue = $this->getFrom();
                } elseif ($condition == 'subject'){
                    $checkValue = $this->getSubject();
                }

                if ($operator == '%like%') {
                    if (strpos($checkValue, $value) === false) {
                        $dispatchFlag = false;
                        break;
                    }
                } elseif ($operator == '=') {
                    if (strcmp($checkValue, $value) !== 0) {
                        $dispatchFlag = false;
                        break;
                    }
                }
            }
            if ($dispatchFlag) {
                Mage::dispatchEvent($_group[0]->getEvent(), ['model' => $this]);
            }
        }
    }

    public function saveAttachments($allAttachment)
    {
        $attachmentModel = Mage::getModel('outlook/attachment');
        foreach ($allAttachment  as $_attachment) {
            $fileName = $_attachment['name'];
            $fileData = base64_decode($_attachment['contentBytes']);
            $path = Mage::helper('outlook')->getBasePath();
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $uniqueFilename = $attachmentModel->getUniqueName($path,$fileName);
            $filePath = $path . DS . $uniqueFilename;
            file_put_contents($filePath, $fileData);

            $data = [
                'name' => $uniqueFilename,
                'email_id' => $this->getId(),
            ];
            $attachmentModel->setData($data)->save();
        }
    }
}