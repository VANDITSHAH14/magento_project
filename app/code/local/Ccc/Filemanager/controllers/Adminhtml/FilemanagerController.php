<?php
class Ccc_Filemanager_Adminhtml_FilemanagerController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('filemanager')
            ->_addBreadcrumb(Mage::helper('filemanager')->__('File'), Mage::helper('filemanager')->__('File'))
            ->_addBreadcrumb(Mage::helper('filemanager')->__('Manage File'), Mage::helper('filemanager')->__('Manage File'))
        ;
        return $this;
    }

    public function indexAction()
    {
        $this->_title($this->__('File'))
             ->_title($this->__('File'))
             ->_title($this->__('Manage File'));

        $this->_initAction();
        $this->renderLayout();
    }

    public function deleteAction() 
    {
        $fileName = $this->getRequest()->getParam('filename');
        if(file_exists($fileName))
        {
            unlink($fileName);
            $this->_redirect('*/*/index');
        }
    }

    public function downloadAction()
    {
        $fullPath = $this->getRequest()->getParam('fullpath');
        $baseName = $this->getRequest()->getParam('basename');
        $filePath = Mage::getBaseDir() . DS . $fullPath;
        // echo 111;
        // echo $filePath;die;
        if (file_exists($filePath)) {
            $this->_prepareDownloadResponse($baseName,file_get_contents($fullPath));
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('filemanager')->__('The requested file does not exist'));
        }
    }

    public function updatedFilenameAction()
    {
        $path = $this->getRequest()->getParam('fullpath');
        $newValue = $this->getRequest()->getParam('newValue');
        $oldValue = $this->getRequest()->getParam('value');
        // print_r($path);

        $newPath = str_replace($oldValue,$newValue,$path);
        print_r($newPath);
        if(!file_exists($newPath))
        {
            rename($path,$newPath);
        }
         $this->_redirect('*/*/index');
    }
    
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('filemanager/adminhtml_file_grid')->toHtml()
        );
    }
}