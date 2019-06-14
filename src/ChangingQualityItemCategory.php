<?php

namespace App;

/**
 * Updates items that have quality that changes over time
 */
class ChangingQualityItemCategory extends AbstractItemCategory {

    /**
	 * @var QualityUpdateRate[] $quality_update_rates The rates at which the quality of items that belong to this category change
	 */
	public $quality_update_rates;
	
	/**
	 * @var int $min_quality The lowest possible quality that an item of this category can have
	 */
	public $min_quality;
	
	/**
	 * @var int $max_quality The highest possible quality that an item of this category can have
	 */
	public $max_quality;
	
	public function __construct($name, $quality_update_rates, $min_quality, $max_quality) {
		parent::__construct($name);
		
		$this->quality_update_rates = $quality_update_rates;
		$this->min_quality = $min_quality;
		$this->max_quality = $max_quality;
	}
    
    /**
     * Updates the given item's sell_in day and quality
     * 
     * @param Item $item The item to update
     */
	public function updateItem($item) {
		$item->quality += $this->getUpdateRateValue($item->sell_in--);

		if ($item->quality < $this->min_quality) {
			$item->quality = $this->min_quality;
		} else if ($item->quality > $this->max_quality) {
			$item->quality = $this->max_quality;
		}
	}
    
    /**
     * Gets the quality change of an item of this category on the given day
     * 
     * @param int $day The item's current sell_in day value
     * 
     * @return int Item's quality change (can be positive or negative)
     */
	private function getUpdateRateValue($day) {
		$update_rate_value = 0;
		$previous_rate_day = PHP_INT_MIN;
		
		foreach ($this->quality_update_rates as $update_rate) {
			if ($update_rate->applied_down_to_day < $day && $update_rate->applied_down_to_day >= $previous_rate_day) {
				$update_rate_value = $update_rate->update_rate;
				$previous_rate_day = $update_rate->applied_down_to_day;
			}
		}
		
		return $update_rate_value;
	}
}