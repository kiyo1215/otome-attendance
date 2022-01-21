<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Rest;

class Attendance extends Model
{
    use HasFactory;
     protected $fillable = [
        'user_id',
        'start_time',
        'end_time'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function rest()
    {
        return $this->belongsTo(Rest::class);
    }
}