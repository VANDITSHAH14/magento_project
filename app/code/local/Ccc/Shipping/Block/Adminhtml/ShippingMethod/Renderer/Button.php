d<?php
class Ccc_Shipping_Block_Adminhtml_Shippingmethod_Renderer_Button extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        // $rates = $row->getShippingAmount();
        $whiteglovedelivery = Mage::getStoreConfig('carriers/whiteglovedelivery');
        $rates = unserialize($whiteglovedelivery['shippingamountbasedonsubtotal']);
        $formattedRates = [];
        $index = 1;

        foreach ($rates as $rate) {
            $formattedRates[$index] = [
                'from' => (int) str_replace('+', '', $rate['from']),
                'to' => isset($rate['to']) && $rate['to'] !== '' ? (int) $rate['to'] : 0,
                'price' => (float) $rate['price']
            ];
            $index++;
        }

        $jsonFormattedRates = json_encode($formattedRates);
        return '<button id="update-button">update</button>
                <div id="popup" class="popup">
                    <div class="popup-header">
                        <span class="close-btn" id="closePopupButton">&times</span>
                        <h2>Shipping Rates</h2>
                        <div id="popup-content"></div>
                    </div>
                </div>
        <script>
            var rateInstance = new UpdateRate("update-button" , ' . $jsonFormattedRates . ', "popup","popup-content","closePopupButton");
        </script>';

    }

}