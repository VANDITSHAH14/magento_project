<?php
class Ccc_Productseller_Block_Adminhtml_Sellerreport extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup='seller';
        $this->_controller = 'adminhtml_sellerreport';
        parent::__construct();
        $this->setTemplate('ccc/customer/sellerreport.phtml');
    }

    public function getAllowAction()
    {
        return (int) Mage::getStoreConfig('productseller/settings/allow_mass_products');
    }
}
