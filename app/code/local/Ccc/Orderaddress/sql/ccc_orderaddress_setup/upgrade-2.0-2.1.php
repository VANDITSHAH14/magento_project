<?php
$installer = $this;
$installer->startSetup();
$table=$installer->getTable("sales/order");

$installer->getConnection()
    ->addColumn($table,'address_validation_required',array(
        'type' => Varien_Db_Ddl_Table::TYPE_SMALLINT,
        'length' => 11,
        'default'=>'0',
        'nullable'=> false,
        'comment' => 'Address Validation Required'
    ));

$installer->getConnection()
    ->addColumn($table,'validation_email_sent_count',array(
        'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'length' =>11,
        'default'=>'0',
        'nullable'=> false,
        'comment' => 'Validation Email Sent Count'
    ));
$installer->endSetup();