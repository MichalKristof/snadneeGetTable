<?php

namespace Tests\Feature;

use Tests\TestCase;

class RestaurantTest extends TestCase
{
    public function test_if_restaurant_index_return_blade_with_data()
    {
        $response = $this->get('/restaurants');

        $response->assertStatus(200);
        $response->assertViewIs('restaurant.index');
        $response->assertViewHas('restaurants');}
}
