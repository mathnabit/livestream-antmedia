<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'meeting_id',
        'visitor_id',
        'message',
    ];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }
}
