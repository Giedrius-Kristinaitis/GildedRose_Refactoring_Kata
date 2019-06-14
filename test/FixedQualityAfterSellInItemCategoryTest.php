<?php

namespace App;

class FixedQualityAfterSellInItemCategoryTest extends \PHPUnit\Framework\TestCase {

    public function testUpdateItemShouldNotSetItemQualityToFixedBeforeSellDate() {
        $category = new FixedQualityAfterSellInItemCategory('fixed after', 10, [new QualityUpdateRate(-1, 0)], 0, 50);
        $item = new Item('item', 10, 20);
        $category->updateItem($item);
        $this->assertNotEquals(10, $item->quality);
    }

    public function testUpdateItemShouldSetItemQualityToFixedAfterSellDate() {
        $category = new FixedQualityAfterSellInItemCategory('fixed after', 10, [new QualityUpdateRate(-1, 0)], 0, 50);
        $item = new Item('item', -1, 20);
        $category->updateItem($item);
        $this->assertEquals(10, $item->quality);
    }
}