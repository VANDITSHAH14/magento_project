<?php
class Xyz_Test_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        echo "<pre>";
        $var =Mage::getModel('xyz_test/abc');
        print_r($var);
    }
}
