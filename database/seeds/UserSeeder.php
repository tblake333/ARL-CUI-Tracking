<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the seeds for the user table.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 70)->create();
    }
}
