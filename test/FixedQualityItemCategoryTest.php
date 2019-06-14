<?php

namespace App;

use \App\FixedQualityItemCategory;

class FixedQualityItemCategoryTest extends \PHPUnit\Framework\TestCase {

    public function testUpdateItemShouldNotChangeItemSellInDayValue() {
        $category = new FixedQualityItemCategory('fixed', 80);

        $item = new Item('Sulfuras', 0, 80);

        $category->updateItem($item);

        $this->assertEquals(0, $item->sell_in);
    }
}