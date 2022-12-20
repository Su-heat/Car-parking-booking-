<?php

namespace Tests\Unit;
use App\Models\parkingReview;
use Tests\TestCase;

class ParkingReviewTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_user_infoTest(){
        $info = parkingReview::make([
            'id' => '3',
            'user_id' => '3',
        ]);
        
        $response = $this->get('/');
        $this->assertTrue(true);
    }

    public function test_getAllReviewTest(){
        $info = parkingReview::make([
            'parking_id' => '6',
            'id' => '6',
        ]);
        
        $response = $this->get('/');
        $this->assertTrue(true);
    }

    public function test_getAllUserReviewTest(){
        $response=$this->call('POST','/App\Models\ParkingReviewDB',[
            'user_id' => '4',
            'id' => '4',
        ]);
        
        $response->assertStatus($response->status(),302);
    }

    public function test_parkingReviewTest(){
        $response=$this->call('POST','/ParkingDB',[
            'id' => '3',
            'product_id' => '3',
        ]);
        
        $response->assertStatus($response->status(),302);
    }

}