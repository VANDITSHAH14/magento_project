<?php
// class Ccc_Filetransfer_Model_Ftp extends Varien_Io_Ftp
// {
//     protected $_configObject = null;
    
//     public function setConfigObject($configObj)
//     {
//         $this->_configObject = $configObj;
//         return $this;
//     }
    
//     public function getFiles()
//     {
//         $configModel = $this->_configObject;
//         $username = $configModel->getUserName();
//         $host = $configModel->getHost();
//         $password = $configModel->getPassword();
//         $remotePath = $configModel->getRemotePath();
//         $completedPath = '/completed/'; // Assuming 'completed' is the destination folder

//         try {
//             $connection = $this->open(
//                 array(
//                     'host' => $host,
//                     'user' => $username,
//                     'password' => $password,
//                 )
//             );
            
//             if ($connection) {
//                 $fileList = $this->ls();

//                 foreach ($fileList as $file) {
//                     $fileName = pathinfo($file['text'], PATHINFO_FILENAME);
//                     $extension = pathinfo($file['text'], PATHINFO_EXTENSION);
//                     $timestamp = date('Ymd_His');
//                     $localFilePath = Mage::getBaseDir('var') . DS . 'filetransfer' . DS . $fileName . '_' . $timestamp . '.' . $extension;
//                     if (!file_exists(dirname($localFilePath))) {
//                         mkdir(dirname($localFilePath), 0755, true);
//                     }

//                     // if(substr_count($file['text'],'.') == 1)
//                     // {
//                     //     $path = substr($file['text'],2);
//                     //     if($path == 'completed'){
//                     //         continue;
//                     //     }

//                     //     $this->cd($path);
//                     //     $folder_file= $this->ls();
//                     //     print_r($folder_file);
//                     //     foreach($folder_file as $_files)
//                     //     {
//                     //         $folderFileName =pathinfo($_files['text'], PATHINFO_FILENAME);
//                     //         $fileextension = pathinfo($_files['text'], PATHINFO_EXTENSION);
//                     //         $localpath =  Mage::getBaseDir('var') . DS . 'filetransfer' . DS . $path . DS . $folderFileName . '_' . $timestamp . '.' . $fileextension;
//                     //         // echo $localpath;
//                     //         if (!file_exists(dirname($localpath))) {
//                     //             mkdir(dirname($localpath), 0755, true);
//                     //         }
//                     //         $this->read($_files['text'], $localpath);
//                     //     }
//                     // }

//                     // $this->read($file['text'], $localFilePath);
//                     // $this->mv($file['text'], $completedPath.$file['text']);
//                 }
//                 return $fileList;
//             }
            
//             $this->close();
//         } catch (Exception $e) {
//             Mage::logException($e);
//             echo 'An error occurred: ' . $e->getMessage();
//         }
//     }
// }

class Ccc_Filetransfer_Model_Ftp extends Varien_Io_Ftp
{
    protected $_config = null;

    public function setConfigObject($obj)
    {
        $this->_config = $obj;
        return $this;
    }

    public function getFiles()
    {
        $configId = $this->_config->getConfigId();
        $host = $this->_config->getHost();
        $userId = $this->_config->getUserName();
        $password = $this->_config->getPassword();

        $connection = $this->open(
            array(
                'host' => $host,
                'user' => $userId,
                'password' => $password,
            )
        );

        if ($connection) {
            $completedDir = 'completed';
            $files = ftp_rawlist($this->_conn, '.');
            $allFiles = [];
            $this->processFilesRecursively($files, '.', $completedDir, $allFiles, $configId, $host, $userId);

            $this->close();
            return $allFiles;
        }
    }

