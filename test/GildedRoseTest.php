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

    public function testLegendaryItemShouldResetToFixedQuality() {
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
                return new ChangingQualityItemCategory('changing', [new QualityUpdateRate(-1, 0), new QualityUpdateRate(-2, PHP_INT_MIN)], 0, 50);
            }
        };
        
        $items = [new Item('Normal Item', 0, 10)];
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
                return new FixedQualityAfterSellInItemCategory('changing', 0, [new QualityUpdateRate(1, 10), new QualityUpdateRate(2, 5), new QualityUpdateRate(3, 0)], 0, 50);
            }
        };
        
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 0, 10)];
        $gilded_rose = new GildedRose($items, $category_provider);
        $gilded_rose->updateQuality();
        $this->assertEquals(0, $items[0]->quality);
    }

    public function testConjuredItemQualityShouldDegradeTwiceAsFastAsNormalItems() {
        $category_provider = new class() implements ItemCategoryProviderInterface {
            public function getItemCategory($item_name) {
                return new ChangingQualityItemCategory('changing', [new QualityUpdateRate(-2, PHP_INT_MIN)], 0, 50);
            }
        };
        
        $items = [new Item('Conjured Mana Cake', 5, 10)];
        $gilded_rose = new GildedRose($items, $category_provider);
        $gilded_rose->updateQuality();
        $this->assertEquals(8, $items[0]->quality);
    }

    public function testConjuredItemQualityShouldDegradeTwiceAsFastAfterSellDate() {
        $category_provider = new class() implements ItemCategoryProviderInterface {
            public function getItemCategory($item_name) {
                return new ChangingQualityItemCategory('changing', [new QualityUpdateRate(-2, 0), new QualityUpdateRate(-4, PHP_INT_MIN)], 0, 50);
            }
        };
        
        $items = [new Item('Conjured Mana Cake', 0, 10)];
        $gilded_rose = new GildedRose($items, $category_provider);
        $gilded_rose->updateQuality();
        $this->assertEquals(6, $items[0]->quality);
    }

    public function testUpdateQualityShouldUpdateAllItems() {
        $category_provider = new class() implements ItemCategoryProviderInterface {
            public function getItemCategory($item_name) {
                return new ChangingQualityItemCategory('changing', [new QualityUpdateRate(-1, 0)], 0, 50);
            }
        };
        
        $items = [new Item('Item 1', 5, 10), new Item('Item 2', 6, 12), new Item('Item 3', 7, 14)];
        $gilded_rose = new GildedRose($items, $category_provider);
        $gilded_rose->updateQuality();
        $this->assertEquals(9, $items[0]->quality);
        $this->assertEquals(11, $items[1]->quality);
        $this->assertEquals(13, $items[2]->quality);
    }
}
