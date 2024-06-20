<?php

$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('ccc_filter_save'))
    ->addColumn('id',Varien_Db_Ddl_Table::TYPE_INTEGER,null,array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'ID')
    ->addColumn('status',Varien_Db_Ddl_Table::TYPE_VARCHAR,255,array(
        'nullable' => false,
    ), 'Status')
    ->addColumn('asign_to',Varien_Db_Ddl_Table::TYPE_VARCHAR,255,array(
        'nullable' => false,
    ), 'Assign To')
    ->addColumn('last_comment',Varien_Db_Ddl_Table::TYPE_VARCHAR,255,array(
        'nullable' => false,
    ), 'Last Comment')
    ->addColumn('created_at',Varien_Db_Ddl_Table::TYPE_INTEGER,11,array(
        'nullable' => false,
    ), 'Created At')
    ->addColumn('filter_name',Varien_Db_Ddl_Table::TYPE_VARCHAR,255,array(
        'nullable' => false,
    ), 'Filter Name')
    ->setComment('CCC Filter Save Table');
$installer->getConnection()->createTable($table);