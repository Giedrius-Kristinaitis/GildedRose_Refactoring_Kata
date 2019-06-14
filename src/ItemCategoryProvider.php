<?php

namespace App;

/**
 * Provides categories for items
 */
class ItemCategoryProvider implements ItemCategoryProviderInterface {

    /**
     * @var AbstractItemCategory $normal_item_category The category of items that require no
     *                                                 special treatment
     */
    private $normal_item_category;

    /**
     * @var AbstractItemCategory[] $exceptional_item_categories The categories of items that 
     *                                                          require special treatment
     */
    private $exceptional_item_categories;

    /**
     * @var array $exceptional_items Names of all exceptional items and name of their category
     */
    private $exceptional_items;

    public function __construct($normal_item_category, $exceptional_item_categories, $exceptional_items) {
        $this->normal_item_category = $normal_item_category;
        $this->exceptional_item_categories = $exceptional_item_categories;
        $this->exceptional_items = $exceptional_items;
    }

    /**
     * Gets the category of the specified item
     * 
     * @param string $item_name The name of the item
     * 
     * @return AbstractItemCategory The category of the item
     */
    public function getItemCategory($item_name) {
        if (array_key_exists($item_name, $this->exceptional_items)) {
            // the item requires special treatment
            $category = $this->getExceptionalItemCategoryByName($this->exceptional_items[$item_name]);

            if ($category == NULL) {
                return $this->normal_item_category;
            }
            
            return $category;
        }

        return $this->normal_item_category;
    }

    /**
     * Gets the exceptional item category with the specified name
     * 
     * @param string $category_name The name of the category
     * 
     * @return AbstractItemCategory Item category, null if not found
     */
    private function getExceptionalItemCategoryByName($category_name) {
        foreach ($this->exceptional_item_categories as $item_category) {
            if ($item_category->name == $category_name) {
                return $item_category;
            }
        }

        return NULL;
    }
}