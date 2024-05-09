<?php
$installer=$this;
$installer->startSetup();
$table=$installer->getTable("sales/quote");

$installer->getConnection()
    ->addColumn($table,'delivery_note',array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 255,
        'comment' => 'Delivery Note'
    ));

$table=$installer->getTable("sales/order");

$installer->getConnection()
    ->addColumn($table,'delivery_note',array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 255,
        'comment' => 'Delivery Note'
    ));

$installer->endSetup();