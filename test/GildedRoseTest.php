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

    public function testItemQualityShouldNotGetGreaterThanFifty() {
        $category_provider = new class() implements ItemCategoryProviderInterface {
            public function getItemCategory($item_name) {
                return new ChangingQualityItemCategory('changing', [new QualityUpdateRate(1, PHP_INT_MIN)], 0, 50);
            }
        };
        
        $items = [new Item('Aged Brie', -2, 50)];
        $gilded_rose = new GildedRose($items, $category_provider);
        $gilded_rose->updateQuality();
        $this->assertEquals(50, $items[0]->quality);
    }

    public function testItemQualityShouldNotGetLowerThanZero() {
        $category_provider = new class() implements ItemCategoryProviderInterface {
            public function getItemCategory($item_name) {
                return new ChangingQualityItemCategory('changing', [new QualityUpdateRate(-1, PHP_INT_MIN)], 0, 50);
            }
        };
        
        $items = [new Item('Normal Item', 5, 0)];
        $gilded_rose = new GildedRose($items, $category_provider);
        $gilded_rose->updateQuality();
        $this->assertEquals(0, $items[0]->quality);
    }

    public function testItemQualityShouldDecreaseTwiceAsFastAfterSellDate() {
        $category_provider = new class() implements ItemCategoryProviderInterface {
            public function getItemCategory($item_name) {
                return new ChangingQualityItemCategory('changing', [new QualityUpdateRate(-1, -1), new QualityUpdateRate(-2, PHP_INT_MIN)], 0, 50);
            }
        };
        
        $items = [new Item('Normal Item', -1, 10)];
        $gilded_rose = new GildedRose($items, $category_provider);
        $gilded_rose->updateQuality();
        $this->assertEquals(8, $items[0]->quality);
    }

    public function testBackstagePassQualityShouldIncreaseByOne() {
        $category_provider = new class() implements ItemCategoryProviderInterface {
            public function getItemCategory($item_name) {
                return new FixedQualityAfterSellInItemCategory('changing', 0, [new QualityUpdateRate(1, 10), new QualityUpdateRate(2, 5), new QualityUpdateRate(3, -1)], 0, 50);
            }
        };
        
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 20, 10)];
        $gilded_rose = new GildedRose($items, $category_provider);
        $gilded_rose->updateQuality();
        $this->assertEquals(11, $items[0]->quality);
    }

    public function testBackstagePassQualityShouldIncreaseByTwo() {
        $category_provider = new class() implements ItemCategoryProviderInterface {
            public function getItemCategory($item_name) {
                return new FixedQualityAfterSellInItemCategory('changing', 0, [new QualityUpdateRate(1, 10), new QualityUpdateRate(2, 5), new QualityUpdateRate(3, -1)], 0, 50);
            }
        };
        
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 7, 10)];
        $gilded_rose = new GildedRose($items, $category_provider);
        $gilded_rose->updateQuality();
        $this->assertEquals(12, $items[0]->quality);
    }

    public function testBackstagePassQualityShouldIncreaseByThree() {
        $category_provider = new class() implements ItemCategoryProviderInterface {
            public function getItemCategory($item_name) {
                return new FixedQualityAfterSellInItemCategory('changing', 0, [new QualityUpdateRate(1, 10), new QualityUpdateRate(2, 5), new QualityUpdateRate(3, -1)], 0, 50);
            }
        };
        
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 3, 10)];
        $gilded_rose = new GildedRose($items, $category_provider);
        $gilded_rose->updateQuality();
        $this->assertEquals(13, $items[0]->quality);
    }

    public function testBackstagePassQualityShouldDropToZeroAfterSellDate() {
        $category_provider = new class() implements ItemCategoryProviderInterface {
            public function getItemCategory($item_name) {
                return new FixedQualityAfterSellInItemCategory('changing', 0, [new QualityUpdateRate(1, 10), new QualityUpdateRate(2, 5), new QualityUpdateRate(3, -1)], 0, 50);
            }
        };
        
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', -1, 10)];
        $gilded_rose = new GildedRose($items, $category_provider);
        $gilded_rose->updateQuality();
        $this->assertEquals(0, $items[0]->quality);
    }
}
