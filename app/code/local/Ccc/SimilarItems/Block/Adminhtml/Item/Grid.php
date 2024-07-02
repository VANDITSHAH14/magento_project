<?php
class Ccc_SimilarItems_Block_Adminhtml_Item_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('itemrGrid');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('items/items')->getCollection();
        /* @var $collection Mage_Cms_Model_Mysql4_Block_Collection */

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $this->addColumn(
            'main_product_id',
            array(
                'header' => Mage::helper('items')->__(' Main Product Id'),
                'align' => 'left',
                'index' => 'main_product_id',
                'type' => 'options',
                'options' => Mage::getModel('items/items')->getProduct()
            )
        );

        $this->addColumn(
            'similar_product_id',
            array(
                'header' => Mage::helper('items')->__('Similar Product Id'),
                'align' => 'left',
                'index' => 'similar_product_id',
                'type' => 'options',
                'options' => Mage::getModel('items/items')->getProduct()
            )
        );

        $this->addColumn(
            'is_deleted',
            array(
                'header' => Mage::helper('items')->__('Is Deleted'),
                'index' => 'is_deleted',
                'type' => 'options',
                'options' => array(
                    0 => 'Yes',
                    1 => 'No'
                ),
            )
        );
        $this->addColumn('created_at', array(
            'header'    => Mage::helper('items')->__('Date Created'),
            'index'     => 'created_at',
            'type'      => 'datetime',
        ));

        $this->addColumn('deleted_at', array(
            'header'    => Mage::helper('items')->__('Date Deleted'),
            'index'     => 'deleted_at',
            'type'      => 'date', 
        ));

        return parent::_prepareColumns();
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
    
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('item_ids');
        $this->getMassactionBlock()->setUseSelectAll(false);

        $statuses = [
            0 => "Yes",
            1 => "No",
        ];

        $this->getMassactionBlock()->addItem('is_deleted', array(
            'label' => Mage::helper('items')->__('Change Is Delete'),
            'url'  => $this->getUrl('*/similar/massUpdateDeleted', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'is_deleted',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('items')->__('Is Deleted'),
                    'values' => $statuses
                )
            )
        ));

        return $this;
    }

}