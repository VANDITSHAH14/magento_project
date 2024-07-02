<?php
class Ccc_SimilarItems_Adminhtml_ItemreportController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
        
    }

    // public function productAction()
    // {
    //     $block = $this->getLayout()->createBlock('items/adminhtml_itemreport');
    //     $this->getResponse()->setBody($block->toHtml());
    // }
}