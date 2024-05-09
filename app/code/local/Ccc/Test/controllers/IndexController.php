<?php
class Ccc_Test_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        echo "<pre>";
        $var =Mage::getModel('ccc_test/abc');
        print_r($var);
    }
}
