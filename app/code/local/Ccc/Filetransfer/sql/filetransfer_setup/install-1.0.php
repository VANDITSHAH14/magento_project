<?php

$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('ccc_filetransfer_configuration'))
    ->addColumn('config_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Config ID')
    ->addColumn('user_name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
    ), 'User Name')
    ->addColumn('password', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
    ), 'Password')
    ->addColumn('host', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
    ), 'Host')
    ->addColumn('port', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
    ), 'Port')
    ->setComment('CCC Filetransfer Configuration Table');
$installer->getConnection()->createTable($table);


$table = $installer->getConnection()
    ->newTable($installer->getTable('ccc_filetransfer_file'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), ' ID')
    ->addColumn('config_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 255, array(
        'nullable' => false,
    ), 'Config Id')
    ->addColumn('host', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
    ), 'Host')
    ->addColumn('file_name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false,
    ), 'file_name')
    ->addColumn('modified_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable' => true,
    ), 'Modified Date')
    ->addForeignKey($installer->getFkName('ccc_filetransfer_file', 'config_id', 'ccc_filetransfer_configuration', 'config_id'),
    'config_id', $installer->getTable('ccc_filetransfer_configuration'), 'config_id',
    Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('CCC Filetransfer File Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();