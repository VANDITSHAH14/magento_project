<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$entityTypeId ="catalog_product";
$attributeCode ="shipping_type";
$attributeLabel ="Shipping Type";

$data = [
    "type" => 'int',
    "input" => 'select',
    "label" => $attributeLabel,
    "source" =>"eav/entity_attribute_source_table",
    "required" =>false,
    "user_define"=>true,
    "unique"=>false,
    "option"=>[
        "value"=>[
            "option1"=>[0=>'freight'],
            "option2"=>[0=>'express'],
        ]
    ]
];
$installer->addAttribute($entityTypeId,$attributeCode,$data);
$installer->endSetup();