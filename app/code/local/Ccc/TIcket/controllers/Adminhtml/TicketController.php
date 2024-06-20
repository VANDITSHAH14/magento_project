<?php
class Ccc_Ticket_Adminhtml_TicketController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('ticket');
        return $this;
    }

    public function indexAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }

    public function saveAction()
    {
        $data = $this->getRequest()->getPost('ticket');
        $ticketModel = Mage::getModel('ticket/ticket');
        $ticketModel->setData($data)->save();
        $this->_redirect('*/*/index');
    }

    public function viewAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
    public function handleAction()
    {
        $data = $this->getRequest()->getParams();
        $ticketModel = Mage::getModel('ticket/ticket');
        $ticketModel->load($data['id']);
        $field = $data['field'];
        $value = $data['value'];
        $ticketModel->setData($field, $value)->save();

    }
    public function saveCommentAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $data['user_id'] = Mage::getSingleton('admin/session')->getUser()->getId();
            $model = Mage::getModel('ticket/comment');
            $model->setData($data)->save();
        }
        $this->_redirect('*/*/index');
    }
    public function saveFilterAction()
    {
        $data = $this->getRequest()->getParams();
        $data['status']  = implode(',',$data['status']);
        $data['asign_to']  = implode(',',$data['asign_to']);
        // print_r($data);
        $filterModel = Mage::getModel('ticket/filter');
        $filterModel->setData($data)->save();
    }
}