<?php
class Ccc_Ticket_Block_Adminhtml_Ticket extends Mage_Adminhtml_Block_Widget_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'ticket';
        $this->_controller = 'adminhtml_ticket';
        parent::__construct();
        $this->setTemplate('ccc/ticketsystem/grid.phtml');
    }
    public function getTickets()
    {
        $ticketCollection = Mage::getModel('ticket/ticket')->getCollection();
        $page = $this->getRequest()->getParam('page', 1);
        $pageSize = 2; // Number of items per page
        $ticketCollection->setCurPage($page);
        $ticketCollection->setPageSize($pageSize);
        $filterId = $this->getRequest()->getParam('filter_id');
        if ($filterId) {
            $filterModel = Mage::getModel('ticket/filter')->load($filterId);
            $status = explode(',', $filterModel->getStatus());
            $asignTo = explode(',', $filterModel->getAsignTo());
            $currentDate = new DateTime();
            $pastDate = $currentDate->modify('-' . $filterModel->getCreatedAt() . 'days')->format('Y-m-d H:i:s');
            $ticketCollection->addFieldToFilter('status', $status);
            $ticketCollection->addFieldToFilter('asign_to', $asignTo);
            $ticketCollection->addFieldToFilter('created_at', array('gteq' => $pastDate));
            $lastComment = $filterModel->getLastComment();
            $filterLastComment = $this->getLastComment($lastComment, $ticketCollection);
            if ($lastComment) {
                $ticketCollection->addFieldToFilter('ticket_id', ["in" => $filterLastComment]);
                // echo $ticketCollection->getSelect()->__toString();
            }
        }
        return $ticketCollection;
    }

    public function getLastComment($userId, $collection)
    {
        $tickets = [];
        $ticketIds = $collection->getAllIds();
        $commentCollection = Mage::getModel('ticket/comment')->getCollection();
        $subSelect = $commentCollection->getConnection()
            ->select()
            ->from(
                array('ctc' => $commentCollection->getTable('ticket/comment')),
                array('ticket_id', 'max_created_at' => new Zend_Db_Expr('MAX(created_at)'))
            )
            ->where('ctc.ticket_id IN (?)', $ticketIds)
            ->group('ctc.ticket_id');


        $commentCollection->getSelect()
            ->joinInner(
                array('max_comments' => $subSelect),
                'main_table.ticket_id = max_comments.ticket_id AND main_table.created_at = max_comments.max_created_at',
                array()
            );
        $commentCollection->addFieldToFilter('user_id', $userId);
        foreach ($commentCollection as $comment) {
            $tickets[] = $comment->getTicketId();
        }
        return $tickets;
    }

    public function getTotalPages()
    {
        $ticketCollection = $this->getTickets();
        $pages = ceil($ticketCollection->getSize() / $ticketCollection->getPageSize());
        return $pages;
    }

    public function getPriority()
    {
        $priority = [1 => "Low", 2 => "medium", 3 => "High"];
        return $priority;
    }

    public function getAllUser($id)
    {
        return Mage::getModel('admin/user')->load($id);
    }
    public function getStatus($id)
    {
        return Mage::getModel('ticket/status')->load($id);
    }

    public function getStatuses()
    {
        return Mage::getModel('ticket/status')->getCollection();
    }

    public function getAllUsers()
    {
        $allUser = Mage::getModel('admin/user')->getCollection();
        return $allUser;
    }

    public function getFilters()
    {
        return Mage::getModel('ticket/filter')->getCollection();
    }


}
