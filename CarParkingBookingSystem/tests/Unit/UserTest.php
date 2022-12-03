<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_user_bookings_test(){
        $response = $this->get('/booking');
        $response->assertStatus($response->status(),302);
    }

    public function test_user_login_test()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_user_register_test()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_user_create_test()
    {
        $user1 = User::make([
            'name' => "Samir",
            'email' => "sss2@gmail.com",
            'pass' => 123456,
        ]);

        $response = $this->get('/');
        $response->assertStatus($response->status(),302);
    }

}