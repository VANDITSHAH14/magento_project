<?php
$installer = $this;
$installer->startSetup();

$attributeCode = 'brand';
$optionsToRemove = array('HP');

$attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $attributeCode);

if ($attribute->getId()) {
    $options = $attribute->getSource()->getAllOptions(false);
    $optionsToDelete = array();
    foreach ($options as $option) {
        if (in_array($option['label'], $optionsToRemove)) {
            $optionsToDelete['delete'][$option['value']] = true;
            $optionsToDelete['value'][$option['value']] = true;
        }
    }
    if (!empty($optionsToDelete)) {
        $setup = new Mage_Eav_Model_Entity_Setup('core_setup');
        $setup->addAttributeOption($optionsToDelete);
    }
}
$installer->endSetup();

