<?php

use App\Item;
use App\User;
use Illuminate\Database\Seeder;

class MovementSeeder extends Seeder
{
    /**
     * Run the seeder for the movements table.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $items = factory(Item::class, 10)->create();

        foreach ($items as $item) {
            $randomlySelectedUsers = $users->random(mt_rand(0, $users->count()/10));
            $this->createMovements($item, $randomlySelectedUsers);
        }
    }

    /**
     * Simulate movements for an item
     * 
     * @param App\Item $item
     * @param array $users
     * 
     * @return void
     */
    private function createMovements($item, $users)
    {
        foreach($users as $user) {
            $item->checkOut($user);
            $item->checkIn();
        }
    }
}
