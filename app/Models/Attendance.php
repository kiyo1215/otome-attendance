<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Attendance extends Model
{
    use HasFactory;
     protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
        'lest_start_time',
        'lest_end_time'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
