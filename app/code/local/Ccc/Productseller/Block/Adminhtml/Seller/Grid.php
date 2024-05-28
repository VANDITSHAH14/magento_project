<?php
class Ccc_Productseller_Block_Adminhtml_Seller_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('sellerGrid');
        $this->setDefaultSort('block_identifier');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {

        $collection = Mage::getModel('seller/seller')->getCollection();
        /* @var $collection Mage_Cms_Model_Mysql4_Block_Collection */

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();


        $this->addColumn(
            'seller_name',
            array(
                'header' => Mage::helper('seller')->__('Seller Name'),
                'align' => 'left',
                'index' => 'seller_name',
            )
        );

        $this->addColumn(
            'company_name',
            array(
                'header' => Mage::helper('seller')->__('Company Name'),
                'align' => 'left',
                'index' => 'company_name'
            )
        );
        $this->addColumn(
            'address',
            array(
                'header' => Mage::helper('seller')->__('Address'),
                'align' => 'left',
                'index' => 'address'
            )
        );

        $this->addColumn(
            'city',
            array(
                'header' => Mage::helper('seller')->__('City'),
                'align' => 'left',
                'index' => 'city'
            )
        );

        $this->addColumn(
            'state',
            array(
                'header' => Mage::helper('seller')->__('State'),
                'align' => 'left',
                'index' => 'state'
            )
        );

        $this->addColumn(
            'country',
            array(
                'header' => Mage::helper('seller')->__('Country'),
                'align' => 'left',
                'index' => 'country'
            )
        );

        $this->addColumn(
            'is_active',
            array(
                'header' => Mage::helper('seller')->__('Is Active'),
                'index' => 'is_active',
                'type' => 'options',
                'options' => array(
                    0 => 'No',
                    1 => 'Yes'
                ),
            )
        );
        $this->addColumn('created_at', array(
            'header'    => Mage::helper('seller')->__('Date Created'),
            'index'     => 'created_at',
            'type'      => 'datetime',
        ));

        $this->addColumn('update_date', array(
            'header'    => Mage::helper('seller')->__('Date Updated'),
            'index'     => 'update_date',
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
        $this->getMassactionBlock()->setFormFieldName('seller_ids');
        $this->getMassactionBlock()->setUseSelectAll(false);


        $statuses = [
            0 => "No",
            1 => "Yes",
        ];

        $this->getMassactionBlock()->addItem('is_active', array(
            'label' => Mage::helper('seller')->__('Change Is Active'),
            'url'  => $this->getUrl('*/seller/massUpdateIsActive', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'is_active',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('seller')->__('Is Active'),
                    'values' => $statuses
                )
            )
        ));

        return $this;
    }

}