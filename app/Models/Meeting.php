<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'key',
        'url',
        'status',
        'duration',
        'start_time',
        'total_watchers',
    ];

    // public function visitors()
    // {
    //     return $this->hasMany(Visitor::class);
    // }

    // public function messages()
    // {
    //     return $this->hasMany(Message::class);
    // }
}
