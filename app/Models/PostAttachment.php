<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostAttachment extends Model
{
    use HasFactory;

    public $table = "post_attachments";
    public $timestamps = true;

    protected $fillable = [
        "post_id", "type", "file_path"
    ];

    public function post()
    {
        return $this->belongsTo("App\Models\Post", "post_id", "id");
    }
}
