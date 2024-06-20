<?php
class Ccc_Filetransfer_Block_Adminhtml_Files_Grid_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        // echo 111;
        $fileName = $row->getFileName();
        // echo $fileName;
        if (pathinfo($fileName, PATHINFO_EXTENSION) == 'zip') {
            $fileName = str_replace('/','_', $fileName);
            $extractUrl = $this->getUrl('*/*/extract', array('filename' => $fileName, 'config_id' => $row->getConfigId()));
            $html = '<a href="' . $extractUrl . '"><button>Extract</button></a>';
            return $html;
        }
        elseif(pathinfo($fileName, PATHINFO_EXTENSION) == 'xml'){
            // echo $fileName;
            $fileName = str_replace('\\','_',$fileName);
            $exportUrl = $this->getUrl('*/*/export', array('filename' => $fileName));
            $html = '<a href="' . $exportUrl . '"><button>Export CSV</button></a>';
            return $html;
        }
        return '';
    }
}
