<?php 

$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('ccc_outlook_email'))
    ->addColumn('email_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Email Id')
    ->addColumn('config_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable'  => false,
    ), 'Configuration Id')
    ->addColumn('from', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
    ), 'From')
    ->addColumn('to', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
    ), 'To')
    ->addColumn('subject', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
    ), 'Subject')
    ->addColumn('body', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
    ), 'Body of Email')
    ->addColumn('has_attachments', Varien_Db_Ddl_Table::TYPE_SMALLINT, 6, array(
        'nullable' => false,
        'default'  => 0,
    ), 'Attachments')
    ->addColumn('received_datetime', Varien_Db_Ddl_Table::TYPE_DATETIME,  null, array(
    ), 'Received Date Time')
    ->addColumn('outlook_id', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
    ), 'Outlook Id')
    ->setComment('Email Table');
$installer->getConnection()->createTable($table);
$installer->endSetup();