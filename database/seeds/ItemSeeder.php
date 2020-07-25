<?php

use App\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the seeder for the items table.
     *
     * @return void
     */
    public function run()
    {
        factory(Item::class, 100)->create();
    }
}
