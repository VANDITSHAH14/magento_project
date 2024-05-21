<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * Create table 'ccc_banner'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('ccc_banner'))
    ->addColumn('banner_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Block ID')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Banner Title')
    ->addColumn('banner_image', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Banner Image')
    ->addColumn('show_on', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        ), 'show on')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => '1',
        ), 'Is Status Active')
    ->setComment('CCC Banner Table');
$installer->getConnection()->createTable($table);

$installer->endSetup();
