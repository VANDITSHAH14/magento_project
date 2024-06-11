<?php
class Ccc_Outlook_Block_Adminhtml_Configuration_Edit_Tab_Event extends Mage_Adminhtml_Block_Widget implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('event_form');
        $this->setTemplate('outlook/event.phtml');
    }

    public function getRegisterData()
    {
        return json_encode(Mage::registry('events_data')->getData());
    }

    public function getEventRemoveUrl()
    {
        return $this->getUrl('*/*/removeForEvents');
    }

    public function getTabLabel()
    {
        return Mage::helper('order')->__('Event Information');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('order')->__('Event Information');
    }

    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
    }

}