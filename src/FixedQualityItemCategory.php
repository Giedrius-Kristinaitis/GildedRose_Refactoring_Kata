<?php

namespace App;

/**
 * Updates items that have a fixed quality at all times
 */
class FixedQualityItemCategory extends AbstractItemCategory {

    /**
	 * @var int $quality_value The fixed quality value for items of this category
	 */
    public $quality_value;

    public function __construct($name, $quality_value) {
        parent::__construct($name);
        
        $this->quality_value = $quality_value;
    }

    /**
     * Updates the given item by making sure it's quality stays the same.
     * Doesn't change item's sell_in day value
     * 
     * @param Item $item The item to update
     */
    public function updateItem($item) {
        if ($item->quality != $this->quality_value) {
			$item->quality = $this->quality_value;
		}
    }
}