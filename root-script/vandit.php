<?php
require_once ('../app/Mage.php');
Mage::app();
echo "<pre>";
// echo (extension_loaded('openssl') ? 'SSL is enabled' : 'SSL is not enabled') . '<br>';
// echo (function_exists('ftp_ssl_connect') ? 'ftp_ssl_connect function exists' : 'ftp_ssl_connect function does not exist') . '<br>';
// phpinfo();

Mage::getModel('filetransfer/observer')->fetch();
// Mage::getModel('outlook/email')->dispatchEvents();
// Mage::getModel('outlook/configuration')->fetchEmails();