<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostAttribute extends Model
{
    use HasFactory;

    public $table = "post_attributes";
    public $timestamps = true;

    protected $fillable = [
        "post_id", "key", "value"
    ];

    public function post()
    {
        return $this->belongsTo("App\Models\Post", "post_id", "id");
    }
}
