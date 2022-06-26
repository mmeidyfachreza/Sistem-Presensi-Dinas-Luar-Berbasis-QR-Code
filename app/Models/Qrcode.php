<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qrcode extends Model
{
    use HasFactory;
    protected $fillable = ['field_work_activity_id','codewords','active'];

    public function field_work_activity()
    {
        return $this->belongsTo(FieldWorkActivity::class,'field_work_activity_id');

    }
    public function scopeIsValidQrcode($query,$codewords,$employeeId,$linkId)
    {
        $query = $query->with('field_work_activity.employees')
        ->whereFieldWorkActivityId($linkId)
        ->whereCodewords($codewords);

        if ($query->exists()) {
            $validEmployeeId = $query->first()->field_work_activity
            ->employees->pluck('id')->toArray();
            return (in_array($employeeId,$validEmployeeId))? true : false;
        }
        // if ($query->with('field_work_activity.employees')
        // ->whereCodewords($codewords)->whereId($linkid)->exists()) {
        //     $employee = $query->with('field_work_activity.employees')
        //     ->whereCodewords($codewords)->first()
        //     ->field_work_activity->employees->pluck('id')->toArray();

        // }
        return false;
    }

    public function scopeGetCoordinate($query,$codewords)
    {
        return explode(', ',$query->with('field_work_activity')
        ->whereCodewords($codewords)->first()->field_work_activity->geo_location);
    }
}
