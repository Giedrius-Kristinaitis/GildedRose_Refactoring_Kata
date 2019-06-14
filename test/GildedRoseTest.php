<?php

namespace App;

class GildedRoseTest extends \PHPUnit\Framework\TestCase {
    
    public function testLegendaryItemShouldNotChangeQualityBeforeSellDate() {
        $category_provider = new class() implements ItemCategoryProviderInterface {
            public function getItemCategory($item_name) {
                return new FixedQualityItemCategory('fixed', 80);
            }
        };

        $items = [new Item('Sulfuras, Hand of Ragnaros', 10, 80)];
        $gilded_rose = new GildedRose($items, $category_provider);
        $gilded_rose->updateQuality();
        $this->assertEquals(80, $items[0]->quality);
    }

    public function testLegendaryItemShouldNotChangeQualityAfterSellDate() {
        $category_provider = new class() implements ItemCategoryProviderInterface {
            public function getItemCategory($item_name) {
                return new FixedQualityItemCategory('fixed', 80);
            }
        };
        
        $items = [new Item('Sulfuras, Hand of Ragnaros', -1, 80)];
        $gilded_rose = new GildedRose($items, $category_provider);
        $gilded_rose->updateQuality();
        $this->assertEquals(80, $items[0]->quality);
    }

    public function testLegendaryItemShouldKeepResetToFixedQuality() {
        $category_provider = new class() implements ItemCategoryProviderInterface {
            public function getItemCategory($item_name) {
                return new FixedQualityItemCategory('fixed', 80);
            }
        };
        
        $items = [new Item('Sulfuras, Hand of Ragnaros', -1, 50)];
        $gilded_rose = new GildedRose($items, $category_provider);
        $gilded_rose->updateQuality();
        $this->assertEquals(80, $items[0]->quality);
    }

    public function testAgedBrieItemShouldIncreaseQualityByOneBeforeSellDay() {
        $category_provider = new class() implements ItemCategoryProviderInterface {
            public function getItemCategory($item_name) {
                return new ChangingQualityItemCategory('changing', [new QualityUpdateRate(1, PHP_INT_MIN)], 0, 50);
            }
        };
        
        $items = [new Item('Aged Brie', 10, 5)];
        $gilded_rose = new GildedRose($items, $category_provider);
        $gilded_rose->updateQuality();
        $this->assertEquals(6, $items[0]->quality);
    }

    public function testAgedBrieItemShouldIncreaseQualityByOneAfterSellDay() {
        $category_provider = new class() implements ItemCategoryProviderInterface {
            public function getItemCategory($item_name) {
                return new ChangingQualityItemCategory('changing', [new QualityUpdateRate(1, PHP_INT_MIN)], 0, 50);
            }
        };
        
        $items = [new Item('Aged Brie', -2, 5)];
        $gilded_rose = new GildedRose($items, $category_provider);
        $gilded_rose->updateQuality();
        $this->assertEquals(6, $items[0]->quality);
    }
}
