<?php
class Ccc_Banner_Block_Adminhtml_Banner_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('bannerGrid');
        $this->setDefaultSort('block_identifier');
        $this->setDefaultDir('ASC');
        $this->setTemplate('banner/grid.phtml');
    }

    protected function _prepareCollection()
    {
        if(Mage::getSingleton('admin/session')->isAllowed('banner/banner/actions/show_all'))
        {
            $collection = Mage::getModel('banner/banner')->getCollection();
            /* @var $collection Mage_Cms_Model_Mysql4_Block_Collection */
            
        }
        else{
            $collection = Mage::getModel('banner/banner')->getCollection();
            /* @var $collection Mage_Cms_Model_Mysql4_Block_Collection */
            $collection->setOrder('banner_id','DESC')->getSelect()->limit(5);
            foreach ($collection as $banner)
            {
                $banner->getData();
            }
            
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        if(Mage::getSingleton('admin/session')->isAllowed('banner/banner/actions/show_title'))
        {
        $this->addColumn('title', array(
            'header'    => Mage::helper('banner')->__('Title'),
            'align'     => 'left',
            'index'     => 'title',
        ));
     }

        $this->addColumn('banner_image', array(
            'header'    =>Mage::helper('banner')->__('banner image'),
            'align'     => 'left',
            'index'     => 'banner_image'
        ));
        

        $this->addColumn('status', array(
            'header'    => Mage::helper('banner')->__('Status'),
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                0 =>'Disabled',
                1 =>'Enabled'
            ),
        ));

        $this->addColumn('show_on', array(
            'header'    =>Mage::helper('banner')->__('show on'),
            'align'     => 'left',
            'index'     => 'show_on'
        ));

        return parent::_prepareColumns();
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('banner_id' => $row->getId()));
    }
}