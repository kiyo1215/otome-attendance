<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Attendance;

class Rest extends Model
{
    use HasFactory;
     protected $fillable = [
        'user_id',
        // 'attendance_id',
        'rest_start_time',
        'rest_end_time',
        'rest_all_time'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}