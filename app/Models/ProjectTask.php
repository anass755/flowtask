<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
    protected $fillable = [
        'description',
        'staff_id',
        'hours',
        'minutes',
        'status',
        'task_date',
        'locked',
    ];

    protected $casts = [
        'task_date' => 'date',
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
