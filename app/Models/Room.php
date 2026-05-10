<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'nama_ruangan',
        'kode_ruangan',
        'keterangan',
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
