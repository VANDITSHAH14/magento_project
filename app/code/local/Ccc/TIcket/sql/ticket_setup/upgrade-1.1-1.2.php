<?php
$installer = $this;
$installer->startSetup();
$table=$installer->getTable("ccc_ticket_comment_history");

$installer->getConnection()
    ->addColumn($table,'parent_id',array(
        'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'length' => 11,
        'comment' => 'Parent Id'
    ));

$installer->endSetup();