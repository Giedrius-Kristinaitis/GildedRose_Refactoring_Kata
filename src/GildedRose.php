<?php

namespace App;

final class GildedRose {

    /**
     * @var Item[] $items All items in the Gilded Rose
     */
    private $items = [];

    /**
     * @var ItemCategoryProviderInterface $item_category_provider Provides categories for items
     */
    private $item_category_provider;

    public function __construct($items, $item_category_provider) {
        $this->items = $items;
        $this->item_category_provider = $item_category_provider;
    }

    /**
     * Updates the quality of all items in the Gilded Rose
     */
    public function updateQuality() {
        foreach ($this->items as $item) {
            // get the item's category and update the item
            $item_category = $this->item_category_provider->getItemCategory($item->name);
            $item_category->updateItem($item);
        }
    }
}

