<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendRequest extends Model
{
    use HasFactory;

    public $table = "friend_requests";
    public $timestamps = true;

    protected $fillable = [
        "user_id", "sent_to", "status"
    ];

    public function scopeIs_sent()
    {
        return $this->status == "sent";
    }

    public function scopeIs_accepted()
    {
        return $this->status == "accepted";
    }

    public function scopeIs_declined()
    {
        return $this->status == "declined";
    }

    public function other_user()
    {
        if ($this->user->id == auth()->user()->id)
        {
            return $this->sent_to_user();
        }
        return $this->user();
    }

    public function user()
    {
        return $this->belongsTo("App\Models\User", "user_id", "id");
    }

    public function sent_to_user()
    {
        return $this->belongsTo("App\Models\User", "sent_to", "id");
    }
}
