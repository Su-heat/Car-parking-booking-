<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=array(
            'description'=>"THIS IS CAR PARKING BOOKING SYSTEM PROJECT",
            'short_des'=>"WELCOME TO CAR PARKING BOOKING SYSTEM!",
            'photo'=>"image.jpg",
            'logo'=>'logo.jpg',
            'address'=>"BRACU",
            'email'=>"carparking@gmail.com",
            'phone'=>"+8801620839605",
        );
        DB::table('settings')->insert($data);
    }
}
