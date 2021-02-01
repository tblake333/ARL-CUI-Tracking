<?php

namespace Tests\Unit;

use App\Item;
use App\Movement;
use App\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemMovementTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Test checkOut() method
     *
     * @return void
     */
    public function test_can_check_out_item()
    {
        $item = factory(Item::class)->create();
        $user = factory(User::class)->create();

        $location = $this->faker()->word();

        // Ensure movement table is empty
        $this->assertCount(0, Movement::all(), 'Movement table is not empty! Be sure to use RefreshDatabase when testing.');

        $item->checkOut($user, $location);

        $this->assertCount(1, Movement::all());
        $this->assertEquals(Movement::first()->barcode, $item->barcode);
        $this->assertEquals(Movement::first()->badge_number, $user->badge_number);
        $this->assertEquals(Movement::first()->type, 'out');
    }

    /**
     * Test checkIn() method
     *
     * @return void
     */
    public function test_can_check_in_item()
    {
        $item = factory(Item::class)->create();
        $user = factory(User::class)->create();

        $location = $this->faker()->word();

        // Ensure movement table is empty
        $this->assertCount(0, Movement::all(), 'Movement table is not empty! Be sure to use RefreshDatabase when testing.');

        $item->checkOut($user, $location);
        $item->checkIn();

        $this->assertCount(2, Movement::all());
        $this->assertEquals(Movement::latest('id')->first()->barcode, $item->barcode);
        $this->assertEquals(Movement::latest('id')->first()->badge_number, $user->badge_number);
    }

    /**
     * Test default item status when item has no movement records
     */
    public function test_item_status_in_when_not_yet_checked_out()
    {
        $item = factory(Item::class)->create();
        
        $this->assertEquals('in', $item->getStatus());
    }

    /**
     * Test item status is correct after check-out
     */
    public function test_item_status_out_when_checked_out()
    {
        $item = factory(Item::class)->create();
        $user = factory(User::class)->create();
        $location = $this->faker()->word();

        $item->checkOut($user, $location);

        $this->assertEquals('out', $item->getStatus());
    }

    public function test_item_status_in_when_checked_in()
    {
        $item = factory(Item::class)->create();
        $user = factory(User::class)->create();
        $location = $this->faker()->word();

        $item->checkOut($user, $location);
        $item->checkIn();

        $this->assertEquals('in', $item->getStatus());
    }

    /**
     * Test check-in exception when attemtping to check-in an item that is already checked-in
     */
    public function test_exception_thrown_if_item_never_checked_out_when_check_in()
    {
        $this->expectException(Exception::class);
        
        $item = factory(Item::class)->create();
        $user = factory(User::class)->create();

        $item->checkIn();
    }

    public function test_exception_thrown_if_item_already_checked_out_when_check_out()
    {
        $this->expectException(Exception::class);
        
        $item = factory(Item::class)->create();
        $user = factory(User::class)->create();
        $location = $this->faker()->word();

        $item->checkOut($user, $location);
        $item->checkOut($user, $location);
    }

    /**
     * Test check-in exception when attemtping to check-in an item that is already checked-in
     */
    public function test_exception_thrown_if_item_already_checked_in_when_check_in()
    {
        $this->expectException(Exception::class);
        
        $item = factory(Item::class)->create();
        $user = factory(User::class)->create();
        $location = $this->faker()->word();

        $item->checkOut($user, $location);
        $item->checkIn();
        $item->checkIn();
    }

    public function test_checked_out_items_empty_when_no_records()
    {
        $user = factory(User::class)->create();
        $this->assertEmpty($user->getCheckedOutItems());
    }

    public function test_checked_out_items_not_empty_when_item_checked_out()
    {
        $item = factory(Item::class)->create();
        $user = factory(User::class)->create();
        $location = $this->faker()->word();

        // Check out item
        $item->checkOut($user, $location);
        
        $this->assertCount(1, $user->getCheckedOutItems());
    }

    public function test_checked_out_items_empty_when_item_checked_in()
    {
        $item = factory(Item::class)->create();
        $user = factory(User::class)->create();
        $location = $this->faker()->word();

        // Check out item
        $item->checkOut($user, $location);
        $item->checkIn();
        
        $this->assertCount(0, $user->getCheckedOutItems());
    }

}
