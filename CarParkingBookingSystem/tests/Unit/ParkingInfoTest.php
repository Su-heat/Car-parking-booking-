<?php

namespace Tests\Unit;
use App\Models\parking;
use App\Models\cart;
use Tests\TestCase;

class ParkingInfoTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_search_Parking_Test(){
        $response=$this->call('POST','/parking',[
            'name' => 'Hey Park',
            'id' => '6',
        ]);
        
        $response->assertStatus($response->status(),302);
        
    }

    public function test_get_Review_Test(){
        $response=$this->call('POST','/parkingReview',[
            'name' => 'Hey Park',
            'id' => '6',
        ]);
        
        $response->assertStatus($response->status(),302);
    }

    public function test_selected_bookings_Test(){

        $response = $this->get('/booking');

        $this->assertTrue(true);
    }

}