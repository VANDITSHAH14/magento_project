<?php
class Ccc_Filemanager_Model_Filemanager extends Varien_Data_Collection_Filesystem
{
    // protected function _construct()
    // {
    //     parent::_construct();
    // }

    protected function _generateRow($filename)
    {
        $relativePath = str_replace($this->_targetDirs, '', dirname($filename));
        $relativePath = $relativePath === '' ? '/' : $relativePath . '/';

        return array(
            'folder_path' => $relativePath,
            'name' => $filename,
            'basename' =>pathinfo($filename)['basename'],
            'file_name' => pathinfo($filename, PATHINFO_FILENAME),
            'created_date' => date('Y-m-d H:i:s', filectime($filename)),
            'extension' => pathinfo($filename, PATHINFO_EXTENSION),
        );
    }
}