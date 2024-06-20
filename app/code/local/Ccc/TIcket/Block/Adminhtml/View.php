<?php
class Ccc_Ticket_Block_Adminhtml_View extends Mage_Adminhtml_Block_Widget_Container
{
    public function __construct()
    {
        $this->_blockGroup='ticket';
        $this->_controller = 'adminhtml_ticket';
        $this->_headerText ='Ticket';
        parent::__construct();
        $this->setTemplate('ccc/ticketsystem/view.phtml');
    }
    public function getTickets($id)
    {
       return Mage::getModel('ticket/ticket')->load($id);
    }
    public function getPriority()
    {
        $priority = [1=>"Low",2=>"medium",3=>"High"];
        return $priority;
    }

    public function getAllUser(){
        $allUser  = Mage::getModel('admin/user')->getCollection();
        return $allUser;
    }
    public function getStatus()
    {
        return Mage::getModel('ticket/status')->getCollection();
    }

    public function getComment($id)
    {
        return Mage::getModel('ticket/comment')->getCollection()->addFieldToFilter('ticket_id',$id);
    }
    public function getUser($id){
        return Mage::getModel('admin/user')->load($id);
    }

}
