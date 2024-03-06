<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'organizations';
    protected $primaryKey = 'id';
    //protected $fillable = [];
    protected $guarded = ['id'];

    public function users()
    {
        return $this->hasMany('App\Models\User','organization_id','id');
    }
}
