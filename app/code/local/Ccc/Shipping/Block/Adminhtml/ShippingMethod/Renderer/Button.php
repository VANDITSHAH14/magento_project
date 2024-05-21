<?php
class Ccc_Shipping_Block_Adminhtml_Shippingmethod_Renderer_Button extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $action = $row->getData($this->getColumn()->getIndex());
        $html = '<button id="btn">' . 'update' . '</button>';
        $html .= '<script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            var btn = document.getElementById("btn");
            btn.onclick = function() {
                // Open a popup window
                var popupWindow = window.open("", "Popup", "width=400,height=400");
                // Write HTML content to the popup window
                popupWindow.document.write("<p>Hello, this is a popup!</p>");
                // console.log(111);
            };
        });
        </script>';
        return $html;
    }

    public function show()
    {
        $html = '<div class="box">
        <div class="hor-scroll">
            <table class="dynamic-grid" cellspacing="0" cellpadding="0">
                <tr id="attribute-options-table">
                    <th>' . $this->__('From') . '</th>
                    <th>' . $this->__('To') . '</th>
                    <th class="nobr a-center">' . $this->__('Is Default') . '</th>
                    <th>';
        if (!$this->getReadOnly()) {
            $html .= $this->getAddNewButtonHtml();
        }
        $html .= '</th>
                </tr>
                <tr class="no-display template" id="row-template">
                    <td><input name="option[value][{{id}}]" value="" class="input-text required-option" type="text" ' . ($this->getReadOnly() ? ' disabled="disabled"' : '') . '/></td>
                    <td class="a-center"><input class="input-text" type="text" name="option[order][{{id}}]" value="{{sort_order}}" ' . ($this->getReadOnly() ? ' disabled="disabled"' : '') . '/></td>
                    <td><input class="input-radio" type="radio" name="default[]" value="{{id}}" ' . ($this->getReadOnly() ? ' disabled="disabled"' : '') . '/></td>
                    <td class="a-left">
                        <input type="hidden" class="delete-flag" name="option[delete][{{id}}]" value="" />';
        if (!$this->getReadOnly()) {
            $html .= $this->getDeleteButtonHtml();
        }
        $html .= '</td>
                </tr>
            </table>
        </div>
    </div>';

        return $html;
    }
}