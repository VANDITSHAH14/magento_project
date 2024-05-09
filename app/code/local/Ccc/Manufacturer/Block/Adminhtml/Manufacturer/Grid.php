<?php
class Ccc_Manufacturer_Block_Adminhtml_Manufacturer_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('orderstockGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('manufacturer/manufacturer')->getCollection();
        /* @var $collection Mage_Cms_Model_Mysql4_Block_Collection */

        $collection->getSelect()
            ->join(
                array('cmb' => Mage::getSingleton('core/resource')->getTableName('ccc_manufacturer_brand')),
                'cmb.mfr_id = main_table.entity_id',
                []
            )->join(
                array('eavo' => Mage::getSingleton('core/resource')->getTableName('eav_attribute_option_value')),
                'cmb.brand_id = eavo.option_id',
                ["brand" => new Zend_Db_Expr('GROUP_CONCAT(eavo.value)')]
            )->group('main_table.entity_id');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn(
            'manufacturer_name',
            array(
                'header' => Mage::helper('manufacturer')->__('Manufacturer Name'),
                'align' => 'left',
                'index' => 'manufacturer_name',
            )
        );

        $this->addColumn(
            'email',
            array(
                'header' => Mage::helper('manufacturer')->__('Email'),
                'align' => 'left',
                'index' => 'email'
            )
        );

        $this->addColumn(
            'street',
            array(
                'header' => Mage::helper('manufacturer')->__('Street'),
                'align' => 'left',
                'index' => 'street'
            )
        );

        $this->addColumn(
            'city',
            array(
                'header' => Mage::helper('manufacturer')->__('City'),
                'align' => 'left',
                'index' => 'city'
            )
        );

        $this->addColumn(
            'state',
            array(
                'header' => Mage::helper('manufacturer')->__('State'),
                'align' => 'left',
                'index' => 'state'
            )
        );

        $this->addColumn(
            'country',
            array(
                'header' => Mage::helper('manufacturer')->__('Country'),
                'align' => 'left',
                'index' => 'country'
            )
        );

        $this->addColumn(
            'zipcode',
            array(
                'header' => Mage::helper('manufacturer')->__('Zipcode'),
                'align' => 'left',
                'index' => 'zipcode'
            )
        );


        $this->addColumn(
            'is_active',
            array(
                'header' => Mage::helper('manufacturer')->__('Is Active'),
                'index' => 'is_active',
                'type' => 'options',
                'options' => array(
                    0 => 'Disabled',
                    1 => 'Enabled'
                ),
            )
        );

        $this->addColumn(
            'brand',
            array(
                'header' => Mage::helper('manufacturer')->__('Brands'),
                'align' => 'left',
                'index' => 'brand'
            )
        );

        return parent::_prepareColumns();
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('entity_id' => $row->getId()));
    }
    public function getBrandOptions()
    {
        $options = array();
        // Assuming your status values are stored in a table named 'status_table'
        // $statusCollection = Mage::getModel('eav/entity_attribute_option')->getCollection()->addFieldToFilter('attribute_id',220);
        $brandCollection = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'brand')->getSource()->getAllOptions();
        foreach ($brandCollection as $status) {
            // print_r(Mage::getModel('manufacturer/brand')->load($status['value'],'brand_id')->getData());
            if (!empty(Mage::getModel('manufacturer/brand')->load($status['value'], 'brand_id')->getData())) {
                $options[] = array(
                    'value' => $status['value'], // Assuming id as value
                    'label' => $status['label'] // Assuming name as label
                );
            }
        }
        return $options;
    }
}