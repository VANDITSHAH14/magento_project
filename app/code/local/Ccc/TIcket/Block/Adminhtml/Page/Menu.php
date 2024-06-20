<?php
class Ccc_Ticket_Block_Adminhtml_Page_Menu extends Mage_Adminhtml_Block_Page_Menu
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('ccc/ticketsystem/menu.phtml');
    }

    public function getAllUser(){
        $allUser  = Mage::getModel('admin/user')->getCollection();
        return $allUser;
    }
    public function getStatus()
    {
        return Mage::getModel('ticket/status')->getCollection();
    }
    public function getPriority()
    {
        $priority = [1=>"Low",2=>"medium",3=>"High"];
        return $priority;
    }
}