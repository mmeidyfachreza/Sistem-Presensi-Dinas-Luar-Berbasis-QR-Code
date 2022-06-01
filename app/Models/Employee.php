<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;

class Employee extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['name','email','phone_number','division','no_identity'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

}
