<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Storage;

class TicketResponse extends Model
{
    use HasFactory;

    public $table = "ticket_responses";
    public $timestamps = true;

    protected $fillable = [
        "ticket_id", "response", "response_by", "is_read"
    ];

    public function ticket()
    {
        return $this->belongsTo("App\Models\Ticket", "ticket_id", "id");
    }

    public function user()
    {
        return $this->belongsTo("App\Models\User", "response_by", "id");
    }
}
