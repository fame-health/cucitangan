<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'nip',
        'jenis_kelamin',
        'no_hp',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedules()
    {
        return $this->hasMany(NurseSchedule::class);
    }

    public function handWashLogs()
    {
        return $this->hasMany(HandWashLog::class);
    }
}
