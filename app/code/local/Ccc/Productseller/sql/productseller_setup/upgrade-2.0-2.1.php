<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$entityTypeId = "catalog_product";
$attributeCode = "seller_id";
$attributeLabel = "Seller Id";

$data = [
    "type" => 'int',
    "input" => 'select',
    "label" => $attributeLabel,
    "source" => "seller/option",
    "required" => false,
    "user_define" => true,
    "unique" => false,
];

$installer->addAttribute($entityTypeId, $attributeCode, $data);
$installer->endSetup();
