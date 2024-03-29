<?php

namespace App;

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

    public function testUpdateItemShouldNotMakeItemQualityGreaterThanMaxQuality() {
        $category = new ChangingQualityItemCategory('changing', [new QualityUpdateRate(5, 0)], 0, 50);
        $item = new Item('item', 1, 46);
        $category->updateItem($item);
        $this->assertEquals(50, $item->quality);
    }

    public function testUpdateItemShouldChangeItemQuality() {
        $category = new ChangingQualityItemCategory('changing', [new QualityUpdateRate(-1, 0)], 0, 50);
        $item = new Item('item', 1, 46);
        $category->updateItem($item);
        $this->assertEquals(45, $item->quality);
    }
}