<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * Create table 'ccc_banner'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('ccc_seller'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Seller ID')
    ->addColumn('seller_name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Seller Name')
    ->addColumn('company_name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Company Name')
    ->addColumn('address', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Address')
    ->addColumn('city', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'City')
    ->addColumn('state', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'State')
    ->addColumn('country', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Country')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => '1',
        ), 'Is Status Active')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Creation Time')
    ->addColumn('update_date', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
        ), 'Updated Date')
    ->setComment('CCC Seller Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();
