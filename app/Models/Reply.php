<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{ 
    protected $fillable = ['content', 'user_id', 'message_id'];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
    use HasFactory;
}
