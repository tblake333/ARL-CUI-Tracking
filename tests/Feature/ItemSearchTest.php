<?php

namespace Tests\Feature;

use App\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test basic search functionality
     *
     * @return void
     */
    public function test_can_search_item()
    {
        $this->withoutExceptionHandling();
        $item = factory(Item::class)->create();

        $response = $this->call('GET', "/items/results/$item->title");

        $response->assertStatus(200);
    }
}
