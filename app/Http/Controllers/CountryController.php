<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Country;
use App\Models\City;

class CountryController extends Controller
{
    public function get_cities()
    {
        $cities = City::where("country_id", "=", request()->country_id)->get();
        
        return response()->json([
            "status" => "success",
            "message" => "Cities has been fetched.",
            "cities" => $cities
        ]);
    }
}
