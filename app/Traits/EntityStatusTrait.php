<?php

namespace App\Traits;

trait EntityStatusTrait
{
    public function scopeIs_active()
    {
        return $this->status == "active";
    }
    
    public function scopeIs_banned()
    {
        return $this->status == "banned";
    }

    public function scopeIs_draft()
    {
        return $this->status == "draft";
    }
}
