<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;

    public $table = "shares";
    public $timestamps = true;

    protected $fillable = [
        "shared_post_id", "post_id", "user_id", "type"
    ];

    public function post()
    {
        return $this->belongsTo("App\Models\Post", "post_id", "id");
    }

    public function shared_post()
    {
        return $this->belongsTo("App\Models\Post", "shared_post_id", "id");
    }

    public function user()
    {
        return $this->belongsTo("App\Models\User", "user_id", "id");
    }
}
