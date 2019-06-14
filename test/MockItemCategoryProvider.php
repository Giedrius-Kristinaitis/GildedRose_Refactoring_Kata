<?php

namespace App;

use \App\ItemCategoryProviderInterface;

class MockItemCategoryProvider implements ItemCategoryProviderInterface {

    private $mock_category;

    public function __construct($mock_category) {
        $this->mock_category = $mock_category;
    }

    public function getItemCategory($item_name) {
        return $this->mock_category;
    }
}