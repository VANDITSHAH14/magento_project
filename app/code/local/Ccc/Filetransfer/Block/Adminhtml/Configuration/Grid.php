<?php
class Ccc_Filetransfer_Block_Adminhtml_Configuration_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        // $this->setId('filetransfer');
    }

    protected function _prepareCollection()
    {

        $collection = Mage::getModel('filetransfer/configuration')->getCollection();

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {

        $this->addColumn(
            'config_id',
            array(
                'header' => Mage::helper('filetransfer')->__('Config Id'),
                'align' => 'left',
                'index' => 'config_id',
            )
        );

        $this->addColumn(
            'user_name',
            array(
                'header' => Mage::helper('filetransfer')->__('User Name'),
                'align' => 'left',
                'index' => 'user_name',
            )
        );

        $this->addColumn(
            'password',
            array(
                'header' => Mage::helper('filetransfer')->__('Password'),
                'align' => 'left',
                'index' => 'password'
            )
        );

        $this->addColumn(
            'host',
            array(
                'header' => Mage::helper('filetransfer')->__('Host'),
                'align' => 'left',
                'index' => 'host'
            )
        );

        $this->addColumn(
            'port',
            array(
                'header' => Mage::helper('filetransfer')->__('Port'),
                'align' => 'left',
                'index' => 'port'
            )
        );

        return parent::_prepareColumns();
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('config_id' => $row->getId()));
    }
    
}