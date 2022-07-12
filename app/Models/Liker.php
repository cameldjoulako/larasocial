<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liker extends Model
{
    use HasFactory;

    public $table = "likers";
    public $timestamps = true;

    protected $fillable = [
        "post_id", "user_id"
    ];

    // the post which is liked
    public function post()
    {
        return $this->belongsTo("App\Models\Post", "post_id", "id");
    }

    // the user who liked this post
    public function user()
    {
        return $this->belongsTo("App\Models\User", "user_id", "id");
    }
}
