<?php

namespace App;

class ItemCategoryProviderTest extends \PHPUnit\Framework\TestCase {

    public function testGetCategoryShouldReturnNormalCategoryBecauseItemNotExceptional() {
        $normal_category = new ChangingQualityItemCategory('normal', [new QualityUpdateRate(1, 0)], 0, 50);
        $exceptional_item_categories = [];
        $exceptional_items = [];

        $category_provider = new ItemCategoryProvider($normal_category, $exceptional_item_categories, $exceptional_items);

        $this->assertEquals($normal_category, $category_provider->getItemCategory('non-exceptional item'));
    }
}