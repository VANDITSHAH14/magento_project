<?php

$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('ccc_ticket_status'))
    ->addColumn('id',Varien_Db_Ddl_Table::TYPE_INTEGER,null,array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'ID')
    ->addColumn('code',Varien_Db_Ddl_Table::TYPE_VARCHAR,255,array(
        'nullable' => false,
    ), 'Code')
    ->addColumn('label',Varien_Db_Ddl_Table::TYPE_VARCHAR,255,array(
        'nullable' => false,
    ), 'Label')
    ->addColumn('color_code',Varien_Db_Ddl_Table::TYPE_VARCHAR,255,array(
        'nullable' => false,
    ), 'Color Code')
    ->setComment('CCC Ticket Status Table');
$installer->getConnection()->createTable($table);

$table = $installer->getConnection()
    ->newTable($installer->getTable('ccc_ticket'))
    ->addColumn('ticket_id',Varien_Db_Ddl_Table::TYPE_INTEGER,null,array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Ticket ID')
    ->addColumn('title',Varien_Db_Ddl_Table::TYPE_VARCHAR,255,array(
        'nullable' => false,
    ), 'Title')
    ->addColumn('description',Varien_Db_Ddl_Table::TYPE_TEXT,255,array(
        'nullable' => false,
    ), 'Description')
    ->addColumn('priority',Varien_Db_Ddl_Table::TYPE_VARCHAR,255,array(
        'nullable' => false,
    ), 'Priority')
    ->addColumn('asign_to',Varien_Db_Ddl_Table::TYPE_VARCHAR,255,array(
        'nullable' => false,
    ), 'Assign To')
    ->addColumn('asign_by',Varien_Db_Ddl_Table::TYPE_VARCHAR,255,array(
        'nullable' => false,
    ), 'Assign By')
    ->addColumn('status',Varien_Db_Ddl_Table::TYPE_TINYINT,255,array(
        'nullable' => false,
    ), 'Status')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'Creation Time')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'Updated Time')
    ->addForeignKey($installer->getFkName('ccc_ticket', 'status', 'ccc_ticket_status', 'id'),
    'status', $installer->getTable('ccc_ticket_status'), 'id',
    Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('CCC Ticket Table');
$installer->getConnection()->createTable($table);


$table = $installer->getConnection()
    ->newTable($installer->getTable('ccc_ticket_comment_history'))
    ->addColumn('comment_id',Varien_Db_Ddl_Table::TYPE_INTEGER,null,array(
        'identity' => true,
        'nullable' => false,
        'primary' => true,
    ), 'Comment ID')
    ->addColumn('ticket_id',Varien_Db_Ddl_Table::TYPE_INTEGER,null,array(
        'nullable' => false,
    ), 'Ticket ID')
    ->addColumn('comment_description',Varien_Db_Ddl_Table::TYPE_TEXT,255,array(
        'nullable' => false,
    ), 'Comment Description')
    ->addColumn('user_id',Varien_Db_Ddl_Table::TYPE_INTEGER,null,array(
        'nullable' => false,
    ), 'User ID')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'Creation Time')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'Updated Time')
    ->addForeignKey($installer->getFkName('ccc_ticket_comment', 'ticket_id', 'ccc_ticket', 'ticket_id'),
    'ticket_id', $installer->getTable('ccc_ticket'), 'ticket_id',
    Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('CCC Ticket Comment History Table');
$installer->getConnection()->createTable($table);



$installer->endSetup();