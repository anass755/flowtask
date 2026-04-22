<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'description',
        'staff_id',
        'hours',
        'minutes',
        'status',
        'task_date',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function getTotalMinutesAttribute()
    {
        return ($this->hours * 60) + $this->minutes;
    }

    public function getTimeDisplayAttribute()
    {
        return sprintf('%dh %dm', $this->hours, $this->minutes);
    }
}
