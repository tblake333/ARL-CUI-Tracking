<?php

use App\Events\ItemEditedEvent;
use App\Item;
use App\User;
use Illuminate\Database\Seeder;

class ChangeSeeder extends Seeder
{
    /**
     * Run the seeder for the changes table.
     *
     * @return void
     */
    public function run()
    {
        $allItems = Item::all();
        $users = User::all();

        $items = $allItems->random($allItems->count()/3);

        foreach ($items as $item) {
            $user = $users->random();
            $this->createChanges($item, $user);
        }
    }

    /**
     * Simulate item edit event for a given item and user
     * 
     * @param $item
     * @param $user
     */
    private function createChanges($item, $user)
    {
        $newItem = factory(Item::class)->make();

        $fillableFields = $newItem->getFillable();
        $changedFields = $this->selectRandomElements($fillableFields, count($fillableFields));

        foreach ($changedFields as $field) {

            if ($field === 'owner') {
                $item->owner = $newItem->owner->toArray();
            } else {
                $item->$field = $newItem->$field;
            }
            
        }

        event(new ItemEditedEvent($item, $user));

        $item->save();
    }

    /**
     * Select a random number of elements from an array.
     * 
     * @param array $arr
     * 
     * @return array Containing the random number of elements in the array
     */
    private function selectRandomElements($arr, $max)
    {
        $result = [];
        $amount = mt_rand(0, $max);
        shuffle($arr);

        for ($i = 0; $i < $amount; $i++) {
            $result[] = $arr[$i];
        }

        return $result;
    }
}