    private function processFilesRecursively($files, $currentPath, $completedDir, &$allFiles, $configId, $host, $userId)
    {
        foreach ($files as $file) {
            $fileDetails = $this->parseRawListLine($file);
            if (!$fileDetails) {
                continue;
            }

            $filePath = ltrim($currentPath . '/' . $fileDetails['filename'], './');

            if ($fileDetails['filename'] !== 'completed' && $fileDetails['filename'] !== '.' && $fileDetails['filename'] !== '..') {
                if ($fileDetails['permissions'][0] !== 'd') {  // It's a file
                    $this->handleFile($fileDetails, $filePath, $completedDir, $allFiles, $configId, $host, $userId);
                } else {  // It's a directory
                    $this->handleDirectory($fileDetails, $filePath, $completedDir, $allFiles, $configId, $host, $userId);
                }
            }
        }
    }

    private function handleFile($fileDetails, $filePath, $completedDir, &$allFiles, $configId, $host, $userId)
    {
        // $userId = $this->_config->getUserName();
        $timestamp = date('Ymd_His');
        $localDir = Mage::getBaseDir('var') . DS . 'filetransfer';
        $localFilePath = $localDir . DS . $filePath;
        $fileInfo = pathinfo($fileDetails['filename']);
        $filenameWithoutExt = $fileInfo['filename'];
        $extension = isset($fileInfo['extension']) ? $fileInfo['extension'] : '';

        $newLocalFilePath = str_replace($fileDetails['filename'], '', $localFilePath) . $filenameWithoutExt . ($extension ? '.' . $extension : '');
        // var_dump($filePath);
        if (!file_exists(dirname($newLocalFilePath))) {
            mkdir(dirname($newLocalFilePath), 0755, true);
        }

        $name = str_replace($localDir, '', $newLocalFilePath);
        $remoteFilePath = '/' . $filePath;
        $modifiedTime = ftp_mdtm($this->_conn, $remoteFilePath);
        // var_dump($remoteFilePath);die;
        if ($modifiedTime != -1) {
            $modifiedDate = date('Y-m-d H:i:s', $modifiedTime);
        } else {
            $modifiedDate = 'Unknown';
        }

        $this->read($filePath, $newLocalFilePath);

        $fileModel = Mage::getModel('filetransfer/files');
        $data= array(
            'config_id' => $configId,
            'user' => $userId,
            // 'file_name' => '/'.$filenameWithoutExt . '_' . $timestamp . '.' . $extension,
            'file_name' => '/'.$filePath,

        );
        $fileModel->setData($data)->save();

        $this->mv($filePath, $completedDir . '/' . $filePath);

        $allFiles[] = [
            'filename' => $name,
            'modified_date' => $modifiedDate,
            'config_id' => $configId,
            'host' => $host
        ];
    }

    private function handleDirectory($fileDetails, $filePath, $completedDir, &$allFiles, $configId, $host)
    {
        $localDirPath = Mage::getBaseDir('var') . DS . 'filetransfer' . DS . $filePath;
        $completedDirPath = $completedDir . '/' . $filePath;

        if (!file_exists($localDirPath)) {
            mkdir($localDirPath, 0755, true);
        }

        if (!$this->ftpDirectoryExists($this->_conn, $completedDirPath)) {
            ftp_mkdir($this->_conn, $completedDirPath);
        }

        $subFiles = ftp_rawlist($this->_conn, $filePath);
        $this->processFilesRecursively($subFiles, $filePath, $completedDir, $allFiles, $configId, $host);
    }

    private function parseRawListLine($line)
    {
        if (preg_match("/^([drwx-]+)\s+\d+\s+\S+\s+\S+\s+(\d+)\s+(\S+\s+\d+\s+\d+:\d+)\s+(.+)/", $line, $matches)) {
            return [
                'permissions' => $matches[1],
                'size' => $matches[2],
                'timestamp' => strtotime($matches[3]),
                'filename' => $matches[4]
            ];
        }
        return null;
    }

    private function ftpDirectoryExists($ftp_conn, $dir)
    {
        $list = ftp_nlist($ftp_conn, $dir);
        return is_array($list);
    }
}
?>
