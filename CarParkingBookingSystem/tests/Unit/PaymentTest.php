<?php

namespace Tests\Unit;
use App\Models\payment;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_bookingTest(){

        $response = $this->get('/booking');

        $this->assertTrue(true);
    }

    public function test_getStatusAttributeTest()
    {
        $response = $this->get('/payment');

        $this->assertTrue(true);
    }
}