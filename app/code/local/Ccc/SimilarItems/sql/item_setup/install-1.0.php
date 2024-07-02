<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('ccc_similar_items'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'ID')
    ->addColumn('main_product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable'  => false,
        ), 'Main Product Id')
    ->addColumn('similar_product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable'  => false,
        ), 'Similar Product Id')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Creation Time')
    ->addColumn('is_deleted', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => '1',
        ), 'Is Deleted')
    ->addColumn('deleted_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Creation Time')
    ->setComment('CCC Similar Items Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();
