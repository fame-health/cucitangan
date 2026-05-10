<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = [
        'nama_shift',
        'jam_mulai',
        'jam_selesai',
    ];

    public function schedules()
    {
        return $this->hasMany(NurseSchedule::class);
    }

    public function handWashLogs()
    {
        return $this->hasMany(HandWashLog::class);
    }
}
