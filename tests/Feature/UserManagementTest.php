<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    /**
     * RefreshDatabase will clear out all tables to ensure tests run in clean slate
     */
    use RefreshDatabase;

    /**
     * Test create user feature
     *
     * @return void
     */
    public function test_can_create_user()
    {
        // Ensure users table is cleared before adding user
        $this->assertCount(0, User::all());

        // Hit endpoint to create user
        $this->post('/users', $this->data());

        // Ensure user was added
        $this->assertCount(1, User::all());

        $user = User::first()->toArray();

        // Ensure user added matched data
        $this->assertEquals($this->data(), $user);
    }

    /**
     * Test badge number requirement
     * 
     * @return void
     */
    public function test_badge_number_is_required()
    {
        // Hit endpoint to create user without badge number
        $response = $this->post('/users', array_merge($this->data(), ['badge_number' => '']));

        $response->assertSessionHasErrors('badge_number');
    }

    /**
     * Test first name requirement
     * 
     * @return void
     */
    public function test_first_name_is_required()
    {
        // Hit endpoint to create user without badge number
        $response = $this->post('/users', array_merge($this->data(), ['first_name' => '']));

        $response->assertSessionHasErrors('first_name');
    }

    /**
     * Test first name requirement
     * 
     * @return void
     */
    public function test_last_name_is_required()
    {
        // Hit endpoint to create user without badge number
        $response = $this->post('/users', array_merge($this->data(), ['last_name' => '']));

        $response->assertSessionHasErrors('last_name');
    }

    /**
     * Returns correct test data for a User
     * 
     * @return array
     */
    private function data() 
    {
        return [
            'badge_number' => 8911,
            'first_name' => 'John',
            'last_name' => 'Smith'
        ];
    }
}
