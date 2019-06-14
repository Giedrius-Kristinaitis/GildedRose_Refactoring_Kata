<?php

namespace App;

/**
 * Updates items of which the quality is a fixed value when the item's sell in day hits 0
 */
class FixedQualityAfterSellInItemCategory extends ChangingQualityItemCategory {

    /**
     * @var int $quality_after_sell_in The items' quality after sell in day hits 0
     */
    public $quality_after_sell_in;

    public function __construct($name, $quality_after_sell_in, $quality_update_rates, $min_quality, $max_quality) {
        parent::__construct($name, $quality_update_rates, $min_quality, $max_quality);

        $this->quality_after_sell_in = $quality_after_sell_in;
    }

    /**
     * Updates the given item's sell_in day and quality
     * 
     * @param Item $item The item to update
     */
	public function updateItem($item) {
        if ($item->sell_in <= 0) {
            if ($item->quality != $this->quality_after_sell_in) {
                $item->quality = $this->quality_after_sell_in;
            }

            $item->sell_in--;
        } else {
            parent::updateItem($item);
        }
	}
}