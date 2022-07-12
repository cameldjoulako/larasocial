<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Storage;

class Ticket extends Model
{
    use HasFactory;

    public $table = "tickets";
    public $timestamps = true;

    protected $fillable = [
        "user_id", "title", "description", "attachment", "status"
    ];

    public function getAttachmentAttribute($value)
    {
        return Storage::exists($value) ? asset('public/' . Storage::url($value)) : "";
    }

    public function unread_responses()
    {
        return $this->responses()->where("is_read", "=", "0");
    }

    public function responses()
    {
        return $this->hasMany("App\Models\TicketResponse", "ticket_id", "id");
    }

    public function user()
    {
        return $this->belongsTo("App\Models\User", "user_id", "id");
    }
}
