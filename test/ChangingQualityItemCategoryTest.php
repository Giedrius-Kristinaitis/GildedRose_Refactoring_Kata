<?php

namespace App;

use \App\ChangingQualityItemCategory;

class ChangingQualityItemCategoryTest extends \PHPUnit\Framework\TestCase {

    public function testUpdateItemShouldDecreaseItemSellInValueByOne() {
        $category = new ChangingQualityItemCategory('changing', [new QualityUpdateRate(-1, 0)], 0, 50);
        $item = new Item('item', 0, 20);
        $category->updateItem($item);
        $this->assertEquals(-1, $item->sell_in);
    }

    public function testUpdateItemShouldNotMakeItemQualityLessThanMinQuality() {
        $category = new ChangingQualityItemCategory('changing', [new QualityUpdateRate(-5, 0)], 0, 50);
        $item = new Item('item', 1, 3);
        $category->updateItem($item);
        $this->assertEquals(0, $item->quality);
    }
}