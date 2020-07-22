<?php

namespace Tests\Feature;

use App\Item;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test ability to create item.
     *
     * @return void
     */
    public function test_can_create_item()
    {
        // Create User to handle owner
        $owner = factory(User::class)->create();

        // Ensure items table is cleared before adding user
        $this->assertCount(0, Item::all(), 'Database is not empty! Be sure to use RefreshDatabase.');

        $data = $this->data($owner);
        
        // Hit endpoint with valid data to create an item
        $response = $this->post('/items', $data);

        // Ensure there are no errors
        $response->assertSessionHasNoErrors();

        // Check if item was added to database
        $this->assertCount(1, Item::all());

        $item = Item::first();

        $this->assertEquals($item->owner_badge_number, $owner->badge_number);
    }

    /**
     * Test barcode requirement
     * 
     * @return void
     */
    public function test_barcode_is_required()
    {
        // Create User to handle owner
        $owner = factory(User::class)->create();

        // Hit endpoint to create item without barcode
        $response = $this->post('/items', array_merge($this->data($owner), ['barcode' => '']));

        $response->assertSessionHasErrors('barcode');
    }

    /**
     * Test title requirement
     * 
     * @return void
     */
    public function test_title_is_required()
    {
        // Create User to handle owner
        $owner = factory(User::class)->create();

        // Hit endpoint to create item without title
        $response = $this->post('/items', array_merge($this->data($owner), ['title' => '']));

        $response->assertSessionHasErrors('title');
    }

    /**
     * Test type requirement
     * 
     * @return void
     */
    public function test_type_is_required()
    {
        // Create User to handle owner
        $owner = factory(User::class)->create();

        // Hit endpoint to create item without type
        $response = $this->post('/items', array_merge($this->data($owner), ['type' => '']));

        $response->assertSessionHasErrors('type');
    }

    /**
     * Test owner badge number requirement
     * 
     * @return void
     */
    public function test_owner_badge_number_is_required()
    {
        // Create User to handle owner
        $owner = factory(User::class)->create();

        // Hit endpoint to create item without owner
        $response = $this->post('/items', array_merge($this->data($owner), ['owner' => ['badge_number' => '']]));

        $response->assertSessionHasErrors('owner.badge_number');
    }

    /**
     * Test location requirement
     * 
     * @return void
     */
    public function test_location_is_required()
    {
        // Create User to handle owner
        $owner = factory(User::class)->create();

        // Hit endpoint to create item without location
        $response = $this->post('/items', array_merge($this->data($owner), ['location' => '']));

        $response->assertSessionHasErrors('location');
    }

    /**
     * Test source requirement
     * 
     * @return void
     */
    public function test_source_is_not_required()
    {
        // Create User to handle owner
        $owner = factory(User::class)->create();

        // Hit endpoint to create item without source
        $response = $this->post('/items', array_merge($this->data($owner), ['source' => '']));

        $response->assertSessionHasNoErrors();
    }

    /**
     * Test source date requirement
     * 
     * @return void
     */
    public function test_source_date_is_not_required()
    {
        // Create User to handle owner
        $owner = factory(User::class)->create();

        // Hit endpoint to create item without source date
        $response = $this->post('/items', array_merge($this->data($owner), ['source_date' => '']));

        $response->assertSessionHasNoErrors();
    }

    /**
     * Test description requirement
     * 
     * @return void
     */
    public function test_description_is_not_required()
    {
        // Create User to handle owner
        $owner = factory(User::class)->create();

        // Hit endpoint to create item without description
        $response = $this->post('/items', array_merge($this->data($owner), ['description' => '']));

        $response->assertSessionHasNoErrors();
    }

    /**
     * Test keywords requirement
     * 
     * @return void
     */
    public function test_keywords_is_not_required()
    {
        // Create User to handle owner
        $owner = factory(User::class)->create();

        // Hit endpoint to create item without keywords
        $response = $this->post('/items', array_merge($this->data($owner), ['keywords' => '']));

        $response->assertSessionHasNoErrors();
    }

    /**
     * Test new user added to user table when creating item.
     * 
     * @return void
     */
    public function test_creates_user_and_item_when_new_badge_number()
    {
        // Create instance of User to handle owner, but do not add to database
        $owner = factory(User::class)->make();

        // Ensure items and users table are cleared before adding user
        $this->assertCount(0, Item::all(), 'Database is not empty! Be sure to use RefreshDatabase.');
        $this->assertCount(0, User::all(), 'Database is not empty! Be sure to use RefreshDatabase.');

        // Hit endpoint to create item with a new badge number
        $response = $this->post('/items', $this->data($owner));

        // Check if item was added to the database
        $this->assertCount(1, Item::all());

        // Check if user was added to the database
        $this->assertCount(1, User::all());
    }

    /**
     * Test owner first name requirement when badge number is new
     * 
     * @return void
     */
    public function test_owner_first_name_required_when_new_badge_number()
    {
        // Create instance of User to handle owner, but do not add to database
        $owner = factory(User::class)->make();

        // Hit endpoint to create item with a new badge number and no owner first name
        $response = $this->post('/items', array_merge($this->data($owner), ['owner' => [
            'badge_number' => $owner->badge_number,
            'first_name' => '',
            'last_name' => $owner->last_name
            ]
        ]));

        $response->assertSessionHasErrors('owner.first_name');
    }

    /**
     * Test owner last name requirement when badge number is new
     * 
     * @return void
     */
    public function test_owner_last_name_required_when_new_badge_number()
    {
        // Create instance of User to handle owner, but do not add to database
        $owner = factory(User::class)->make();

        // Hit endpoint to create item with a new badge number and no owner last name
        $response = $this->post('/items', array_merge($this->data($owner), ['owner' => [
            'badge_number' => $owner->badge_number,
            'first_name' => $owner->first_name,
            'last_name' => ''
            ]
        ]));

        $response->assertSessionHasErrors('owner.last_name');
    }

    /**
     * Test owner first name requirement when user already exists
     * 
     * @return void
     */
    public function test_owner_first_name_not_required_when_existing_badge_number()
    {
        // Create instance of User to handle owner, and add to database
        $owner = factory(User::class)->create();

        // Hit endpoint to create item with a new badge number and no owner first name
        $response = $this->post('/items', array_merge($this->data($owner), ['owner' => [
            'badge_number' => $owner->badge_number,
            'first_name' => '',
            'last_name' => $owner->last_name
            ]
        ]));

        $response->assertSessionHasNoErrors();
    }

     /**
     * Test owner last name requirement when user already exists
     * 
     * @return void
     */
    public function test_owner_last_name_not_required_when_existing_badge_number()
    {
        // Create instance of User to handle owner, and add to database
        $owner = factory(User::class)->create();

        // Hit endpoint to create item with a new badge number and no owner last name
        $response = $this->post('/items', array_merge($this->data($owner), ['owner' => [
            'badge_number' => $owner->badge_number,
            'first_name' => $owner->first_name,
            'last_name' => ''
            ]
        ]));

        $response->assertSessionHasNoErrors();
    }

    /**
     * Returns correct test data for an Item
     * 
     * @param $owner User representing the owner of the item
     * 
     * @return array
     */
    private function data($owner) 
    {
        return [
            'title' => 'Sample of CUI Data',
            'barcode' => 'CUI0000006',
            'owner' => [
                'badge_number' => $owner->badge_number,
                'first_name' => $owner->first_name,
                'last_name' => $owner->last_name
            ],
            'type' => 'Hardcopy',
            'source' => 'ARL',
            'source_date' => '2006-04-16',
            'location' => 'filing cabinet B',
            'description' => 'Data set used to determine XX development',
            'keywords' => 'sample, development, hardcopy'
        ];
    }
}
