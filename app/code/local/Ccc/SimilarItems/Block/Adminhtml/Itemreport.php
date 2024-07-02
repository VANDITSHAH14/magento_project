<?php
class Ccc_SimilarItems_Block_Adminhtml_Itemreport extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup = 'items';
        $this->_controller = 'adminhtml_itemreport';
        parent::__construct();
        $this->setTemplate('ccc/catalog/itemreport.phtml');
    }

    public function getAllowAction()
    {
        return (int) Mage::getStoreConfig('similar/settings/allow_show_similar_items');
    }

    public function getProductSku()
    {
        return $this->getRequest()->getParam('query');
    }
}
