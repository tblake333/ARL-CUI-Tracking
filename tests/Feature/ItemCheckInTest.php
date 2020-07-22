<?php

namespace Tests\Feature;

use App\Item;
use App\Movement;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemCheckInTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic check in functionality
     *
     * @return void
     */
    public function test_can_check_in_item()
    {
        // Ensure movement table is empty
        $this->assertCount(0, Movement::all(), 'Movement table not empty! Be sure to use RefreshDatabase when testing.');

        $item = factory(Item::class)->create();
        $user = factory(User::class)->create();

        $item->checkOut($user);

        $this->assertCount(1, Movement::all());

        $response = $this->post("/check-in/$item->id");

        $response->assertSessionHasNoErrors();

        $this->assertCount(2, Movement::all());
        $this->assertEquals(Movement::latest('id')->first()->barcode, $item->barcode);
        $this->assertEquals(Movement::latest('id')->first()->badge_number, $user->badge_number);
        $this->assertEquals(Movement::latest('id')->first()->type, 'in');
    }

    /**
     * Test check-in of invalid items are handled properly
     */
    public function test_invalid_items_cannot_be_checked_out()
    {
        // TODO: Consider redirecting to add item?

        $this->assertCount(0, Movement::all(), 'Movement table not empty! Be sure to use RefreshDatabase when testing.');

        // Attempt to hit endpoint with invalid item id
        $response = $this->post('/check-in/1234');

        $response->assertStatus(404);

        // Ensure movement was not created
        $this->assertCount(0, Movement::all());
    }

    /**
     * Test check-in of never before checked-out items is handled properly
     */
    public function test_never_before_checked_out_items_cannot_be_checked_in()
    {
        $this->assertCount(0, Movement::all(), 'Movement table not empty! Be sure to use RefreshDatabase when testing.');

        $item = factory(Item::class)->create();

        // Attempt to hit endpoint with item that has never been checked-out
        $response = $this->post("/check-in/$item->id");

        $response->assertStatus(404);

        // Ensure movement was not created
        $this->assertCount(0, Movement::all());
    }

    /**
     * Test check-in of already checked-in items is handled properly
     */
    public function test_already_checked_in_items_cannot_be_checked_in()
    {
        $this->assertCount(0, Movement::all(), 'Movement table not empty! Be sure to use RefreshDatabase when testing.');

        $item = factory(Item::class)->create();
        $user = factory(User::class)->create();

        // Check out item
        $item->checkOut($user);
        $item->checkIn();

        // Ensure movements were created by check-out and check-in events
        $this->assertCount(2, Movement::all());

        // Attempt to hit endpoint with invalid item id
        $response = $this->post("/check-in/$item->id");

        $response->assertStatus(404);

        // Ensure movement was not created
        $this->assertCount(2, Movement::all());
    }
}
