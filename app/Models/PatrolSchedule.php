<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatrolSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'patrol_point_id',
        'start_time',
        'end_time',
    ];

    // Relasi ke User (petugas)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Titik Patroli
    public function patrolPoint()
    {
        return $this->belongsTo(PatrolPoint::class);
    }
}
