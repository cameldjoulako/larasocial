<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    public $table = "replies";
    public $timestamps = true;

    protected $fillable = [
        "comment_id", "user_id", "reply"
    ];

    public function comment()
    {
        return $this->belongsTo("App\Models\Comment", "comment_id", "id");
    }

    public function user()
    {
        return $this->belongsTo("App\Models\User", "user_id", "id");
    }
}
