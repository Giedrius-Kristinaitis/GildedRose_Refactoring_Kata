<?php

namespace App;

class FixedQualityItemCategoryTest extends \PHPUnit\Framework\TestCase {

    public function testUpdateItemShouldNotChangeItemSellInDayValue() {
        $category = new FixedQualityItemCategory('fixed', 80);
        $item = new Item('Sulfuras', 0, 80);
        $category->updateItem($item);
        $this->assertEquals(0, $item->sell_in);
    }

    public function testUpdateItemShouldNotChangeItemQuality() {
        $category = new FixedQualityItemCategory('fixed', 80);
        $item = new Item('Sulfuras', 0, 80);
        $category->updateItem($item);
        $this->assertEquals(80, $item->quality);
    }

    public function testUpdateItemShouldResetItemQualityToFixedValue() {
        $category = new FixedQualityItemCategory('fixed', 80);
        $item = new Item('Sulfuras', 0, 50);
        $category->updateItem($item);
        $this->assertEquals(80, $item->quality);
    }
}