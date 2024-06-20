<?php 

class Ccc_Filetransfer_Model_Observer
{
    public function fetch()
    {
        $configCollection = Mage::getModel('filetransfer/configuration')->getCollection();

        foreach($configCollection as $_config){
            $_config->fetchFiles();
        }
    }
}