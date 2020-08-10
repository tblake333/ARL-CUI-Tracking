<?php

namespace Tests\Unit;

use App\Item;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemSearchUnitTest extends TestCase
{
    use RefreshDatabase;

    // TODO: Handle conflicts in case random barcodes end up being the same (rare case)

    /**
     * Test item can be searched in all fields.
     *
     * @return void
     */
    public function test_single_item_can_be_searched_from_all_fields()
    {
        $item = factory(Item::class)->create();

        foreach ($item->getFillable() as $field) {
            $results = Item::search($item->$field);
            if ($field === 'owner') {
                $results = Item::search($item->owner_badge_number);
            }
            $this->assertCount(1, $results);
        }
    }

    public function test_multiple_items_can_be_searched_from_all_fields()
    {
        $item = factory(Item::class)->create();
        $numberOfItems = 10;

        // Populate half of  the items with matching values of $item
        for ($i = 0; $i < $numberOfItems; $i++) {
            $newItem = Item::create($this->defaultData());
            if ($i % 2 === 0) {
                $this->copyFields($newItem, $item);
            }
        }

        // Half of the new items as well as the original copy
        $expectedResults = $numberOfItems/2 + 1;

        foreach ($item->getFillable() as $field) {
            $results = null;
            if ($field === 'owner') {
                $results = Item::search($item->owner_badge_number);
            } else {
                $results = Item::search($item->$field);
            }
            if ($field !== 'barcode') {
                $this->assertCount($expectedResults, $results);
            }
        }
    }

    /**
     * Copy fields from one item to another
     * 
     * @param $toModify Item to modify
     * @param $toCopy Item to copy
     */
    private function copyFields($toModify, $toCopy)
    {
        foreach ($toModify->getFillable() as $field) {
            if ($field === 'owner') {
                $toModify->owner_badge_number = $toCopy->owner_badge_number;
            } else if ($field !== 'barcode') {
                $toModify->$field = $toCopy->$field;
            }
        }
        $toModify->save();
    }

    private function defaultData()
    {
        return [
            'barcode' => 'CUI' . mt_rand(0, 999999),
            'title' => 'default',
            'type' => 'default',
            'location' => 'default',
            'owner' => [
                'badge_number' => factory(User::class)->create()->badge_number
            ]
        ];
    }
}
