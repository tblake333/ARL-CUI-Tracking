<?php

namespace Tests\Feature;

use App\Item;
use App\User;
use App\Movement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemCheckOutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test basic check out functionality
     *
     * @return void
     */
    public function test_existing_user_can_check_out_item()
    {
        // Ensure movement table is empty
        $this->assertCount(0, Movement::all(), 'Movement table not empty! Be sure to use RefreshDatabase when testing.');

        // Create item in database
        $item = factory(Item::class)->create();

        // Create user in database
        $user = factory(User::class)->create();

        // Hit endpoint with valid data to check out an item
        $response = $this->post("/check-out/$item->id", $this->data($user));

        $response->assertSessionHasNoErrors();

        $this->assertCount(1, Movement::all());
        $this->assertEquals(Movement::first()->barcode, $item->barcode);
        $this->assertEquals(Movement::first()->badge_number, $user->badge_number);
        $this->assertEquals(Movement::first()->type, 'out');
    }

    /**
     * Test badge number requirement
     * 
     * @return void
     */
    public function test_badge_number_required_when_check_out()
    {
        // Create item in database
        $item = factory(Item::class)->create();

        // Create user in database
        $user = factory(User::class)->create();

        // Hit endpoint to check out item without a badge number
        $response = $this->post("/check-out/$item->id", array_merge($this->data($user), ['badge_number' => '']));

        $response->assertSessionHasErrors('badge_number');
    }

    /**
     * Test first name requirement when existing user checks out an item
     * 
     * @return void
     */
    public function test_first_name_not_required_when_existing_user_check_out()
    {
        // Ensure movement table is empty
        $this->assertCount(0, Movement::all(), 'Movement table not empty! Be sure to use RefreshDatabase when testing.');

        // Create item in database
        $item = factory(Item::class)->create();

        // Create user in database
        $user = factory(User::class)->create();

        // Hit endpoint to check out item without a first name
        $response = $this->post("/check-out/$item->id", $this->data($user));

        $response->assertSessionHasNoErrors();

        $this->assertCount(1, Movement::all());
        $this->assertEquals(Movement::first()->barcode, $item->barcode);
        $this->assertEquals(Movement::first()->badge_number, $user->badge_number);
    }

    /**
     * Test last name requirement when existing user checks out an item
     * 
     * @return void
     */
    public function test_last_name_not_required_when_existing_user_check_out()
    {
        // Ensure movement table is empty
        $this->assertCount(0, Movement::all(), 'Movement table not empty! Be sure to use RefreshDatabase when testing.');

        // Create item in database
        $item = factory(Item::class)->create();

        // Create user in database
        $user = factory(User::class)->create();

        // Hit endpoint to check out item without a last name
        $response = $this->post("/check-out/$item->id", $this->data($user));

        $response->assertSessionHasNoErrors();

        $this->assertCount(1, Movement::all());
        $this->assertEquals(Movement::first()->barcode, $item->barcode);
        $this->assertEquals(Movement::first()->badge_number, $user->badge_number);
    }

    /**
     * Test new user creation when checking an item out as a new user
     * 
     * @return void
     */
    public function test_creates_new_user_when_new_badge_number_check_out()
    {
        $this->assertCount(0, User::all(), 'Users table is not empty! Be sure to use RefreshDatabase when testing.');

        // Create item in database
        $item = factory(Item::class)->create();

        // Ensure new user was created by item factory in order for the item to have an owner
        $this->assertCount(1, User::all());

        // Create instance of user model, but do not add to database
        $user = factory(User::class)->make();

        // Hit endpoint to check out item with a new badge number
        $response = $this->post("/check-out/$item->id", $this->data($user, true));

        $response->assertSessionHasNoErrors();

        // Ensure new user was created by checking out item as a new user
        $this->assertCount(2, User::all());
        $this->assertTrue((bool)User::where('badge_number', $user->badge_number)->first());
    }

    /**
     * Test first name requirement when checking an item out as a new user
     * 
     * @return void
     */
    public function test_first_name_required_when_new_badge_number_check_out()
    {
        // Create item in database
        $item = factory(Item::class)->create();

        // Create instance of user model, but do not add to database
        $user = factory(User::class)->make();

        // Hit endpoint to check out item with a new badge number, but without a first name
        $response = $this->post("/check-out/$item->id", $this->data($user));

        $response->assertSessionHasErrors('first_name');
    }

    /**
     * Test last name requirement when checking an item out as a new user
     * 
     * @return void
     */
    public function test_last_name_required_when_new_badge_number_check_out()
    {
        // Create item in database
        $item = factory(Item::class)->create();

        // Create instance of user model, but do not add to database
        $user = factory(User::class)->make();

        // Hit endpoint to check out item with a new badge number, but without a last name
        $response = $this->post("/check-out/$item->id", $this->data($user));

        $response->assertSessionHasErrors('last_name');
    }

    /**
     * Test consistent check-out functionality when item has recorded movements before
     */
    public function test_can_check_out_item_when_item_checked_in()
    {
        $this->assertCount(0, Movement::all(), 'Movement table not empty! Be sure to use RefreshDatabase when testing.');
        
        $item = factory(Item::class)->create();
        $user = factory(User::class)->create();

        $item->checkOut($user);
        $item->checkIn();

        $this->assertCount(2, Movement::all());

        $response = $this->post("/check-out/$item->id", $this->data($user));

        $response->assertSessionHasNoErrors();
        $this->assertCount(3, Movement::all());
        $this->assertEquals(Movement::latest('id')->first()->barcode, $item->barcode);
        $this->assertEquals(Movement::latest('id')->first()->badge_number, $user->badge_number);
        $this->assertEquals(Movement::latest('id')->first()->type, 'out');
    }

    /**
     * Test check-out of invalid items are handled properly
     */
    public function test_invalid_items_cannot_be_checked_out()
    {
        $this->assertCount(0, Movement::all(), 'Movement table not empty! Be sure to use RefreshDatabase when testing.');

        $user = factory(User::class)->create();

        // Attempt to hit endpoint with invalid item id
        $response = $this->post('/check-out/1234', $this->data($user));

        $response->assertStatus(404);

        // Ensure movement was not created
        $this->assertCount(0, Movement::all());
    }

    /**
     * Test already checked-out items are handled properly
     */
    public function test_already_checked_out_items_cannot_be_checked_out()
    {
        $this->assertCount(0, Movement::all(), 'Movement table not empty! Be sure to use RefreshDatabase when testing.');

        $item = factory(Item::class)->create();
        $user = factory(User::class)->create();

        // Check out item
        $item->checkOut($user);

        // Ensure movement was created by check-out
        $this->assertCount(1, Movement::all());

        // Attempt to hit endpoint with invalid item id
        $response = $this->post("/check-out/$item->id", $this->data($user));

        $response->assertStatus(404);

        // Ensure movement was not created
        $this->assertCount(1, Movement::all());
    }


    /**
     * Correct data for checking-out an item given a user, and if the user
     * new to the database.
     * 
     * @param App\User $user
     * @param bool $newUser
     * 
     * @return array
     */
    private function data($user, $newUser = false)
    {
        $result = ['badge_number' => $user->badge_number];

        if ($newUser) {
            $result['first_name'] = $user->first_name;
            $result['last_name'] = $user->last_name;
        }

        return $result;
    }
}
