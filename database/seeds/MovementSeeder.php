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
        $items = Item::all();
        
        $this->createMovements($items, $users, 200);
    }

    /**
     * Simulate movements for an item
     * 
     * @param $items
     * @param $users
     * @param int $amount
     * 
     * @return void
     */
    private function createMovements($items, $users, $amount)
    {
        for ($i = 0; $i < $amount; $i++) {
            $item = $items->random();

            if ($item->getStatus() === 'in') {
                $user = $users->random();
                $item->checkOut($user);
            } else {
                $item->checkIn();
            }

        }
    }
}
