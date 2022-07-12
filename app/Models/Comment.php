<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public $table = "comments";
    public $timestamps = true;

    protected $fillable = [
        "user_id", "post_id", "comment"
    ];

    public function replies()
    {
        return $this->hasMany("App\Models\Reply", "comment_id", "id")
            ->orderBy("id", "desc");
    }

    public function user()
    {
        return $this->belongsTo("App\Models\User", "user_id", "id");
    }

    public function post()
    {
        return $this->belongsTo("App\Models\Post", "post_id", "id");
    }
}
