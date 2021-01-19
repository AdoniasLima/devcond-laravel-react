<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        //Units
        DB::table("units")->insert([
            "name" => "APT 100",
            "id_owner" => 1
        ]);
        DB::table("units")->insert([
            "name" => "APT 101",
            "id_owner" => 1
        ]);
        DB::table("units")->insert([
            "name" => "APT 200",
            "id_owner" => 0
        ]);
        DB::table("units")->insert([
            "name" => "APT 201",
            "id_owner" => 0
        ]);
        //Areas
        DB::table("areas")->insert([
            "allowed" => 1,
            "title" => "Academy",
            "cover" => "gym.jpg",
            "days" => "1,2,4,5",
            "start_time" => "06:00:00",
            "end_time" => "22:00:00"
        ]);
        DB::table("areas")->insert([
            "allowed" => 1,
            "title" => "Pool",
            "cover" => "pool.jpg",
            "days" => "1,2,3,4,5",
            "start_time" => "07:00:00",
            "end_time" => "23:00:00"
        ]);
        DB::table("areas")->insert([
            "allowed" => 1,
            "title" => "Barbecue grill",
            "cover" => "barbecue.jpg",
            "days" => "4,5,6",
            "start_time" => "09:00:00",
            "end_time" => "23:00:00"
        ]);
        //Walls
        DB::table("walls")->insert([
            "title" => "Hello",
            "body" => "All ok",
            "datecreated" => "2020-01-19 15:00:00"
        ]);
        DB::table("walls")->insert([
            "title" => "Alert",
            "body" => "Bla bla bla",
            "datecreated" => "2020-01-19 19:00:00"
        ]);
    }
}
