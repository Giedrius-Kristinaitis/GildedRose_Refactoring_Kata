<?php

namespace App;

/**
 * Provides categories for items
 */
interface ItemCategoryProviderInterface {

    /**
     * Gets the category of the specified item
     * 
     * @param string $name The name of the item
     * 
     * @return AbstractItemCategory The category of the item
     */
    public function getItemCategory($item_name);
}