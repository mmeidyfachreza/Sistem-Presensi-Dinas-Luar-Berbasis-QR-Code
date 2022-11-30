<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Presence extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'field_work_activity_id',
        'date',
        'start_time',
        'end_time',
        'start_location',
        'end_location',
        'work_duration'
    ];

    public function scopeHavePresence($query,$employeeId)
    {
        return $query-> whereEmployeeId($employeeId)->where('date',Carbon::now()->format('Y-m-d'))->exists();
    }

    public function scopeGetPresence($query,$employeeId)
    {
        return $query-> whereEmployeeId($employeeId)->where('date',Carbon::now()->format('Y-m-d'))->first();
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }

    public function field_work_activity()
    {
        return $this->belongsTo(FieldWorkActivity::class,'field_work_activity_id');
    }
}
