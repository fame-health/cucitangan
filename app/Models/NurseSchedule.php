<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NurseSchedule extends Model
{
    protected $fillable = [
        'nurse_id',
        'room_id',
        'shift_id',
        'tanggal',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function nurse()
    {
        return $this->belongsTo(Nurse::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
