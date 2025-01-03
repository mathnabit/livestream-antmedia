<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'meeting_id',
        'ip_address',
        'user_agent',
        'session_token',
        'status',
    ];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
