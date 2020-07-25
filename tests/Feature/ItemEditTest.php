<?php

namespace Tests\Feature;

use App\Change;
use App\Item;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemEditTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $requiredStringFields = ['title', 'type', 'location'];
    private $nonRequiredStringFields = ['source', 'description', 'keywords'];
    private $nonRequiredDateFields = ['source_date'];


    /**
     * Test basic edits tracked functionality when changing a required string field
     * 
     * Such required string fields for items include the item's title, type, and location
     *
     * @return void
     */
    public function test_edit_item_required_string_changes_tracked()
    {
        $this->assertCount(0, Change::all(), 'Changes table is not empty! Be sure to use RefreshDatabase when testing.');

        $item = factory(Item::class)->create();
        $user = factory(User::class)->create();

        $count = 0;

        foreach ($this->requiredStringFields as $field) {

            // Hit endpoint to edit item and modifying the string fields
            $newValue = 'modified';
            $this->patch("/items/$item->id", array_merge($this->data($item, $user), [$field => $newValue]));

            // Ensure Change was tracked in changes table
            $this->assertCount(++$count, Change::all());
            $this->assertEquals(Change::latest('id')->first()->item_id, $item->id);
            $this->assertEquals(Change::latest('id')->first()->badge_number, $user->badge_number);
            $this->assertEquals(Change::latest('id')->first()->field, $field);
            $this->assertEquals(Change::latest('id')->first()->old, $item->$field);
            $this->assertEquals(Change::latest('id')->first()->new, $newValue);

            // Refresh model to update attributes in this instance
            $item->refresh();
        }

        // Ensure all changes were tracked
        $this->assertCount(count($this->requiredStringFields), Change::all());
    }

    /**
     * Test basic edits tracked functionality when changing a non-required string field
     *
     * @return void
     */
    public function test_edit_item_non_required_string_changes_tracked()
    {
        $this->assertCount(0, Change::all(), 'Changes table is not empty! Be sure to use RefreshDatabase when testing.');

        $item = factory(Item::class)->create();
        $user = factory(User::class)->create();

        $count = 0;

        foreach ($this->nonRequiredStringFields as $field) {

            // Hit endpoint to edit item and modifying the string fields
            $newValue = 'modified';
            $this->patch("/items/$item->id", array_merge($this->data($item, $user), [$field => $newValue]));

            // Ensure Change was tracked in changes table
            $this->assertCount(++$count, Change::all());
            $this->assertEquals(Change::latest('id')->first()->item_id, $item->id);
            $this->assertEquals(Change::latest('id')->first()->badge_number, $user->badge_number);
            $this->assertEquals(Change::latest('id')->first()->field, $field);
            $this->assertEquals(Change::latest('id')->first()->old, $item->$field);
            $this->assertEquals(Change::latest('id')->first()->new, $newValue);

            // Refresh model to update attributes in this instance
            $item->refresh();
        }

        // Ensure all changes were tracked
        $this->assertCount(count($this->nonRequiredStringFields), Change::all());
    }

    /**
     * Test basic edits tracked functionality when changing a non-required date field
     */
    public function test_edit_item_non_required_date_changes_tracked()
    {
        $this->assertCount(0, Change::all(), 'Changes table is not empty! Be sure to use RefreshDatabase when testing.');

        $item = factory(Item::class)->create();
        $user = factory(User::class)->create();

        $count = 0;

        foreach ($this->nonRequiredDateFields as $field) {

            // Hit endpoint to edit item and modifying the string fields
            $newValue = Carbon::parse($item->$field)->addDay()->format('Y-m-d');
            $this->patch("/items/$item->id", array_merge($this->data($item, $user), [$field => $newValue]));

            // Ensure Change was tracked in changes table
            $this->assertCount(++$count, Change::all());
            $this->assertEquals(Change::latest('id')->first()->item_id, $item->id);
            $this->assertEquals(Change::latest('id')->first()->badge_number, $user->badge_number);
            $this->assertEquals(Change::latest('id')->first()->field, $field);
            $this->assertEquals(Change::latest('id')->first()->old, $item->$field);
            $this->assertEquals(Change::latest('id')->first()->new, $newValue);

            // Refresh model to update attributes in this instance
            $item->refresh();
        }

        // Ensure all changes were tracked
        $this->assertCount(count($this->nonRequiredDateFields), Change::all());
    }

    /**
     * Test multiple field changes tracked
     *
     * @return void
     */
    public function test_multiple_changes_at_once_tracked()
    {
        $this->assertCount(0, Change::all(), 'Changes table is not empty! Be sure to use RefreshDatabase when testing.');

        $item = factory(Item::class)->create();
        $user = factory(User::class)->create();

        $newTitle = 'newTitle';
        $newType = 'newType';
        $newLocation = 'newLocation';
        $this->patch("/items/$item->id", array_merge($this->data($item, $user), [
            'title' => $newTitle,
            'type' => $newType,
            'location' => $newLocation
        ]));

        $this->assertCount(3, Change::all());
    }

    /**
     * Test case where edited_by field corresponds to a new badge number, so new user must be created with
     * the additional first and last name fields
     */
    public function test_new_user_created_if_new_edited_by_badge_number()
    {
        $this->assertCount(0, Change::all(), 'Changes table is not empty! Be sure to use RefreshDatabase when testing.');
        $this->assertCount(0, User::all(), 'Users table is not empty! Be sure to use RefreshDatabase when testing.');

        $item = factory(Item::class)->create();
        // Ensure new user was created from creating an owner for the item
        $this->assertCount(1, User::all());
        // Make user model instance, but do not persist to database
        $user = factory(User::class)->make();

        $this->patch("/items/$item->id", array_merge($this->data($item, $user), [
            'edited_by' => [
                'badge_number' => $user->badge_number,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name
            ],
            'title' => 'newTitle'
        ]));

        // Only changed title field
        $this->assertCount(1, Change::all());
        $this->assertCount(2, User::all());
    }

    /**
     * Test case where owner field corresponds to a new badge number, so new user must be created with
     * the additional first and last name fields
     */
    public function test_new_user_created_if_new_owner_badge_number()
    {
        $this->assertCount(0, Change::all(), 'Changes table is not empty! Be sure to use RefreshDatabase when testing.');
        $this->assertCount(0, User::all(), 'Users table is not empty! Be sure to use RefreshDatabase when testing.');

        $item = factory(Item::class)->create();
        // Ensure new user was created from creating an owner for the item
        $this->assertCount(1, User::all());

        $user = factory(User::class)->create();
        // New user created for edited_by field
        $this->assertCount(2, User::all());
        
        // Make user model instance, but do not persist to database
        $newOwner = factory(User::class)->make();

        $this->patch("/items/$item->id", array_merge($this->data($item, $user), [
            'owner' => [
                'badge_number' => $newOwner->badge_number,
                'first_name' => $newOwner->first_name,
                'last_name' => $newOwner->last_name
            ],
            'title' => 'newTitle'
        ]));

        // Changed owner and title field
        $this->assertCount(2, Change::all());
        $this->assertCount(3, User::all());
    }

    /**
     * Test case where both the edited_by and owner fields correspond to new badge numbers, so the users
     * must both be created at once.
     */
    public function test_both_new_users_created_when_new_edited_by_and_owner_badge_number()
    {
        $this->assertCount(0, Change::all(), 'Changes table is not empty! Be sure to use RefreshDatabase when testing.');
        $this->assertCount(0, User::all(), 'Users table is not empty! Be sure to use RefreshDatabase when testing.');

        $item = factory(Item::class)->create();
        // Ensure new user was created from creating an owner for the item
        $this->assertCount(1, User::all());

        // Make new user model instances for both edited_by and owner users, but do not persist them to the database
        $editedBy = factory(User::class)->make();
        $newOwner = factory(User::class)->make();
        // Ensure user count is still 1 in users table
        $this->assertCount(1, User::all());

        $this->patch("/items/$item->id", array_merge($this->data($item, $editedBy), [
            'edited_by' => [
                'badge_number' => $editedBy->badge_number,
                'first_name' => $editedBy->first_name,
                'last_name' => $editedBy->last_name
            ],
            'owner' => [
                'badge_number' => $newOwner->badge_number,
                'first_name' => $newOwner->first_name,
                'last_name' => $newOwner->last_name
            ],
            'title' => 'newTitle'
        ]));

        // Changed owner and title field
        $this->assertCount(2, Change::all());
        $this->assertCount(3, User::all());
    }

    public function test_name_fields_required_when_new_badge_number()
    {
        $this->assertCount(0, Change::all(), 'Changes table is not empty! Be sure to use RefreshDatabase when testing.');
        $this->assertCount(0, User::all(), 'Users table is not empty! Be sure to use RefreshDatabase when testing.');

        $item = factory(Item::class)->create();
        // Ensure new user was created from creating an owner for the item
        $this->assertCount(1, User::all());

        $editedBy = factory(User::class)->make();

        $response = $this->patch("/items/$item->id", array_merge($this->data($item, $editedBy), ['title' => 'newTitle']));

        $response->assertSessionHasErrors('edited_by.first_name');
        $response->assertSessionHasErrors('edited_by.last_name');

        $this->assertCount(0, Change::all());
        $this->assertCount(1, User::all());
    }

    private function data($item, $edited_by)
    {
        $result = [
            'title' => $item->title,
            'barcode' => $item->barcode,
            'type' => $item->type,
            'owner' => [
                'badge_number' => $item->owner_badge_number
            ],
            'source' => $item->source,
            'source_date' => $item->source_date,
            'location' => $item->location,
            'description' => $item->description,
            'keywords' => $item->keywords,
            'edited_by' => [
                'badge_number' => $edited_by->badge_number
            ]
        ];

        return $result;
    }
}
