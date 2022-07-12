<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Country;
use App\Models\City;

class CountriesCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            [
                "name" => "Pakistan",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name" => "England",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name" => "USA",
                "created_at" => now(),
                "updated_at" => now()
            ]
        ];
        Country::insert($countries);

        $country = Country::where("name", "=", "Pakistan")->first();
        $cities = [
            [
                "name" => "Lahore",
                "country_id" => $country->id,
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name" => "Islamabad",
                "country_id" => $country->id,
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name" => "Multan",
                "country_id" => $country->id,
                "created_at" => now(),
                "updated_at" => now()
            ]
        ];
        City::insert($cities);

        $country = Country::where("name", "=", "England")->first();
        $cities = [
            [
                "name" => "London",
                "country_id" => $country->id,
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name" => "Manchester",
                "country_id" => $country->id,
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name" => "Cambridge",
                "country_id" => $country->id,
                "created_at" => now(),
                "updated_at" => now()
            ]
        ];
        City::insert($cities);

        $country = Country::where("name", "=", "USA")->first();
        $cities = [
            [
                "name" => "New York",
                "country_id" => $country->id,
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name" => "Chicago",
                "country_id" => $country->id,
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name" => "Los Angeles",
                "country_id" => $country->id,
                "created_at" => now(),
                "updated_at" => now()
            ]
        ];
        City::insert($cities);
    }
}
