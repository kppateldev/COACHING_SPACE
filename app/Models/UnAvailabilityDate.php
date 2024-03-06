<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class UnAvailabilityDate extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $table = 'unavailability_dates';
    protected $primaryKey = 'id';
    //protected $fillable = [];
    protected $guarded = ['id'];

    protected $casts = [
        'time_slots' => 'array',
    ];

    public function users()
    {
        return $this->hasMany('App\Models\User','coach_id','id');
    }
}
