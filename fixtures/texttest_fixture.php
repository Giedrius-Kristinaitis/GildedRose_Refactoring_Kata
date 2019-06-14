<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\GildedRose;
use App\Item;
use App\ItemCategoryProvider;
use App\FixedQualityItemCategory;
use App\FixedQualityAfterSellInItemCategory;
use App\ChangingQualityItemCategory;
use App\QualityUpdateRate;

echo "OMGHAI!\n";

$items = array(
    new Item('+5 Dexterity Vest', 10, 20),
    new Item('Aged Brie', 2, 0),
    new Item('Elixir of the Mongoose', 5, 7),
    new Item('Sulfuras, Hand of Ragnaros', 0, 80),
    new Item('Sulfuras, Hand of Ragnaros', -1, 80),
    new Item('Backstage passes to a TAFKAL80ETC concert', 15, 20),
    new Item('Backstage passes to a TAFKAL80ETC concert', 10, 49),
    new Item('Backstage passes to a TAFKAL80ETC concert', 5, 49),
    new Item('Conjured Mana Cake', 3, 6)
);

// create the item category provider
$normal_item_category = new ChangingQualityItemCategory('Category Normal', [new QualityUpdateRate(-1, -1), new QualityUpdateRate(-2, PHP_INT_MIN)], 0, 50);

$exceptional_item_categories = [
    new FixedQualityItemCategory('Category Sulfuras', 80),
    new ChangingQualityItemCategory('Category Aged Brie', [new QualityUpdateRate(1, PHP_INT_MIN)], 0, 50),
    new FixedQualityAfterSellInItemCategory('Category Backstage pass', 0, [new QualityUpdateRate(1, 10), new QualityUpdateRate(2, 5), new QualityUpdateRate(3, -1)], 0, 50),
    new ChangingQualityItemCategory('Category Conjured', [new QualityUpdateRate(-2, PHP_INT_MIN)], 0, 50)
];

$exceptional_items = [
    'Sulfuras, Hand of Ragnaros' => 'Category Sulfuras',
    'Aged Brie' => 'Category Aged Brie',
    'Backstage passes to a TAFKAL80ETC concert' => 'Category Backstage pass',
    'Conjured Mana Cake' => 'Category Conjured'
];

$category_provider = new ItemCategoryProvider($normal_item_category, $exceptional_item_categories, $exceptional_items);

// initialize the Gilded Rose
$app = new GildedRose($items, $category_provider);

// perform test
$days = 2;
if (count($argv) > 1) {
    $days = (int) $argv[1];
}

for ($i = 0; $i < $days; $i++) {
    echo("-------- day $i --------\n");
    echo("name, sellIn, quality\n");
    foreach ($items as $item) {
        echo $item . PHP_EOL;
    }
    echo PHP_EOL;
    $app->updateQuality();
}
