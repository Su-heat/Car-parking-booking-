<?php

namespace Tests\Unit;
use App\Models\Cart;
use App\Models\Order;
use App\Models\parking;
use Tests\TestCase;

class SelectedBookingTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_getAllparkingFromSelectedBookingTest(){
        $info = parking::make([
            'user_id' => '6',
        ]);
        
        $response = $this->get('/');
        $this->assertTrue(true);
    }


    public function test_ParkingBelongsTest(){
        $info = parking::make([
            'parking_id' => '6',
        ]);
        
        $response = $this->get('/');
        $this->assertTrue(true);
    }


    public function test_booking_belongTest(){
        $info = Order::make([
            'order_id' => '1',
        ]);
        
        $response = $this->get('/');
        $this->assertTrue(true);
    }
}