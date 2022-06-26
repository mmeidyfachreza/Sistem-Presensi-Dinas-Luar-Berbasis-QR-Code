<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class FieldWorkActivity extends Model
{
    use HasFactory,SoftDeletes,Sluggable,SluggableScopeHelpers;

    protected $fillable = ['project_name','description','pic_name','pic_email',
    'pic_phone_number','pic_position','address','geo_location','start_date',
    'end_date','date','link','tolerance_distance'];
    protected $dates = ['start_date','end_date'];

    public function employees()
    {
        return $this->belongsToMany(Employee::class,'field_work_teams')->withTimestamps();
    }

    public function qrcode()
    {
        return $this->hasOne(Qrcode::class);
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'link' => [
                'source' => 'project_name'
            ]
        ];
    }

}
