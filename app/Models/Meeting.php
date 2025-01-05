<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'stream_key',
        'name',
        'stream_url',
        'total_visitors',
        'current_viewers',
    ];

    public function visitors()
    {
        return $this->hasMany(Visitor::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
