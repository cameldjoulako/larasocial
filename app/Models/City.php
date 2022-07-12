<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public $table = "cities";
    public $timestamps = true;

    protected $fillable = [
        "name", "country_id"
    ];
}
