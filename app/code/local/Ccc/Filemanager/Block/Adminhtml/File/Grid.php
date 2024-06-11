<?php
class Ccc_Filemanager_Block_Adminhtml_File_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('fileGrid');
    }

    protected function _prepareCollection()
    {
        // print_r($this->getRequest()->getParams());
        if($this->getRequest()->getParam('isAjax'))
        {
            if($this->getRequest()->getParam('filePath'))
            {
                $dir = base64_decode($this->getRequest()->getParam('filePath'));
                $collection = Mage::getModel('filemanager/filemanager')->addTargetDir($dir);
                $this->setCollection($collection);
            }
        }
        // /* @var $collection Mage_Cms_Model_Mysql4_Block_Collection */
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {

        $this->addColumn(
            'created_date',
            array(
                'header' => Mage::helper('filemanager')->__('Created Date'),
                'align' => 'left',
                'index' => 'created_date',
                'filter' => false
            )
        );

        $this->addColumn(
            'folder_path',
            array(
                'header' => Mage::helper('filemanager')->__('Folder Path'),
                'align' => 'left',
                'index' => 'folder_path'
            )
        );

        $this->addColumn(
            'file_name',
            array(
                'header' => Mage::helper('filemanager')->__('File Name'),
                'align' => 'left',
                'index' => 'file_name',
                'renderer' => 'Ccc_Filemanager_Block_Adminhtml_File_Grid_Renderer_Filename',
                'filter_condition_callback' => array($this ,'_filterByFileName')
            )
        );
        $this->addColumn(
            'extension',
            array(
                'header' => Mage::helper('filemanager')->__('Extension'),
                'align' => 'left',
                'index' => 'extension'
            )
        );

        $this->addColumn(
            'name',
            array(
                'header' => Mage::helper('filemanager')->__('Buttons'),
                'align' => 'left',
                'index' => 'name',
                'renderer' => 'Ccc_Filemanager_Block_Adminhtml_File_Grid_Renderer_Button'
            )
        );

        return parent::_prepareColumns();
    }
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }
    public function _filterByFileName($collection,$column)
    {
        if ($value = $column->getFilter()->getValue()) {
            // return;
            $collection->addFieldToFilter('file_name', array('like' => "%$value%"));
        }

    }
}