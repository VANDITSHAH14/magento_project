<?php

$installer = $this;

$installer->startSetup();

$table=$installer->getTable("ccc_filetransfer_configuration");

$installer->getConnection()
    ->addColumn($table,'remote_path',array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 255,
        'comment' => 'Remote Path'
    ));
$installer->getConnection()
    ->addColumn($table,'local_path',array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length' => 255,
        'comment' => 'local path'
    ));
$installer->getConnection()
    ->modifyColumn($table,'port','INT');

$table=$installer->getTable("ccc_filetransfer_file");

$installer->getConnection()
    ->addColumn($table,'created_at',array(
        'type' => Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        'nullable' =>false,
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
        'comment' => 'Created At'
    ));
    
