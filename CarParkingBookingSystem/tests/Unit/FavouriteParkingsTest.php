<?php

namespace Tests\Unit;
use App\Models\Wishlist;
use Tests\TestCase;

class FavouriteParkingTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_parkingTest(){
        $info = Wishlist::make([
            'parking_id' => '6',
        ]);
        
        $response = $this->get('/');
        $this->assertTrue(true);
    }
}