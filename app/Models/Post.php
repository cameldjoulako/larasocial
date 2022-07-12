<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public $table = "posts";
    public $timestamps = true;

    protected $fillable = [
        "caption", "user_id", "type", "status"
    ];

    // accessors
    public function getCreatedAtAttribute($value)
    {
        return date("Y-m-d H:i:s", strtotime($value));
    }
    public function getUpdatedAtAttribute($value)
    {
        return date("Y-m-d H:i:s", strtotime($value));
    }

    // check if authenticated user has liked this post
    public function scopeHas_liked()
    {
        foreach ($this->likers as $liker)
        {
            if ($liker->user_id == auth()->user()->id)
            {
                return true;
            }
        }
        return false;
    }

    public function scopeIs_shared()
    {
        return $this->hasOne("App\Models\Share", "post_id", "id") != null;        
    }

    public function scopeGet_attribute($query, $key)
    {
        foreach ($this->post_attributes as $attribute)
        {
            if ($attribute->key == $key)
            {
                return $attribute->value;
            }
        }
        return "";
    }

    public function post_attributes()
    {
        return $this->hasMany("App\Models\PostAttribute", "post_id", "id");
    }

    public function shared_post()
    {
        return $this->hasOne("App\Models\Share", "post_id", "id");
    }

    // how many shares this post got
    public function shares()
    {
        return $this->hasMany("App\Models\Share", "shared_post_id", "id")
            ->orderBy("id", "desc");
    }

    // comments on this post
    public function comments()
    {
        return $this->hasMany("App\Models\Comment", "post_id", "id")
            ->orderBy("id", "desc");
    }

    // all people who has liked this post
    public function likers()
    {
        return $this->hasMany("App\Models\Liker", "post_id", "id");
    }

    // the user this post belongs to
    public function user()
    {
        return $this->belongsTo("App\Models\User", "user_id", "id");
    }

    // all the attachments attached with this post
    public function post_attachments()
    {
        return $this->hasMany("App\Models\PostAttachment", "post_id", "id");
    }
}
