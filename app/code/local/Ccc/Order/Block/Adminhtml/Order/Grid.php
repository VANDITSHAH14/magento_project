<?php
class Ccc_Order_Block_Adminhtml_Order_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('orderGrid');
        $this->setDefaultSort('block_identifier');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('order/order')->getCollection();
        /* @var $collection Mage_Cms_Model_Mysql4_Block_Collection */
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('status', array(
            'header'    => Mage::helper('order')->__('Status'),
            'align'     => 'left',
            'index'     => 'status',
            'type'      => 'options',
            'options' => Mage::getSingleton('sales/order_config')->getStatuses(),

        ));

        $this->addColumn('short_order', array(
            'header'    =>Mage::helper('order')->__('Short Order'),
            'align'     => 'left',
            'index'     => 'short_order'
        ));

        $this->addColumn('is_active', array(
            'header'    => Mage::helper('order')->__('Is Active'),
            'index'     => 'is_active',
            'type'      => 'options',
            'options'   => array(
                0 => Mage::helper('order')->__('Disabled'),
                1 => Mage::helper('order')->__('Enabled')
            ),
        ));
        $this->addColumn('total_range', array(
            'header'    =>Mage::helper('order')->__('Total Range'),
            'align'     => 'left',
            'index'     => 'total_range'
        ));

        $this->addColumn('created_at', array(
            'header'    => Mage::helper('order')->__('Date Created'),
            'index'     => 'created_at',
            'type'      => 'datetime',
        ));
        $this->addColumn('created_by', array(
            'header'    =>Mage::helper('order')->__('Created By'),
            'align'     => 'left',
            'index'     => 'created_by'
        ));
        

        return parent::_prepareColumns();
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('entity_id' => $row->getId()));
    }
}