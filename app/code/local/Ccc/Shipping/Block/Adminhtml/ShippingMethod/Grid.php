<?php
class Ccc_Shipping_Block_Adminhtml_Shippingmethod_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('shippingGrid');
        $this->setDefaultSort('block_identifier');
        $this->setDefaultDir('ASC');
    }

    protected function _prepareCollection()
    {
        $collection = new Varien_Data_Collection();
        $whiteglovedelivery = Mage::getStoreConfig('carriers/whiteglovedelivery');
        $amount = unserialize($whiteglovedelivery['shippingamountbasedonsubtotal']);
        // print_r($amount);
        $varion = new Varien_Object();
        $formattedAmounts = [];
        foreach ($amount as $_amount) {
            $formattedAmounts[] = "{$_amount['from']} - {$_amount['to']} = {$_amount['price']}";
        }
        $shippingData = [
            'shipping_method_code' => $whiteglovedelivery['code'],
            'shipping_method_name' => $whiteglovedelivery['name'],
            'description' => $whiteglovedelivery['description'],
            'shipping_amount' =>implode(', ', $formattedAmounts),
        ];

        $varion->setData($shippingData);
        $collection->addItem($varion);
        /* @var $collection Mage_Cms_Model_Mysql4_Block_Collection */
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('shipping_method_code', array(
            'header' => Mage::helper('shipping')->__('Shipping Method Code'),
            'align' => 'left',
            'index' => 'shipping_method_code',

        )
        );

        $this->addColumn('shipping_method_name', array(
            'header' => Mage::helper('shipping')->__('Shipping Method Name'),
            'align' => 'left',
            'index' => 'shipping_method_name'
        )
        );

        $this->addColumn('description', array(
            'header' => Mage::helper('order')->__('Short Description'),
            'align' => 'left',
            'index' => 'description'
        )
        );

        $this->addColumn('shipping_amount', array(
            'header' => Mage::helper('order')->__('Shipping Amount'),
            'align' => 'left',
            'index' => 'shipping_amount'
        )
        );
        $this->addColumn('action', array(
            'header'   => Mage::helper('shipping')->__('Shipping Amount Update'),
            'width'    => '100px',
            'sortable' => false,
            'filter'   => false,
            'renderer' => 'Ccc_Shipping_Block_Adminhtml_Shippingmethod_Renderer_Button',
        ));

        return parent::_prepareColumns();
    }
}