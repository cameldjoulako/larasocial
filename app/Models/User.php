<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    public $table = "users";
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',

        // all fields which we will be updating
        "username", "gender", "profile_image", "cover_photo", "dob", "about_me", "city_id", "country_id", "role"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getProfileImageAttribute($value)
    {
        if (Storage::exists($value))
        {
            return asset('public/' . Storage::url($value));
        }
        else
        {
            return asset('/public/assets/img/default_profile.jpg');
        }
    }

    public function getCoverPhotoAttribute($value)
    {
        if (Storage::exists($value))
        {
            return asset('public/' . Storage::url($value));
        }
        else
        {
            return asset('/public/assets/img/default_cover.jpg');
        }
    }

    public function scopeIs_admin()
    {
        return $this->role == "admin";
    }

    public function scopeIs_friend_request_sent_or_received($query, $user_id)
    {
        foreach ($this->friend_requests() as $friend_request)
        {
            if ($friend_request->sent_to == $user_id
                || $friend_request->user_id == $user_id)
            {
                return true;
            }
        }
        return false;
    }

    public function scopeIs_friend_request_sent($query, $user_id)
    {
        foreach ($this->friend_requests_sent as $friend_request)
        {
            if ($friend_request->sent_to == $user_id)
            {
                return true;
            }
        }
        return false;
    }

    public function scopeIs_friend($query, $user_id)
    {
        foreach ($this->friends() as $friend)
        {
            if ($friend->other_user->id == $user_id)
            {
                return true;
            }
        }
        return false;
    }

    public function scopeFriends()
    {
        return $this->friend_requests()->where("status", "=", "accepted");
    }

    public function posts()
    {
        return $this->hasMany("App\Models\Post", "user_id", "id")
            ->where("status", "=", "active");
    }

    public function friend_requests()
    {
        return $this->friend_requests_sent->merge($this->friend_requests_received);
    }

    public function friend_requests_sent()
    {
        return $this->hasMany("App\Models\FriendRequest", "user_id", "id");
    }

    public function friend_requests_received()
    {
        return $this->hasMany("App\Models\FriendRequest", "sent_to", "id");
    }

    // city_id belongs to ID of cities table
    public function city()
    {
        return $this->belongsTo("App\Models\City", "city_id", "id");
    }

    // country_id belongs to ID of countries table
    public function country()
    {
        return $this->belongsTo("App\Models\Country", "country_id", "id");
    }

    public function scopeGet_unread_tickets()
    {
        $responses = 0;
        foreach ($this->tickets as $ticket)
        {
            $responses += $ticket->unread_responses()->count();
        }
        return $responses;
    }

    public function tickets()
    {
        return $this->hasMany("App\Models\Ticket", "user_id", "id")
            ->orderBy("id", "desc");
    }
}
