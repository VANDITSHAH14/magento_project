<?php
class Ccc_Filemanager_Block_Adminhtml_File_Grid_Renderer_Filename extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value = $row->getFileName();
        $fullPath = Mage::getBaseDir().DS.$row->getName();
        $url = $this->getUrl('*/*/updatedFilename');
        $html = '<div class="editable" data-id="' . $row->getId() . '" data-url ="'.$url.'" data-fullpath="'.$fullPath.'">' . $value . '</div>';
        return $html;
    }
}
