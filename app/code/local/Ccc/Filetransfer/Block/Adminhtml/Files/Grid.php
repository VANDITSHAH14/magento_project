<?php
class Ccc_Filetransfer_Block_Adminhtml_Files_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        // $this->setId('filetransfer');
    }

    protected function _prepareCollection()
    {

        $collection = Mage::getModel('filetransfer/files')->getCollection();

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {

        $this->addColumn(
            'id',
            array(
                'header' => Mage::helper('filetransfer')->__('Id'),
                'align' => 'left',
                'index' => 'id',
            )
        );

        $this->addColumn(
            'config_id',
            array(
                'header' => Mage::helper('filetransfer')->__('Config Id'),
                'align' => 'left',
                'index' => 'config_id',
            )
        );


        $this->addColumn(
            'file_name',
            array(
                'header' => Mage::helper('filetransfer')->__('File Name'),
                'align' => 'left',
                'index' => 'file_name',
            )
        );


        $this->addColumn(
            'modified_date',
            array(
                'header' => 'Modified At',
                'align' => 'left',
                'index' => 'modified_date'
            )
            );

        $this->addColumn(
            'created_at',
            array(
                'header' => 'Created At',
                'align' => 'left',
                'index' => 'created_at'
            )
        );

        $this->addColumn(
            'action', 
            array(
            'header' => Mage::helper('filetransfer')->__('Action'),
            'width' => '100px',
            'sortable' => false,
            'filter' => false,
            'renderer' => 'Ccc_Filetransfer_Block_Adminhtml_Files_Grid_Renderer_Action'
            )
        );


        return parent::_prepareColumns();
    }
    // public function getRowUrl($row)
    // {
    //     return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    // }
    
}