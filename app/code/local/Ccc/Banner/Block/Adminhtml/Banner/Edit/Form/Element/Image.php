<?php
class Ccc_Banner_Block_Adminhtml_Banner_Edit_Form_Element_Image extends Varien_Data_Form_Element_Image
{
    protected function _getUrl()
    {
        $url = false;
        if ($this->getValue()) {
            $url = Mage::getBaseUrl('media'). $this->getValue();
        }
        return $url;
    }
}