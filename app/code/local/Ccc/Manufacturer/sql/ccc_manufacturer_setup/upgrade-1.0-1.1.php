<?php
$installer = $this;
$installer->startSetup();
$table = $installer->getTable('ccc_manufacturer');
    
$installer->getConnection()->modifyColumn($table, 'created_by', 'INT');

$installer->endSetup();
