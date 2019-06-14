<?php 

namespace App;

/**
 * Updates items based on category information
 */
abstract class AbstractItemCategory {

    /**
     * @var string $name The name of the category
     */
    public $name;

    public function __construct($name) {
        $this->name = $name;
    }

    /**
     * Updates the given item's sell_in and quality values
     * 
     * @param Item $item The item to update
     */
    public abstract function updateItem($item);
}