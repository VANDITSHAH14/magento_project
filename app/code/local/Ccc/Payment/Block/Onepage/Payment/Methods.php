<?php
class Ccc_Payment_Block_Onepage_Payment_Methods extends Mage_Checkout_Block_Onepage_Payment_Methods
{
    public function getBrand()
    {
        $quote = $this->getQuote();
        $brandId = [];
        if ($quote && $quote->getId() && $quote->getItemsCount()) {
            foreach ($quote->getAllVisibleItems() as $item) {
                $brandId[] = $item->getBrand();
            }
        }
        return $brandId;
    }
}