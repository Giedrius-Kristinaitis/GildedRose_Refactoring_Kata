<?php

namespace App;

class GildedRoseTest extends \PHPUnit\Framework\TestCase {
    
    public function testLegendaryItemShouldNotChangeQualityBeforeSellDate() {
        $category_provider = new class() implements ItemCategoryProviderInterface {
            public function getItemCategory($item_name) {
                return new FixedQualityItemCategory('fixed', 80);
            }
        };
        
        $items = [new Item('legendary item', 10, 80)];
        $gilded_rose = new GildedRose($items, $category_provider);
        $this->assertEquals(80, $items[0]->quality);
    }
}
